<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login(): string
    {
        $data = [
            'title'      => 'Login — TokoOnline',
            'activeMenu' => 'login',
        ];

        return view('layout/header', $data)
            . view('auth/login', $data)
            . view('layout/footer');
    }

    public function prosesLogin(): RedirectResponse
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[4]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel->findByUsername($username);

        if ($user === null || ! password_verify($password, (string) $user['password'])) {
            session()->setFlashdata('error', 'Username atau password tidak sesuai.');

            return redirect()->back()->withInput();
        }

        $intendedUrl = (string) session()->get('redirect_url');
        session()->regenerate();

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => (int) $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role_id'    => (int) $user['role_id'],
        ]);
        session()->remove('redirect_url');

        session()->setFlashdata('success', 'Selamat datang kembali, ' . $user['nama'] . '!');

        if ((int) $user['role_id'] === 1) {
            return redirect()->to(base_url('admin'));
        }

        if ($intendedUrl !== '' && str_starts_with($intendedUrl, base_url())) {
            return redirect()->to($intendedUrl);
        }

        return redirect()->to(base_url('/'));
    }

    public function register(): string
    {
        $data = [
            'title'      => 'Daftar Akun — TokoOnline',
            'activeMenu' => 'register',
        ];

        return view('layout/header', $data)
            . view('auth/register', $data)
            . view('layout/footer');
    }

    public function prosesRegister(): RedirectResponse
    {
        $rules = [
            'nama'             => 'required|min_length[3]|max_length[50]',
            'username'         => 'required|alpha_dash|min_length[4]|max_length[50]|is_unique[tb_user.username]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => trim((string) $this->request->getPost('username')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'  => 2,
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');

        return redirect()->to(base_url('login'));
    }

    public function logout(): RedirectResponse
    {
        session()->remove([
            'isLoggedIn',
            'user_id',
            'nama',
            'username',
            'role_id',
            'redirect_url',
            'last_invoice_id',
        ]);
        session()->regenerate();
        session()->setFlashdata('info', 'Anda telah keluar dari akun.');

        return redirect()->to(base_url('login'));
    }
}
