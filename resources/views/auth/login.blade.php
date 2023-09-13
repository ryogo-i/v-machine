@extends('layouts.app')
@section('title', 'ユーザーログイン画面')
@section('content')
<div class="container">
    <div class="border">
        <p>ユーザーログイン画面</p>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
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
                    <a class="register-btn" href="{{ route('register') }}">新規登録</a>
                    <button type="submit" class="login-btn">{{ __('ログイン') }}</button>                            
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
