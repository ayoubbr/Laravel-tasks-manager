@extends('home')

@section('content')
    <div class="page">
        <div class="card d-flex">

            <div class="content w-full">

                <div class="d-flex justify-around align-center my-10">
                    <h1 class="p-relative fs-25 " style="margin: 0">Task : {{ $task->title }}</h1>
                    <a href="/tasks/{{ $task->id }}/edit">
                        <span class="label btn-shape py-2 bg-stone-900 c-white hover:bg-slate-500">
                            <i class="fa-solid fa-pencil mr-2"></i> Edit Task
                        </span>
                    </a>
                </div>

                <div class="grid gap-4 grid-cols-1">
                    @unless($task->type == 'Master')
                        <div class="tasks m-5 p-20 bg-white rad-10">
                            <div class="d-flex justify-between align-center mb-3">
                                <h2 class=" text-2xl">
                                    Comments
                                </h2>
                                <button
                                    class="bg-sky-400 hover:bg-sky-600 btn-plus hover:text-white p-10 rounded-md d-flex align-center">
                                    Add comment
                                    <i class="fa-solid fa-circle-plus ml-2 cursor-pointer"></i>
                                </button>

                            </div>

                            <div class="hided mb-10 comment-create">
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
                                            <label for="description" class="inline-block text-lg mb-2">Description</label>
                                            <input type="text" class="border border-gray-400 rounded p-2 w-full"
                                                name="description" value="{{ old('description') }}" />

                                            @error('description')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid gap-4 grid-cols-2">
                                        <div class="mb-6">
                                            <label for="duration" class="inline-block text-lg mb-2">Duration</label>
                                            <input type="number" step="any"
                                                class="border border-gray-400 rounded p-2 w-full" name="duration"
                                                value="{{ old('duration') }}" />

                                            @error('duration')
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
                                                        class="text-lg d-flex comment-head justify-between align-center bg-slate-200 p-10">
                                                        <span>{{ $comment->task->user->name }}</span>
                                                        <span>{{ $comment->task->userAffectedTo }}</span>
                                                        <span>{{ $comment->created_at }}</span>
                                                        <h3>{{ $comment->title }}</h3>
                                                        <span>{{ $comment->duration }} (hours)</span>
                                                        <div class="d-flex gap-3 align-center">
                                                            <i class="cursor-pointer fa-regular  fa-images image"></i>
                                                            <form
                                                                action="/tasks/task-details/{{ $task->id }}/comments/{{ $comment->id }}/"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <span class="label">
                                                                    <button type="submit">
                                                                        <i class="fa-regular fa-trash-can delete"></i>
                                                                    </button>
                                                                </span>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <p class=" p-10 c-grey"> {{ $comment->description }}</p>
                                                </div>
                                            </div>

                                            <div class="targetClass">
                                                @if (count($comment_images) != 0)
                                                    <div class="hidden grid gap-4 grid-cols-3 bg-white rad-6 p-relative">

                                                        @foreach ($comment_images as $commentImage)
                                                            @if ($comment->id == $commentImage->comment_id)
                                                                <img class="cover" src="/comment_imgs/{{ $commentImage->image }}"
                                                                    alt="" />
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="p-10">No Images Found!</p>
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
                    <div class="tasks m-5  p-20  bg-white rad-10">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <h2 class="mb-5 text-2xl">
                                Uploads
                            </h2>
                        </div>
                        <div class="courses-page d-grid m-5 gap-10">
                            @foreach ($uploads as $upload)
                                <div class="course bg-eee rad-6 p-relative">
                                    <img class="cover" src="/task_imgs/{{ $upload->upload }}" alt="" />
                                    {{-- <embed src="/task_imgs/{{ $upload->upload }}"> --}}
                                    <p class="p-4">{{ $upload->upload }}</p>
                                    <div class="p-20 d-flex justify-between">
                                        <h4 class="m-0">Id: {{ $upload->id }}</h4>
                                        <form action="/tasks/task-details/{{ $task->id }}/{{ $upload->id }}/"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <span class="label  py-2 ">
                                                <button type="submit">
                                                    <i class="fa-regular fa-trash-can delete"></i>
                                                </button>
                                            </span>
                                        </form>
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
        let hided = document.querySelector('.hided');
        let imageIcon = document.querySelectorAll('.fa-images');
        let plusIcon = document.querySelector('.btn-plus');
        if (imageIcon) {
            imageIcon.forEach(element => {
                element.addEventListener('click', (event) => {
                    let target = event.target.parentElement.parentElement.parentElement.parentElement
                        .nextElementSibling.firstElementChild.classList;
                    target.toggle('hidden');
                });
            });
        }
        if (plusIcon) {
            plusIcon.addEventListener('click', (event) => {
                hided.classList.toggle('hided');
            });
        }
    </script>
@endsection
