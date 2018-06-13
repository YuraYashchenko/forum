@extends('layouts.app')

@section ('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">{{ $thread->title }}</div>

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
                            {{ $reply->user->name  }} said  {{ $reply->user->created_at->diffForHumans()  }} ago..
                        </div>

                        <div class="card-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection