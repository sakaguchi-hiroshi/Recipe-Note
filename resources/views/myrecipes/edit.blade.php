@extends('layouts.index')
  @section('title', 'Myrecipe編集画面')
  @section('my_menu')
  <a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a>
  @endsection
  @section('main')
  <section class="contents">
    <div class="box">
      <form action="/myrecipes/update" method="post" enctype="multipart/form-data">
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
        <div class="form_group">
          <label for="title">料理のタイトル</label>
          <input type="text" name="title" value="{{ old('title', $myrecipe->title)}}" id="title">
          @error('title')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="form_group">
          <label for="image"></label>
          <input type="file" name="image" id="image" accept="image/*" capture="camera" />
        </div>
        <div class="form_group">
          <label for="movie"></label>
          <input type="file" name="movie" id="movie" accept="video/*">
        </div>
        <div class="form_group">
          <label for="url">参考記事のURL</label>
          <input type="url" name="url" value="{{ old('url', $myrecipe->url)}}" id="url">
          @error('url')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="form_group">
          <label for="recipe">料理の作り方</label>
          <textarea name="recipe" id="recipe" cols="100" rows="20">{{ old('recipe', $myrecipe->recipe)}}</textarea>
          @error('recipe')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <button type="submit">変更内容を保存</button>
      </form>
    </div>
  </section>
  @endsection