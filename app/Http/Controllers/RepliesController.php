<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Reply;
use App\Rules\SpamFree;
use App\SpamDetection\Spam;
use App\Thread;
use Illuminate\Support\Facades\Gate;


class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Fetch all replies.
     *
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(2);
    }


    /**
     * Store a reply.
     *
     * @param $channel
     * @param Thread $thread
     * @param StoreReplyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Spam $spam
     */
    public function store($channel, Thread $thread, StoreReplyRequest $request)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('user');


        return response($reply, 201);
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), [
                'body' => ['required', new SpamFree]
            ]);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Your reply cant be saved this time.', 422);
        }

        return response('Your reply was updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return response([], 204);
    }
}
