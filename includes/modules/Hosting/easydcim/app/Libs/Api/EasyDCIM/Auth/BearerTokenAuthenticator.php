<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Auth;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\AuthenticatorInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\AuthenticationException;

/**
 * Bearer token authentication handler
 */
class BearerTokenAuthenticator implements AuthenticatorInterface
{
    protected ?string $token = null;

    public function __construct(?string $token = null)
    {
        $this->token = $token;
    }

    /**
     * {@inheritDoc}
     */
    public function addAuthenticationHeaders(array $headers): array
    {
        if ($this->token !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }

        return $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthenticated(): bool
    {
        return $this->token !== null && !empty(trim($this->token));
    }

    /**
     * {@inheritDoc}
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validateToken(): void
    {
        if ($this->token === null || empty(trim($this->token))) {
            throw new AuthenticationException('Authentication token is required but not provided');
        }

        // Basic token format validation
        if (strlen($this->token) < 10) {
            throw new AuthenticationException('Authentication token appears to be invalid (too short)');
        }

        // Check for common invalid patterns
        if (preg_match('/^(null|undefined|false|true|0|1)$/i', $this->token)) {
            throw new AuthenticationException('Authentication token appears to be invalid');
        }
    }

    /**
     * Create authenticator from token
     *
     * @param string $token
     * @return self
     */
    public static function fromToken(string $token): self
    {
        return new self($token);
    }
}
