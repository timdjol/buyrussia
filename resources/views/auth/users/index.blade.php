@extends('auth.layouts.master')
@section('title', __('admin.users'))

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row aic">
                        <div class="col-md-10">
                            <h1>Users</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('users.create') }}"><i class="fa-solid fa-plus"></i>
                                    Add</a>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! Avatar::create($user->name)->setDimension(35, 35)->setFontSize(15)->toSvg() !!} {{ $user->name }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                    @endforelse
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user) }}" method="post">
                                        <ul>
                                            <li><a class="btn edit" href="{{ route('users.edit', $user)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn delete"><i class="fa-solid fa-trash"></i></button>
                                        </ul>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
