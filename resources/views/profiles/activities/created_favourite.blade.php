@component('profiles.activities.activity')
    @slot('head')
        <a href="{{ $activity->subject->favouritable->path() }}">
            {{ $profileUser->name }} favourited a reply
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favouritable->body }}
    @endslot
@endcomponent