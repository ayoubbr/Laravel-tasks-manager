@extends('home')

@section('content')
    <div class="card flex-center">

        <div class="flex gap-64">
            <h2><span class="text-lg font-bold"> {{ $task->title }}</span></h2>

            <div>
                @foreach ($comments as $comment)
                    {{ $comment->description }}
                @endforeach
            </div>

            <a href="/tasks" class="bg-sky-400 hover:bg-sky-500 py-2 px-4 rounded-md ">
                Go Back
                <i class="fa-regular fa-circle-right"></i>
            </a>

        </div>

        <div class="flex-center">
            @foreach ($images as $image)
                <img src="/task_imgs/{{ $image->image }}" style="max-width: 20rem;
                border-radius:6px"
                    alt="">
            @endforeach
        </div>
    </div>
@endsection
