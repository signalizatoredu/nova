<?php

namespace Nova\Security;

use Phalcon\DI\Injectable;

use Nova\Http\StatusCode as HttpStatusCode;
use Nova\Models\AuthToken;
use Nova\Models\User;
use Nova\Object;

class SessionAuthenticationProvider extends Injectable implements
    AuthenticationProviderInterface
{
    public function __construct($dependencyInjector)
    {
        $this->_dependecyInjector = $dependencyInjector;
    }

    /**
     * Generate a new or updates an existing AuthToken from an user
     * ID or from an user ID and existing AuthToken
     *
     * @param int userId User ID
     * @param AuthToken authToken Existing authentication token
     *
     * @return AuthToken|boolean
     */
    private function generateAuthToken(User $user, AuthToken $authToken = null)
    {
        if ($authToken == null) {
            $authToken = new AuthToken();

            $authToken->setUserId($user->getId());
            $authToken->setSeries(AuthToken::generateUuid());
        }

        $authToken->setToken(AuthToken::generateUuid());

        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        $date->add(\DateInterval::createFromDateString("+4 weeks"));

        $authToken->setExpirationDate($date->format("Y-m-d H:i:s"));

        if (!$authToken->save()) {
            foreach ($authToken->getMessages() as $message) {
                $this->logger->log("Error when saving AuthToken: " . $message);
            }

            return false;
        }

        return $authToken;
    }

    private function setAuthTokenCookie(User $user, AuthToken $authToken)
    {
        $token = $user->getUsername() . ":"
               . $authToken->getSeries() . ":"
               . $authToken->getToken();

        $timestamp = \DateTime::createFromFormat(
            "Y-m-d H:i:s",
            $authToken->getExpirationDate()
        )->getTimestamp();

        $this->cookies->set("token", $token, $timestamp);
    }

    private function destroySession()
    {
        if ($this->cookies->has("token")) {
            $this->cookies->get("token")->delete();
        }

        $this->session->remove("auth");
        $this->session->destroy();
    }

    private function registerSession($user)
    {
        $this->session->set("auth", array(
            "id" => $user->getId(),
            "identification" => $user->getUsername()
        ));
    }

    public function authenticate($identification, $password, $remember = false)
    {
        $user = User::findFirstByUsername($identification);

        if ($user) {
            if ($this->security->checkHash($password, $user->getPassword())) {
                if ($remember) {
                    $authToken = $this->generateAuthToken($user);
                    $this->setAuthTokenCookie($user, $authToken);
                }

                $this->registerSession($user);

                return true;
            }
        }

        return false;
    }

    public function authenticateWithToken($identification, $series, $token)
    {
        $user = User::findFirstByUsername($identification);

        if (!$user) {
            return false;
        }

        $authToken = AuthToken::findFirst(array(
            "conditions" => "user_id = :user_id: AND series = :series:",
            "bind" => array(
                "user_id" => $user->getId(),
                "series" => $series,
            )
        ));

        if ($authToken) {
            if ($authToken->getToken() == $token) {
                $authToken = $this->generateAuthToken($user, $authToken);
                $this->setAuthTokenCookie($user, $authToken);
                $this->registerSession($user);

                return true;
            }

            // Compromised token, delete it.
            // TODO: Delete all user related sessions
            $authToken->delete();
        }

        $this->destroySession();

        return false;
    }

    public function deauthenticate()
    {
        $this->destroySession();
    }

    public function getAuthenticatedUserId()
    {
        return $this->session->get("auth")["id"];
    }

    public function isAuthenticated()
    {
        if (!$this->session->has("auth")) {
            if ($this->cookies->has("token")) {
                $token = trim($this->cookies->get("token"));
                $credentials = explode(":", $token);
                $this->authenticateWithToken(
                    $credentials[0],
                    $credentials[1],
                    $credentials[2]
                );
            }
        }

        return $this->session->has("auth");
    }
}
