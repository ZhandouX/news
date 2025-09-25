<?php

namespace App\Http\Controllers\MediaSosial;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\InstagramRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instagram;
use Carbon\Carbon;

class InstagramController extends Controller
{
    // INDEX
    public function index()
    {
        $instagrams = Instagram::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.instagram.index', compact('instagrams'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.instagram.create');
    }

    // SAVE CREATED
    public function store(InstagramRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Instagram::create($data);

        return redirect()->route('super-admin.instagram.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Instagram $instagram)
    {
        return view('super-admin.instagram.edit', compact('instagram'));
    }

    // SAVE UPDATE
    public function update(InstagramRequest $request, Instagram $instagram)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $instagram->update($data);

        return redirect()->route('super-admin.instagram.index')
            ->with('success', 'Konten Instagram berhasil diperbarui');
    }

    // DELETE
    public function destroy(Instagram $instagram)
    {
        $instagram->delete();

        return redirect()->route('super-admin.instagram.index')
            ->with('success', 'Konten Instagram berhasil dihapus.');
    }
}
