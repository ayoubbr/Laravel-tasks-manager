@extends('home')

@section('content')
    <div class="projects p-20 bg-white rad-10 m-5">
        <h2 class="mt-0 mb-5">Tasks</h2>
        <div class="responsive-table">
            <table class="fs-15 w-full">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Title</td>
                        <td>Type</td>
                        <td>Status</td>
                        <td>Prent Task</td>
                        <td>Affected user</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>

                    @unless($tasks->isEmpty())
                        @foreach ($tasks as $task)
                            <tr>
                                <td> {{ $task['id'] }}
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
                                            ' c-white',
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
                                    {{ $task->parent_id }}
                                </td>
                                <td style="text-transform: uppercase">
                                    @if ($task->userAffectedTo)
                                        {{ $task->userAffectedTo }}
                                    @else
                                        <p>no user affected</p>
                                    @endif
                                </td>
                                <td class="d-flex align-center">
                                    <a href="{{ route('task.details', $task->id) }}"
                                        class="bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                        View Details
                                    </a>
                                    <a href="/tasks/{{ $task->id }}/edit">
                                        <span
                                            class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                            Edit <i class="ml-1 fa-solid fa-pencil"></i>

                                        </span>
                                    </a>
                                    <form action="/tasks/{{ $task->id }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <span
                                            class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                            <button type="submit">
                                                Delete <i class=" ml-1 fa-solid fa-trash"></i>

                                            </button>
                                        </span>
                                    </form>
                                    @if ($task->type == 'Master')
                                        <a href="/tasks/{{ $task->id }}/task-child/create">
                                            <span
                                                class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                                Create Child Task <i class="ml-1 fa-solid fa-plus"></i>

                                            </span>
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p class="text-zinc-900 bg-zinc-200 p-10 mb-5 rounded-md">No tasks found</p>
                    @endunless
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-5">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
