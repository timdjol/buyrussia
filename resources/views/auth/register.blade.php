@extends('layouts.app')

@section('content')
    <div class="page register">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12">
                    <h1>등록하다</h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'name'])
                            <label for="">당신의 이름</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        </div>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'email'])
                            <label for="">귀하의 이메일</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        </div>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'password'])
                            <label for="">비밀번호</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'password_confirmation'])
                            <label for="">비밀번호 확인</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <button class="more">등록하다</button>
                    </form>
                    <div class="already">
                        <a href="{{ route('login') }}">이미 등록하셨나요?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
