<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\SshKeys\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\SshPublicKey;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\CreateSshKeyRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\ListSshKeysRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\UpdateSshKeyRequest;

/**
 * SSH public keys belonging to the account's owner.
 *
 * Keys live on the EasyDCIM user, not on the device, so every call is
 * client-scoped and acts as the impersonated user. A key marked default is the
 * one EasyDCIM installs automatically; the rebuild form can pick others.
 */
class SshKeys
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey\SshKeyData>
     */
    public function getKeys(): array
    {
        try {
            return $this->api->client()->sshKeys()->listAll(new ListSshKeysRequest());
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * Rows for the widget table.
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->getKeys() as $key) {
            $data[] = [
                'id'          => $key->id,
                'name'        => $key->name,
                'sshKey'      => $key->sshKey,
                // EasyDCIM does not always return a fingerprint; derive one so
                // the column is never blank.
                'fingerprint' => $key->fingerprint ?: SshPublicKey::fingerprint($key->sshKey),
                'default'     => (bool) $key->default,
                'created'     => $key->createdAt,
            ];
        }

        return $data;
    }

    /**
     * Key name/id pairs for the rebuild form's key picker.
     */
    public function getOptions(): array
    {
        $options = [];

        foreach ($this->getKeys() as $key) {
            $options[] = [
                'key'     => $key->id,
                'value'   => $key->name,
                'default' => (bool) $key->default,
            ];
        }

        return $options;
    }

    public function getJSONKeys()
    {
        self::jsonEncode([
            'result' => $this->getData()
        ]);
    }

    public function create($data)
    {
        try
        {
            $name = trim((string) ($data['name'] ?? ''));
            $sshKey = trim((string) ($data['sshKey'] ?? ''));

            if ($name === '')
            {
                $this->fail('The key name cannot be empty.');
            }

            if (!SshPublicKey::isValid($sshKey))
            {
                $this->fail(SshPublicKey::validationMessage());
            }

            $result = $this->api->client()->sshKeys()->create(new CreateSshKeyRequest(
                name: $name,
                sshKey: $sshKey,
                default: !empty($data['default'])
            ));

            if ($result->success === false)
            {
                $this->fail($result->message ?: 'Key cannot be added');
            }

            self::jsonEncode([
                'message' => 'SSH key added successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            $this->fail($exc->getMessage() ?: 'Key cannot be added');
        }
    }

    public function update($data)
    {
        try
        {
            $id = $data['updateId'] ?? null;

            if (empty($id))
            {
                $this->fail('SSH key ID is required.');
            }

            $name = trim((string) ($data['name'] ?? ''));
            $sshKey = trim((string) ($data['sshKey'] ?? ''));

            if ($name === '')
            {
                $this->fail('The key name cannot be empty.');
            }

            // The key body is optional on update; validate it only if resubmitted.
            if ($sshKey !== '' && !SshPublicKey::isValid($sshKey))
            {
                $this->fail(SshPublicKey::validationMessage());
            }

            $result = $this->api->client()->sshKeys()->update($id, new UpdateSshKeyRequest(
                name: $name,
                sshKey: $sshKey !== '' ? $sshKey : null,
                default: !empty($data['default'])
            ));

            if ($result->success === false)
            {
                $this->fail($result->message ?: 'Key cannot be edited');
            }

            self::jsonEncode([
                'message' => 'SSH key edited successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            $this->fail($exc->getMessage() ?: 'Key cannot be edited');
        }
    }

    public function setAsDefault($data)
    {
        try
        {
            $id = $data['defaultId'] ?? null;

            if (empty($id))
            {
                $this->fail('SSH key ID is required.');
            }

            $result = $this->api->client()->sshKeys()->setAsDefault($id);

            if ($result->success === false)
            {
                $this->fail($result->message ?: 'Key cannot be set as default');
            }

            self::jsonEncode([
                'message' => 'SSH key set as default'
            ]);
        }
        catch (\Exception $exc)
        {
            $this->fail($exc->getMessage() ?: 'Key cannot be set as default');
        }
    }

    public function delete($data)
    {
        try
        {
            $id = $data['deleteId'] ?? null;

            if (empty($id))
            {
                $this->fail('SSH key ID is required.');
            }

            $result = $this->api->client()->sshKeys()->destroy($id);

            if ($result->success === false)
            {
                $this->fail($result->message ?: 'Key cannot be deleted');
            }

            self::jsonEncode([
                'message' => 'SSH key deleted successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            $this->fail($exc->getMessage() ?: 'Key cannot be deleted');
        }
    }

    /**
     * Answer the AJAX caller with an error and stop.
     */
    protected function fail(string $message): void
    {
        header('HTTP/1.1 400 Bad Request');
        self::jsonEncode(['error' => $message]);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data' => $data
        ]));
        die;
    }
}
