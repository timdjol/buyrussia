@extends('layouts.app')

@section('title', '404')

@section('content')

<div class="page page-not">
    <div class="container">
        <div class="col-md-12">
            <div class="text-wrap">
                <h1>Error 404</h1>
                <div class="alert alert-danger">죄송합니다. 해당 페이지가 존재하지 않습니다!</div>
                <div class="btn-wrap">
                    <a href="{{ route('index') }}" class="more">메인페이지로 돌아갑니다!</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page{
        padding: 150px 0;
    }
    .page-not .text-wrap{
        text-align: center;
    }
    .page-not .alert{
        margin: 20px 0 40px
    }
</style>

@endsection