@extends('layouts.app')
  @section('title', 'Recipe Note ログイン画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/login.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
    <div class="main-section">
      @if(session('result'))
        <div class="flash-message">
        {{ session('result') }}
        </div>
      @endif
      <h2 class="main-headline">ログイン</h2>
      <form class="auth-form" action="/login" method="post">
        @csrf
        <div class="auth-form-container">
          <input type="email" placeholder="メールアドレス" name="email" value="{{ old('email') }}">
          @error('email')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
        <div class="auth-form-container">
          <input type="password" placeholder="パスワード" name="password">
          @error('password')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
        <button class="auth-form-btn" type="submit">ログイン</button>
      </form>
      <div class="transition-container">
        <p class="transition-txt">アカウントをお持ちでない方はこちらから</p>
        <a class="transition-link" href="/register">会員登録</a>
      </div>
    </div>
  @endsection

  @include('layouts.footer.first')