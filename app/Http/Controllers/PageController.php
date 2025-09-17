<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home() 
    {
        return view('user.dashboard');
    }
    public function layanan()
    {
        return view('user.services');
    }

    public function informasi()
    {
        return view('user.about_us');
    }

    public function galeri()
    {
        return view('user.galery');
    }

    public function kontak()
    {
        return view('user.contact');
    }
}