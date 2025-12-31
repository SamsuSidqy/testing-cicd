<?php

namespace App\Http\Controllers\Services\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Developer\PermissionUsers;
class PermissionServices extends Controller
{
    public function updatePermission(Request $req){
        $validasi = $req->validate([
            'permissions' => 'required | array',
            'id_users' => 'required'
        ]);
        $data = collect($validasi['permissions'])->map(function ($perm, $menuId) use ($validasi){
            return [        
                'id_menu'    => $menuId,
                'id_users'   => $validasi['id_users'],
                'create'     => $perm['create'] ?? 0,
                'updated'     =>$perm['updated'] ?? 0,
                'delete'     => $perm['delete'] ?? 0,
                'show'       => $perm['show'] ?? 0,            
            ];
        })->values()->toArray();
        PermissionUsers::upsert(
            $data,
            ['id_menu','id_users'], // unique key
            ['create', 'updated', 'delete', 'show']
        );
        return redirect()->back()->with('success','Permission Berhasil Di Perbarui');
    }
}
