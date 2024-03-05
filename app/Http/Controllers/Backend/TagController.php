<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    //
    public function AllTag() {
        $tags   = Tag::latest()->get();
        $total  = Tag::count();
        return view('backend.tag.tag_all',compact('tags','total'));
    }

    public function StoreTag (Request $request) {
        $request->validate([
            'name' => 'required | unique:tags'
        ], [
            'name' => 'This name already exists!',
        ]);

//        dd($request->all());
        $data           = new Tag();
        $data->auth_id  = Auth::user()->id;
        $data->name     = $request->name;
        $data->save();

        $notification = array(
            'message'       => 'New Tag Added Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    }

    // Edit Method
    public function EditTag($id) {
        $tags   = Tag::latest()->get();
        $data   = Tag::findOrFail($id);
        $total  = Tag::count();
        return view('backend.tag.edit_tag', compact('tags', 'data','total'));
    }


    // Update Method
    public function UpdateTag (Request $request, $id) {
        $data = Tag::where('id', $id)->first();

        $data->auth_id  = Auth::user()->id;
        $data->name     = $request->name;
        $data->save();

        $notification = array(
            'message'       => 'New Tag Added Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->route('all.tag')->with($notification);
    } // End Method

    // Delete Permission
    public function DeleteTag($id){
        Tag::findOrFail($id)->delete();

        $notification = array(
            'message'       => 'Tag Deleted Successfully',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    } // End Method

    // Mark Delete Function
    function MarkDelete(Request $request){
        if (is_null($request->mark)) {
            $notification = array(
                'message'       => 'Please Select Tags',
                'alert-type'    => 'warning',
            );
            return redirect()->back()->with($notification);
        }

        foreach ($request->mark as $mark_id){
            Tag::find($mark_id)->delete();
        }
        $notification = array(
            'message'       => 'Marked Tags Deleted',
            'alert-type'    => 'error',
        );
        return redirect()->back()->with($notification);
    }

}
