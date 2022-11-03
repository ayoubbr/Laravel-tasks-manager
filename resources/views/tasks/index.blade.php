@extends('home')

@section('content')

    <div class="projects p-20 bg-white rad-10 m-5">
        <h2 class="mt-0 mb-5">Table</h2>
        <div class="responsive-table">
            <table class="fs-15 w-full">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Title</td>
                        <td>Type</td>
                        <td>Status</td>
                        <td>Images</td>
                        <td>Affected user</td>
                    </tr>
                </thead>
                <tbody>

                    @unless(count($tasks) == 0)
                        @foreach ($tasks as $task)
                            <tr>
                                <td>
                                    {{ $task['id'] }}
                                </td>
                                <td>
                                    {{ $task['title'] }}
                                </td>

                                <td>
                                    <a href="/tasks/?type={{ $task->type }}">
                                        {{ $task['type'] }}</a>

                                </td>
                                <td>
                                    <a href="/tasks/?status={{ $task->status }}">
                                        <span @class([
                                            'label',
                                            'btn-shape',
                                            'c-white',
                                            'py-2',
                                            'bg-orange' => $task->status == 'To Validate',
                                            'bg-green' => $task->status == 'Open',
                                            'bg-red' => $task->status == 'To Dispatch',
                                            'bg-blue' => $task->status == 'Completed',
                                        ])>
                                            {{ $task['status'] }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('task.images', $task->id) }}"
                                        class="bg-sky-400 py-2 px-4 rounded-md hover:bg-sky-500">View Images</a>
                                </td>
                                <td>
                                   {{$task ->userAffectedTo}}
                                </td>


                            </tr>
                        @endforeach
                    @else
                        <p>no tasks found</p>
                    @endunless


                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
