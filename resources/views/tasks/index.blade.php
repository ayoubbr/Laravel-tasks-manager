@extends('home')

@section('content')

    <div class="projects p-20 bg-white rad-10 m-5">
        <h2 class="mt-0 mb-5">Tasks</h2>
        <div class="responsive-table">
            <table class="fs-15 w-full">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Title</td>
                        <td>Type</td>
                        <td>Status</td>
                        <td>Affected user</td>
                        <td>Parent Task</td>
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
                                            'bg-orange-500' => $task->status == 'To Validate',
                                            'bg-red-500' => $task->status == 'Open',
                                            'bg-sky-500' => $task->status == 'To Dispatch',
                                            'bg-green-500' => $task->status == 'Completed',
                                        ])>
                                            {{ $task['status'] }}
                                        </span>
                                    </a>
                                </td>
                                
                                <td>
                                    {{ $task->userAffectedTo }}
                                </td>
                                <td>
                                   id :  {{ $task->parent_id }}
                                </td>


                            </tr>
                        @endforeach
                    @else
                        <p class="text-zinc-900 bg-zinc-200 p-10 mb-5 rounded-md">No tasks found</p>
                    @endunless


                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
