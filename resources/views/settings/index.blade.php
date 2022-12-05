@extends('home')

@section('content')
    <div class="content w-full">
        <h1 class="p-relative">Settings</h1>
        <div class="settings-page m-20 d-grid gap-20">
            <!-- Start Settings Box -->
            <div class="p-20 bx-shadow bg-white rad-10" style="max-height: 250px;" >
                <h2 class="mt-0 ">Manage Status</h2>
                <div class="">
                    <form method="POST" action="{{ route('status.store') }}">
                        @csrf
                        <label class="fs-14 c-grey d-block mb-10" for="name">Status Title</label>
                        <input class="b-none border-ccc p-10 rad-6 d-block w-full" name="name" type="text"
                            id="first" placeholder="Status" />
                        <input type="submit" style="float: right"
                            class="text-white cursor-pointer p-2 mt-1 rounded-md  bg-sky-500 hover:bg-sky-700"
                            value="Create">
                    </form>
                </div>
            </div>
            <!-- End Settings Box -->
            <!-- Start Settings Box -->
            <div class="p-20 bx-shadow bg-white rad-10" >
                <h2 class="mt-0 mb-10">Status Created</h2>
                @foreach ($statuses as $status)
                    <h2 class="text-xl mb-7">{{ $status->name }}</h2>
                    <div class="sec-box mb-5 between-flex">
                        <div>
                            <p class="text-sm c-grey mb-0 fs-13">Created at : {{ $status->created_at }}</p>
                        </div>
                        <a id="delete" class="button bg-red-500 hover:bg-red-600 c-white btn-shape"
                            href="{{ route('status.delete', $status->id) }}">Delete</a>
                    </div>
                @endforeach
            </div>
            <!-- End Settings Box -->
        </div>
    </div>
@endsection
