<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function getData()
    {
        $roles = Role::select(['id', 'name', 'display_name', 'description', 'created_at']);

        return DataTables::of($roles)->make(true);
    }
}
