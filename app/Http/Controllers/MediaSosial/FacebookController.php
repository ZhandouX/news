<?php

namespace App\Http\Controllers\MediaSosial;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Facebook;
use Carbon\Carbon;

class FacebookController extends Controller
{
    // INDEX
    public function index()
    {
        $facebooks = Facebook::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.facebook.index', compact('facebooks'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.facebook.create');
    }

    // SAVE CREATED
    public function store(FacebookRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Facebook::create($data);

        return redirect()->route('super-admin.facebook.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Facebook $facebook)
    {
        return view('super-admin.facebook.edit', compact('facebook'));
    }

    // SAVE UPDATE
    public function update(FacebookRequest $request, Facebook $facebook)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $facebook->update($data);

        return redirect()->route('super-admin.facebook.index')
            ->with('success', 'Konten Facebook berhasil diperbarui');
    }

    // DELETE
    public function destroy(Facebook $facebook)
    {
        $facebook->delete();

        return redirect()->route('super-admin.facebook.index')
            ->with('success', 'Konten Facebook berhasil dihapus.');
    }
}
