@extends('home')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="projects p-20  rad-10 m-5">
        <h2 class="mt-0 mb-5">Users</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        {{-- <div class="panel-heading">users</div> --}}
                        <div class="panel-body">
                            <table class="table table-striped users-table" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="60px">Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Tasks Created</th>
                                        <th>Tasks Affected</th>
                                        <th width="60px">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>


                                            <td>
                                                <a href="{{ route('users.show', $user->id) }}">
                                                    <img src="{{ $user->logo ? asset('storage/' . auth()->user()->logo) : asset('/images/no-image.png') }}"
                                                        alt="user photo">
                                                </a>

                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ count($user['tasks']) }}</td>
                                            <td>
                                                {{-- {{  count($tasks)}} --}}
                                                @foreach ($tasks as $task)
                                                    @if ($user->name == $task->userAffectedTo)
                                                        Task : {{ $task->id }} -
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $user->duration }}</td>
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
