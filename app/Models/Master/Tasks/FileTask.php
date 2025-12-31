<?php

namespace App\Models\Master\Tasks;

use Illuminate\Database\Eloquent\Model;

use App\Models\Master\Tasks\Task;

class FileTask extends Model
{
    protected $table = 'files_tasks';

    protected $primaryKey = 'id_file_tasks';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function task_ref(){
        return $this->belongsTo(Task::class,'taks','id_tasks');
    }
}
