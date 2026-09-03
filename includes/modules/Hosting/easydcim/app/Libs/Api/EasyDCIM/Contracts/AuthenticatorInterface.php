<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts;

/**
 * Interface for authentication handling
 */
interface AuthenticatorInterface
{
    /**
     * Add authentication headers to the request
     *
     * @param array<string, string> $headers Existing headers
     * @return array<string, string> Headers with authentication added
     */
    public function addAuthenticationHeaders(array $headers): array;

    /**
     * Check if authentication is configured
     */
    public function isAuthenticated(): bool;

    /**
     * Get the authentication token
     */
    public function getToken(): ?string;

    /**
     * Set the authentication token
     *
     * @param string|null $token Bearer token
     * @return self
     */
    public function setToken(?string $token): self;

    /**
     * Validate the token format
     *
     * @throws \ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\AuthenticationException
     */
    public function validateToken(): void;
}
