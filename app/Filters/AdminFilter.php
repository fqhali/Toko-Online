<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Silakan login sebagai Administrator untuk mengakses halaman ini.');

            return redirect()->to(base_url('login'));
        }

        if ((int) session()->get('role_id') !== 1) {
            session()->setFlashdata('error', 'Akses ditolak! Halaman tersebut khusus untuk Administrator.');

            return redirect()->to(base_url('/'));
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
