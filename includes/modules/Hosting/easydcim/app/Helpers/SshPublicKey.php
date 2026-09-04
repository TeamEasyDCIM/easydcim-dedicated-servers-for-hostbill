<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

/**
 * OpenSSH public key parsing and validation.
 *
 * The WHMCS module validates keys with phpseclib. This module vendors no
 * third-party packages, so the check is done here instead: an OpenSSH public
 * key is "<type> <base64 blob> [comment]", and the blob itself begins with a
 * length-prefixed copy of the same type string. Verifying that the two agree
 * rejects truncated, re-typed and non-key input without needing a crypto
 * library.
 */
class SshPublicKey
{
    /**
     * Key types EasyDCIM accepts for OS installation.
     */
    public const SUPPORTED_TYPES = [
        'ssh-rsa',
        'ssh-dss',
        'ssh-ed25519',
        'sk-ssh-ed25519@openssh.com',
        'ecdsa-sha2-nistp256',
        'ecdsa-sha2-nistp384',
        'ecdsa-sha2-nistp521',
        'sk-ecdsa-sha2-nistp256@openssh.com',
    ];

    public static function isValid(?string $key): bool
    {
        return self::parse($key) !== null;
    }

    /**
     * @return array{type: string, blob: string, comment: string}|null null when the key is not usable
     */
    public static function parse(?string $key): ?array
    {
        if ($key === null) {
            return null;
        }

        // Keys pasted from a terminal often arrive wrapped or padded.
        $key = trim(preg_replace('/\s+/', ' ', $key));

        if ($key === '') {
            return null;
        }

        $parts = explode(' ', $key);

        if (count($parts) < 2) {
            return null;
        }

        $type = $parts[0];
        $blob = $parts[1];
        $comment = count($parts) > 2 ? implode(' ', array_slice($parts, 2)) : '';

        if (!in_array($type, self::SUPPORTED_TYPES, true)) {
            return null;
        }

        $decoded = base64_decode($blob, true);

        if ($decoded === false || strlen($decoded) < 4) {
            return null;
        }

        // The blob opens with a 32-bit big-endian length followed by the type.
        $length = unpack('N', substr($decoded, 0, 4))[1] ?? 0;

        if ($length <= 0 || $length > strlen($decoded) - 4) {
            return null;
        }

        if (substr($decoded, 4, $length) !== $type) {
            return null;
        }

        return ['type' => $type, 'blob' => $blob, 'comment' => $comment];
    }

    /**
     * SHA256 fingerprint in the form `ssh-keygen -l` prints, for display only.
     */
    public static function fingerprint(?string $key): string
    {
        $parsed = self::parse($key);

        if ($parsed === null) {
            return '';
        }

        $decoded = base64_decode($parsed['blob'], true);

        if ($decoded === false) {
            return '';
        }

        return 'SHA256:' . rtrim(base64_encode(hash('sha256', $decoded, true)), '=');
    }

    public static function validationMessage(): string
    {
        return 'This value must be a valid SSH public key in OpenSSH format.';
    }
}
