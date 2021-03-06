<?php

namespace App\Http\Controllers;

use App\Thread;

class SubscriptionsController extends Controller
{
    /**
     * SubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channel
     * @param Thread $thread
     */
    public function store($channel, Thread $thread)
    {
        $thread->subscribe(auth()->id());
    }

    /**
     * @param $channel
     * @param Thread $thread
     */
    public function destroy($channel, Thread $thread)
    {
        $thread->unsubscribe(auth()->id());
    }
}
