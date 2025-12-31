<?php

namespace App\Models\Developer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Developer\BadgesMenuModels;
use App\Models\Developer\MenuModels;

class SubMenuModels extends Model
{
    protected $table = 'sub_menu';

    protected $primaryKey = 'id_sub_menu';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function badges(){
        return $this->belongsTo(BadgesMenuModels::class,'badge','id_badge_menu')->where('deleted',false)->where('is_active',true);
    }

    public function menu(){
        return $this->hasMany(MenuModels::class,'sub','id_sub_menu')->where('deleted',false)->where('is_active',true);
    }
}
