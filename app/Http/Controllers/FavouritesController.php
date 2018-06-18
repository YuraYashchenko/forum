<?php

namespace App\Http\Controllers;

use App\Reply;


class FavouritesController extends Controller
{
    /**
     * FavouritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
       $reply->favourite(auth()->id());
    }
}
