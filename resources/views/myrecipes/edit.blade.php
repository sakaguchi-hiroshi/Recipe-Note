@extends('layouts.app')
  @section('title', 'Myrecipe編集画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/myrecipes/edit.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
  <section class="main-section">
    <h2 class="main-section-headline">Myrecipe編集</h2>
    <form class="recipe-form-update" action="/myrecipes/update" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="recipe_id" value="{{ $myrecipe->id }}">
      @if(isset($myrecipe->image))
        <input type="hidden" name="old_image_path" value="{{$myrecipe->image->path}}">
        <input type="hidden" name="old_image_id" value="{{$myrecipe->image->id}}">
      @endif
      @if(isset($myrecipe->movie))
        <input type="hidden" name="old_movie_path" value="{{$myrecipe->movie->path}}">
        <input type="hidden" name="old_movie_id" value="{{$myrecipe->movie->id}}">
      @endif
      <div class="form-group">
        <label class="form-label" for="title">料理のタイトル</label>
        <input class="form-input" type="text" name="title" value="{{ old('title', $myrecipe->title)}}" id="title">
        @error('title')
        <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="image">料理の画像</label>
        <input class="form-input" type="file" name="image" id="image" accept="image/*" capture="camera" />
      </div>
      <div class="form-group">
        <label class="form-label" for="movie">料理動画</label>
        <input class="form-input" type="file" name="movie" id="movie" accept="video/*">
      </div>
      <div class="form-group">
        <label class="form-label" for="url">参考記事のURL</label>
        <input class="form-input" type="url" name="url" value="{{ old('url', $myrecipe->url)}}" id="url">
        @error('url')
        <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="recipe">料理の作り方</label>
        <textarea class="form-textarea" name="recipe" id="recipe" cols="100" rows="20">{{ old('recipe', $myrecipe->recipe)}}</textarea>
        @error('recipe')
        <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit" class="form-btn">変更内容を保存</button>
    </form>
  </section>
  @endsection

  @include('layouts.footer.first')