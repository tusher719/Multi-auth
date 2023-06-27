<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //
    public function AllPermission(){
        $permissions = Permission::all();
        return view('backend.pages.permissions.all_permissions', compact('permissions'));
    } // End Method

    // Add Permissions controller
    public function AddPermission(){
        return view('backend.pages.permissions.add_permissions');
    } // End Method

    // Store Permissions controller
    public function StorePermission(Request $request){
        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.permission')->with($notification);
    } // End Method


}
