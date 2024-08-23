<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequestsForAdmin extends Middleware
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
                'error' => fn () => $request->session()->get('error'),
                'success' => fn () => $request->session()->get('success'),
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
                    'isVisible' => true
                ],
                [
                    'label' => 'Roles',
                    'url' => route('admin.roles.index'),
                    'isActive' => $request->routeIs('admin.roles.*'),
                    'isVisible' => true
                ],
                [
                    'label' => 'Users',
                    'url' => route('admin.users.index'),
                    'isActive' => $request->routeIs('admin.users.*'),
                    'isVisible' => true
                ],
                [
                    'label' => 'Categories',
                    'url' => route('admin.categories.index'),
                    'isActive' => $request->routeIs('admin.categories.*'),
                    'isVisible' => true
                ],
                [
                    'label' => 'Products',
                    'url' => route('admin.products.index'),
                    'isActive' => $request->routeIs('admin.products.*'),
                    'isVisible' => true
                ],
            ],
        ];
    }
}
