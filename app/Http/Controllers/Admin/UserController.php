<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    public function getData()
    {
        $users = User::with('role')->select('users.*');

        return DataTables::of($users)
            ->addColumn('role_name', function ($row) {
                if (!$row->role) {
                    return '<span class="badge bg-secondary text-white">Tidak Ada Peran</span>';
                }
                
                $badgeClass = 'bg-primary';
                if ($row->role->name === 'admin') {
                    $badgeClass = 'bg-danger';
                } elseif ($row->role->name === 'editor') {
                    $badgeClass = 'bg-success';
                } elseif ($row->role->name === 'operator') {
                    $badgeClass = 'bg-info';
                }

                return '<span class="badge ' . $badgeClass . ' text-white fw-bold">' . e($row->role->display_name) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $isCurrentUser = auth()->id() === $row->id;
                $disabledDelete = $isCurrentUser ? 'disabled' : '';
                return '
                    <button class="btn btn-sm btn-info edit-btn me-1" data-id="' . $row->id . '">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" ' . $disabledDelete . '>
                        <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                ';
            })
            ->rawColumns(['role_name', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $data['password'] = Hash::make($request->password);

        User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'nullable|exists:roles,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $data = $request->validate($rules);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus.'
        ]);
    }
}
