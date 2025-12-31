<?php

namespace App\Models\Developer;

use Illuminate\Database\Eloquent\Model;

use App\Models\Authentication\Users;

class Logging extends Model
{
    protected $table = 'logging';

    protected $primaryKey = 'id_logging';

    public $timestamps = false;

    protected $guarded = [
        
    ];

    public function pengguna(){
        return $this->belongsTo(Users::class,'users','id_users');
    }
}
