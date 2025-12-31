<?php

namespace App\Http\Controllers\Services\Master\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Authentication\Users;

class CreateController extends Controller
{
    public function createUser(Request $req){
        $validasi = $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'linkedln' => 'nullable',
            'whatsaap' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'address' => 'required',
            'profile' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'roles' => 'required',            
        ]);

        $files = $req->file('profile');
        if ($files) {
            $filename = time() . ".".$files->getClientOriginalExtension();
            $files->move(public_path('wp-content/profile'),$filename);
            $validasi['profile'] = $filename ?? null;
        }
        $validasi['password'] = Hash::make($validasi['password']);        

        Users::create($validasi);

        return redirect()->back()->with('success','User Berhasil Di Tambahkan');
    }
}
