@extends('auth.layouts.master')

@section('title', 'Pages')

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
                            <h1>Pages</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('pages.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>

                    @if($pages->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        <form action="{{ route('pages.destroy', $page) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('pages.edit', $page)
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
                        {{ $pages->links('pagination::bootstrap-4') }}
                    @else
                        <div class="alert alert-danger">Pages not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
