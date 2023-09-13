@extends('layouts.app')
@section('title', 'ユーザー新規登録画面')
@section('content')
<div class="container">
    <div class="border">
        <p>ユーザー新規登録画面</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form">
                    <input id="password" type="password" placeholder="パスワード" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
                <div class="form">
                    <input id="email" type="email" placeholder="アドレス" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>                             

                <div class="form-btn">
                    <button type="submit" class="register-btn">新規登録</button>
                    <a class="back-btn" href="{{ route('login') }}">戻る</a>                  
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
