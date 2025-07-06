<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika user belum login
        if (!session()->get('logged_in')) {
            // Simpan URL yang diminta untuk redirect setelah login
            session()->set('redirect_to', current_url());

            // Redirect ke halaman login dengan pesan
            return redirect()->to('/user/login')->with('flash_msg', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah request untuk saat ini
    }
}
