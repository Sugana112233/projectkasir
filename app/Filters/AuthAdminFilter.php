<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }
        
        // Cek apakah user adalah admin
        if (session()->get('level') != 'admin') {
            return redirect()->to('/kasir/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin!');
        }
        
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}