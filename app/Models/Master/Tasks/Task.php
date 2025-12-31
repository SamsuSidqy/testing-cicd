<?php

namespace App\Models\Master\Tasks;

use Illuminate\Database\Eloquent\Model;

use App\Models\Authentication\Users;
use App\Models\Master\Project;
use App\Models\Master\Tasks\ForumTask;
use App\Models\Master\Tasks\FileTask;

class Task extends Model
{
    protected $table = 'tasks';

    protected $primaryKey = 'id_tasks';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function anggota(){
        return $this->belongsTo(Users::class,'responsibility','id_users');
    }

    public function project_task(){
        return $this->belongsTo(Project::class,'project','id_projects');
    }

    public function activity(){
        return $this->hasOne(ForumTask::class,'tasks','id_tasks')->orderBy('created_at','desc');
    }

    public function fileTugas(){
        return $this->hasMany(FileTask::class,'taks','id_tasks');
    }

}
