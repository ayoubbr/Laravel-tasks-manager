 @extends('home')

 @section('content')
     <div class="card">
         <div>
             <header class="text-center d-flex align-center justify-center p-7 bg-orange-500">
                 <h2 class="text-2xl">Edit Task {{ $task->title }}</h2>
             </header>
             <form method="POST" action="/tasks/{{ $task->id }}" enctype="multipart/form-data" class="p-7 create-form">
                 @csrf
                 @method('PUT')
                 <div class="grid grid grid-cols-3 gap-4">
                     <div>
                         <label for="title" class="inline-block text-lg mb-2">Title</label>
                         <input type="text" class="border border-gray-200 rounded p-2 w-full"  placeholder="Title" name="title"
                             value="{{ $task->title }}" />

                         @error('title')
                             <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                         @enderror
                     </div>
                     <div>
                         <label for="type" class="inline-block text-lg mb-2">Type</label>
                         <select id="type" name="type" value="{{ $task->type }}"
                             class="cursor-pointer border border-gray-200 rounded p-2 w-full">
                             <option value="">Select Type</option>
                             <option value="Master" {{ $task->type == 'Master' ? 'selected' : '' }}>Master</option>
                             <option value="Normal" {{ $task->type == 'Normal' ? 'selected' : '' }}>Normal</option>
                         </select>

                         @error('type')
                             <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                         @enderror
                     </div>
                     <div>
                         <label for="status" class="inline-block text-lg mb-2">Status</label>
                         <select name="status" class="cursor-pointer select-type border border-gray-200 rounded p-2 w-full">
                             <option value="">Select Status</option>
                             <option value="Open" {{ $task->status == 'Open' ? 'selected' : '' }}>Open</option>
                             <option value="To Dispatch" {{ $task->status == 'To Dispatch' ? 'selected' : '' }}>To Dispatch
                             </option>
                             <option value="To Validate" {{ $task->status == 'To Validate' ? 'selected' : '' }}>To Validate
                             </option>
                             <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed
                             </option>
                         </select>
                         @error('status')
                             <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                         @enderror
                     </div>
                 </div>
                 <div class="grid grid grid-cols-3 gap-4">
                     <div class="mb-6 user">
                         <label for="userAffectedTo" class="inline-block text-lg mb-2">
                             User
                         </label>
                         <select id="userAffectedTo" name="userAffectedTo"
                             class="cursor-pointer border border-gray-200 rounded p-2 w-full">
                             <option value="">Select User</option>
                             @foreach ($users as $user)
                                 <option class="option" value="{{ $user->name }}"
                                     {{ $task->userAffectedTo == $user->name ? 'selected' : '' }}>
                                     {{ $user->name }} </option>
                             @endforeach

                         </select>
                         @error('userAffectedTo')
                             <p class="text-red-500 text-xs mt-1">
                                 {{ $message }}</p>
                         @enderror
                     </div>

                     <div class="col-span-2">
                         <label for="images" class="inline-block text-lg mb-2">
                             Upload Images
                         </label>
                         <input type="file"
                         class="cursor-pointer border border-gray-500 rounded p-1
                         block w-full text-sm text-slate-500 
                         file:mr-7 file:cursor-pointer file:px-5 file:py-2 file:rounded-full 
                         file:border-0 file:text-sm file:font-semibold  
                         file:bg-orange-500 file:text-white-700 hover:file:bg-orange-600 w-full"
                          name="images[]" accept="image/*" multiple />
                         @error('images')
                             <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                         @enderror
                     </div>
                 </div>
                 <div class="grid grid grid-cols-1">
                     <div >
                         <button
                             class="bg-stone-900 text-white rounded py-2 px-4 
                         hover:bg-slate-500">
                             Update Task
                         </button>

                         <a href="/tasks/manage"class="text-black ml-4 py-2 px-4 rounded-md hover:bg-slate-500">
                             Go Back
                             <i class="fa-regular fa-circle-right"></i>
                         </a>
                     </div>
             </form>
         </div>
     </div>
     <script>
         let user = document.querySelector(".user");
         let selectType = document.querySelector(".select-type");
         let option = document.querySelector(".option");
         selectType.parentElement.addEventListener('change', (event) => {
             console.log(option);
             if (event.target.value == 'To Dispatch') {
                 user.classList.remove('hidden');
                 option.classList.remove('hidden');
             } else {
                 user.classList.add('hidden');
                 option.classList.add('hidden');
                 option.setAttribute('value', '');
             }
         });
     </script>
 @endsection
