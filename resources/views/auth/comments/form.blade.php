@extends('auth.layouts.master')

@isset($comment)
    @section('title', 'Edit comment')
@else
    @section('title', 'Add comment')
@endisset

@section('content')

    <div class="comment admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($comment)
                        <h1>Edit comment</h1>
                    @else
                        <h1>Add comment</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post" action="{{ route('comments.update', $comment) }}">
                        @isset($comment)
                            @method('PUT')
                        @endisset
                            @include('auth.layouts.error', ['fieldname' => 'description'])
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="editor" rows="3">{{ old('description', isset($comment) ?
                            $comment->description : null) }}</textarea>
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
