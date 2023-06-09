<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Page View Controller
    public function AdminDashboard(){
        return view('admin.index');
    } // End Method


    // Admin Logout Controller
    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } // End Method


    // admin Login Controller
    public function AdminLogin(Request $request){
        Return view('admin.admin_login');
    } // End Method


    // Admin Profile Controller
    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    } // End Method


}
