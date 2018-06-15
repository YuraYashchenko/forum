<?php

namespace App\Http\Controllers;

use App\Channel;

class ChannelsController extends Controller
{
    public function index(Channel $channel)
    {
        $threads = $channel->threads;

        return view('threads.index', compact('threads'));
    }
}
