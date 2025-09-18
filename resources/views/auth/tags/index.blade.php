@extends('auth.layouts.master')

@section('title', 'Tags')

@section('content')

    <div class="admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row aic">
                        <div class="col-md-10">
                            <h1>Tags</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('taglists.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>

                    @if($tags->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tag->title }}</td>
                                    <td><div class="alert alert-warning">
                                            {{ $tag->type }}
                                        </div></td>
                                    <td>
                                        <form action="{{ route('taglists.destroy', $tag) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('taglists.edit', $tag)
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
                        {{ $tags->links('pagination::bootstrap-4') }}
                    @else
                        <div class="alert alert-danger">Tags not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
