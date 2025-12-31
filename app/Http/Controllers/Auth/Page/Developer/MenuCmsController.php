<?php

namespace App\Http\Controllers\Auth\Page\Developer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Developer\MenuModels;
use App\Models\Developer\BadgesMenuModels;
use App\Models\Developer\SubMenuModels;

class MenuCmsController extends Controller
{
    public function HomePage(Request $req)
    {   
        $data = [];
        $data['submenu'] = SubMenuModels::with('menu')->where('deleted',false)->get();
        $data['badges'] = BadgesMenuModels::with('sub_menu')->where('deleted',false)->get();
        $data['menus'] = MenuModels::with('submenu')->where('deleted',false)->get();

        return view('Auth.Developer.menu_cms',$data);
    }
}
