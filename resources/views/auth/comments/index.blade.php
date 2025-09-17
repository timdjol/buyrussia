@extends('auth.layouts.master')

@section('title', 'Comments')

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
                            <h1>Comments</h1>
                        </div>
                    </div>

                    @if($comments->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Post</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}
                                    <td>{!! Avatar::create($comment->user->name)->setDimension(35, 35)->setFontSize(15)
                                    ->toSvg()
                                    !!} {{ $comment->user->name }}</td>
                                    <td>{{ $comment->description }}</td>
                                    <td>{{ $comment->post->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('comments.edit', $comment)
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
                        {{ $comments->links('pagination::bootstrap-4') }}
                    @else
                        <div class="alert alert-danger">Comments not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
