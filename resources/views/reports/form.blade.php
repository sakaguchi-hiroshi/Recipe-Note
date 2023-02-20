@extends('layouts.app')
  @section('title', '投稿レポート作成画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/reports/form.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
  <section class="main-section">
    <h2 class="main-section-headline">投稿レポート作成</h2>
    <form class="recipe-form-add" action="/reports/add" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ old('user_id', $user_id) }}">
      <input type="hidden" name="post_id" value="{{ old('post_id', $post_id) }}">
      <div class="form-group">
        <label class="form-label" for="image">料理レポート画像</label>
        <input class="form-input" type="file" name="image" placeholder="料理の画像を選択" id="image" accept="image/*" capture="camera" />
      </div>
      <div class="form-group">
        <label class="form-label" for="coment">料理のレポート</label>
        <textarea class="form-textarea" name="coment" id="coment" cols="30" rows="4">{{ old('coment')}}</textarea>
        @error('coment')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit" class="form-btn">保存</button>
    </form>
  </section>
  @endsection

  @include('layouts.footer.first')