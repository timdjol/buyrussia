@extends('auth.layouts.master')

@section('title', 'Ads')

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
                            <h1>Ads</h1>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-wrap">
                                <a class="btn add" href="{{ route('ads.create') }}"><i class="fa-solid
                                fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>

                    @if($ads->isNotEmpty())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $ad)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! Avatar::create($ad->user->name)->setDimension(35, 35)->setFontSize(15)
                                    ->toSvg
                                    () !!} {{ $ad->user->name }}</td>
                                    <td>{{ $ad->title }}</td>
                                    <td>
                                        <form action="{{ route('ads.destroy', $ad) }}" method="post">
                                            <ul>
                                                <li><a class="btn edit" href="{{ route('ads.edit', $ad)
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
                        {{ $ads->links('pagination::bootstrap-4') }}
                    @else
                        <div class="alert alert-danger">Ads not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
