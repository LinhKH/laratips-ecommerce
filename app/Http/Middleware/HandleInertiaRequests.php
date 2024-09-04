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

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'front.app';

    public function rootView(Request $request): string
    {
        if ($request->routeIs('admin.*')) {
            return 'admin.app';
        }

        return $this->rootView;
    }

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
        $user = null;
        $userSession = null;
        $wishlist = 0;
        $cart = 0;

        if (Session::has('user_name')) {
            $userSession['user_name'] = Session::get('user_name');
            $userSession['user_id'] = Session::get('user_id');
            $userSession['user_city'] = Session::get('user_city');
        }

        if (Session::has('user_id')) {
            $user = Session::get('user_id');
            $wishlist_items = Users::where('user_id', $user)->pluck('wishlist')->first();
            $wishlist = count(array_filter(explode(',', $wishlist_items)));
            $cart = Cart::where('product_user', $user)->count();
        }
        $allCategories = Category::with(['categories','childrenCategories'])->get();
        
        return [
            ...parent::share($request),
            'all_category' => $allCategories,
            'generalSettings' => DB::table('general_settings')->first(),
            'socialLinks' => DB::table('social_links')->first(),
            'sitePages' => DB::table('pages')->where('status', '1')->get(),
            'user' => $user,
            'userSession' => $userSession,
            'userWishlist' => $wishlist,
            'userCart' => $cart,
            'auth' => [
                'user' => Users::where('user_id', $user)->first(),
            ],
            'flash' => [
                'error' => fn () => $request->session()->get('error'),
                'success' => fn () => $request->session()->get('success'),
            ],
        ];
    }
}
