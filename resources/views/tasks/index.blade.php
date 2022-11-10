@extends('home')

@section('content')
    <div class="projects p-20 bg-white rad-10 m-5">
        <span class="d-flex justify-between p-2.5">
            <p>Task</p>
            <div class="d-flex gap-1.5">
                <p class="w-24 text-center">Duration</p>
                <p class="w-24 text-center">Created By</p>
                <p class="w-36 text-center">Status</p>
                <p class="w-36 text-center">Created at</p>
                <p class="w-24 text-center  mr-5">Type</p>
            </div>

        </span>
        <x-tasks :tasks="$tasks" :users="$users" />
        
    </div>
@endsection
