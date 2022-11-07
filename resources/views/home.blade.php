<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="page d-flex">
        {{-- Start Sidebar  --}}
        <div class="sidebar bg-white p-20  p-relative">
            <h3 class="p-relative txt-c mt-0">Tasks Manager</h3>
            <ul>
                <li>
                    <a class="d-flex align-center fs-14 c-black rad-6 p-10 
                    {{ 'tasks' == request()->path() ? 'active' : '' }}"
                        href="/tasks">
                        <i class="fa-regular fa-chart-bar fa-fw"></i>
                        <span>Tasks</span>
                    </a>
                </li>
                @auth
                    <li>
                        <a class="d-flex align-center fs-14 c-black rad-6 p-10
                        {{ 'tasks/manage' == request()->path() ? 'active' : '' }}"
                            href="/tasks/manage">
                            <i class="fa-solid fa-gear fa-fw"></i>
                            <span>Manage Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-center fs-14 c-black rad-6 p-10
                        {{ 'tasks/create' == request()->path() ? 'active' : '' }}"
                            href="/tasks/create">
                            <i class="fa-solid fa-folder-plus"></i>
                            <span>Add Task</span>
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
        {{-- end Sidebar --}}
        {{-- Start Content --}}
        <div class="content w-full">
            <!-- Start Head -->
            <div class="head bg-white p-15 between-flex">
                <div class="search p-relative">
                    <form action="">
                        <input class="p-10" type="text" name="search" placeholder="Type A Keyword" />


                        <button class="search-icon" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                </div>
                <div class="icons d-flex align-center">
                    @auth
                        <img class="mr-2"
                            src="{{ auth()->user()->logo ? asset('storage/' . auth()->user()->logo) : asset('/images/no-image.png') }}"
                            alt="" />
                        <form action="/" method="post">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @else
                        <a href="/register">
                            <span class=" p-relative mr-5">
                                Register
                            </span>
                        </a>
                        <a href="/login">
                            <span class=" p-relative">
                                Login
                            </span>
                        </a>
                    @endauth
                </div>
            </div>
            <!-- End Head -->
            @yield('content')
        </div>
        {{-- End Content --}}
    </div>
    <x-flash-message />
</body>

</html>
