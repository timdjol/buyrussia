@extends('auth.layouts.master')

@section('title', 'Permissions')

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
                            <h1>Permissisons</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('permissions.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>
                    @if($permissions->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('permissions.edit', $permission)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Do you want to delete this?');"
                                                        class="btn delete"><i class="fa-solid fa-trash"></i></button>
                                            </ul>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $permissions->links('pagination::bootstrap-4') }}
                    @else
                        <h2 style="text-align: center">Not found</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
