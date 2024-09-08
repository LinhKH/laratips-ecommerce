<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAddress;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->has('user_name')) {
            $user_id = session()->get('user_id');
            $addresses = UserAddress::with(['country','state','city'])->where('user_id', $user_id)->get();
            return Inertia::render('MyAddress', ['addresses' => $addresses]);
        } else {
            return Inertia::render('UserLogin');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session()->has('user_name')) {
            $user_id = session()->get('user_id');
            $request->validate([
                'name' => ['required', 'max:200'],
                'email' => ['required', 'max:200', 'email'],
                'phone' => ['required', 'max:200'],
                'country' => ['required', 'max:200'],
                'state' => ['required', 'max:200'],
                'city' => ['required', 'max:200'],
                'address' => ['required'],
            ]);
    
            $address = new UserAddress();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->email = $request->email;
            $address->phone = $request->phone;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->save();
    
            return redirect()->back()->with('success', 'Address Created Successfuly!.');
        } else {
            return Inertia::render('UserLogin');
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (session()->has('user_name')) {
            $user_id = session()->get('user_id');
            $user = Users::where(['user_id' => $user_id])->first();
            $country = Country::select(['countries.*'])->get();
            $state = State::select(['states.*'])->where('status', 1)->get();
            $city = City::select(['cities.*'])->where('status', 1)->get();
            $address = UserAddress::findOrFail($id);
            return Inertia::render('EditAddress', ['user' => $user, 'city' => $city, 'state' => $state, 'country' => $country, 'address' => $address]);
        } else {
            return Inertia::render('UserLogin');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'max:200', 'email'],
            'phone' => ['required', 'max:200'],
            'country' => ['required', 'max:200'],
            'state' => ['required', 'max:200'],
            'city' => ['required', 'max:200'],
            'address' => ['required'],
        ]);

        $address = UserAddress::findOrFail($id);
        $address->user_id = session()->get('user_id');
        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->save();

        return to_route('address.index')->with('success', 'Address Updated Successfuly!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = UserAddress::findOrFail($id);
        $address->delete();
        return to_route('address.index')->with('success', 'Address deleted successfully.');
    }
}
