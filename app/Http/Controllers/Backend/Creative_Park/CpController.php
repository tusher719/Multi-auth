<?php

namespace App\Http\Controllers\Backend\Creative_Park;

use App\Http\Controllers\Controller;
use App\Models\CP\Creative_park;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpController extends Controller
{
    //
    public function AllMembers() {
        $students = Creative_park::all();
        return view('backend.creative_park.all_members', compact('students'));
    }


    // Add Members
    public function AddMember() {
        return view('backend.creative_park.add_members');
    }


    // Admin Profile Update Controller
    public function StoreMembers(Request $request) {

//        $auth_id->$id;
        $data = new Creative_park();
        $data->auth_id = Auth::user()->id;
        $data->student_id = $request->student_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->batch = $request->batch;
        $data->section = $request->section;
        $data->gender = $request->gender;
        $data->date = $request->dob;
        $data->blood = $request->blood;
//        dd($request->all());

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('uploads/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('uploads/students_img'),$filename);
            $data['photo'] = $filename;
        }
//
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Success',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method

    // Edit Method
    public function ViewDetails($id) {
        $user = User::findOrFail($id);
        $details = Creative_park::findOrFail($id);
        return view('backend.creative_park.view_members', compact('details'));
    }
}
