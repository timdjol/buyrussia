@extends('layouts.app')

@section('title', 'Search')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        a.btn {
            font-size: 14px;
            padding: 8px 10px;
            border-radius: 5px;
            background-color: #24C3B1;
            text-decoration: none;
            color: #fff;
            border: none;
        }
        a {
            color: #24C3B1;
            text-decoration: none;
        }
        table{
            width: 100%;
        }
        table td{
            border-top: 1px solid #ddd;
        }

    </style>

    <div class="page search community">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <h1>Search</h1>
                    @if($search->isNotEmpty())
                        <div class="table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    <th>번호
                                    </th>
                                    <th>제목</th>
                                    <th>작성자
                                    </th>
                                    <th>작성일
                                    </th>
                                    <th>행동</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($search as $ad)
                                    <tr>
                                        <td>{{ $ad->id }}</td>
                                        <td>
                                            <h5><a href="{{ route('ad', $ad->id) }}">{{ $ad->title }}</a></h5>
                                            <p>{{Illuminate\Support\Str::limit(strip_tags
                                        ($ad->description), 40)}}</p>
                                        </td>
                                        <td style="font-size: 14px">{!! Avatar::create($ad->user->name)->setDimension(35,
                                     35)->setFontSize
                                    (15)
                                    ->toSvg() !!} {{ $ad->user->name }}</td>
                                        <td>
                                            <div class="date">{{ $ad->created_at->format('d M Y') }}</div>
                                        </td>
                                        <td><a href="{{ route('ad', $ad->id) }}" class="btn view"><i class="fa-regular fa-eye"></i></a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger">Ads not found</div>
                    @endif
                </div>
                <div class="col-lg-2">
                    <div class="ban">
                        <a href=""><img src="{{ route('index') }}/img/adv.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection