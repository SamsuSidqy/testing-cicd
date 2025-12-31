<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

use App\Models\Authentication\Users;
use App\Models\Master\MemberProject;

class Project extends Model
{
    protected $table = 'projects';

    protected $primaryKey = 'id_projects';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function users(){
        return $this->belongsTo(Users::class,'pm','id_users');
    }

    public function member(){
        return $this->hasMany(MemberProject::class,'id_projects','id_projects');
    }
}
