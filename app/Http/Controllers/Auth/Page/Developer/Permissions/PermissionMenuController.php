<?php

namespace App\Http\Controllers\Auth\Page\Developer\Permissions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Authentication\Users;
use App\Models\Developer\PermissionUsers;
use App\Models\Developer\MenuModels;

class PermissionMenuController extends Controller
{
    public function HomePage(Request $req)
    {
        $data = [];
        $data['users'] = Users::all();

        $detail = $req->query('detail');

        if ($detail) {
            $data['permision'] = PermissionUsers::where('id_users',$detail)
            ->get()->keyBy('id_menu');
            $data['menu'] = MenuModels::where('deleted',false)->get();
        }

        return view('Auth.Developer.Permissions.permissions',$data);
    }
}
