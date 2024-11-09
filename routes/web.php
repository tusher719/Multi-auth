<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\Creative_Park\CpController;
use App\Http\Controllers\Backend\Creative_Park\PanelController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TodosController;
use App\Http\Controllers\Backend\WalletController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    // Admin Login
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    //Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');


    // Permissions All Route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

        // Import & Export Route
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });

    // Roles All Route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');


        // Roles in Permissions
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
    });


    // Admin User All Route
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('permission:admin.all');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('permission:admin.add');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('permission:admin.edit');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'AdminAdmin')->name('delete.admin')->middleware('permission:admin.delete');
    });

    // Creative Park All Route
    Route::controller(CpController::class)->group(function () {
        Route::get('/creative-park/all/students', 'AllMembers')->name('all.cp.members')->middleware('permission:admin.all');
        Route::get('/creative-park/add/students', 'AddMember')->name('add.cp.member')->middleware('permission:admin.add');
        Route::post('/creative-park/store/students', 'StoreMembers')->name('cp.store.members');
        Route::get('/creative-park/view/students/{id}', 'ViewDetails')->name('cp.view.details');
        Route::get('/creative-park/clone/students/{id}', 'CloneMembers')->name('cp.clone.students');
        Route::get('/creative-park/edit/students/{id}', 'EditMembers')->name('cp.edit.students');
        Route::post('/creative-park/update/students/{id}', 'UpdateMembers')->name('cp.update.students');
        Route::get('/creative-park/delete/students/{id}', 'DeleteStudent')->name('cp.delete.students');
        Route::delete('/creative-park/students/delete-all', 'MultiDelete')->name('multi.delete');
        Route::get('/students/inactive/{id}', 'InactiveStudent')->name('cp.inactive.students');
        Route::get('/students/active/{id}', 'ActiveStudent')->name('cp.active.students');

        // routes/web.php
        Route::get('/get-student-details', 'getStudentDetails')->name('student.details');








        // Import & Export Route
        Route::get('/creative-park/import/cp_students', 'ImportStudents')->name('import.students');
        Route::get('/creative-park/export/student', 'ExportStudent')->name('export.student');
        Route::post('/creative-park/import/student', 'ImportStudent')->name('import.student');
    });

    // Creative Park All Route
    Route::controller(PanelController::class)->group(function () {
        Route::get('/creative-park/panel/all/panel', 'AllPanel')->name('all.panel')->middleware('permission:admin.all');
        // Route::post('/creative-park/panel/all/position/store', 'StorePanel')->name('store.panel');


        Route::post('creative-park/panel/store', 'StorePanel')->name('store.panel');
        Route::get('creative-park/panel/edit/{id}', 'editPanel');
        Route::put('creative-park/panel/update', 'updatePanel')->name('update.panel');
        Route::delete('creative-park/panel/delete/{id}', 'deletePanel')->name('delete.panel');
    });

    // Tag All Route
    Route::controller(TagController::class)->group(function () {
        Route::get('/tag/all', 'AllTag')->name('all.tag')->middleware('permission:admin.all');
        Route::post('/tag/store', 'StoreTag')->name('store.tag');
        Route::get('/tag/edit/{id}', 'EditTag')->name('edit.tag');
        Route::post('/tag/update/{id}', 'UpdateTag')->name('update.tag');
        Route::get('/tag/delete/{id}', 'DeleteTag')->name('delete.tag');
        Route::post('/tag/mark/delete', 'MarkDelete')->name('Mark.delete');
    });

    // Wallet All Route
    Route::controller(WalletController::class)->group(function () {
        Route::get('/wallet', 'Wallet')->name('wallet');
        Route::post('/wallet/store', 'StoreWallet')->name('store.wallet');
        Route::get('/wallet/edit/{id}', 'EditWallet')->name('edit.wallet');
        Route::post('/wallet/update/{id}', 'UpdateWallet')->name('update.wallet');
        Route::get('/wallet/delete/{id}', 'DeleteWallet')->name('delete.wallet');
        Route::get('/wallet/analytics', 'ShowPieChart')->name('wallet.analytics');
        Route::get('/wallet/record', 'recordPage')->name('wallet.record');
        Route::post('/wallet/record/submit-form', 'SumitForm')->name('submit.form');
    });

    // Tag All Route
    Route::controller(TodosController::class)->group(function () {
        Route::get('/todos/all', 'AllTodos')->name('all.todos');
        Route::post('/todos/store', 'StoreTodos')->name('store.todos');
        Route::get('/todos/edit/{id}', 'EditTodos')->name('edit.todos');
        Route::post('/todos/update/{id}', 'UpdateTodos')->name('update.todos');
        Route::get('/todos/delete/{id}', 'DeleteTodos')->name('delete.todos');
        // Route::post('/todos/mark/delete', 'MarkDelete')->name('Mark.delete');
    });
}); // End Group Admin Middleware


// Agent Group Middleware
Route::middleware(['auth', 'roles:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
}); // End Group Agent Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
