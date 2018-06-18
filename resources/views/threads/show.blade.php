@extends('layouts.app')

@section ('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->user->name }}</a> posted:  {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            A thread was posted by <a href="#">{{ $thread->user->name }}</a> {{ $thread->created_at->diffForHumans() }},
                            and has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-8">
                @auth
                    <form action="{{ route('add.reply', [$thread->channel->slug, $thread->id]) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <textarea name="body" id="body" placeholder="Type a reply" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="form-control">Post</button>
                        </div>
                    </form>
                @endauth
                @guest
                <p class="text-center">Pleas <a href="{{ route('login') }}">sign in</a> to leave a reply</p>
                @endguest
            </div>
        </div>


    </div>
@endsection