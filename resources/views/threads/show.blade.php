@extends('layouts.app')

@section ('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->user->name }}</a> posted:  {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    <div class="card mt-3">
                        <div class="card-header">
                            <a href="#">{{ $reply->user->name }}</a> said  {{ $reply->user->created_at->diffForHumans()  }} ...
                        </div>

                        <div class="card-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center mt-3">
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