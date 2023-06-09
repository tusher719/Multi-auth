<?php

namespace App\Http\Controllers;

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
}
