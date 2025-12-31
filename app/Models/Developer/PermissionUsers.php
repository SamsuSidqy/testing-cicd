<?php

namespace App\Models\Developer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Developer\MenuModels;

class PermissionUsers extends Model
{
    protected $table = 'role_permission_users';

    protected $primaryKey = 'id_role_permission_users';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function menu(){
        return $this->belongsTo(MenuModels::class,'id_menu','id_menu_cms');
    }
}
