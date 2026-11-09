<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Illuminate\Database\Capsule\Manager as DB;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;

/**
 * Binds a HostBill account to the EasyDCIM user that owns it.
 *
 * Client-scoped API calls impersonate an EasyDCIM user (X-Impersonate-User).
 * That user must not be derived from the HostBill client e-mail, which clients
 * can edit themselves. Instead the EasyDCIM user ID is stored per account in the
 * account detail "EasyDCIM Client ID" (option11), which only an administrator
 * can edit - the HostBill counterpart of the admin-only "EasyDCIMClientID"
 * custom field of the WHMCS module.
 *
 * A binding is only written when the account has none yet, and only from a
 * trusted source:
 *  - the EasyDCIM user created/selected by Create for this client,
 *  - the user_id of the account's EasyDCIM order (Order ID is admin-only),
 *  - an administrator editing the account detail.
 * The cron and "Update Order Information" afterwards follow the owner of the
 * EasyDCIM order when an EasyDCIM administrator changes it (syncWithOrderOwner()).
 * Changing the HostBill e-mail address never changes a binding.
 *
 * Writes go through the module instance when it holds the account (so the
 * module's own later save of its details keeps the value), straight to
 * hb_accounts otherwise (cron, other accounts of the client).
 */
class EasyDCIMUserBinding
{
    /**
     * Account detail key in hb_accounts.extra_details.
     */
    public const DETAIL = 'option11';

    /**
     * Name the module's getDetail()/updateDetail() know the detail by.
     */
    public const DETAIL_NAME = 'EasyDCIMClientID';

    /**
     * Account detail holding the EasyDCIM order ID.
     */
    public const ORDER_DETAIL = 'option4';

    /**
     * HostBill modules whose accounts store bindings in DETAIL.
     */
    public const MODULES = ['easydcim'];

    /**
     * @var array<int, int|null>
     */
    protected static $resolved = [];

    /**
     * EasyDCIM user ID stored on the account, or null.
     *
     * @param object|null $module module instance, when one is in scope
     */
    public static function getForAccount(int $accountId, $module = null): ?int
    {
        if (self::moduleHolds($module, $accountId)) {
            return self::parseId($module->getDetail(self::DETAIL_NAME));
        }

        $details = self::details($accountId);

        return $details === null ? null : self::parseId($details[self::DETAIL] ?? null);
    }

    /**
     * EasyDCIM user ID for the account: the stored binding, or (first use of an
     * account provisioned before bindings existed) the owner of its EasyDCIM order.
     *
     * @param object|null $module module instance, when one is in scope
     */
    public static function resolveForAccount(int $accountId, EasyDCIMClient $api, $module = null): ?int
    {
        if ($accountId <= 0) {
            return null;
        }

        if (array_key_exists($accountId, self::$resolved)) {
            return self::$resolved[$accountId];
        }

        $userId = self::getForAccount($accountId, $module);

        if ($userId === null) {
            $userId = self::bindFromOrder($accountId, $api, $module);
        }

        return self::$resolved[$accountId] = $userId;
    }

    /**
     * Store a binding for an account that has none yet.
     *
     * Refuses when the EasyDCIM user is already bound to an account of a
     * different HostBill client on the same EasyDCIM instance.
     *
     * @return int|null the bound EasyDCIM user ID, or null when not bound
     */
    public static function bindIfUnbound(int $accountId, int $easydcimUserId, $module = null): ?int
    {
        $existing = self::getForAccount($accountId, $module);

        if ($existing !== null) {
            return $existing;
        }

        $account = self::getAccount($accountId);

        if (!$account || $easydcimUserId <= 0) {
            return null;
        }

        if (self::isBoundToOtherClient($easydcimUserId, (int) $account->client_id, (int) $account->server_id)) {
            self::log('EasyDCIM user #' . $easydcimUserId . ' is already linked to another HostBill client; not linked to account #' . $accountId . ' automatically.');

            return null;
        }

        return self::store($accountId, $easydcimUserId, $module) ? $easydcimUserId : null;
    }

    /**
     * Keep the binding in line with the owner of the account's EasyDCIM order.
     * Order owners are changed by EasyDCIM administrators only, so a different
     * owner replaces the stored binding - unless that EasyDCIM user is already
     * linked to another HostBill client, which is logged and left for an admin.
     *
     * @return int|null the EasyDCIM user ID bound after the call, or null when not bound
     */
    public static function syncWithOrderOwner(int $accountId, int $orderUserId, $module = null): ?int
    {
        $existing = self::getForAccount($accountId, $module);

        if ($existing === null) {
            return self::bindIfUnbound($accountId, $orderUserId, $module);
        }

        if ($orderUserId <= 0 || $existing === $orderUserId) {
            return $existing;
        }

        $account = self::getAccount($accountId);

        if (!$account) {
            return $existing;
        }

        if (self::isBoundToOtherClient($orderUserId, (int) $account->client_id, (int) $account->server_id)) {
            self::log('EasyDCIM order owner of account #' . $accountId . ' changed to user #' . $orderUserId
                . ', which is already linked to another HostBill client; the account stays linked to user #' . $existing . '.');

            return $existing;
        }

        if (!self::store($accountId, $orderUserId, $module)) {
            return $existing;
        }

        self::log('EasyDCIM order owner of account #' . $accountId . ' changed; the account is now linked to user #' . $orderUserId . ' (was #' . $existing . ').');

        return $orderUserId;
    }

    /**
     * Write the binding.
     */
    public static function store(int $accountId, int $easydcimUserId, $module = null): bool
    {
        if ($accountId <= 0 || $easydcimUserId <= 0) {
            return false;
        }

        if (self::moduleHolds($module, $accountId)) {
            $module->updateDetail(self::DETAIL_NAME, (string) $easydcimUserId);
        } else {
            $details = self::details($accountId);

            if ($details === null) {
                return false;
            }

            $details[self::DETAIL] = (string) $easydcimUserId;

            DB::table('hb_accounts')->where('id', '=', $accountId)->update(['extra_details' => serialize($details)]);
        }

        self::$resolved[$accountId] = $easydcimUserId;

        return true;
    }

    /**
     * Bind an account from the user_id of its EasyDCIM order.
     */
    public static function bindFromOrder(int $accountId, EasyDCIMClient $api, $module = null): ?int
    {
        $account = self::getAccount($accountId);

        if (!$account || (int) $account->server_id <= 0) {
            return null;
        }

        if (self::moduleHolds($module, $accountId)) {
            $orderId = self::parseId($module->getDetail('OrderID'));
        } else {
            $details = self::unserializeDetails($account->extra_details);
            $orderId = self::parseId($details[self::ORDER_DETAIL] ?? null);
        }

        if ($orderId === null) {
            return null;
        }

        try {
            $response = $api->admin()->orders()->show($orderId);
            $userId   = $response->data === null ? 0 : (int) $response->data->user_id;
        } catch (\Throwable $e) {
            self::log('Could not read EasyDCIM order #' . $orderId . ' to link account #' . $accountId . ': ' . $e->getMessage());

            return null;
        }

        return $userId > 0 ? self::bindIfUnbound($accountId, $userId, $module) : null;
    }

    /**
     * EasyDCIM user already bound to this HostBill client on the same EasyDCIM
     * instance (newest provisioned account first), or null.
     */
    public static function forHostBillClient(int $clientId, int $serverId): ?int
    {
        if ($clientId <= 0) {
            return null;
        }

        $accounts = self::accountsQuery()
            ->where('a.client_id', '=', $clientId)
            ->whereIn('a.server_id', self::sameInstanceServerIds($serverId))
            ->orderBy('a.id', 'desc')
            ->get(['a.id', 'a.extra_details']);

        foreach ($accounts as $account) {
            $details = self::unserializeDetails($account->extra_details);

            if (!self::isProvisioned($details)) {
                continue;
            }

            $id = self::parseId($details[self::DETAIL] ?? null);

            if ($id !== null) {
                return $id;
            }
        }

        return null;
    }

    /**
     * Bind the client's not-yet-bound accounts on this instance from their orders
     * (migration of accounts provisioned before bindings existed).
     */
    public static function bindClientAccountsFromOrders(int $clientId, int $serverId, EasyDCIMClient $api, int $exceptAccountId = 0, int $limit = 10): ?int
    {
        if ($clientId <= 0) {
            return null;
        }

        $accounts = self::accountsQuery()
            ->where('a.client_id', '=', $clientId)
            ->where('a.id', '!=', $exceptAccountId)
            ->whereIn('a.server_id', self::sameInstanceServerIds($serverId))
            ->orderBy('a.id', 'desc')
            ->get(['a.id', 'a.extra_details']);

        $tried = 0;

        foreach ($accounts as $account) {
            if (!self::isProvisioned(self::unserializeDetails($account->extra_details))) {
                continue;
            }

            if (++$tried > $limit) {
                break;
            }

            $userId = self::resolveForAccount((int) $account->id, $api);

            if ($userId !== null) {
                return $userId;
            }
        }

        return null;
    }

    /**
     * True when the EasyDCIM user is bound to an account of another HostBill
     * client on the same EasyDCIM instance.
     */
    public static function isBoundToOtherClient(int $easydcimUserId, int $clientId, int $serverId): bool
    {
        // The LIKE filters only narrow the rows; the unserialised value decides.
        $accounts = self::accountsQuery()
            ->where('a.client_id', '!=', $clientId)
            ->whereIn('a.server_id', self::sameInstanceServerIds($serverId))
            ->where('a.extra_details', 'LIKE', '%"' . self::DETAIL . '"%')
            ->where('a.extra_details', 'LIKE', '%' . $easydcimUserId . '%')
            ->get(['a.id', 'a.extra_details']);

        foreach ($accounts as $account) {
            $details = self::unserializeDetails($account->extra_details);

            if (self::parseId($details[self::DETAIL] ?? null) === $easydcimUserId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Strict positive integer parsing (admin-entered values may contain spaces).
     *
     * @param mixed $value
     */
    public static function parseId($value): ?int
    {
        if (is_int($value)) {
            return $value > 0 ? $value : null;
        }

        $value = trim((string) $value);

        if ($value === '' || !ctype_digit($value)) {
            return null;
        }

        $id = (int) $value;

        return $id > 0 ? $id : null;
    }

    /**
     * Accounts of the EasyDCIM modules (alias "a").
     */
    protected static function accountsQuery()
    {
        return DB::table('hb_accounts as a')
            ->join('hb_products_modules as pm', 'pm.product_id', '=', 'a.product_id')
            ->join('hb_modules_configuration as m', 'm.id', '=', 'pm.module')
            ->whereIn('m.module', self::MODULES)
            ->distinct();
    }

    /**
     * An account that never got an EasyDCIM order may carry a wrong EasyDCIM
     * Client ID (typed in by hand, or left by a failed Create), so other
     * accounts of the client must not inherit it.
     */
    protected static function isProvisioned(array $details): bool
    {
        return self::parseId($details[self::ORDER_DETAIL] ?? null) !== null;
    }

    /**
     * EasyDCIM user IDs are per EasyDCIM instance: all HostBill server entries
     * pointing at the same host as the given server.
     *
     * @return int[]
     */
    protected static function sameInstanceServerIds(int $serverId): array
    {
        $server = DB::table('hb_servers')->where('id', '=', $serverId)->first(['id', 'host', 'ip']);

        if (!$server) {
            return [$serverId];
        }

        $endpoint = self::endpoint($server);
        $ids      = [$serverId];

        foreach (DB::table('hb_servers')->get(['id', 'host', 'ip']) as $row) {
            if (self::endpoint($row) === $endpoint) {
                $ids[] = (int) $row->id;
            }
        }

        return array_values(array_unique($ids));
    }

    protected static function endpoint($server): string
    {
        return strtolower(trim((string) ($server->host ?: $server->ip)));
    }

    /**
     * True when the module instance is loaded for this account.
     */
    protected static function moduleHolds($module, int $accountId): bool
    {
        if (!is_object($module) || !method_exists($module, 'updateDetail') || !method_exists($module, 'getAccount')) {
            return false;
        }

        $account = $module->getAccount();

        return $accountId > 0 && is_array($account) && (int) ($account['id'] ?? 0) === $accountId;
    }

    /**
     * @return object|null hb_accounts row (id, client_id, server_id, extra_details)
     */
    protected static function getAccount(int $accountId)
    {
        if ($accountId <= 0) {
            return null;
        }

        return DB::table('hb_accounts')
            ->where('id', '=', $accountId)
            ->first(['id', 'client_id', 'server_id', 'extra_details']);
    }

    /**
     * The account's extra details, read straight from the database.
     */
    protected static function details(int $accountId): ?array
    {
        $account = self::getAccount($accountId);

        return $account ? self::unserializeDetails($account->extra_details) : null;
    }

    protected static function unserializeDetails($raw): array
    {
        if (!is_string($raw) || $raw === '') {
            return [];
        }

        $details = @unserialize($raw, ['allowed_classes' => false]);

        return is_array($details) ? $details : [];
    }

    protected static function log(string $message): void
    {
        error_log('[EasyDCIM] ' . $message);
    }
}
