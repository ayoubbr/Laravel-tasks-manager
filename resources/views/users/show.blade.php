@extends('home')
@section('content')
    <h1 class="p-relative text-xl">Profile</h1>
    <div class="profile-page m-5">
        <!-- Start Overview -->
        <div class="overview bg-white rad-10 d-flex align-center bx-shadow">
            <div class="avatar-box txt-c p-20 ">
                <img class="rad-half mb-10"
                    src="{{ $user->logo ? asset('storage/' . $user->logo) : asset('/images/no-image.png') }}"
                    alt="user photo" />
                <h3 class="m-0 font-bold">{{ $user->name }}</h3>
                {{-- <p class="c-grey mt-10">Level 20</p>
                <div class="level rad-6 bg-eee p-relative">
                    <span style="width: 70%"></span>
                </div>
                <div class="rating mt-10 mb-10">
                    <i class="fa-solid fa-star c-orange fs-13"></i>
                    <i class="fa-solid fa-star c-orange fs-13"></i>
                    <i class="fa-solid fa-star c-orange fs-13"></i>
                    <i class="fa-solid fa-star c-orange fs-13"></i>
                    <i class="fa-solid fa-star c-orange fs-13"></i>
                </div>
                <p class="c-grey m-0 fs-13">550 Rating</p> --}}
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
                    {{-- <div class="fs-14">
                        <label>
                            <input class="toggle-checkbox" type="checkbox" checked />
                            <div class="toggle-switch"></div>
                        </label>
                    </div>   --}}
                </div>
                <!-- End Information Row -->
                <!-- Start Information Row -->
                {{-- <div class="box p-20 d-flex align-center">
                    <h4 class="c-grey w-full fs-15 m-0">Personal Information</h4>
                    <div class="fs-14">
                        <span class="c-grey">Email:</span>
                        <span>o@nn.sa</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Phone:</span>
                        <span>019123456789</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Date Of Birth:</span>
                        <span>25/10/1982</span>
                    </div>
                    <div class="fs-14">
                        <label>
                            <input class="toggle-checkbox" type="checkbox" />
                            <div class="toggle-switch"></div>
                        </label>
                    </div>
                </div>
                <!-- End Information Row -->
                <!-- Start Information Row -->
                <div class="box p-20 d-flex align-center">
                    <h4 class="c-grey w-full fs-15 m-0">Job Information</h4>
                    <div class="fs-14">
                        <span class="c-grey">Title:</span>
                        <span>Full Stack Developer</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Programming Language:</span>
                        <span>Python</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Years Of Experience:</span>
                        <span>15+</span>
                    </div>
                    <div class="fs-14">
                        <label>
                            <input class="toggle-checkbox" type="checkbox" checked />
                            <div class="toggle-switch"></div>
                        </label>
                    </div>
                </div>
                <!-- End Information Row -->
                <!-- Start Information Row -->
                <div class="box p-20 d-flex align-center">
                    <h4 class="c-grey w-full fs-15 m-0">Billing Information</h4>
                    <div class="fs-14">
                        <span class="c-grey">Payment Method:</span>
                        <span>Paypal</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Email:</span>
                        <span>email@website.com</span>
                    </div>
                    <div class="fs-14">
                        <span class="c-grey">Subscription:</span>
                        <span>Monthly</span>
                    </div>
                    <div class="fs-14">
                        <label>
                            <input class="toggle-checkbox" type="checkbox" />
                            <div class="toggle-switch"></div>
                        </label>
                    </div>
                </div> --}}
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
                    {{-- <input class="b-none border-ccc p-10 rad-6 d-block w-full" style="height: 40px;" name="month"
                        type="text" placeholder="month" />
                    <input class="b-none border-ccc p-10 rad-6 d-block w-full" style="height: 40px;" name="year"
                        type="text" placeholder="year" /> --}}
                    <input type="submit" style="float: right; height:40px"
                        class="text-white cursor-pointer p-2 mt-1 rounded-md  bg-stone-500 hover:bg-sky-700" value="Search">

                    <a href="{{ route('users.show', $user->id) }}"
                        class="text-white cursor-pointer p-2 mt-1 rounded-md bg-stone-500 hover:bg-sky-700">All Tasks</a>
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
        <!-- Start Other Data -->
        {{-- <div class="other-data d-flex gap-20">
            <div class="activities p-20 bg-white rad-10 mt-20">
                <h2 class="mt-0 mb-2">Latest Activities</h2>
                <p class="mt-0 mb-10 c-grey fs-15">Latest Activities Done By The User</p>
                <div class="activity d-flex align-center txt-c-mobile">
                    <div class="info">
                        <span class="d-block mb-5">Store</span>
                        <span class="c-grey">Bought The Mastering Python Course</span>
                    </div>
                    <div class="date">
                        <span class="d-block mb-5">18:10</span>
                        <span class="c-grey">Yesterday</span>
                    </div>
                </div>

            </div>
        </div> --}}
        <!-- End Other Data -->
    </div>
@endsection
