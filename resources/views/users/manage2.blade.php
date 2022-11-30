<!--@extends('home')

@section('content')
        <div class="projects p-20 bg-white rad-10 m-5">
            <h2 class="mt-0 mb-5">Users</h2>
            <div class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Name</td>
                            <td>Duration</td>
                            <td>Image</td>
                            {{-- <td>Prent user</td> --}}
                            {{-- <td>Affected user</td> --}}
                            {{-- <td>Actions</td> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @unless($users->isEmpty())
        @foreach ($users as $user)
        <tr>
                                        <td> {{ $user['id'] }}
                                        </td>
                                        <td>
                                            {{ $user['name'] }}
                                        </td>

                                        {{-- <td>
                                    <a href="/users/?type={{ $user->type }}">
                                        {{ $user['type'] }}</a>

                                </td> --}}
                                        {{-- <td>
                                    <a href="/users/?status={{ $user->status }}">
                                        <span @class([
                                            'label',
                                            'btn-shape',
                                            ' c-white',
                                            'py-2',
                                            'bg-orange-500' => $user->status == 'To Validate',
                                            'bg-red-500' => $user->status == 'Open',
                                            'bg-sky-500' => $user->status == 'To Dispatch',
                                            'bg-green-500' => $user->status == 'Completed',
                                        ])>
                                            {{ $user['status'] }}
                                        </span>
                                    </a>
                                </td> --}}

                                        <td>
                                            {{-- {{ $user->duration }} --}}
                                        </td>
                                        <td>
                                            {{-- {{ $user->logo }} --}}
                                        </td>
                                        {{-- <td class="d-flex align-center">
                                    <a href="{{ route('user.details', $user->id) }}"
                                        class="bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                        View Details
                                    </a>
                                    <a href="/users/{{ $user->id }}/edit">
                                        <span
                                            class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                            Edit <i class="ml-1 fa-solid fa-pencil"></i>

                                        </span>
                                    </a>
                                    <form action="/users/{{ $user->id }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <span
                                            class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                            <button type="submit">
                                                Delete <i class=" ml-1 fa-solid fa-trash"></i>

                                            </button>
                                        </span>
                                    </form>
                                    @if ($user->type == 'Master')
                                        <a href="/users/{{ $user->id }}/user-child/create">
                                            <span
                                                class="label btn-shape bg-stone-900 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                                Create Child user <i class="ml-1 fa-solid fa-plus"></i>

                                            </span>
                                        </a>
                                    @endif

                                </td> --}}
                                    </tr>
        @endforeach
    @else
        <p class="text-zinc-900 bg-zinc-200 p-10 mb-5 rounded-md">No users found</p>
    @endunless
                    </tbody>
                </table>
            </div>

            {{-- <div class="mt-5">
            {{ $users->links() }}
        </div> --}}
        </div>
@endsection

-->
