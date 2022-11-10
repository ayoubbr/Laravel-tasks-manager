<li class="{{ !$task->isChild() ? 'first' : null }}">
    <span style="display: flex; gap:10px" class="treespan d-flex">
        <div class="relative d-flex cursor-pointer align-center text-left">

            <i class="btn fa-solid fa-bars-staggered"></i>

            <div class="list hidden absolute z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg 
            ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    @if ($task->type == 'Master')
                        <a class="text-gray-700 block px-4 py-2 text-sm"
                            href="/tasks/{{ $task->id }}/task-child/create">
                            <i class="ml-1 mr-3 fa-solid fa-plus"></i> Add Child Task
                        </a>
                    @endif
                    <a href="{{ route('task.details', $task->id) }}" class="text-gray-700 block px-4 py-2 text-sm">
                        <i class="fa-solid fa-eye ml-1 mr-3"></i>
                        View Details
                    </a>

                    @if ($task->type !== 'Master')
                        <a href="{{ route('task.details', $task->id) }}" class="text-gray-700 block px-4 py-2 text-sm">
                            <i class="fa-solid fa-plus ml-1 mr-3"></i>
                            Add Comment
                        </a>
                    @endif
                    <a href="/tasks/{{ $task->id }}/edit" class="text-gray-700 block px-4 py-2 text-sm">
                        <i class="ml-1 fa-solid fa-pencil mr-3"></i>
                        Edit
                    </a>
                    <form class="text-gray-700 block px-4 py-2 text-sm" action="/tasks/{{ $task->id }}"
                        method="POST">
                        @csrf
                        @method('delete')

                        <button type="submit">
                            <i class="ml-1 fa-solid fa-trash mr-3"></i>
                            Delete
                        </button>

                    </form>
                </div>
            </div>
        </div>
        {{ $task->title }}
        <div class="d-flex ml-auto gap-2.5">
            <p class="w-24">{{ $task->duration }}</p>
            <p class="w-24">{{ $task->user->name }}</p>
            <p class="w-36 cursor-pointer relative ">
                @if ($task->status == 'To Dispatch')
                    {{ $task->userAffectedTo }}
                @else
                    {{ $task->status }}
                @endif
            </p>           
        <p class="w-36">{{ $task->created_at }}</p>
        <p class="w-24">{{ $task->type }}</p>
        </div>
    </span>
    <x-tasks :tasks="$task->children" :users="$users" />
</li>
