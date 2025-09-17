@extends('auth.layouts.master')

@section('content')
    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <h1>Information about role {{ $role->name }}</h1>
                    <table class="table">
                        <tr>
                            <th>Title</th>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <th>Permissions</th>
                            <td>
                                @if ($role->name=='Super Admin')
                                    <span class="badge bg-primary">All</span>
                                @else
                                    @forelse ($rolePermissions as $permission)
                                        <span class="badge bg-primary">{{ $permission->name }}</span>
                                    @empty
                                    @endforelse
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .badge{
        background-color: #0163b4;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        display: inline-block;
        margin: 2px;
    }
</style>