@extends('layouts.app')

@section ('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($threads as $thread)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <a href="{{ $thread->path() }}">
                                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                    <strong>{{ $thread->title }}</strong>
                                @else
                                    {{ $thread->title }}
                                @endif
                            </a>
                            <strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection