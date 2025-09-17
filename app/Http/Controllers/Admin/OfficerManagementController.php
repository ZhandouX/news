<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
class OfficerManagementController extends Controller
{
    /* ======================================== */
    /* ====== MANAGEMENT OFFICER ACCOUNT ====== */
    /* ======================================== */

    // SHOW ACTIVITY OFFICER ACCOUNT
    public function officerAccount()
    {
        // Ambil semua user yang punya role 'admin'
        $admins = User::role('admin')->get();

        // Tambahkan info kontribusi berita dan status online
        $admins = $admins->map(function ($admin) {
            $admin->news_count = $admin->news()->count(); // jumlah berita yang dibuat
            $admin->status = $admin->isOnline() ? 'Online' : 'Offline';
            return $admin;
        });

        $totalAdmins = User::role('admin')->count();

        return view('super-admin.news.officer-account', compact('admins', 'totalAdmins'));
    }

    // ONLINE OR OFFLINE ACCOUNT STATUS
    public function officerStatus()
    {
        $admins = User::role('admin')->get()->map(function ($admin) {
            $admin->news_count = $admin->news()->count();
            $admin->status = $admin->isOnline() ? 'Online' : 'Offline';
            return $admin;
        });

        return response()->json($admins);
    }

    // INDEX OFFICER ACCOUNT
    public function indexAdmin()
    {
        // Ambil semua user dengan role 'admin'
        $admins = User::role('admin')->paginate(10); // bisa pakai paginate atau get() sesuai kebutuhan

        // Tambahkan info status online
        $admins->transform(function ($admin) {
            $admin->status = $admin->isOnline() ? 'Online' : 'Offline';
            return $admin;
        });

        // Kirim ke view index admin
        return view('super-admin.admins.index', compact('admins'));
    }

    // CREATE OFFICER ACCOUNT
    public function createAdmin()
    {
        return view('super-admin.admins.create');
    }

    // SAVED OFFICER ACCOUNT
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ambil role admin
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'role_id' => $adminRole->id,
        ]);

        // assign role spatie
        $user->assignRole($adminRole->name);

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Akun admin berhasil dibuat!');
    }

    // EDIT OFFICER ACCOUNT
    public function editAdmin(User $user)
    {
        return view('super-admin.admins.edit', compact('user'));
    }

    // UPDATE OFFICER ACCOUNT
    public function updateAdmin(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $adminRole->id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // pastikan role spatie
        if (!$user->hasRole('admin')) {
            $user->assignRole($adminRole);
        }

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Akun admin berhasil diperbarui!');
    }


    // DESTROY OFFICER ACCOUNT
    public function destroyAdmin(User $user)
    {
        $user->removeRole('admin');
        $user->delete();

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Akun admin berhasil dihapus!');
    }
}
