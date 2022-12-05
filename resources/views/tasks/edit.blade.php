 @extends('home')

 @section('content')
     <div class="card bx-shadow rounded-md">
         <div>
             <header class="text-center rounded-t-md d-flex align-center justify-center p-20 bg-orange-500">
                 <h2 class="text-2xl">Edit Task {{ $task->title }}</h2>
             </header>
             <div class="px-12  py-8">
                 <form method="POST" action="/tasks/{{ $task->id }}" enctype="multipart/form-data" class="create-form">
                     @csrf
                     @method('PUT')
                     <div class="grid grid grid-cols-2 gap-4">
                         <div>
                             <label for="title" class="inline-block text-lg mb-1">Title</label>
                             <input type="text" class="border border-gray-200 rounded p-2 w-full" placeholder="Title"
                                 name="title" value="{{ $task->title }}" />

                             @error('title')
                                 <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                             @enderror
                         </div>
                         <div>
                             <label for="status" class="inline-block text-lg mb-1">Status</label>
                             <select name="status"
                                 class="cursor-pointer select-status border border-gray-200 rounded p-2 w-full">
                                 <option value=""disabled selected>Select Status</option>
                                 @foreach ($statuses as $status)
                                     <option value="{{ $status->name }}"
                                         {{ $task->status == $status->name ? 'selected' : '' }}>
                                         {{ $status->name }}</option>
                                 @endforeach
                                 @foreach ($users as $user)
                                     <option class="useroption" value="{{ $user->name }}"
                                         {{ $task->userAffectedTo == $user->name ? 'selected' : '' }}>{{ $user->name }}
                                     </option>
                                 @endforeach
                             </select>
                             @error('status')
                                 <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                             @enderror
                         </div>
                     </div>
                     <div class="grid grid-cols-1">
                         <div>
                             <label for="description" class="inline-block text-lg mb-1">Description</label>
                             <textarea class="comment-text border border-gray-500 rounded p-2 w-full" value="" name="description"
                                 id="description" rows="4">{{ $task->description }}</textarea>
                             @error('description')
                                 <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                             @enderror
                         </div>
                     </div>
                     <div class="grid grid grid-cols-1 gap-4">
                         <div>
                             <label for="uploads" class="inline-block text-lg mb-1">
                                 Uploads
                             </label>
                             <input type="file"
                                 class="cursor-pointer border border-gray-500 rounded p-1
                         block w-full text-sm text-slate-500 
                         file:mr-7 file:cursor-pointer file:px-5 file:py-2 file:rounded-full 
                         file:border-0 file:text-sm file:font-semibold  
                         file:bg-orange-500 file:text-white-700 hover:file:bg-orange-600 w-full"
                                 name="uploads[]" multiple />
                             @error('uploads')
                                 <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                             @enderror
                         </div>
                     </div>
                     <div class="grid grid grid-cols-1 mt-4">
                         <div>
                             <button
                                 class="bg-orange-600 text-white rounded py-2 px-4 
                         hover:bg-orange-700">
                                 Update Task
                             </button>

                             <a href="/tasks"class="border text-black ml-4 py-2 px-4 rounded-md hover:bg-orange-600 hover:text-white">
                                 Go Back
                                 <i class="fa-regular fa-circle-right"></i>
                             </a>
                         </div>
                 </form>
             </div>
         </div>
     </div>
     <script>
         let user = document.querySelector(".user");
         let selectSts = document.querySelector(".select-status");
         let options = document.querySelectorAll(".useroption");

         if (selectSts.parentElement) {
             selectSts.parentElement.addEventListener('change', (event) => {
                 if (event.target.value == 'To Dispatch') {
                     user.classList.remove('hidden');
                     options.forEach(element => {
                         element.setAttribute('value', element.innerHTML);
                     });
                 } else {
                     user.classList.add('hidden');
                     options.forEach(element => {
                         element.setAttribute('value', '');
                     });
                 }
             });

             if (selectSts.value !== 'To Dispatch') {
                 user.classList.add('hidden');
                 options.forEach(element => {
                     element.setAttribute('value', '');
                 });
             }

         }
     </script>
 @endsection
