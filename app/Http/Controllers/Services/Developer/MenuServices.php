<?php

namespace App\Http\Controllers\Services\Developer;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Helpers\Developer\MenuCmsHelpers;

use App\Models\Developer\MenuModels;
use App\Models\Developer\BadgesMenuModels;
use App\Models\Developer\SubMenuModels;

class MenuServices
{
    public function storeBadges(Request $req){
        /**
         * Melakukan Validasi Setiap Request Dikirim
         * (Name) Validasi ['Wajib Di Isi - Required']         
        **/

        $validasi = $req->validate([
            'name' => 'required'
        ]);

        /**
         * Store Ke Dalam Database         
        **/
        BadgesMenuModels::create($validasi);
        return redirect()->back()->with('success','Badges Berhasil Di Tambah');
    }

    public function updateBadges(Request $req){

        /**
         * Melakukan Validasi Setiap Request Dikirim
         * (Name) Validasi ['Wajib Di Isi - Required']
         * (id) Validasi ['Wajib Di Isi - Required']         
        **/

        $validasi = $req->validate([
            'name' => 'required',
            'id_badge' => 'required'
        ]);

         /**
         * Melakukan Pengupdatean Data Name Badge Berdasarkan Id Yang Di Kirim                
        **/
        BadgesMenuModels::where('id_badge_menu',$validasi['id_badge'])->update([
            'name' => $validasi['name']
        ]);

        return redirect()->back()->with('success','Badges Berhasil Di Update');
    }

    public function deleteBadges(Request $req){

        /**
         * Melakukan Validasi Setiap Request Dikirim    
         * (id) Validasi ['Wajib Di Isi - Required']         
        **/
        $validasi = $req->validate([
            'id_badge' => 'required'
        ]);

        /**
         * Melakukan Soft Delete Badge Berasarkan Id Request Yang Dikirm       
        **/
        BadgesMenuModels::where('id_badge_menu',$validasi['id_badge'])->update([
            'deleted' => true
        ]);
        return redirect()->back()->with('success','Badge Berhasil Di Hapus');
    }

    public function storeSub(Request $req){

        /**
         * Melakukan Validasi Setiap Request Dikirim    
         * (Icon) Validasi (Wajib Di Isi - Required)
         * (Badge) Validasi (Wajib Di Isi - Required) -> id dari badge
         * (Name) Validasi (Wajib Di Isi - Required)         
        **/

        $validasi = $req->validate([
            'name' => 'required',
            'badge' => 'required',
            'icon' => 'required'
        ]);

        /**
         * Melakukan Store Data Ke Dalam Database       
        **/
        SubMenuModels::create($validasi);
        return redirect()->back()->with('success','Sub Berhasil Di Buat');
    }

    public function updateSub(Request $req){

        /**
         * Melakukan Validasi Setiap Request Dikirim    
         * (Icon) Validasi (Wajib Di Isi - Required)
         * (Badge) Validasi (Wajib Di Isi - Required) -> id dari badge
         * (Name) Validasi (Wajib Di Isi - Required)
         * (Id) Validasi (Wajib Di Isi - Required) -> id dari sub
        **/

        $validasi = $req->validate([
            'name' => 'required',
            'badge' => 'required',
            'icon' => 'required',
            'id_sub' => 'required'
        ]);

        /**
         * Melakukan Update Data Di Dalam Database Berdasarkan Id Sub
        **/
        SubMenuModels::where('id_sub_menu',$validasi['id_sub'])->update([
            'name' => $validasi['name'],
            'badge' => $validasi['badge'],
            'icon' => $validasi['icon']
        ]);

        return redirect()->back()->with('success','Sub Berhasil Di Perbarui');
    }

    public function deleteSub(Request $req){ 

        /**
         * Melakukan Validasi Setiap Request Dikirim             
         * (Id) Validasi (Wajib Di Isi - Required) -> id dari sub
        **/

        $validasi = $req->validate([
            'id_sub' => 'required'
        ]);

        /**
         * Melakukan Penghapusan Soft Di Dalam Database
        **/
        SubMenuModels::where('id_sub_menu',$validasi['id_sub'])->update([
            'deleted' => true
        ]);
         return redirect()->back()->with('success','Sub Berhasil Di Hapus');
    }

    public function updateMenu(Request $req){
        /**
         * Melakukan Validasi Setiap Request Dikirim             
         * (Id) Validasi (Wajib Di Isi - Required) -> id dari menu
         * (name) Validasi (Wajib Di Isi - Required)
         * (Sub) Validasi (Wajib Di Isi - Required) -> Id dari Sub Menu
         * (role) Validasi (Tidak Wajib - NULL)
        **/
        $validasi = $req->validate([
            'name' => 'required',            
            'sub' => 'required',
            'role' => 'nullable',
            'id_menu' => 'required'
        ]);
        /**
         * Melakukan Pembaruan Dari Menu Berdasarkan Id Menu Di Request        
        **/
        MenuModels::where('id_menu_cms',$validasi['id_menu'])->update([
            'name' => $validasi['name'],
            'sub' => $validasi['sub'],
            'role' => $validasi['role'] ?? null
        ]);
        return redirect()->back()->with('success','Menu Berhasil Di Perbarui');
    }

    public function deleteMenu(Request $req){        
        /**
         * Melakukan Validasi Setiap Request Dikirim             
         * (Id) Validasi (Wajib Di Isi - Required) -> id dari menu
        **/
        $validasi = $req->validate([
            'id_menu' => 'required'
        ]);

        /**
         * Melakukan Soft Delete Di Dalam Database
        **/
         MenuModels::where('id_menu_cms',$validasi['id_menu'])->update([
            'deleted' => true
         ]);
         return redirect()->back()->with('success','Sub Berhasil Di Hapus');
    }

    public function storeMenu(Request $req){
        /**
         * Melakukan Validasi Setiap Request Dikirim             
         * (Name) Validasi (Wajib Di Isi - Required)
         * (Parrent Folder) Validasi (Tidak Wajib)
         * (Route Name) Validasi (Wajib Di Isi - Required, Unique)
         * (Class Name) Validasi (Wajib Di Isi - Required, Unique)
         * (Views Name) Validasi (Wajib Di Isi - Required, Unique)
         * (Sub) Validasi (Wajib Di Isi - Required) -> id dari sub menu
         * (Role) Validasi (Tidak Wajib, Null)
         * (Method) Validasi (Wajib Di Isi - Required)
         * (Url) Validasi (Wajib Di Isi - Required)
        **/

        $validasi = $req->validate([
            'name' => 'required',
            'parrent_folder' => 'nullable',
            'route_name' => [
                'required',
                Rule::unique('menu_cms', 'route_name')
                ->where('deleted',false)
                ->where('is_active',true)
            ],
            'class_name' => [
                'required',
                Rule::unique('menu_cms', 'class_name')
                ->where('deleted',false)
                ->where('is_active',true)
            ],
            'name_views' => [
                'required',
                Rule::unique('menu_cms', 'name_views')
                ->where('deleted',false)
                ->where('is_active',true)
            ],
            'sub' => 'required',
            'role' => 'nullable',
            'metode' => 'required',
            'url' => [
                'required',
                Rule::unique('menu_cms', 'url')
                ->where('deleted',false)
                ->where('is_active',true)
            ],
        ]);


        /**
         * Melakukan Pembersihan String Terhindar Dari Spasi
         * (Route Name, Class Name, Viws Name, Parrent Folder Name)
        **/
        $validasi['route_name'] = str_replace(' ','-',$validasi['route_name']);
        $validasi['class_name'] = str_replace(' ','',$validasi['class_name']);
        $validasi['name_views'] = str_replace(' ','',$validasi['name_views']);
        $folder = str_replace(' ','_',$validasi['parrent_folder']);

        if ($validasi['parrent_folder']) {    
            $validasi['parrent_folder'] = $folder;
        }

         /*
        |--------------------------------------------------------------------------
        | Buat Controller
        |--------------------------------------------------------------------------
        */
        MenuCmsHelpers::CreateController(
            $req->class_name,
            $req->name_views,
            $req->metode,
            !empty($validasi['parrent_folder'])
                ? str_replace(' ', '_', $validasi['parrent_folder'])
                : null
        );

        /*
        |--------------------------------------------------------------------------
        | Buat Blade Views
        |--------------------------------------------------------------------------
        */

        MenuCmsHelpers::CreateBladeViews(
            $req->name_views,
            !empty($validasi['parrent_folder'])
                ? str_replace(' ', '_', $validasi['parrent_folder'])
                : null
        );

        MenuModels::create($validasi);

        return redirect()->back()->with('success','Pembuatan Menu Berhasil Di Lakukan');
    }
}
