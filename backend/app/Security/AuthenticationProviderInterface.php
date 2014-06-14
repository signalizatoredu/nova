<?php

namespace Nova\Security;

interface AuthenticationProviderInterface
{
    public function __construct($dependencyInjector);

    /**
     * Authenticate an user
     *
     * @param string identification Identification
     * @param string password Password
     * @param boolean remember Param to set if it should be a persistent login
     *
     * @return boolean
     */
    public function authenticate($identification, $password, $remember = false);

    /**
     * Authenticate an user with a token from a persistent login
     *
     * @param identification Identification
     * @param series The token series
     * @param token The token
     *
     * @return boolean
     */
    public function authenticateWithToken($identification, $series, $token);

    /**
     * Deauthenticate the authenticated user
     *
     * @return void
     */
    public function deauthenticate();

    /**
     * Get the user ID of the currently authenticated user
     *
     * @return int
     */
    public function getAuthenticatedUserId();

    /**
     * Check if the current request is authenticated
     *
     * @return boolean
     */
    public function isAuthenticated();
}
