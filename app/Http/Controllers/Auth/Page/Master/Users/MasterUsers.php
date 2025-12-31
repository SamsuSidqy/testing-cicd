<?php

namespace App\Http\Controllers\Auth\Page\Master\Users;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Illuminate\Pagination\Paginator;

use App\Models\Authentication\Users;

class MasterUsers extends Controller
{
    public function HomePage(Request $req, $page = 1)
    {   
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        $data = [];
        $query = Users::with(['tasks'])->orderBy('created_at','desc');
        $query->where('deleted',false);
        $query->where('roles','!=','Developer');
        $search = $req->query('s');
        if ($search) {
            $query->where('name','LIKE', $search .'%');
            $query->orWhere('email','LIKE', $search .'%');
        }

        $data['users'] = $query->paginate(10);

        return view('Auth.Master.Users.master_users',$data);
    }
}
