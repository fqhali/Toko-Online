<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about(): string
    {
        $data = [
            'title'      => 'Tentang Kami — TokoOnline',
            'activeMenu' => 'about',
        ];

        return view('layout/header', $data)
            . view('about', $data)
            . view('layout/footer');
    }

    public function contact(): string
    {
        $data = [
            'title'      => 'Kontak — TokoOnline',
            'activeMenu' => 'contact',
        ];

        return view('layout/header', $data)
            . view('contact', $data)
            . view('layout/footer');
    }
}
