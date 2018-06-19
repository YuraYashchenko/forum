<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user->load('threads'),
            'threads' => $user->threads()->paginate(1)
        ]);
    }
}
