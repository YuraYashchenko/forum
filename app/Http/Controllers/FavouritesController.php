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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Reply $reply)
    {
       $reply->favourite(auth()->id());

       return back();
    }
}
