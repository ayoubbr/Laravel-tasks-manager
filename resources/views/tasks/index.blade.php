@extends('home')

@section('content')

    <div class="projects p-20 bg-white rad-10 m-20">
        <h2 class="mt-0 mb-20">Table</h2>
        <div class="responsive-table">
            <table class="fs-15 w-full">
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Type</td>
                        <td>Comments</td>
                        <td>Uploads</td>
                        {{-- <td>Team</td> --}}
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>

                    @unless(count($tasks) == 0)
                        @foreach ($tasks as $task)
                            <tr>
                                <td> <a href="/tasks/{{ $task['id'] }}">
                                        {{ $task['title'] }}
                                    </a></td>

                                <td>
                                    <a href="/tasks/?type={{ $task->type }}">
                                        {{ $task['type'] }}</a>

                                </td>
                                <td>
                                    <x-task-comments :commentsCsv="$task->comments" />

                                </td>
                                <td>{{ $task['uploads'] }}</td>
                                <td>
                                    <a href="/tasks/?status={{ $task->status }}">
                                        <span class="label btn-shape bg-orange c-white">
                                            {{ $task['status'] }}
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p>no tasks found</p>
                    @endunless


                </tbody>
            </table>
        </div>
    </div>
@endsection
