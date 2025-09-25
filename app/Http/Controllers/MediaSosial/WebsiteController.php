<?php

namespace App\Http\Controllers\MediaSosial;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Website;
use Carbon\Carbon;

class WebsiteController extends Controller
{
    // INDEX
    public function index()
    {
        $websites = Website::orderBy('content_date', 'desc')->paginate(10);
        return view('super-admin.website.index', compact('websites'));
    }

    // CREATE
    public function create()
    {
        return view('super-admin.website.create');
    }

    // SAVE CREATED
    public function store(WebsiteRequest $request)
    {
        // Ambil data input
        $data = $request->only([
            'title',
            'link',
            'content_date'
        ]);

        Website::create($data);

        return redirect()->route('super-admin.website.index')
            ->with('success', 'Konten Berhasil ditambahkan');
    }

    // EDIT
    public function edit(Website $website)
    {
        return view('super-admin.website.edit', compact('website'));
    }

    // SAVE UPDATE
    public function update(WebsiteRequest $request, Website $website)
    {
        $data = $request->only(['title', 'link', 'content_date']);

        $website->update($data);

        return redirect()->route('super-admin.website.index')
            ->with('success', 'Konten website berhasil diperbarui');
    }

    // DELETE
    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('super-admin.website.index')
            ->with('success', 'Konten website berhasil dihapus.');
    }
}
