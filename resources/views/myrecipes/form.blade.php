@extends('layouts.app')
  @section('title', 'Myrecipe Form')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/myrecipes/form.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
  <section class="main-section">
    <h2 class="main-section-headline">マイレシピ作成</h2>
    <form class="recipe-form-add" action="/myrecipes/add" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user_id }}">
      <div class="form-group">
        <label class="form-label" for="title">料理のタイトル</label>
        <input class="form-input" type="text" name="title" placeholder="例）海老グラタン" id="title">
        @error('title')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="image">料理画像</label>
        <input class="form-input" type="file" name="image" placeholder="料理の画像を選択" id="image" accept="image/*" capture="camera" />
      </div>
      <div class="form-group">
        <label class="form-label" for="movie">料理動画</label>
        <input class="form-input" type="file" name="movie" placeholder="料理の動画を選択" id="movie" accept="video/*">
      </div>
      <div class="form-group">
        <label class="form-label" for="url">参考記事のURL</label>
        <input class="form-input" type="url" name="url" placeholder="urlを入力" id="url">
        @error('url')
        <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="recipe">料理の作り方</label>
        <textarea class="form-textarea" name="recipe" id="recipe" cols="100" rows="20"></textarea>
        @error('recipe')
        <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit" class="form-btn">保存</button>
    </form>
  </section>
  @endsection

  @include('layouts.footer.first')