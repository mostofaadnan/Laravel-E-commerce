<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Image;
use File;
use App\Models\Store;

class StoreController extends Controller
{
    function __construct()
    {
        /*   $this->middleware('permission:Store-List|Store-create|Store-edit|Store-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:Store-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Store-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Store-delete', ['only' => ['destroy']]); */
    }


    public function index()
    {
        return view('Store.index');
    }
    public function LoadAll(Request $request)
    {
        $Store = Store::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($Store)
            ->addIndexColumn()
            ->addColumn('action', function ($Store) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Store->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Store->id . '">Delete</a>';
                return $button;
            })

            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Store = new Store;

        $Store->name = $request->name;
        $Store->address = $request->address;
        $Store->mobile = $request->mobile;
        $Store->email = $request->email;
        $Store->description = $request->description;
        $Store->googleMap = $request->googleMap;
        $Store->status = $request->status;

        if ($request->hasFile('file')) {
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/CompanyStore/' . $img);
            Image::make($image)->save($location);
            $Store->image = $img;
        }
        $Store->save();
        return response()->json($Store);
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
        $category = Store::find($id);
        return response()->json($category);
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
        $Store = Store::find($id);
        $Store->name = $request->name;
        $Store->address = $request->address;
        $Store->mobile = $request->mobile;
        $Store->email = $request->email;
        $Store->description = $request->description;
        $Store->googleMap = $request->googleMap;
        $Store->status = $request->status;
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/CompanyStore/' . $Store->image)) {
                File::delete('storage/app/public/CompanyStore/' . $Store->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/CompanyStore/' . $img);
            Image::make($image)->save($location);
            $Store->image = $img;
        }
        $Store->update();
        return response()->json($Store);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $Storedelete = Store::find($id);
        if (!is_null($Storedelete)) {
            if (File::exists('storage/app/public/CompanyStore/' . $Storedelete->image)) {
                File::delete('storage/app/public/CompanyStore/' . $Storedelete->image);
            }

            $Storedelete->delete();

            return response()->json($Storedelete);
        }
    }
}
