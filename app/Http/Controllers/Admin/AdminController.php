<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{

    // INDEX ==> UNTUK MENAMPILKAN AKUN PETUGAS (role admin)
    public function index()
    {
        // Ambil semua user dengan role 'admin' beserta jumlah berita yang mereka buat
        $admins = User::role('admin')
            ->withCount('news')
            ->get()
            ->map(function ($admin) {
                // Tambahkan status online/offline
                $admin->status = $admin->isOnline() ? 'Online' : 'Offline';
                return $admin;
            });

        return view('super-admin.officer-accoount', compact('admins'));
    }
}
