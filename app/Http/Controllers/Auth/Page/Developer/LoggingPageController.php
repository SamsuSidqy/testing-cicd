<?php

namespace App\Http\Controllers\Auth\Page\Developer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Illuminate\Pagination\Paginator;

use App\Models\Developer\Logging;
use App\Models\Authentication\Users;

class LoggingPageController extends Controller
{
    public function HomePage(Request $req, $page=1)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = [];

        $q = Logging::orderBy('created_at','desc');

        $searchType = $req->input('type');       
        if ($searchType) {
            $q->where('type',$searchType);
        }

        $searchUser = $req->input('users');
        if ($searchUser) {
            $q->where('users',$searchUser);
        }

        $data['log'] = $q->paginate(10);

        $data['users'] = Users::where('roles','!=','Developer')->get();

        return view('Auth.Developer.logging',$data);
    }
}
