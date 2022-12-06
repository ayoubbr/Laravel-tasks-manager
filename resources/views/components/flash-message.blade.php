@if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-slate-800 
        text-cyan-400 px-20 py-6 mt-1 rounded-md flash">
        <div style="display: flex;">
            {{-- <span class="mr-5">
                    <i class="fa-solid fa-check-double"></i> 
            </span> --}}
            <p>
                {{ session('message') }}
            </p>
        </div>
    </div>
@endif
