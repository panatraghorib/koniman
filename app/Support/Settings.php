<?php

namespace App\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


class Settings
{

    static $permissions_group = [
        'user' => [],
        'role' => [],
        'post' => [],
        'category' => [],
        'cabor' => [],
    ];

    public static function getPermissionsGroup(): array
    {
        return self::$permissions_group;
    }

    public static function getRouteName()
    {
        // $routes = Route::getRoutes();

        // $routeNames = [];

        // Loop melalui setiap route dan ambil nama-nama route
        // foreach ($routes as $route) {
        //     $routeName = $route->getName();
        //     if ($routeName) {
        //         $routeNames[] = $routeName;
        //     }
        // }

        // return $routeNames;
    }
}
