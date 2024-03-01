<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function AllTag() {
        $tags = Tag::latest()->get();
        $total      = Tag::count();
        return view('backend.tag.tag_all',compact('tags','total'));
    }

    public function StoreTag (Request $request) {
//        $request->validate(['name' => 'required']);

//        dd($request->all());
        Tag::create([
            'name' => $request->name
        ]);

        $notification = array(
            'message' => 'New Tag Added Successfully!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    // Delete Permission
    public function DeleteTag($id){

        Tag::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Tag Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } // End Method
}
