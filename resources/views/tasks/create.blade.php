@php
    
@endphp

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
                        <select id="type" name="type" value="{{ old('type') }}"
                            class="border border-gray-200 rounded p-2 w-full">
                            <option value="">Select Type</option>
                            <option value="Master">Master</option>
                            <option value="Normal">Normal</option>

                            {{-- <input type="text" class="border border-gray-200 rounded p-2 w-full" name="type"
                                placeholder="Example: Senior Laravel Developer" value="{{ old('type') }}" /> --}}
                        </select>

                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="status" class="inline-block text-lg mb-2">Status</label>
                        <select name="status" value="{{ old('status') }}"
                            class="border border-gray-200 rounded p-2 w-full">
                            <option value="">Select Status</option>
                            <option value="Open">Open</option>
                            <option value="To Dispatch">To Dispatch</option>
                            <option value="To Validate">To Validate</option>
                            <option value="Completed">Completed</option>
                        </select>
                        {{-- <input type="text" class="border border-gray-200 rounded p-2 w-full" name="status"
                            placeholder="Example: Remote, Boston MA, etc" value="{{ old('status') }}" /> --}}

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
                        <label for="image" class="inline-block text-lg mb-2">
                            Upload Images
                        </label>
                        <input type="file"
                            class="border border-gray-200 rounded p-2 
                        block w-full text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold
      file:bg-violet-50 file:text-violet-700
      hover:file:bg-violet-100 w-full"
                            name="images[]" accept="image/*" multiple />
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <button class="bg-sky-400 text-black rounded py-2 px-4 
                        hover:bg-sky-500">
                            Create Task
                        </button>

                        <a href="/tasks" class="text-black bg-sky-300
                         ml-4 py-2 px-4 rounded-md hover:bg-sky-400">
                            Go Back
                             <i class="fa-regular fa-circle-right"></i> 
                        </a>
                    </div>
            </form>
        </div>
    </div>
@endsection
