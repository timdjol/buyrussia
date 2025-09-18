@extends('auth.layouts.master')

@isset($tag)
    @section('title', 'Edit tag ' . $tag->title)
@else
    @section('title', 'Add tag')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($tag)
                        <h1>Edit {{ $tag->title }}</h1>
                    @else
                        <h1>Add</h1>
                    @endisset
                    <form method="post"
                          @isset($tag)
                              action="{{ route('taglists.update', $tag) }}"
                          @else
                              action="{{ route('taglists.store') }}"
                            @endisset
                    >
                        @isset($tag)
                            @method('PUT')
                        @endisset
                            @include('auth.layouts.error', ['fieldname' => 'title'])
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{ old('title', isset($tag) ?
                                    $tag->title : null) }}" required>
                            </div>
                        @csrf
                        <button class="more">Send</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
