@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                </h1>
            </div>

            <hr>

            @foreach ($activities as $date => $activity)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach

            {{--{{ $threads->links() }}--}}
        </div>
    </div>
@endsection