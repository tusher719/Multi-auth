<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Spatie\Permission\Models\Role;

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





    // Admin Profile Update Controller
    public function AdminProfileStore(Request $request) {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->usernames = $request->usernames;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('uploads/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('uploads/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Success',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method





    // Admin Change Password
    public function AdminChangePassword() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    } // End Method





    // Admin Update Password
    public function AdminUpdatePassword(Request $request) {

        // Valiation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Match the old password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error',
            );

            return back()->with($notification);
        }

        /// Update The New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success',
        );

        return back()->with($notification);

    } // End Method



    // ===============|| Admin User All Method ||===============
    // All Admin Methods
    public function AllAdmin() {
        $alladmin =  User::where('role', 'admin')->get();
        return view("backend.pages.admin.all_admin", compact('alladmin'));
    } // End Methods


    public function AddAdmin() {

        $roles = Role::all();
        return view('backend.pages.admin.add_admin', compact('roles'));
    } // End Methods


    // Store Admin
    public function StoreAdmin(Request $request) {

        $user = new User();
        $user->usernames = $request->usernames;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Inserted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.admin')->with($notification);

    }


    // Edit Method
    public function EditAdmin($id) {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.pages.admin.edit_admin', compact('user', 'roles'));
    }


    // Update Method
    public function UpdateAdmin(Request $request,$id) {

        $user = User::findOrFail($id);
        $user->usernames = $request->usernames;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.admin')->with($notification);

    }


    // Delete Method
    public function AdminAdmin($id){
        $user = User::findOrFail($id);
        if(!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => 'New Admin User Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

}

