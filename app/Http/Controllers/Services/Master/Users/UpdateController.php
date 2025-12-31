<?php

namespace App\Http\Controllers\Services\Master\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\Authentication\Users;
class UpdateController extends Controller
{
    public function UpdateUsers(Request $req){
        $validasi = $req->validate([
            'id_users' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users','email')->ignore($req->id_users,'id_users')
            ],
            'password' => 'nullable',
            'linkedln' => 'nullable',
            'whatsaap' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'alamat' => 'nullable',
            'roles' => 'required'
        ]);

        $payload = [
            'name' => $validasi['name'],
            'email' => $validasi['email'],
            'roles' => $validasi['roles'],
            'linkedln' => $validasi['linkedln'],
            'whatsaap' => $validasi['whatsaap'],
            'facebook' => $validasi['facebook'],
            'twitter' => $validasi['twitter'],
            'address' => $validasi['alamat'],            
        ];

        if ($validasi['password']) {
            $payload['password'] = Hash::make($validasi['password']);
        }
        Users::where('id_users',$validasi['id_users'])->update($payload);
        return redirect()->back()->with('success','Update Users Berhasil Di Lakukan');
    }

    public function UpdateProfile(Request $req){
        $validasi = $req->validate([            
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users','email')->ignore(auth()->user()->id_users,'id_users')
            ],
            'password' => 'nullable',
            'linkedln' => 'nullable',
            'whatsaap' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'alamat' => 'nullable',
            'profile' => 'nullable|image|mimes:jpeg,jpg,png|max:10240'
        ]);

        $payload = [
            'name' => $validasi['name'],
            'email' => $validasi['email'],
            'linkedln' => $validasi['linkedln'],
            'whatsaap' => $validasi['whatsaap'],
            'facebook' => $validasi['facebook'],
            'twitter' => $validasi['twitter'],
            'address' => $validasi['alamat'],            
        ];

        $files = $req->file('profile');
        if ($files) {
            $filename = time() . ".".$files->getClientOriginalExtension();
            $files->move(public_path('wp-content/profile'),$filename);
            $payload['profile'] = $filename ?? null;
        }

        if ($validasi['password']) {
            $payload['password'] = Hash::make($validasi['password']);
        }
        Users::where('id_users',auth()->user()->id_users)->update($payload);
        return redirect()->back()->with('success','Update Users Berhasil Di Lakukan');
    }

    public function DeleteUsers(Request $req){
        $validasi = $req->validate([
            'id_users' => 'required'
        ]);

        Users::where('id_users',$validasi['id_users'])->update(['deleted' => true]);
        return redirect()->back()->with('success','User Berhasil Di Hapus');
    }
}
