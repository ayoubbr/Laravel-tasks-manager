<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/t.png') }}">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" />
    @yield('style')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    @php
        $prefix = Request::route()->getPrefix();
    @endphp
    <div class="page d-flex">
        {{-- Start Sidebar  --}}
        <div class="sidebar bg-white p-10  p-relative">
            <h3 class="p-relative txt-c mt-0">Tasks Manager</h3>
            <ul>
                <li>
                    <a class="d-flex justify-start align-center  c-black rad-6 py-3 pr-10 pl-5
                    {{ 'tasks' == request()->path() ? 'active' : '' }}"
                        href="/tasks">
                        <i class="fa-regular fa-chart-bar fa-fw"></i>
                        <span class="sidebarspan">Tasks</span>
                    </a>
                </li>
                @auth
                    <li>
                        <a class="d-flex justify-start align-center  c-black rad-6 py-3 pr-10 pl-5
                            {{ 'tasks/create' == request()->path() ? 'active' : '' }}"
                            href="/tasks/create">
                            <i class=" fa-solid fa-folder-plus"></i>
                            <span class="sidebarspan">Add Task</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex justify-start align-center py-3 pr-10 pl-5  c-black rad-6 
                             {{ str_contains(request()->path(), 'users') ? 'active' : '' }}"
                            href="/users/manage">
                            <i class="fa-solid fa-users-gear fa-fw"></i>

                            <span class="sidebarspan">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex justify-start align-center  c-black rad-6 py-3 pr-10 pl-5
                             {{ 'settings' == request()->path() ? 'active' : '' }}"
                            href="/settings">
                            <i class=" fa-solid fa-gear fa-fw"></i>
                            <span class="sidebarspan">Settings</span>
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
                    {{-- <form action="">
                         <input class="p-10" type="text" name="search" placeholder="Type A Keyword" /> 

                         <button class="search-icon" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button> 
                    </form>  --}}
                </div>
                <div class="icons d-flex align-center">
                    @auth
                        @if (str_contains(auth()->user()->logo, '2022'))
                            <img id="target" class="target mr-2 cursor-pointer"
                                src="{{ auth()->user()->logo ? asset('storage/logos/' . auth()->user()->logo) : asset('/images/no-image.png') }}" />
                        @endif
                        @if (!str_contains(auth()->user()->logo, '2022'))
                            <img id="target" class="target mr-2 cursor-pointer"
                                src="{{ auth()->user()->logo ? asset('storage/' . auth()->user()->logo) : asset('/images/no-image.png') }}" />
                        @endif
                        <div
                            class="list-user hidden absolute z-10 mt-2 py-1 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="text-zinc-500 px-10 py-2 ">{{ auth()->user()->name }}</div>
                            <hr>
                            {{-- <form action="{{ route('users.show', auth()->user()->id) }}" method="GET" class="px-10 py-3 ">
                                @csrf
                                <button type="submit">Profile</button>
                            </form> --}}
                            <form action="/" method="post" class="px-10 py-3 ">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    @else
                        <a class="sign-in" href="/register">
                            <span class=" p-relative mr-5">
                                Register
                            </span>
                        </a>
                        <a class="sign-in" href="/login">
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
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script>
        $(document).on('click', function(e) {
            if (e.target.id != 'target') {
                $(".list-user").hide();
            }
        });

        $("#target").click(function() {
            $(".list-user").toggle();
        });
    </script>
    @yield('javascript')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script>
</body>

</html>
