<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();

        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);

        // Jika sudah login, redirect ke home
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Jika tidak ada input email, tampilkan form login
        if (!$email || !$password) {
            return view('user/login');
        }

        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();

        if ($login) {
            $pass = $login['userpassword'];

            if (password_verify($password, $pass)) {
                // Simpan data login ke session
                $session->set([
                    'user_id'    => $login['id'],
                    'user_name'  => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in'  => true,
                ]);

                // Redirect ke halaman yang diminta atau home default
                $redirectTo = session()->get('redirect_to') ?? '/';
                session()->remove('redirect_to');

                return redirect()->to($redirectTo)->with('flash_msg', 'Login berhasil! Selamat datang, ' . $login['username']);
            } else {
                $session->setFlashdata('flash_msg', 'Password salah.');
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata('flash_msg', 'Email tidak terdaftar.');
            return redirect()->to('/user/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login')->with('flash_msg', 'Anda telah berhasil logout.');
    }
}
