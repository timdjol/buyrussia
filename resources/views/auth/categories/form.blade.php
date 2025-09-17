@extends('auth.layouts.master')

@isset($category)
    @section('title', 'Edit category ' . $category->title)
@else
    @section('title', 'Add category')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($category)
                        <h1>Edit {{ $category->title }}</h1>
                    @else
                        <h1>Add</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($category)
                              action="{{ route('categories.update', $category) }}"
                          @else
                              action="{{ route('categories.store') }}"
                        @endisset
                    >
                        @isset($category)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'title'])
                            <label for="">Title</label>
                            <input type="text" name="title" value="{{ old('title', isset($category) ?
                                    $category->title : null) }}" required>
                        </div>
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'parent_id'])
                            <label for="parent_id">Parent category (optional)</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">— без родителя —</option>
                                @foreach($options as $opt)
                                    <option value="{{ $opt['id'] }}"
                                    @isset($category)
                                        {{ (string)old('parent_id', $category->parent_id) === (string)$opt['id'] ? 'selected' : '' }}
                                        @else
                                        {{ (string)old('parent_id') === (string)$opt['id'] ? 'selected' : '' }}
                                        @endisset
                                    >{{ $opt['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'image'])
                            <label for="">Image</label>
                            @isset($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="">
                            @endisset
                            <input type="file" name="image">
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
