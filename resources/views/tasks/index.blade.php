@extends('home')

@section('content')
    <div class="projects p-20 bg-white rad-10 m-5">
        <span class="d-flex justify-between p-2.5">
            <p>Task</p>
            <div class="d-flex gap-4">
                <p class="w-24">Duration</p>
                <p class="w-24">Created By</p>
                <p class="w-36">Status / affected To </p>
                <p class="w-36">Created at</p>
                <p class="w-24">Type</p>
            </div>

        </span>
        <x-tasks :tasks="$tasks" :users="$users" />
        
    </div>
@endsection
