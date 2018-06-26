@extends('layouts.app')

@section ('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('profiles.show', $thread->user->name) }}">{{ $thread->user->name }}</a> posted:  {{ $thread->title }}
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
                                A thread was posted by <a href="{{ route('profiles.show', $thread->user->name) }}">{{ $thread->user->name }}</a> {{ $thread->created_at->diffForHumans() }},
                                and has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribed) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>
            </div>
        </div>
    </thread-view>
@endsection