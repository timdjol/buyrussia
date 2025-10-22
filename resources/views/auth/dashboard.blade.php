@extends('auth.layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="admin dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-2 side">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="auth">
                                Welcome {{ \Illuminate\Support\Facades\Auth::user()->name }}<br>
                                <a href="{{ route('get-logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Log
                                    out</a>
                            </div>
                        </div>
                    </div>
                    @can('edit-contact')
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-signs-post"></i></h2>
                                    Count of posts: <b>{{ $posts->count() }}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-list"></i></h2>
                                    Count of categories: <b>{{ $categories->count() }}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-tag"></i></h2>
                                    Count of tags: <b>{{ $tags->count() }}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-comment"></i></h2>
                                    Count of comments: <b>{{ $comments->count() }}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-rectangle-ad"></i></h2>
                                    Count of ads: <b>{{ $ads->count() }}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-item">
                                    <h2><i class="fa-solid fa-file"></i></h2>
                                    Count of pages: <b>{{ $pages->count() }}</b>
                                </div>
                            </div>
                        </div>

                        <div class="row slider">
                            <div class="col-md-12">
                                <div class="row aic">
                                    <div class="col-md-10">
                                        <h3>Slider</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-wrap">
                                            <a class="btn add" href="{{ route('sliders.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>
                                @if($sliders->isNotEmpty())
                                    <div class="table-wrap">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sliders as $slider)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ Storage::url($slider->image) }}" style="height:
                                                100px"></td>
                                                    <td>
                                                        <form action="{{ route('sliders.destroy', $slider) }}"
                                                              method="post">
                                                            <ul>
                                                                <li><a class="btn edit" href="{{ route('sliders.edit', $slider)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    onclick="return confirm('Do you want to delete this?');"
                                                                    class="btn delete"><i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger">Sliders not found</div>
                                @endif
                            </div>
                        </div>

                        <div class="row vantage" style="margin-top: 40px">
                            <div class="col-md-12">
                                <div class="row aic">
                                    <div class="col-md-10">
                                        <h3>Advantages</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-wrap">
                                            <a class="btn add" href="{{ route('vantages.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>
                                @if($vantages->isNotEmpty())
                                    <div class="table-wrap">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($vantages as $vantage)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ Storage::url($vantage->image) }}" alt=""
                                                             style="width: 60px"></td>
                                                    <td>{{ $vantage->title }}</td>
                                                    <td>
                                                        <form action="{{ route('vantages.destroy', $vantage) }}"
                                                              method="post">
                                                            <ul>
                                                                <li><a class="btn edit" href="{{ route('vantages.edit',
                                                            $vantage)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    onclick="return confirm('Do you want to delete this?');"
                                                                    class="btn delete"><i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger">Advantages not found</div>
                                @endif
                            </div>
                        </div>

                        <div class="row video" style="margin-top: 40px">
                            <div class="col-md-12">
                                <div class="row aic">
                                    <div class="col-md-10">
                                        <h3>Video</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-wrap">
                                            <a class="btn add" href="{{ route('videos.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>
                                @if($videos->isNotEmpty())
                                    <div class="table-wrap">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Video</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($videos as $video)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $video->link }}</td>
                                                    <td>
                                                        <form action="{{ route('videos.destroy', $video) }}"
                                                              method="post">
                                                            <ul>
                                                                <li><a class="btn edit" href="{{ route('videos.edit',
                                                            $video)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    onclick="return confirm('Do you want to delete this?');"
                                                                    class="btn delete"><i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger">Videos not found</div>
                                @endif
                            </div>
                        </div>

                        <div class="row blog" style="margin-top: 40px">
                            <div class="col-md-12">
                                <div class="row aic">
                                    <div class="col-md-10">
                                        <h3>Bloggers</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="btn-wrap">
                                            <a class="btn add" href="{{ route('bloggers.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>
                                @if($bloggers->isNotEmpty())
                                    <div class="table-wrap">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($bloggers as $blogger)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ Storage::url($blogger->image) }}" alt=""
                                                             style="width: 60px"></td>
                                                    <td>
                                                        <form action="{{ route('bloggers.destroy', $blogger) }}"
                                                              method="post">
                                                            <ul>
                                                                <li><a class="btn edit" href="{{ route('bloggers.edit',
                                                            $blogger)
                                            }}"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    onclick="return confirm('Do you want to delete this?');"
                                                                    class="btn delete"><i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-danger">Bloggers not found</div>
                                @endif
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>

@endsection
