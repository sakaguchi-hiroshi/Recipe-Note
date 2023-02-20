@extends('layouts.app')
  @section('title', 'Recipe Note 会員登録画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/register.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
    <div class="main-section">
      @if (session('result'))
        <div class="flash-message">
          {{ session('result') }}
        </div>
      @endif
      <h2 class="main-headline">会員登録</h2>
      <form class="auth-form" action="/register" method="post">
        @csrf
        <div class="auth-form-container">
          <input type="text" placeholder="名前" name="name" value="{{ old('name') }}">
          @error('name')
            <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="auth-form-container">
          <input type="email" placeholder="メールアドレス" name="email" value="{{ old('email') }}">
          @error('email')
            <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="auth-form-container">
          <input type="password" placeholder="パスワード" name="password">
          @error('password')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
        <div class="auth-form-container">
          <input type="password" placeholder="確認用パスワード" name="password_confirmation">
          @error('password_confirmation')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
        <button class="auth-form-btn" type="submit">会員登録</button>
      </form>
      <div class="transition-container">
        <p class="transition-txt">アカウントをお持ちの方はこちらから</p>
        <a class="transition-link" href="/login">ログイン</a>
      </div>
    </div>
  @endsection

  @include('layouts.footer.first')