<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\slider;
use DataTables;
use Image;
use File;

class SliderController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $category = Category::orderby('id', 'asc')->get();
        return view('slider.index', compact('category'));
    }
    public function LoadAll()
    {
        $subcategory = slider::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($subcategory)
            ->addIndexColumn()

            ->addColumn('status', function (slider $slider) {
                return $slider->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($slider) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $slider->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $slider->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $slider = new slider;
        $slider->title = $request->title;
        $slider->category = $request->category;
        $slider->remark = $request->description;
        $slider->status = $request->status;
        /*  single image insert   */
        if ($request->hasFile('file')) {
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/slider/' . $img);
            Image::make($image)->save($location);
            $slider->image = $img;
        }
        $slider->save();
        return response()->json($slider);
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
        $slider = slider::find($id);
        return response()->json($slider);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $slider = slider::find($id);
        if (!is_null($slider)) {
            $slider->title = $request->title;
            $slider->category = $request->category;
            $slider->remark = $request->description;
            $slider->status = $request->status;
            /*  single image insert   */
            if ($request->hasFile('file')) {
                if (File::exists('storage/app/public/slider/' . $slider->image)) {
                    File::delete('storage/app/public/slider/' . $slider->image);
                }
                $image = $request->File('file');
                $img = time() . $image->getClientOriginalExtension();
                $location = storage_path('app/public/slider/' . $img);
                Image::make($image)->save($location);
                $slider->image = $img;
            }
            $slider->update();
        }
        return response()->json($slider);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $slider = slider::find($id);
        if (!is_null($slider)) {
            if (File::exists('storage/app/public/slider/' . $slider->image)) {
                File::delete('storage/app/public/slider/' . $slider->image);
            }
            $slider->delete();
        }
    }
}
