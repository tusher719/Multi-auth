<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Todos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodosController extends Controller
{
    //
    public function AllTodos()
    {
        $todos   = Todos::latest()->get();
        $total  = Todos::count();
        return view('backend.todos.all_todos', compact('todos', 'total'));
    }


    // Store Method
    public function StoreTodos(Request $request)
    {
        $data                   = new Todos();
        $data->user_id          = Auth::id();
        $data->name             = $request->name;
        $data->todo_slug        = strtolower(str_replace(' ', '-', $request->name));
        $data->end_date         = $request->end_date;
        $data->note             = $request->note;
        $data->status           = $request->status;
        $data->save();

        $notification = array(
            'message'       => 'New Todo Added Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    }

    // Edit Method
    public function EditTodos($id)
    {
        $todos   = Todos::latest()->get();
        $data   = Todos::findOrFail($id);
        $total  = Todos::count();
        return view('backend.todos.edit_todo', compact('todos', 'data', 'total'));
    }

    // Update Method
    public function UpdateTodos(Request $request, $id)
    {
        $data = Todos::where('id', $id)->first();

        // $data->auth_id  = Auth::user()->id;
        $data->name             = $request->name;
        $data->todo_slug        = strtolower(str_replace(' ', '-', $request->name));
        $data->end_date         = $request->end_date;
        $data->note             = $request->note;
        $data->status           = $request->status;
        $data->save();

        $notification = array(
            'message'       => 'New Todo Updated Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->route('all.todos')->with($notification);
    } // End Method
}
