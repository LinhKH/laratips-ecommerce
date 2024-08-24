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
        $allCategories = Category::with(['categories','childrenCategories'])->get();
       
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'error' => fn () => $request->session()->get('error'),
                'success' => fn () => $request->session()->get('success'),
            ],
            'all_category' => $allCategories,
            'generalSettings' => DB::table('general_settings')->first(),
            'sitePages' => DB::table('pages')->where('status', '1')->get(),
        ];
    }
}
