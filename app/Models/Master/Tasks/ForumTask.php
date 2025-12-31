<?php

namespace App\Models\Master\Tasks;

use Illuminate\Database\Eloquent\Model;

use App\Models\Authentication\Users;
use App\Models\Master\Tasks\Task;
use App\Models\Master\Tasks\FileTask;

class ForumTask extends Model
{
    protected $table = 'forum';

    protected $primaryKey = 'id_forum';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function users(){
        return $this->belongsTo(Users::class,'sender','id_users');
    }

    public function task(){
        return $this->belongsTo(Task::class,'tasks','id_tasks');
    }

    public function files(){
        return $this->hasMany(FileTask::class,'forum','id_forum');
    }
}
