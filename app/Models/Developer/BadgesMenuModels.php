<?php

namespace App\Models\Developer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Developer\SubMenuModels;

class BadgesMenuModels extends Model
{
    protected $table = 'badge_menu';

    protected $primaryKey = 'id_badge_menu';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function sub_menu()
    {
        return $this->hasMany(SubMenuModels::class,'badge','id_badge_menu')->where('deleted',false)->where('is_active',true);
    }
}
