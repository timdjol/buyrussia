@extends('layouts.app')

@section('content')

    <style>
        .google-wrap{
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 5px;
            background-color: #f5f5f5;
            display: block;
            text-align: center;
        }
        .google-wrap img{
            max-width: 30px;
            margin-left: 10px;
        }
        .google-wrap a{
            text-decoration: none;
        }
    </style>
    <div class="page register login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12">
                    <h1>로그인</h1>
                    <div class="google-wrap">
                        <a href="{{ route('google.redirect') }}" class="btn btn-google">
                            Authorized by <img src="{{ route('index') }}/img/google.svg" alt="">
                        </a>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'email'])
                            <label for="">이메일 주소</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'password'])
                            <label for="">비밀번호</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">나를 기억해</label>
                        </div>
                        <button class="more">로그인</button>

                        <div class="already">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    비밀번호를 잊으셨나요?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
