@extends('home')

@section('content')
    <div class="page d-flex">
        <div class="content w-full">
            <h1 class="p-relative fs-25">{{ $task->title }}</h1>
            <div style="display: flex">
                <div class="tasks m-10 p-20 bg-white rad-10" style="min-width: 500px">
                    <h2 class="mt-0 mb-20">Comments</h2>
                    @unless(count($comments) == 0)
                        @foreach ($comments as $comment)
                            <div style="display:flex; flex-direction:column">
                                <div class="task-row between-flex">
                                    <div class="info">
                                        <h3 class="mt-0 mb-5 fs-15"> {{ $comment->id }}</h3>
                                        <p class="m-0 c-grey"> {{ $comment->description }}</p>
                                    </div>

                                    <i class="fa-regular fa-images mr-2 delete"></i>
                                    <i class="fa-regular fa-trash-can delete"></i>

                                </div>
                                <div class="hidden">
                                    <img class="cover" src="{{ asset('/images/no-image.png') }}" alt="image" />
                                    <h4 class="m-0">text</h4>
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
        let hidden = document.querySelector('.hidden');
        let imageIcon = document.querySelector('.fa-images');
        imageIcon.addEventListener('click', (event) => {
            hidden.classList.toggle('hidden')
        });
    </script>
@endsection
