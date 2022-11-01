@extends('home')

@section('content')
    <div class="card">

        <div style="padding: 30px 80px">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-5">Edit Task {{ $task->title }}</h2>
            </header>
            <form method="POST" action="/tasks/{{ $task->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid grid-cols-3 gap-4">
                    <div class="mb-6">
                        <label for="title" class="inline-block text-lg mb-2">Title</label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                            value="{{ $task->title }}" />

                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="type" class="inline-block text-lg mb-2">Type</label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="type"
                            placeholder="Example: Senior Laravel Developer" value="{{ $task->type }}" />

                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="status" class="inline-block text-lg mb-2">Status</label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="status"
                            placeholder="Example: Remote, Boston MA, etc" value="{{ $task->status }}" />

                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid grid-cols-3 gap-4">
                    <div class="mb-6">
                        <label for="uploads" class="inline-block text-lg mb-2">
                            uploads
                        </label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="uploads"
                            value="{{ $task->uploads }}" />

                        @error('uploads')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="comments" class="inline-block text-lg mb-2">
                            Comments
                        </label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="comments"
                            value="{{ $task->comments }}" />

                        @error('comments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <button class="bg-sky-400 text-black rounded py-2 px-4 hover:bg-sky-500">
                            Update Task
                        </button>

                        <a href="/" class="text-black ml-4"> Back </a>
                    </div>
            </form>
        </div>
    </div>
@endsection
