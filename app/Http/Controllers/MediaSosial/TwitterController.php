<?php

namespace App\Http\Controllers\MediaSosial;

use App\Http\Controllers\Controller;
use App\Http\Requests\TwitterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Twitter;
use Carbon\Carbon;

class TwitterController extends Controller
{
    // INDEX
    public function index()
    {
        $twitters = Twitter::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.twitter.index', compact('twitters'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.twitter.create');
    }

    // SAVE CREATED
    public function store(TwitterRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Twitter::create($data);

        return redirect()->route('super-admin.twitter.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Twitter $twitter)
    {
        return view('super-admin.twitter.edit', compact('twitter'));
    }

    // SAVE UPDATE
    public function update(TwitterRequest $request, Twitter $twitter)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $twitter->update($data);

        return redirect()->route('super-admin.twitter.index')
            ->with('success', 'Konten twitter berhasil diperbarui');
    }

    // DELETE
    public function destroy(Twitter $twitter)
    {
        $twitter->delete();

        return redirect()->route('super-admin.twitter.index')
            ->with('success', 'Konten twitter berhasil dihapus.');
    }
}
