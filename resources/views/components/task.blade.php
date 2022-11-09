<style>
    .list {
        right: -219px;
        top: 15px;
    }

    .list a:hover,
    form:hover {
        background-color: rgb(166, 247, 220)
    }

    .status-list {
        right: -28px;
        top: 32px;
    }

    .status-form {
        max-height: 24px !important;
    }

    .select {
        background-color: transparent;
        border: none;
        padding: 0;
        cursor: pointer;

    }
</style>

<li class="{{ !$task->isChild() ? 'first' : null }}">
    <span style="display: flex; gap:10px" class="treespan d-flex">
        <div class="relative d-flex cursor-pointer align-center text-left">

            <i class="btn fa-solid fa-bars-staggered"></i>

            <div class="list hidden absolute z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg 
            ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    @if ($task->type == 'Master')
                        <a class="text-gray-700 block px-4 py-2 text-sm"
                            href="/tasks/{{ $task->id }}/task-child/create">
                            <i class="ml-1 mr-3 fa-solid fa-plus"></i> Create Child Task
                        </a>
                    @endif
                    <a href="{{ route('task.details', $task->id) }}" class="text-gray-700 block px-4 py-2 text-sm">
                        <i class="fa-solid fa-eye ml-1 mr-3"></i>
                        View Details
                    </a>
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
                <i class="fa-solid fa-arrow-down-wide-short ml-2 btn2"></i>
            </p>
            {{-- <div class="status-list hidden absolute z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg 
                ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none"> --}}

            {{-- <div class="w-36"> --}}
                {{-- <form class="status-form text-gray-700 block px-4 py-2 text-sm"
                    action="/tasks/{{ $task->id }}/updateStatusAndUserAffected" method="POST">
                    @csrf
                    @method('put')
                    <select class="select" name="status"
                        class="cursor-pointer select-status border border-gray-200 rounded p-2 w-full">
                        <option value="">Select Status</option>
                        <option value="Open" {{ $task->status == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="To Validate" {{ $task->status == 'To Validate' ? 'selected' : '' }}>To
                            Validate
                        </option>
                        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}"
                                {{ $task->status == '$user->name' ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="apply">
                        <i class="fa-solid fa-square-check"></i> Apply Changes
                    </button>
                </form> --}}
                {{-- @foreach ($users as $user)
                        <form class="text-gray-700 block px-4 py-2 text-sm"
                            action="/tasks/{{ $task->id }}/updateStatusAndUserAffected" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit">
                                <i class="ml-1 fa-solid fa-user mr-3"></i>
                                {{ $user->name }}
                            </button>
                        </form>
                    @endforeach --}}
                {{-- </div> --}}
            {{-- </div> --}}
            <p class="w-24">{{ $task->type }}</p>
        </div>
    </span>
    <x-tasks :tasks="$task->children" :users="$users" />
</li>
