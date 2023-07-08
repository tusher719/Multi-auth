<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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





    // ================================||All Roles Route||================================

    // All Role
    public function AllRoles(){
        $role = Role::all();
        return view('backend.pages.roles.all_roles', compact('role'));
    } // End Method


    // Add Roles
    public function AddRoles(){
        return view('backend.pages.roles.add_roles');
    } // End Method


    // Store Roles
    public function StoreRoles(Request $request){
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.roles')->with($notification);
    } // End Method


    // Edit Permission
    public function EditRoles($id){
        $roles= Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));

    } // End Method


    // Update Permissions controller
    public function UpdateRoles(Request $request){
        $role_id = $request->id;

        Role::FindOrFail($role_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.roles')->with($notification);
    } // End Method


    // Delete Permission
    public function DeleteRoles($id){

        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } // End Method




    // ================================||Add Role Permission all Method||================================
    // All Roles Permission
    public function AddRolesPermission() {

        $roles = Role::all();
        $permission = Permission::all();
        $permission_group = User::getPermissionGroups();

        return view('backend.pages.role_setup.add_roles_permission', compact('roles', 'permission', 'permission_group'));
    } // End Method


    //
    public function RolePermissionStore(Request $request) {

        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        } // End Foreach Role Permissions

        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.roles.permission')->with($notification);

    } // End Method



    // All Roles Permission page view
    public function AllRolesPermission() {

        $roles = Role::all();
        return view('backend.pages.role_setup.all_roles_permission', compact('roles'));
    } // End Method


    // Admin Edit Role Permissions
    public function AdminEditRoles($id) {
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $permission_group = User::getPermissionGroups();

        return view('backend.pages.role_setup.edit_roles_permission', compact('role', 'permission', 'permission_group'));
    } // End Method



    // Admin Role Permissions Update
    public function AdminRolesUpdate(Request $request, $id) {

        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.roles.permission')->with($notification);

    } // End Method


}
