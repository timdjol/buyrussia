@extends('auth.layouts.master')

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($role)
                        <h1>Edit role {{ $role->name }}</h1>
                    @else
                        <h1>Add role</h1>
                    @endisset
                        <form method="post" enctype="multipart/form-data"
                              @isset($role)
                                  action="{{ route('roles.update', $role) }}"
                              @else
                                  action="{{ route('roles.store') }}"
                                @endisset
                        >
                            @csrf
                            @isset($role)
                                @method('PUT')
                            @endisset
                            @include('auth.layouts.error', ['fieldname' => 'name'])
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="name" value="{{ old('name', isset($role) ? $role->name :
                                null) }}">
                            </div>

                            <div class="form-group">
                                <label for="">Permissions</label>
                                <select multiple aria-label="Permissions" id="permissions" name="permissions[]"
                                        style="height: 210px;">
                                    @forelse ($permissions as $permission)
                                        <option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>
                                            {{ $permission->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <button class="more">Send</button>
                            <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                        </form>
                </div>
            </div>
        </div>
    </div>

    
@endsection