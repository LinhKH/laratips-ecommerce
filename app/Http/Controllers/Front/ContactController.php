<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {

        return Inertia::render('ContactUs', [
            'title' => 'Contact Us', 
            'breadcrumb' => ['Dashboard'=>'admin.dashboard']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:contact_us,email',
            'phone' => 'required',
            'description' => 'required',
        ]);
        DB::table('contact_us')->insert([
            'client' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return to_route('contact_us.index')->with(['success' => 'Account Created Successfully.']);
    }
}
