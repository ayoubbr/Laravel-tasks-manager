@extends('home')
@section('content')
    <div class="card p-5">
        <div class="bg-gray-200 p-4 rounded-md">
            <div class="task-row between-flex">
                <div class="info">
                    <div class="text-md d-flex  gap-20 comment-head justify-between align-center bg-slate-200 p-10">
                        <div>
                            <span class="text-sm">created by :
                            </span>
                            {{ $comment->task->user->name }}
                        </div>
                        <span>
                            <span class="text-sm">affected to :</span>
                            @if ($comment->task->userAffectedTo !== null)
                                {{ $comment->task->userAffectedTo }}
                            @else
                                NO USER
                            @endif
                        </span>
                        <span>
                            <span class="text-sm">created at:</span>
                            {{ $comment->created_at }}
                        </span>
                        <span>
                            <span class="text-sm">duration : </span>
                            {{ $comment->duration }} (hours)
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bx-shadow p-5">
            <div class="mt-2">
                <form method="POST" action="{{ route('tasks.comments.update', $comment->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 grid-cols-2">
                        <div class="mb-6">
                            <label for="title" class="inline-block text-lg mb-2">Title</label>
                            <input type="text" class="border border-gray-400 rounded p-2 w-full" name="title"
                                value="{{ $comment->title }}" />

                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="duration" class="inline-block text-lg mb-2">Duration</label>
                            <input type="number" step="any" class="border border-gray-400 rounded p-2 w-full"
                                name="duration" value="{{ $comment->duration }}" />
                            @error('duration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-4 grid-cols-2">
                        <div class="mb-6">
                            <label for="description" class="inline-block text-lg mb-2">Description</label>
                            <textarea class="border border-gray-400 rounded w-full px-2" name="description" id="description" rows="4">{{ $comment->description }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="images" class="inline-block text-lg mb-2">
                                Upload Images
                            </label>
                            <input type="file"
                                class="border border-gray-400 rounded p-2  block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold  file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 w-full"
                                name="images[]" accept="image/*" multiple />
                            @error('images')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-4 grid-cols-2">
                        <div class="mb-6">
                            <button type="submit" class="bg-cyan-500 text-white rounded py-2 px-4 hover:bg-cyan-600">
                                Update Comment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
