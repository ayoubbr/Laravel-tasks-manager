@extends('home')
@section('content')
    <h1 class="p-relative text-xl">Profile</h1>
    <div class="profile-page m-5">
        <!-- Start Overview -->
        <div class="overview bg-white rad-10 d-flex align-center bx-shadow">
            <div class="avatar-box txt-c p-20 ">
                <img class="rad-half mb-10"
                    src="{{ $user->logo ? asset('storage/logos/' . $user->logo) : asset('/images/no-image.png') }}"
                    alt="user photo" />
                <h3 class="m-0 font-bold">{{ $user->name }}</h3>
            </div>
            <div class="info-box w-full txt-c-mobile">
                <!-- Start Information Row -->
                <div class="box p-20 d-flex align-center">
                    <h4 class="c-grey fs-15 m-0 w-full">General Information</h4>
                    <div class="fs-14">
                        <span class="c-grey">Full Name</span>
                        <span class="font-bold">{{ $user->name }}</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Email:</span>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Duration:</span>
                        <span>{{ $user->duration }}</span>
                    </div>
                </div>
                <!-- End Information Row -->
            </div>
        </div>
        <!-- End Overview -->
        <div class="activities p-20 bg-white rad-10 mt-5 bx-shadow">
            <form method="GET" action="{{ route('user.tasks.filter', $user->id) }}">
                @csrf
                <div class="row d-flex gap-10 align-center justify-center">
                    <input class="b-none border-ccc p-10 rad-6 d-block w-full" style="height: 40px;" name="day"
                        type="date" placeholder="day" value="{{ $day }}" />
                    <input class="b-none border-ccc p-10 rad-6 d-block w-full" style="height: 40px;" name="month"
                        type="month" placeholder="month" value="{{ $month }}" />
                    <select name="year" class="b-none border-ccc p-1 rad-6 d-block w-full" style="height: 40px;">
                        |<option value="" selected disabled> Select a year</option>
                        @for ($i = 2020; $i < 2031; $i++)
                            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                    <div class="d-flex gap-1">
                        <input type="submit" style="float: right; height:40px"
                            class="text-white cursor-pointer py-2 px-4 rounded-md  bg-sky-500 hover:bg-sky-700"
                            value="Search">
                        <a href="{{ route('users.show', $user->id) }}"
                            class="d-flex justify-center align-center gap-2 text-white cursor-pointer p-2  rounded-md bg-red-500 hover:bg-red-700">
                            <i class="fa-solid fa-rotate-right"></i>
                            Refresh</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- Start Other Data -->
        <div class="other-data d-flex gap-20 ">
            <div class="activities p-20 bg-white rad-10 mt-2 bx-shadow">
                <h2 class="mt-0 mb-2">Latest Activities</h2>
                <p class="mt-0 mb-10 c-grey fs-15">Latest Activities Done By <span class="font-bold">
                        {{ $user->name }}</span></p>
                @if (count($tasks) == 0)
                    <p class="text-yellow-600">No Tasks found with that date!</p>
                @endif
                @foreach ($tasks as $task)
                    <div class="activity d-flex align-center txt-c-mobile">
                        <div class="info">
                            <span class="d-block mb-5">{{ $task->title }}</span>
                            <span class="c-grey">{{ $task->description }}</span>
                        </div>
                        <div class="date">
                            <span class="d-block mb-5"><span class="text-gray-400"> updated at :
                                </span>{{ $task->updated_at->format('h:i') }}</span>
                            <span class="c-grey">{{ $task->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- End Other Data -->
    </div>
@endsection
