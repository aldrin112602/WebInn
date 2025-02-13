<?php

use Illuminate\Support\Facades\{ Broadcast, Auth };

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat', function ($user) {
    return Auth::check();
});
