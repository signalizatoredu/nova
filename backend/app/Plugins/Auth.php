<?php

namespace Nova\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\Dispatcher;

use Nova\Models\AuthToken;
use Nova\Models\User;

class Auth extends Component
{
    private $authUser = null;

    public function getAuthUser()
    {
        return isset($this->authUser) ? $this->authUser : null;
    }

    /**
     * Check the auth headers and see if they're valid
     *
     * @return boolean
     */
    public function validateAuthHeaders()
    {
        $username = $this->request->getHeader("HTTP_AUTH_USERNAME");
        $series = $this->request->getHeader("HTTP_AUTH_SERIES");
        $token = $this->request->getHeader("HTTP_AUTH_TOKEN");

        $user = User::findFirstByUsername($username);

        if (!$user) {
            return false;
        }

        $authToken = AuthToken::findFirst(array(
            "conditions" => "user_id = :user_id: and series = :series:",
            "bind" => array(
                "user_id" => $user->getId(),
                "series" => $series,
            )
        ));

        if ($authToken) {
            if ($authToken->getToken() == $token) {
                $this->authUser = $user;

                return true;
            }

            // Compromised token, delete it.
            // TODO: Delete all user related sessions
            $authToken->delete();
        }

        return false;
    }
}
