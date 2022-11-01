@extends('home')

@section('content')
<div class="card">

    <div class="p-20">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase  mb-4">Create a Task</h2>
        </header>
        <form method="POST" action="/tasks" enctype="multipart/form-data">
            @csrf
            <div class="grid grid grid-cols-3 gap-4">
                <div class="mb-6">
                    <label for="title" class="inline-block text-lg mb-2">Title</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                        value="{{ old('title') }}" />

                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="type" class="inline-block text-lg mb-2">Type</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="type"
                        placeholder="Example: Senior Laravel Developer" value="{{ old('type') }}" />

                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="status" class="inline-block text-lg mb-2">Status</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="status"
                        placeholder="Example: Remote, Boston MA, etc" value="{{ old('status') }}" />

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
                        value="{{ old('uploads') }}" />

                    @error('uploads')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="comments" class="inline-block text-lg mb-2">
                        Comments
                    </label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="comments"
                        value="{{ old('comments') }}" />

                    @error('comments')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid grid-cols-2 gap-4">
                <div class="mb-6">
                    <button class="bg-sky-400 text-black rounded py-2 px-4 hover:bg-sky-500">
                        Create Task
                    </button>

                    <a href="/" class="text-black ml-4"> Back </a>
                </div>
        </form>
    </div>
</div>
@endsection
