<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'admin.app';

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
            'flash' => [
                'success' => $request->session()->get('success'),
            ],
            'menus' => [
                [
                    'label' => 'Dashboard',
                    'url' => route('admin.dashboard'),
                    'isActive' => $request->routeIs('admin.dashboard'),
                    'isVisible' => true,
                ],
                [
                    'label' => 'Permissions',
                    'url' => route('admin.permissions.index'),
                    'isActive' => $request->routeIs('admin.permissions.*'),
                    'isVisible' => $request->user()?->can('view permissions module'),
                ],
                [
                    'label' => 'Roles',
                    'url' => route('admin.roles.index'),
                    'isActive' => $request->routeIs('admin.roles.*'),
                    'isVisible' => $request->user()?->can('view roles module'),
                ],
                [
                    'label' => 'Users',
                    'url' => route('admin.users.index'),
                    'isActive' => $request->routeIs('admin.users.*'),
                    'isVisible' => $request->user()?->can('view users module'),
                ],
                [
                    'label' => 'Categories',
                    'url' => route('admin.categories.index'),
                    'isActive' => $request->routeIs('admin.categories.*'),
                    'isVisible' => $request->user()?->can('view categories module'),
                ],
                // [
                //     'label' => 'Products',
                //     'url' => route('admin.products.index'),
                //     'isActive' => $request->routeIs('admin.products.*'),
                //     'isVisible' => $request->user()?->can('view products module'),
                // ],
            ],
        ];
    }
}
