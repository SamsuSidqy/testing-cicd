<?php

namespace App\Models\Developer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Developer\SubMenuModels;
use App\Models\Developer\PermissionUsers;

class MenuModels extends Model
{
    protected $table = 'menu_cms';

    protected $primaryKey = 'id_menu_cms';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function submenu(){
        return $this->belongsTo(SubMenuModels::class,'sub','id_sub_menu')->where('deleted',false)->where('is_active',true);
    }

    public function permission(){
        return $this->hasMany(PermissionUsers::class,'id_menu','id_menu_cms');
    }
}
