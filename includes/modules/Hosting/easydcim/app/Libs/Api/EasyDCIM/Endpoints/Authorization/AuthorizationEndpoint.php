<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Authorization;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;

/**
 * Authorization endpoints for authentication and session management
 */
class AuthorizationEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3';

    /**
     * Login with username/email and password
     *
     * @param string $username Username or email address
     * @param string $password Password
     * @param bool $rememberMe Remember me option
     * @return array{success: bool, data: array{token: string, user: array}} Login response with bearer token
     */
    public function login(string $username, string $password, bool $rememberMe = false): array
    {
        return $this->post('login', [
            'username' => $username,
            'password' => $password,
            'remember_me' => $rememberMe,
        ]);
    }

    /**
     * Request password reset email
     *
     * @param string $email Email address for password reset
     * @return array{success: bool, message: string} Success response
     */
    public function remindPassword(string $email): array
    {
        return $this->post('password/remind', [
            'email' => $email,
        ]);
    }

    /**
     * Restore password with reset token
     *
     * @param string $token Password reset token (from email)
     * @param string $password New password
     * @param string $passwordConfirmation Password confirmation
     * @return array{success: bool, message: string} Success response
     */
    public function restorePassword(
        string $token,
        string $password,
        string $passwordConfirmation
    ): array {
        return $this->post('password/restore', [
            'token' => $token,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ]);
    }

    /**
     * Activate user account
     *
     * @param string $token Activation token (from registration email)
     * @return array{success: bool, message: string} Activation response
     */
    public function activateAccount(string $token): array
    {
        return $this->get($this->buildPath('activate', $token));
    }

    /**
     * List active SSO providers
     *
     * @return array{success: bool, data: array} List of available SSO providers
     */
    public function listSsoProviders(): array
    {
        return $this->get('oauth/providers');
    }

    /**
     * OAuth2 redirect - Get authorization URL
     *
     * @param string $provider Provider name (e.g., 'google', 'github')
     * @param string|null $redirectUrl Optional redirect URL after authentication
     * @return array{success: bool, data: array{url: string}} Authorization URL
     */
    public function oauth2Redirect(string $provider, ?string $redirectUrl = null): array
    {
        $data = ['provider' => $provider];
        
        if ($redirectUrl !== null) {
            $data['redirect_url'] = $redirectUrl;
        }

        return $this->post('oauth/redirect', $data);
    }

    /**
     * OAuth2 exchange - Exchange authorization code for token
     *
     * @param string $provider Provider name
     * @param string $code Authorization code from OAuth2 callback
     * @param string|null $state State parameter from OAuth2 callback
     * @return array{success: bool, data: array{token: string, user: array}} Login response with bearer token
     */
    public function oauth2Exchange(string $provider, string $code, ?string $state = null): array
    {
        $data = [
            'provider' => $provider,
            'code' => $code,
        ];

        if ($state !== null) {
            $data['state'] = $state;
        }

        return $this->post('oauth/callback', $data);
    }

    /**
     * Logout the current user
     *
     * @return array{success: bool, message: string} Logout response
     */
    public function logout(): array
    {
        return $this->post('logout');
    }

    /**
     * Perform complete OAuth2 flow (redirect + exchange)
     * Helper method that combines redirect and exchange
     *
     * @param string $provider Provider name
     * @param callable $redirectCallback Callback to handle redirect (receives URL)
     * @param callable $codeCallback Callback to get authorization code
     * @return array{success: bool, data: array{token: string, user: array}} Login response
     */
    public function oauth2Flow(
        string $provider,
        callable $redirectCallback,
        callable $codeCallback
    ): array {
        // Get redirect URL
        $redirectResponse = $this->oauth2Redirect($provider);
        $authUrl = $redirectResponse['data']['url'] ?? null;

        if ($authUrl === null) {
            throw new \RuntimeException('Failed to get OAuth2 authorization URL');
        }

        // Execute redirect callback
        $redirectCallback($authUrl);

        // Get authorization code
        $code = $codeCallback();

        // Exchange code for token
        return $this->oauth2Exchange($provider, $code);
    }
}
