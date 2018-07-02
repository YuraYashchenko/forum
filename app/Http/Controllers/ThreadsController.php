<?php

namespace App\Http\Controllers;

use App\Filters\ThreadsFilter;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ThreadsFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function index(ThreadsFilter $filters)
    {
        $threads = Thread::latest()
            ->filter($filters)
            ->get();

        if (request()->wantsJson())
        {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'channel_id' => $request->channel_id
        ]);

        return redirect()->to($thread->path())->with('flash', 'You have created a thread.');
    }

    /**
     * Display the specified resource.
     *
     * @param $chanel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($chanel, Thread $thread)
    {
        if (auth()->check())
        {
            auth()->user()->read($thread);
        }

        return view('threads.show', [
            'thread' => $thread,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        return response([], 204);
    }
}
