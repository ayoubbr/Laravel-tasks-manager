@extends('home')

@section('content')
    <div class="taskbox">
        {{-- <img src="" alt="" /> --}}
        <div class="content">
            <h3>
                {{ $task['title'] }}
            </h3>
        </div>

        <div class="info">
            type: {{ $task['type'] }}
            {{-- <a class="status"></a> --}}
            {{-- <i class="fas fa-long-arrow-alt-right"></i> --}}
        </div>
        <div class="info">
            status: {{ $task['status'] }}
        </div>
        <div class="info">
            uploads: {{ $task['uploads'] }}
        </div>
        <div class="info">
          comments:  <x-task-comments :commentsCsv="$task->comments" />


        </div>
    </div>
@endsection
