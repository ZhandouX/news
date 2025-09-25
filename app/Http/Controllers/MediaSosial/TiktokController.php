<?php

namespace App\Http\Controllers\MediaSosial;

use App\Http\Controllers\Controller;
use App\Http\Requests\TiktokRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tiktok;
use Carbon\Carbon;

class TiktokController extends Controller
{
    // INDEX
    public function index()
    {
        $tiktoks = Tiktok::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.tiktok.index', compact('tiktoks'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.tiktok.create');
    }

    // SAVE CREATED
    public function store(TiktokRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Tiktok::create($data);

        return redirect()->route('super-admin.tiktok.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Tiktok $tiktok)
    {
        return view('super-admin.tiktok.edit', compact('tiktok'));
    }

    // SAVE UPDATE
    public function update(TiktokRequest $request, Tiktok $tiktok)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $tiktok->update($data);

        return redirect()->route('super-admin.tiktok.index')
            ->with('success', 'Konten tiktok berhasil diperbarui');
    }

    // DELETE
    public function destroy(Tiktok $tiktok)
    {
        $tiktok->delete();

        return redirect()->route('super-admin.tiktok.index')
            ->with('success', 'Konten tiktok berhasil dihapus.');
    }
}
