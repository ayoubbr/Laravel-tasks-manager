@extends('home')

@section('content')
    <div class="card bx-shadow rounded-md">
        <header class="text-center rounded-t-md d-flex align-center justify-center p-20 bg-orange-500">
            <h2 class="text-2xl">Edit User {{ $user->name }}</h2>
        </header>
        <div class="px-12 py-8">
            <form method="POST" action="{{ route('users.edit.update', $user->id) }}" enctype="multipart/form-data"
                class="create-form">
                @csrf
                @method('PUT')
                <div class="grid grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="inline-block text-lg mb-2">Name</label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="Name"
                            name="name" value="{{ $user->name }}" />

                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="inline-block text-lg mb-2">Email</label>
                        <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="Email"
                            name="email" value="{{ $user->email }}" />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid grid-cols-1 gap-4">
                    <div>
                        <label for="logo" class="inline-block text-lg mb-2">
                            Profile Image
                        </label>
                        <input type="file"
                            class="cursor-pointer border border-gray-500 rounded p-1 block w-full text-sm text-slate-500 file:mr-7 file:cursor-pointer file:px-5 file:py-2 file:rounded-full file:border-0 file:text-sm file:font-semibold  file:bg-orange-500 file:text-white-700 hover:file:bg-orange-600 w-full"
                            name="logo" />
                        @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid grid-cols-1 mt-5">
                    <div>
                        <button type="submit" class="bg-orange-600 text-white rounded py-2 px-4 hover:bg-orange-700">
                            Update user
                        </button>
                        <a href=""class="text-black ml-4 py-2 px-4 rounded-md hover:bg-orange-600 hover:text-white">
                            Go Back
                            <i class="fa-regular fa-circle-right"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
