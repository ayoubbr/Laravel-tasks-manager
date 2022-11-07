@extends('home')
@section('content')
    <div class="card">

        <div class="p-10 max-w-lg mx-auto ">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">Register</h2>
                <p class="mb-4">Create an account</p>
            </header>

            <form method="POST" action="/users" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="inline-block text-base mb-1"> Name </label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                        value="{{ old('name') }}" />

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="inline-block text-base mb-1">Email</label>
                    <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email"
                        value="{{ old('email') }}" />

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="inline-block text-base mb-1">
                        Password
                    </label>
                    <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
                        value="{{ old('password') }}" />

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="inline-block text-base mb-1">
                        Confirm Password
                    </label>
                    <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password_confirmation"
                        value="{{ old('password_confirmation') }}" />

                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="logo" class="inline-block text-base mb-1">
                        Profile picture
                    </label>
                    <input type="file"
                        class="border border-gray-200 rounded p-2
                     w-full border border-gray-200 rounded p-2  
                            block w-full text-sm text-slate-500 
                            file:mr-4 file:py-2 file:px-4 file:rounded-full 
                            file:border-0 file:text-sm file:font-semibold  
                            file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 w-full" " name="logo" />
                        @error('logo')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="bg-stone-900
                         text-white rounded py-2 px-4 hover:bg-slate-500">
                            Sign Up
                        </button>
                    </div>

                    <div class="mt-5">
                        <p>
                            Already have an account?
                            <a href="/login" class="text-black">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
@endsection
