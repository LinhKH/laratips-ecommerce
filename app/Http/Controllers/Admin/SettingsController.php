<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    private string $routeResourceName = 'social_settings';
    public function general_settings(Request $request)
    {
        if ($request->input()) {
            $request->validate([
                // 'site_logo'=>'image|mimes:jpg,jpeg,png,svg',
                'site_name' => 'required',
                'site_title' => 'required',
                'theme_color' => 'required',
                'copyright' => 'required',
                'currency' => 'required',
                'description' => 'required',
            ]);

            if ($request->site_logo != '') {
                $path = public_path() . '/site/';

                //code for remove old file
                if ($request->old_logo != '' && $request->old_logo != null) {
                    $file_old = $path . $request->old_logo;
                    if (file_exists($file_old)) {
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->site_logo;
                $filename = $request->site_logo->getClientOriginalName();
                $file->move($path, $filename);
            } else {
                $filename = $request->old_logo;
            }
            $phone = '';
            if ($request->phone && $request->phone != '') {
                $phone = $request->phone;
            }
            $email = '';
            if ($request->email && $request->email != '') {
                $email = $request->email;
            }
            $address = '';
            if ($request->address && $request->address != '') {
                $address = $request->address;
            }

            $update = DB::table('general_settings')->update([
                'site_logo' => $filename,
                'site_name' => $request->site_name,
                'site_title' => $request->site_title,
                'theme_color' => $request->theme_color,
                'copyright' => $request->copyright,
                'currency' => $request->currency,
                'description' => $request->description,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
            ]);
            return to_route('admin.general_settings.index')->with('success', 'General Setting Updated Successfuly!.');
        } else {
            $settings = DB::table('general_settings')->first();
            return inertia()->render('General/Create', [
                'data' => $settings,
                'title' => 'General Setting Management',
                'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            ]);
        }
    }

    public function profile_settings(Request $request)
    {
        if ($request->input()) {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            $update = $request->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return to_route('admin.profile_settings.index')->with('success', 'Profile Updated Successfuly!.');
        } else {
            $settings = $request->user();
            return inertia()->render('Profiles/Create', [
                'data' => $settings,
                'title' => 'Profile Admin',
                'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            ]);
        }
    }

    public function change_password(Request $request)
    {
        if ($request->input()) {
            $request->validate([
                'password' => ['required', 'current_password'],
                'new_pass' => ['min:6', 'required_with:password_confirmation', 'same:re_pass'],
                're_pass' => ['required'],
            ]);

            $update = $request->user()->update([
                'password' => Hash::make($request->new_pass),
            ]);
            return to_route('admin.profile_settings.index')->with('success', 'Password Updated Successfuly!.');
        }
    }

    public function social_settings(Request $request)
    {
        if ($request->input()) {
            $update = DB::table('social_links')->update([
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'zalo' => $request->zalo,
            ]);
            return to_route('admin.social_settings.index')->with('success', 'Social Updated Successfuly!.');
        } else {
            $social = DB::table('social_links')->first();

            return inertia()->render('Social/Create', [
                'data' => $social,
                'title' => 'Social Management',
                'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
                'filters' => (object) $request->all(),
                'routeResourceName' => $this->routeResourceName,
            ]);
        }
    }
}
