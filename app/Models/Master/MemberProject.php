<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

use App\Models\Master\Project;
use App\Models\Authentication\Users;

class MemberProject extends Model
{
    protected $table = 'member_project';

    protected $primaryKey = 'id_member_project';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function project(){
        return $this->belongsTo(Project::class,'id_projects','id_projects');
    }

    public function users(){
        return $this->belongsTo(Users::class,'id_users','id_users');
    }
}
