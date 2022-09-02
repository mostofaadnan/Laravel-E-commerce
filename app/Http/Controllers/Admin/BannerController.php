<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\banner;
use DataTables;
use Image;
use File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        return view('banner.index');
    }
    public function LoadAll()
    {
        $banner = banner::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($banner)
            ->addIndexColumn()

            ->addColumn('status', function (banner $banner) {
                return $banner->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('type', function (banner $banner) {
                $banartype="";
                switch ($banner->type) {
                    case 1:
                        $banartype = "Product Side";
                        break;
                    case 2:
                        $banartype = "Home Top";
                        break;
                    default:
                        $banartype = "Home Buttom";
                        break;
                }
                return $banartype;
            })

            ->addColumn('action', function ($banner) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $banner->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $banner->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $banner = new banner;
        $banner->status = $request->status;
        $banner->type = $request->banartype;
        /*  single image insert   */
        if ($request->hasFile('file')) {
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/banner/' . $img);
            Image::make($image)->save($location);
            $banner->image = $img;
        }
        $banner->save();
        return response()->json($banner);
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
        $banner = banner::find($id);
        return response()->json($banner);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $banner = banner::find($id);
       
        if (!is_null($banner)) {
            $banner->type = $request->banartype;
            $banner->status = $request->status;
            /*  single image insert   */
            if ($request->hasFile('file')) {
                if (File::exists('storage/app/public/banner/' . $banner->image)) {
                    File::delete('storage/app/public/banner/' . $banner->image);
                }
                $image = $request->File('file');
                $img = time() . $image->getClientOriginalExtension();
                $location = storage_path('app/public/banner/' . $img);
                Image::make($image)->save($location);
                $banner->image = $img;
            }
            $banner->update();
        }
        return response()->json($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $banner = banner::find($id);
        if (!is_null($banner)) {
            if (File::exists('storage/app/public/banner/' . $banner->image)) {
                File::delete('storage/app/public/banner/' . $banner->image);
            }
            $banner->delete();
        }
    }
}
