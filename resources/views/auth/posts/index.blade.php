@extends('auth.layouts.master')

@section('title', 'Posts')

@section('content')

    <div class="admin posts">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="row aic">
                        <div class="col-md-6">
                            <h1>Posts</h1>
                            <p>Count of posts: {{ $count->count() }}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('posts.create') }}"><i class="fa-solid
                                fa-plus"></i> Add post/journal</a>
                            </div>
                        </div>
                    </div>

                    @if($posts->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
{{--                                <th>Tag</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @isset($post->image)
                                            <img src="{{ Storage::url($post->image) }}" alt="" width="80px">
                                        @else
                                            <img src="data:image/svg+xml;utf8,
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 160 80'>
                        <rect width='160' height='80' fill='%23f2f2f2'/>
                        <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='12'>no image</text>
                    </svg>">
                                        @endisset
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        @php
                                            $cats = explode(', ', $post->category_id)
                                        @endphp
                                        @foreach($cats as $cat)
                                            @php
                                                $category = \App\Models\Category::where('id', $cat)->first();
                                            @endphp
                                            <div class="alert alert-primary">{{ $category->title ?? '' }}</div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('posts.destroy', $post) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('posts.edit', $post)
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
                        {{ $posts->links('pagination::bootstrap-4') }}
                    @else
                        <div class="alert alert-danger">Posts not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
