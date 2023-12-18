<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

/**
 *overide namespace Illuminate\Foundation\Auth\Access{trait AuthorizesRequests}
 */
trait Authorizable
{
    // ebility based class method method => authorization
    private $abilities = [
        'index' => 'view',
        'create' => 'add',
        'store' => 'add',
        'show' => 'read',
        'edit' => 'edit',
        'update' => 'edit',
        'destroy' => 'delete',
        'restore' => 'restore',
        'trashed' => 'restore',
    ];

    //  'view',
    //  'add',
    //  'edit',
    //  'delete',
    //  'restore',
    //  'read'

    /**
     * Override of callAction to perform the authorization before.
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());
        $action = Arr::get($this->getAbilities(), $method);
        // get method name with ability
        //view_role, view_user
        return $action ? $action . '_' . $routeName[0] : null;
    }

    private function getAbilities()
    {
        return $this->abilities;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}
