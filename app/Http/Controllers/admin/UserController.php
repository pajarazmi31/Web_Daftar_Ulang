<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Asumsi model Role penampung tingkatan hak akses
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // READ ALL
    // Tambahkan Request di argumen fungsi index
    public function index(Request $request)
    {
        // Mengambil keyword pencarian
        $search = $request->input('search');

        $users = User::with('role')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        // Opsional: cari berdasarkan nama role juga
                        ->orWhereHas('role', function ($roleQuery) use ($search) {
                            $roleQuery->where('nama_role', 'like', "%{$search}%");
                        });
                });
            })
            ->paginate(10);

        return view('admin.manajemen_akun.index', compact('users'));
    }

    // FORM CREATE
    public function create()
    {
        $roles = Role::all();
        return view('admin.manajemen_akun.create', compact('roles'));
    }

    // PROCESS STORE
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role_id'  => 'required|exists:role,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('manajemen_akun')->with('success', 'Akun pengguna baru berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.manajemen_akun.edit', compact('user', 'roles'));
    }

    // PROCESS UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->role_id == 3 || is_numeric($request->email)) {
            // Validasi untuk Siswa (Menerima NISN sebagai string/numerik tanpa format @email)
            $emailValidationRule = 'required|string|max:255|unique:users,email,' . $user->id;
        } else {
            // Validasi untuk Admin / Operator / Pimpinan (Wajib format email resmi)
            $emailValidationRule = 'required|string|email|max:255|unique:users,email,' . $user->id;
        }
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => $emailValidationRule,
            'role_id'  => 'required|exists:role,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        // Update password hanya jika kolom diinput oleh admin
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('manajemen_akun')->with('success', 'Data akun berhasil diperbarui.');
    }

    // PROCESS DESTROY
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah user menghapus dirinya sendiri secara tidak sengaja
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();

        return redirect()->route('manajemen_akun')->with('success', 'Akun telah berhasil dihapus dari sistem.');
    }
}
