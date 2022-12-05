@extends('home')
@section('content')
<div class="card bx-shadow rounded-md mt-20">
    <div class="p-10 max-w-lg mx-auto">
        <header class="text-center py-3">
            <h2 class="text-2xl font-bold uppercase mb-1">Login</h2>
            <p class="mb-4">Log into your account</p>
        </header>
        <form method="POST" action="/users/authenticate">
            @csrf

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Email</label>
                <input type="email" class="border border-gray-400 focus:border-gray-600 hover:border-gray-600 rounded p-2 w-full" name="email"
                    value="{{ old('email') }}" />

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">
                    Password
                </label>
                <input type="password" class="border border-gray-400 focus:border-gray-600 hover:border-gray-600 rounded p-2 w-full" name="password"
                    value="{{ old('password') }}" />

                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-stone-900 
                text-white rounded py-2 px-4 hover:bg-sky-600">
                    Sign In
                </button>
            </div>

            <div class="mt-8 mb-5">
                <p>
                    Don't have an account?
                    <a href="/register" class="text-sky-500 hover:text-sky-600">Register</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
