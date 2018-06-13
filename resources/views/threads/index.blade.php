@extends('layouts.app')

@section ('content')
    <div class="container">
            <div class="col-md-8">
                @foreach($threads as $thread)
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('threads.show', $thread->id) }}">
                                {{ $thread->title }}
                            </a>
                        </div>

                        <div class="card-body">
                           {{ $thread->body }}
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
@endsection