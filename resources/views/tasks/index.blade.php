@extends('home')

@section('content')
    <div class="projects p-20 bg-white rad-10 m-5">
        <x-tasks :tasks="$tasks" />
    </div>
@endsection
