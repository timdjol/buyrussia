@extends('auth.layouts.master')

@isset($contact)
    @section('title', 'Edit contact')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <h1>Edit contact</h1>
                    <form method="post" action="{{ route('contacts.update', $contact) }}" enctype="multipart/form-data">
                        @isset($contact)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-6">
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Phone number</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', isset($contact) ?
                            $contact->phone : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ old('email', isset($contact) ?
                            $contact->email : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" value="{{ old('address', isset($contact) ?
                                $contact->address : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('facebook')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Facebook</label>
                                    <input type="text" name="facebook" value="{{ old('whatsapp', isset($contact) ?
                                $contact->facebook : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('twitter')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Twitter</label>
                                    <input type="text" name="twitter" value="{{ old('twitter', isset($contact) ?
                                $contact->twitter : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('talk')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Talk</label>
                                    <input type="text" name="talk" value="{{ old('talk', isset($contact) ?
                                $contact->talk : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('blogger')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Blogger</label>
                                    <input type="text" name="blogger" value="{{ old('blogger', isset($contact) ?
                                $contact->blogger : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @error('youtube')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="">Youtube</label>
                                    <input type="text" name="youtube" value="{{ old('youtube', isset($contact) ?
                                $contact->youtube : null) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @include('auth.layouts.error', ['fieldname' => 'description'])
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="editor" rows="3">{{ old('description', isset($contact) ?
                            $contact->description : null) }}</textarea>
                                </div>
                                <script src="https://cdn.tiny.cloud/1/yxonqgmruy7kchzsv4uizqanbapq2uta96cs0p4y91ov9iod/tinymce/6/tinymce.min.js"
                                        referrerpolicy="origin"></script>
                                <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
                                <script>
                                    ClassicEditor
                                        .create(document.querySelector('#editor'))
                                        .catch(error => {
                                            console.error(error);
                                        });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Banner #1</label>
                                    @isset($contact->ban)
                                        <img src="{{ Storage::url($contact->ban) }}" alt="" width="100">
                                    @endisset
                                    <input type="file" name="ban">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Link to Banner #1</label>
                                    <input type="text" name="link_ban" value="{{ old('link_ban', isset($contact) ?
                            $contact->link_ban : null) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Banner #2</label>
                                    @isset($contact->ban2)
                                        <img src="{{ Storage::url($contact->ban2) }}" alt="" width="100">
                                    @endisset
                                    <input type="file" name="ban2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Link to Banner #2</label>
                                    <input type="text" name="link_ban2" value="{{ old('link_ban2', isset($contact) ?
                            $contact->link_ban2 : null) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Banner #3</label>
                                    @isset($contact->ban3)
                                        <img src="{{ Storage::url($contact->ban3) }}" alt="" width="100">
                                    @endisset
                                    <input type="file" name="ban3">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Link to Banner #3</label>
                                    <input type="text" name="link_ban3" value="{{ old('link_ban3', isset($contact) ?
                            $contact->link_ban3 : null) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Banner #4</label>
                                    @isset($contact->ban4)
                                        <img src="{{ Storage::url($contact->ban4) }}" alt="" width="100">
                                    @endisset
                                    <input type="file" name="ban4">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Link to Banner #4</label>
                                    <input type="text" name="link_ban4" value="{{ old('link_ban4', isset($contact) ?
                            $contact->link_ban4 : null) }}">
                                </div>
                            </div>
                        </div>
                        @csrf
                        <button class="more">Save</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
