@extends('home')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="projects p-20  rad-10 m-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default bg-white p-8">
                        <div class="panel-body">
                            <table class="table table-striped users-table" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="50px">Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Tasks Created</th>
                                        <th width="60px">Duration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('users.show', $user->id) }}">
                                                    @if (str_contains($user->logo, '2022'))
                                                        <img src="{{ $user->logo ? asset('storage/logos/' . $user->logo) : asset('/images/no-image.png') }}"
                                                            alt="user photo">
                                                    @endif
                                                    @if (!str_contains($user->logo, '2022'))
                                                        <img src="{{ $user->logo ? asset('storage/' . $user->logo) : asset('/images/no-image.png') }}"
                                                            alt="user photo">
                                                    @endif
                                                </a>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->tasks->count() }}</td>
                                            <td>{{ $user->duration }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" style="height: 40px"
                                                    class="text-white bg-sky-500 hover:bg-sky-700 px-4 d-flex align-center rounded-md">Edit</a>
                                                <a href="{{ route('users.delete', $user->id) }}" style="height: 40px"
                                                    class="text-white bg-red-500 hover:bg-red-700 px-4 d-flex align-center rounded-md" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('javascript')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
@endsection
