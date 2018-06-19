@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>
            </div>

            <hr>

            @foreach ($profileUser->threads as $thread)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                       <span>
                            <a href="{{ route('profiles.show', $thread->user->name) }}">{{ $thread->user->name }}</a> posted:
                           {{ $thread->title }}
                       </span>

                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            @endforeach

            {{ $threads->links() }}
        </div>
    </div>
@endsection