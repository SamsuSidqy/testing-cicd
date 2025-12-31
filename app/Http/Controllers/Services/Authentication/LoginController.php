<?php

namespace App\Http\Controllers\Services\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\Authentication\Users;

class LoginController
{
    public function LoginHandler(Request $req) : RedirectResponse{

        /**
         * Melakukan Validasi Setiap Request Dikirim
         * (Email) Validasi ['Wajib Di Isi - Required']
         * (Password) Validasi ['Wajib Di Isi - Required']
         */

        $validasi = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'Membutuhkan Sebuah Email',
            'password.required' => 'Membutuhkan Sebuah Password'
        ]);

        /* 
         * Membuat Cariabel $cek untuk melihat hasil validasi login email dan password
         */
        $validasi['deleted'] = false; // Melakukan Pengecekaj Jika Akun Sudah Di Delete / Belum
        $cek = Auth::attempt($validasi);        

        if ($cek) {
            $req->session()->regenerate();  
            $user = Auth::user();          
            return redirect()->route('auth.dashboard');  
        }else{
            return back()->with('error','Email / Password Salah');
        }

    }
}
