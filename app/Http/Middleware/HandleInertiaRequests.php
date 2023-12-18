<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            // 'flash' => [
            //     'message' => fn () => $request->session()->get('message')
            // ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
            ],
            'toast' => session('toast'),
            'user_roles' => $request->user() ? $request->user()->roles->pluck('name') : [],
            'user_permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
            'isAdmin' => auth()->user()?->hasRole('Superadmin'),
            'setting' => [
                'instansi_name' => setting('agencyName'),
                'website_name' => setting('appName', env('APP_NAME', 'LaraTra')),
                'website_logo' => setting('websiteLogo') ? URL::to(asset('storage/' . setting('websiteLogo'))) : null,
                // 'website_logo' => setting('websiteLogo') ? URL::route('image', ['path' => setting('websiteLogo')]) : null,
            ],
        ];
    }
}