<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use DataTables;
use DB;



class RoleController extends Controller
{/*
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    */
    public function index()
    {
        return view('roles.index');
    }
    public function LoadAll(Request $request)
    {

        $Role = Role::orderBy('id', 'desc')->latest()->get();

        /* $table = Datatables::of($purchases);
       return $table->make(true); */
        return Datatables::of($Role)
            ->addIndexColumn()
            ->addColumn('permistions', function ($Role) {
                $parmiisstion = $Role->getAllPermissions()->pluck('name')->implode(',');
                return $parmiisstion;
            })
            ->addColumn('action', function ($Role) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" data-id="' . $Role->id . '" class="edit btn btn-outline-info btn-sm">Show</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button id="dataedit" type="button" name="delete" data-id="' . $Role->id . '"class=" btn btn-outline-success btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button id="datadelete" type="button" data-id="' . $Role->id . '" class="delete btn btn-outline-danger btn-sm">Delete</button>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('action', function ($subcategory) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $subcategory->id . '">Show</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $subcategory->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="datadelete" data-id="' . $subcategory->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }
    public function create()
    {
        /* return auth()->user()->permissions;  */
        /*  auth()->user()->assignRole('Admin'); */
        /*  auth()->user()->givePermissionTo('role-create'); */
        /*  auth()->user()->givePermissionTo('role-create'); */
        /*  return auth()->user()->permissions; */
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles')
            ->with('success', 'Role created successfully');
    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles')
            ->with('success', 'Role updated successfully');
    }
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles')
            ->with('success', 'Role deleted successfully');
    }
}
