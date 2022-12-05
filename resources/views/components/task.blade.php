<li class="{{ !$task->isChild() ? 'first' : null }}">
    <span style="display: flex; gap:10px" class="treespan d-flex">
        <div class="relative d-flex cursor-pointer align-center text-left">
            <i class="btn fa-solid fa-bars-staggered"></i>
            <div class="list hidden absolute z-10 mt-2 w-56  origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    @if ($task->type == 'Master' && auth()->user())
                        <a class="text-gray-700 block px-4 py-2 text-sm"
                            href="/tasks/{{ $task->id }}/task-child/create">
                            <i class="ml-1 mr-3 fa-solid fa-plus"></i> Add Child Task
                        </a>
                    @endif
                    <a href="{{ route('task.details', $task->id) }}" class="text-gray-700 block px-4 py-2 text-sm">
                        <i class="fa-solid fa-eye ml-1 mr-3"></i>
                        View Details
                    </a>
                    @if ($task->type !== 'Master' && auth()->user())
                        <a href="{{ route('task.details', $task->id) }}" class="text-gray-700 block px-4 py-2 text-sm">
                            <i class="fa-solid fa-plus ml-1 mr-3"></i>
                            Add Comment
                        </a>
                    @endif
                    @if (auth()->user())
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
                    @endif
                </div>
            </div>
        </div>

        {{ $task->title }}
        <div class="d-flex ml-auto gap-1.5 text-sm">
            <p class="w-24 text-center">{{ $task->duration }}</p>
            <p class="w-24 text-center">{{ $task->user->name }}</p>
            <div class="w-36 text-center cursor-pointer">
                <form class="status-form text-gray-700 block " action="/tasks/{{ $task->id }}/updateStatus"
                    method="POST">
                    @csrf
                    @method('put')
                    <select class="select" name="status"
                        class="cursor-pointer select-status border border-gray-200 rounded p-2 w-full">
                        <option value="" disabled selected>Select Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->name }}"
                                {{ $task->status == $status->name ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}"
                                {{ $task->userAffectedTo == $user->name ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="hidden apply bg-gray-200 rounded-sm p-1"
                        style="position: relative;left: 370px;top: -23px;">
                        <i class="fa-solid fa-circle-check "></i> Apply
                    </button>
                </form>
            </div>
            <p class="w-36 text-center">{{ $task->created_at }}</p>
            <p class="w-24 text-center mr-5">{{ $task->type }}</p>
        </div>
    </span>
    <x-tasks :tasks="$task->children" :users="$users" :statuses="$statuses" />
</li>