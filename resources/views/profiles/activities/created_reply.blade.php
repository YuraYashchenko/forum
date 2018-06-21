@component('profiles.activities.activity')
    @slot('head')
        <a href="{{ route('profiles.show', $activity->subject->user->name) }}">{{ $activity->subject->user->name }}</a> leave a reply to thread
        <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent