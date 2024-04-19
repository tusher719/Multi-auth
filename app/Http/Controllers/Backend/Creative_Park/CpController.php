<?php

namespace App\Http\Controllers\Backend\Creative_Park;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\CP\Creative_park;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CpController extends Controller
{
    //
    public function AllMembers() {
        $total          = Creative_park::count();
        $activeUser     = Creative_park::where('status', 'active')->count();
        $inactiveUser   = Creative_park::where('status', 'inactive')->count();
        $students       = Creative_park::all();
        return view('backend.creative_park.all_members', compact('total','activeUser','inactiveUser','students'));
    }

    // Add Members
    public function AddMember() {
        $tags = Tag::all();
        return view('backend.creative_park.add_members', compact('tags'));
    }

    // Members Added Controller
    public function StoreMembers(Request $request) {
//        $auth_id->$id;
        $data = new Creative_park();
        $data->auth_id      = Auth::user()->id;
        $data->student_id   = $request->student_id;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->phone        = $request->phone;
        $data->phone_2      = $request->phone_2;
        $data->batch        = $request->batch;
        $data->section      = $request->section;
        $data->gender       = $request->gender;
        $data->date         = $request->dob;
        $data->blood        = $request->blood;
        $data->status        = $request->status == true ? 'active':'inactive';

        if($request->file('photo')){
            $file = $request->file('photo');
//            @unlink(public_path('uploads/students_img/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('uploads/students_img'),$filename);
            $data['photo'] = $filename;
        }
        $data->save();

        if($request->has('tags')){
            $data->tags()->attach($request->tags);
        }

        $notification = array(
            'message'       => 'New Student Added Success',
            'alert-type'    => 'success',
        );
        return redirect()->route('all.cp.members')->with($notification);

    } // End Method

    // Edit Method
    public function ViewDetails($id) {
//        $user = User::findOrFail($id);
        $details = Creative_park::findOrFail($id);
        return view('backend.creative_park.view_members', compact('details'));
    }

    // Edit Method
    public function EditMembers($id) {
        $info= Creative_park::findOrFail($id);
        $tags = Tag::all();
        return view('backend.creative_park.edit_members', compact('info','tags'));
    }

    // Update Method
    public function UpdateMembers(Request $request, $id) {
        $data = Creative_park::where('id', $id)->first();

        $data->student_id   = $request->student_id;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->phone        = $request->phone;
        $data->phone_2        = $request->phone_2;
        $data->batch        = $request->batch;
        $data->section      = $request->section;
        $data->gender       = $request->gender;
        $data->date         = $request->dob;
        $data->blood        = $request->blood;
        $data->status        = $request->status == true ? 'active':'inactive';

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('uploads/students_img/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('uploads/students_img'),$filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $data->tags()->sync($request->tags);

        $notification = array(
            'message'       => 'Student Info Updated Successfully',
            'alert-type'    => 'success',
        );
        return redirect()->route('all.cp.members')->with($notification);
    }




    // Delete Method
    public function DeleteStudent($id) {

        $data = Creative_park::find($id);

        if (!is_null($data->photo)) {
            $img_path = public_path('uploads/students_img/'.$data->photo);
            unlink($img_path);
        }

        $data->delete();
        $data->tags()->detach();

        $notification = array(
            'message'       => 'Student Deleted Successfully',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    } // End Method


    public function MultiDelete(Request $request)
    {
        $ids = $request->ids;
        Creative_park::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['status'=>true,'message'=>"User successfully removed."]);

    }


    // Product Active Inactive
    public function InactiveStudent($id) {
        Creative_park::findOrFail($id)->update(['status' => 'inactive']);

        $notification = array(
            'message'       => 'User Inactive',
            'alert-type'    => 'warning'
        );
        return redirect()->back()->with($notification);
    }

    public function ActiveStudent($id) {
        Creative_park::findOrFail($id)->update(['status' => 'active']);
        $notification = array(
            'message'       => 'User Active',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    // Clone Student Method
    public function CloneMembers($id) {
        $info= Creative_park::findOrFail($id);
        return view('backend.creative_park.clone_members', compact('info'));
    } // End Method



    // File Import Method
    public function ImportStudents() {
        return view('backend.creative_park.import_students');
    } // End Method

    public function ImportStudent(Request $request) {
        Excel::import(new StudentsImport, $request->file('import_file'));
        $notification = array(
            'message'       => 'Students Imported Successfully',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    } // End Method

    // File Export Permissions Method
    public function ExportStudent(){
        return Excel::download(new StudentExport, 'cp_students.xlsx');
    } // End Method
}


