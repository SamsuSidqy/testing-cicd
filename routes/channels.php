<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Authentication\Users;
use App\Models\Master\Tasks\Task;
use App\Models\Master\Project;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('task.forum.{forum}', function ($user, $forum) {        
    $id_users = (int) $user->id_users;
    $result = Task::where('responsibility', $id_users)->first();
    $result2 = Project::where('pm', $id_users)->first();    
    if ($result || $result2) {
        return [
            'users' => $user
        ];
    }
    return false;
});

Broadcast::channel('notification.{userId}',function($user, $userId){    
    if ((int) $user->id_users === (int) $userId) {
        return true;
    }

    return false;
});