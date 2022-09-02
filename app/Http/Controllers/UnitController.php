<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unit;
use DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:unit-setup', ['only' => ['index']]);
        $this->middleware('permission:unit-setup', ['only' => ['create', 'store']]);
        $this->middleware('permission:unit-setup', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:unit-setup', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('setup.unit');
    }
    public function LoadAll()
    {
        $Unit = unit::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($Unit)
            ->addIndexColumn()
            ->addColumn('status', function (Unit $Unit) {
                return $Unit->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($Unit) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Unit->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Unit->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $title = $request->title;
        $short = $request->short;
        $description = $request->description;
        $status = $request->status;

        $insert = unit::insert([
            "title" => $title,
            "Shortcut" => $short,
            "description" => $description,
            "status" => $status,
        ]);
        return response()->json($insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->dataid;
        $units = unit::find($id);
        return response()->json($units);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
      
        $update = unit::find($id);
        if (!is_null($update)) {
            $update->title = $request->title;
            $update->Shortcut = $request->short;
            $update->description = $request->description;
            $update->status = $request->status;
            $update->update();
        }
        return response()->json($update);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $unitdelte = unit::find($id);
        if (!is_null($unitdelte)) {
            $unitdelte->delete();
            return response()->json($unitdelte);
        }
    }
}
