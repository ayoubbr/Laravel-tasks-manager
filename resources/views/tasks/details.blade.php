@extends('home')

@section('content')
    <div class="page">
        <div class="card d-flex bx-shadow rounded-md">
            <div class="content w-full p-20">
                <div class="d-flex justify-start gap-5 ml-5 align-center my-10">
                    <h1 class="p-relative fs-25" style="margin: 0">Task : {{ $task->title }}</h1>
                    <a href="/tasks/{{ $task->id }}/edit">
                        <span class="label btn-shape py-2 bg-sky-600 c-white hover:bg-sky-700">
                            <i class="fa-solid fa-pencil mr-2"></i> Edit Task
                        </span>
                    </a>
                </div>
                <div class="grid gap-4 grid-cols-1">
                    @unless($task->type == 'Master')
                        <div class="tasks m-5 px-5 bg-white rad-10">
                            <div class="d-flex px-1 justify-between align-center mb-3"
                                style="border-bottom: 1px solid #dad7d7;">
                                <h2 class="text-2xl py-5">
                                    Comments
                                </h2>
                                @if (auth()->user())
                                    <button
                                        class="bg-sky-600 hover:bg-sky-700 btn-plus text-white hover:text-white p-10 rounded-md d-flex align-center">
                                        Toggle form to add a comment
                                    </button>
                                @endif
                            </div>
                            <div class="comment_create mb-10 comment-create">
                                <form method="POST" action="/tasks/task-details/{{ $task->id }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid gap-4 grid-cols-2">
                                        <div class="mb-6">
                                            <label for="title" class="inline-block text-lg mb-2">Title</label>
                                            <input type="text" class="border border-gray-400 rounded p-2 w-full"
                                                name="title" value="{{ old('title') }}" />

                                            @error('title')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-6">
                                            <label for="duration" class="inline-block text-lg mb-2">Duration</label>
                                            <input type="number" step="any"
                                                class="border border-gray-400 rounded p-2 w-full" name="duration"
                                                value="{{ old('duration') }}" />

                                            @error('duration')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="grid gap-4 grid-cols-2">
                                        <div class="mb-6">
                                            <label for="description" class="inline-block text-lg mb-2">Description</label>
                                            <textarea class="border border-gray-400 rounded p-2 w-full" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-6">

                                            <label for="images" class="inline-block text-lg mb-2">
                                                Upload Images
                                            </label>
                                            <input type="file"
                                                class="border border-gray-400 rounded p-2  
                                        block w-full text-sm text-slate-500 
                                        file:mr-4 file:py-2 file:px-4 file:rounded-full 
                                        file:border-0 file:text-sm file:font-semibold  
                                        file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 w-full"
                                                name="images[]" accept="image/*" multiple />
                                            @error('images')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="grid gap-4 grid-cols-2">
                                        <div class="mb-6">
                                            <button type="submit"
                                                class="bg-cyan-500 text-white rounded py-2 px-4 hover:bg-cyan-600">
                                                Create Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @unless($task->type == 'Master')
                                @unless(count($comments) == 0)
                                    @foreach ($comments as $comment)
                                        <div class="comment-row mb-10">
                                            <div class="task-row between-flex">
                                                <div class="info">
                                                    <div
                                                        class="text-md d-flex comment-head justify-between align-center bg-slate-200 p-10">
                                                        <span> <span class="text-sm">created by :
                                                            </span>{{ $comment->task->user->name }}</span>
                                                        <span><span class="text-sm">affected to :</span>
                                                            @if ($comment->task->userAffectedTo !== null)
                                                                {{ $comment->task->userAffectedTo }}
                                                            @else
                                                                NO USER
                                                            @endif
                                                        </span>
                                                        <span><span class="text-sm">created at
                                                                :</span>{{ $comment->created_at }}</span>
                                                        <span><span class="text-sm">duration : </span>{{ $comment->duration }}
                                                            (hours)
                                                        </span>
                                                        <div class="d-flex gap-3 align-center">
                                                            <a href="{{ route('tasks.comments.edit', $comment->id) }}">
                                                                <i class="cursor-pointer fa-solid  fa-pencil edit"></i>
                                                            </a>
                                                            <i class="cursor-pointer fa-regular fa-images image"></i>
                                                            <a id="delete"
                                                                href="/tasks/task-details/{{ $task->id }}/comments/{{ $comment->id }}/">
                                                                <i class="fa-regular fa-trash-can delete"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <h3 class="p-10">{{ $comment->title }}</h3>
                                                    <p class="p-10 c-grey"> {{ Str::substr($comment->description, 0, 78) }}
                                                        @if (strlen($comment->description) >= 78)
                                                            <span>...</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="targetClass">
                                                @if (count($comment->images) != 0)
                                                    <p class="p-10 text-green-500">Images Found!</p>
                                                    <div class="hidden grid gap-4 grid-cols-3 bg-white p-5 rad-6 p-relative">
                                                        @foreach ($comment_images as $commentImage)
                                                            @if ($comment->id == $commentImage->comment_id)
                                                                <img class="cover rounded-md"
                                                                    src="/comment_imgs/{{ $commentImage->image }}" alt="" />
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="p-10 text-yellow-500">No Images Found!</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>no comments</p>
                                @endunless
                            @endunless
                        </div>
                    @endunless
                    <div class="tasks m-5 bg-white rad-10">
                        <div class="d-flex justify-between align-center" style="border-bottom: 1px solid #dad7d7;">
                            <h2 class="p-15 text-2xl">
                                Description
                            </h2>
                        </div>
                        <div class="courses-page d-grid m-5 gap-10">
                            {{ $task->description }}
                        </div>
                    </div>
                    <div class="tasks m-5 bg-white rad-10">
                        <div class="d-flex justify-between align-center" style="border-bottom: 1px solid #dad7d7;">
                            <h2 class="p-15 text-2xl">
                                Uploads
                            </h2>
                        </div>
                        <div class="courses-page d-grid m-5 gap-10">
                            @if (count($uploads) == 0)
                                <p>No uploads found</p>
                            @endif
                            @foreach ($uploads as $upload)
                                <div class="course bg-eee rad-6 p-relative">
                                    <img class="cover" src="/task_imgs/{{ $upload->upload }}" alt="" />
                                    <p class="p-4">{{ $upload->upload }}</p>
                                    <div class="p-20 d-flex justify-between">
                                        <h4 class="m-0">Id: {{ $upload->id }}</h4>
                                        <a id="delete" class="label  py-2 "
                                            href="/tasks/task-details/upload/{{ $upload->id }}/">
                                            <i class="fa-regular fa-trash-can delete"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let hidden = document.querySelectorAll('.hidden');
        let comment_create = document.querySelector('.comment_create');
        let imageIcon = document.querySelectorAll('.fa-images');
        let plusIcon = document.querySelector('.btn-plus');
        if (imageIcon) {
            imageIcon.forEach(element => {
                element.addEventListener('click', (event) => {
                    let target = event.target.parentElement.parentElement.parentElement.parentElement
                        .nextElementSibling.firstElementChild.nextElementSibling.classList;
                    target.toggle('hidden');
                    console.log(target);
                });
            });
        }
        if (plusIcon) {
            plusIcon.addEventListener('click', (event) => {
                if (plusIcon.innerHTML == 'Add comment') {
                    plusIcon.innerHTML = 'hide';
                }
                comment_create.classList.toggle('hided');
            });
        }
    </script>
@endsection
