@component('profiles.activities.activity')
    @slot('head')
        <a href="{{ route('profiles.show', $activity->subject->user->name) }}">{{ $activity->subject->user->name }}</a> posted:
        <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent