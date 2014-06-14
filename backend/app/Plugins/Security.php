<?php

namespace Nova\Plugins;

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclAdapter;
use Phalcon\Acl\Resource as AclResource;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class Security extends Plugin
{
    public function __construct($dependencyInjector)
    {
        $this->_dependecyInjector = $dependencyInjector;
    }

    public function getAcl()
    {
        if (!isset($this->persistent->acl)) {
            $acl = new AclAdapter();
            $acl->setDefaultAction(Acl::DENY);

            $roles = array(
                "user" => new AclRole("user"),
                "guest" => new AclRole("guest"),
            );

            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            // Read each json acl file
            // Oh.. and O(n^3) complexity. Great.
            foreach (new \GlobIterator(__DIR__ . "/../config/acl/*.json") as $file) {
                $resource = new AclResource($file->getBasename(".json"));

                $string = file_get_contents($file->getPathname());
                $obj = json_decode($string);

                foreach ($obj as $action => $allowedRoles) {
                    $acl->addResource($resource, $action);

                    foreach ($allowedRoles as $allowedRole) {
                        $acl->allow($allowedRole, $resource->getName(), $action);
                    }
                }
            }

            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        if ($this->auth->isAuthenticated()) {
            $role = "user";
        } else {
            $role = "guest";
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();
        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != Acl::ALLOW) {
            $dispatcher->forward(array(
                "controller" => "error",
                "action" => "unauthorized"
            ));

            return false;
        }
    }
}
