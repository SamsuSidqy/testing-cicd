<?php

namespace App\Models\Authentication;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Master\Project;
use App\Models\Master\Tasks\Task;

class Users extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id_users';

    protected $guarded = [
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];


    // public $timestamps = false;

    public function pm_project(){
        return $this->hashMany(Project::class,'pm','id_users');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'responsibility','id_users');
    }
       
}


