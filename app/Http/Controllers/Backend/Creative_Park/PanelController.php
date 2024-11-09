<?php

namespace App\Http\Controllers\Backend\Creative_Park;

use App\Http\Controllers\Controller;
use App\Models\CP\Panel as CPPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    //
    public function AllPanel()
    {
        // $panel       = Panel::where('position_roll', 'ASC')->get();
        $panel       = CPPanel::with('user')->get();
        return view('backend.creative_park.panel.panel', compact('panel'));
    }

    public function StorePanel(Request $request)
    {
        $request->validate([
            'position' => 'required|string',
            'position_roll' => 'required|string'
        ]);

        $data = new CPPanel();
        $data->auth_id = Auth::user()->id;
        $data->position = $request->position;
        $data->position_roll = $request->position_roll;
        $data->save();

        return response()->json(['status' => 'success', 'message' => 'New Position Added Successfully!']);
    }


    public function deletePanel($id)
    {
        $panel = CPPanel::findOrFail($id);
        $panel->delete();

        return redirect()->route('all.panel')->with('success', 'Panel deleted successfully!');
    }




    public function editPanel($id)
    {
        $panel = CPPanel::findOrFail($id);
        return response()->json($panel);
    }

    public function updatePanel(Request $request)
    {
        $request->validate([
            'position' => 'required|string',
            'position_roll' => 'required|string'
        ]);

        $panel = CPPanel::findOrFail($request->id);
        $panel->position = $request->position;
        $panel->position_roll = $request->position_roll;
        $panel->save();

        return response()->json(['status' => 'success', 'message' => 'Panel updated successfully!']);
    }
}
