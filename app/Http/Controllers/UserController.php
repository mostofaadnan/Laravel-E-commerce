<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Image;
use File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /*
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show', 'profile']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }

   */
    public function index()
    {
        return view('user.index');
    }
    public function create()
    {

        $roles = Role::select('id', 'name')->get();
        return view('user.create', compact('roles'));
    }

    public function LoadAll()
    {
        $users = Admin::orderBy('id', 'desc')->latest()
            ->get();

        /* $table = Datatables::of($purchases);
     return $table->make(true); */
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function (Admin $users) {
                return $users->roles()->pluck('name')->implode(' ');
            })
            ->addColumn('status', function ($users) {
                return $users->status == 1 ?  'Active' : 'Inactive';
            })
            ->addColumn('action', function ($users) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="dataedit" type="button" name="delete" data-id="' . $users->id . '" class="delete btn btn-outline-success btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button id="datadelete" type="button" name="delete" data-id="' . $users->id . '" class="btn btn-outline-danger btn-sm">Delete</button>';
                $button .= '</div>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required',
            /*  'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:122048', */

        ]);
        
        $input = $request->all();
     
        $input['password'] = Hash::make($input['password']);
        if ($request->hasFile('user_image')) {
            $image = $request->File('user_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/user/' . $img);
            Image::make($image)->save($location);
            $input['image'] = $img;
        }
       
        $user = Admin::create($input);
        $roles = $request['roles'];
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }
        return redirect()->route('users');
    }

    public function edit($id)
    {

        $user = Admin::find($id);
        $roles = Role::select('id', 'name')->get();
        $userRole = $user->roles->pluck('id', 'id')->all();
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            /* 'password' => 'required|same:password_confirmation', */
            'roles' => 'required',
            /*  'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:122048', */

        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = Admin::find($id);
        if ($request->hasFile('user_image')) {
            if (File::exists('images/User/' . $user->image)) {
                File::delete('images/User/' . $user->image);
            }
            $image = $request->File('user_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = public_path('images/User/' . $img);
            Image::make($image)->save($location);
            $input['image'] = $img;
        }
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $roles = $request['roles'];
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }
        return redirect()->route('users');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
    }
}
