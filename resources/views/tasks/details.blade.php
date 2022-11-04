@extends('home')

@section('content')
    <div class="page d-flex">
        <div class="content w-full">
            <h1 class="p-relative fs-25">{{ $task->title }}</h1>
            <div class="grid gap-4 grid-cols-2">
                <div class="tasks m-10 p-20 bg-white rad-10">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <h2 class="mb-5">
                            Comments
                        </h2>
                        <p> Add comment
                            <i class="fa-solid fa-circle-plus mb-5 cursor-pointer"></i>
                        </p>
                    </div>

                    <div class="hided">
                        <form method="POST" action="/tasks/task-details/{{ $task->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-6">
                                <label for="description" class="inline-block text-lg mb-2">Description</label>
                                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="description"
                                    value="{{ old('description') }}" />

                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">

                                <label for="images" class="inline-block text-lg mb-2">
                                    Upload Images
                                </label>
                                <input type="file"
                                    class="border border-gray-200 rounded p-2  
                                    block w-full text-sm text-slate-500 
                                    file:mr-4 file:py-2 file:px-4 file:rounded-full 
                                    file:border-0 file:text-sm file:font-semibold  
                                    file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 w-full"
                                    name="images[]" accept="image/*" multiple />
                                @error('images')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="mb-6">
                                <button type="submit" class="bg-cyan-500 text-white rounded py-2 px-4 hover:bg-cyan-600">
                                    Create Comment
                                </button>
                            </div>

                        </form>
                    </div>
                    @unless(count($comments) == 0)
                        @foreach ($comments as $comment)
                            <div class="comment-row">
                                <div class="task-row between-flex">
                                    <div class="info">
                                        <h3 class="mt-0 mb-5 fs-15">ID : {{ $comment->id }}</h3>
                                        <p class="m-0 c-grey"> {{ $comment->description }}</p>
                                    </div>

                                    <i class="fa-regular fa-images mr-2 delete"></i>
                                    <form action="/tasks/task-details/{{ $task->id }}/{{ $comment->id }}/" method="POST">
                                        @csrf
                                        @method('delete')
                                        <span class="label  py-2 ">
                                            <button type="submit">
                                                <i class="fa-regular fa-trash-can delete"></i>
                                            </button>
                                        </span>
                                    </form>
                                </div>

                                <div>
                                    @if (count($comment_images) != 0)
                                        <div class="grid gap-4 grid-cols-3 bg-white rad-6 p-relative">

                                            @foreach ($comment_images as $commentImage)
                                                @if ($comment->id == $commentImage->comment_id)
                                                    <img class="cover" src="/comment_imgs/{{ $commentImage->image }}"
                                                        alt="" />
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p>nothing found</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>no comments</p>
                    @endunless
                </div>
                <div class="courses-page d-grid m-10 gap-10">
                    @foreach ($images as $image)
                        <div class="course bg-white rad-6 p-relative">
                            <img class="cover" src="/task_imgs/{{ $image->image }}" alt="" />
                            <div class="p-20">
                                <h4 class="m-0">{{ $image->image }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <script>
        // let hidden = document.querySelector('.hidden');
        let hided = document.querySelector('.hided');
        let imageIcon = document.querySelectorAll('.fa-images');
        let plusIcon = document.querySelector('.fa-circle-plus');

        // if (imageIcon) {
        //     imageIcon.forEach(element => {
        //         element.addEventListener('click', (event) => {
        //             hidden.classList.toggle('hidden')
        //         });
        //     });

        // }
        if (plusIcon) {
            plusIcon.addEventListener('click', (event) => {
                hided.classList.toggle('hided')
            });
        }
    </script>
@endsection
