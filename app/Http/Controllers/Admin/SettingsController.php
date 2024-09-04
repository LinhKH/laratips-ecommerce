<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    private string $routeResourceName = 'social_settings';
    public function general_settings(Request $request){
        if($request->input()){
            $request->validate([
                // 'site_logo'=>'image|mimes:jpg,jpeg,png,svg',
                'site_name'=>'required',
                'site_title'=>'required',
                'theme_color'=>'required',
                'copyright'=>'required',
                'currency'=>'required',
                'description'=>'required',
            ]);

            if($request->site_logo != ''){
                $path = public_path().'/site/';

                //code for remove old file
                if($request->old_logo != '' && $request->old_logo != null){
                    $file_old = $path.$request->old_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->site_logo;
                $filename = $request->site_logo->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_logo;
            }
            $phone = '';
            if($request->phone && $request->phone != ''){
                $phone = $request->phone;
            }
            $email = '';
            if($request->email && $request->email != ''){
                $email = $request->email;
            }
            $address = '';
            if($request->address && $request->address != ''){
                $address = $request->address;
            }

            // dd($request->toArray());

            $update = DB::table('general_settings')->update([
                'site_logo'=>$filename,
                'site_name'=>$request->site_name,
                'site_title'=>$request->site_title,
                'theme_color'=>$request->theme_color,
                'copyright'=>$request->copyright,
                'currency'=>$request->currency,
                'description'=>$request->description,
                'phone'=>$phone,
                'email'=>$email,
                'address'=>$address,
            ]);
            return to_route('admin.general_settings.index')->with('success', 'General Setting Updated Successfuly!.');
        }else{
            $settings = DB::table('general_settings')->first();
            return inertia()->render('General/Create', [
                'data' => $settings,
                'title' => 'General Setting Management',
                'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            ]);
        }
    }


    public function profile_settings(Request $request){
        if($request->input()){
            $request->validate([
                'admin_name'=>'required',
                'admin_email'=>'required',
                'username'=>'required',
            ]);

            $update = DB::table('admin')->update([
                'admin_name'=>$request->admin_name,
                'admin_email'=>$request->admin_email,
                'username'=>$request->username,
            ]);
            return $update;
        }else{
            $settings = DB::table('admin')->get();
            return view('admin.settings.profile',['data'=>$settings]);
        }
    }

    public function change_password(Request $request){
        if($request->input()){
            $request->validate([
                'password'=>'required',
                'new_pass'=>'required',
                're_pass'=>'required',
            ]);

            $select = DB::table('admin')->pluck('password');

            if(Hash::check($request->password,$select[0])){
                $update = DB::table('admin')->update([
                    'password'=>Hash::make($request->new_pass),
                ]);
                return '1';
            }else{
                return response()->json(['password'=>'Please Enter Correct Old Password']);
            }
        }
    }

    public function social_settings(Request $request){
        if($request->input()){
            $update = DB::table('social_links')->update([
                'instagram'=>$request->instagram,
                'twitter'=>$request->twitter,
                'facebook'=>$request->facebook,
                'tiktok'=>$request->tiktok,
                'zalo'=>$request->zalo,
            ]);
            return to_route('admin.social_settings.index')->with('success', 'Social Updated Successfuly!.');
        }else{
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
