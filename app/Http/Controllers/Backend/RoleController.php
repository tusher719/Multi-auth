<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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


    // Edit Permission
    public function editPermission($id){

        $permission = Permission::findOrFail($id);
        return view('backend.pages.permissions.edit_permissions', compact('permission'));

    } // End Method


    // Update Permissions controller
    public function UpdatePermission(Request $request){
        $per_id = $request->id;

        Permission::FindOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.permission')->with($notification);
    } // End Method


    // Delete Permission
    public function deletePermission($id){

        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }




    // ================================||Import & Export Route||================================

    public function ImportPermission(){
        return view('backend.pages.permissions.import_permissions');
    } // End Method

    // export Permissions
    public function Export(){
        return Excel::download(new PermissionExport, 'permission.xlsx');
    } // End Method


    public function Import(Request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } // End Method
}
