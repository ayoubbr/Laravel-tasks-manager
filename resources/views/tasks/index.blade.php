@extends('home')

@section('content')
    <div class="projects bx-shadow px-5 py-10 bg-white rad-10 m-5 mx-10 mb-24">
        <span class="d-flex justify-between p-3 bg-sky-600 rounded-md text-white">
            <p>Task Title</p>
            <div class="d-flex gap-1.5">
                <p class="w-24 text-center">Duration</p>
                <p class="w-24 text-center">Created By</p>
                <p class="w-36 text-center">Status</p>
                <p class="w-36 text-center">Created at</p>
                <p class="w-24 text-center mr-5">Type</p>
            </div>
        </span>
        <x-tasks :tasks="$tasks" :users="$users" :statuses="$statuses" />
    </div>
    <script>
        let btns = document.querySelectorAll('.btn');
        let lists = document.querySelectorAll('.list');
        btns.forEach(el => {
            window.addEventListener('click', (event) => {
                if (event.target !== el) {
                    el.nextElementSibling.classList.add('hidden');
                }
            });
        });

        btns.forEach(element => {
            element.addEventListener('click', (event) => {
                event.target.nextElementSibling.classList
                    .toggle('hidden');
            })
        });

        let selects = document.querySelectorAll('.select');
        console.log(selects);

        selects.forEach(element => {
            element.onchange = function(e) {
                element.nextElementSibling.click();
            }
        });
    </script>
@endsection
