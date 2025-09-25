<?php

namespace App\Http\Controllers\MediaSosial;

use App\Http\Controllers\Controller;
use App\Http\Requests\YoutubeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Youtube;
use Carbon\Carbon;

class YoutubeController extends Controller
{
    // INDEX
    public function index()
    {
        $youtubes = Youtube::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.youtube.index', compact('youtubes'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.youtube.create');
    }

    // SAVE CREATED
    public function store(YoutubeRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Youtube::create($data);

        return redirect()->route('super-admin.youtube.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Youtube $youtube)
    {
        return view('super-admin.youtube.edit', compact('youtube'));
    }

    // SAVE UPDATE
    public function update(YoutubeRequest $request, Youtube $youtube)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $youtube->update($data);

        return redirect()->route('super-admin.youtube.index')
            ->with('success', 'Konten Youtube berhasil diperbarui');
    }

    // DELETE
    public function destroy(Youtube $youtube)
    {
        $youtube->delete();

        return redirect()->route('super-admin.youtube.index')
            ->with('success', 'Konten Youtube berhasil dihapus.');
    }
}
