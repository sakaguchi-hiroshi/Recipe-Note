@extends('layouts.index')
  @section('title', 'Myrecipe Form')
  @section('my_menu')
  <a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a>
  @endsection
  @section('main')
  <section class="contents">
    <div class="box">
      <form action="/myrecipes/add" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <div class="form_group">
          <label for="title">料理のタイトル</label>
          <input type="text" name="title" placeholder="例）海老グラタン" id="title">
          @error('title')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="form_group">
          <label for="image">料理画像</label>
          <input type="file" name="image" placeholder="料理の画像を選択" id="image" accept="image/*" capture="camera" />
        </div>
        <div class="form_group">
          <label for="movie">料理動画</label>
          <input type="file" name="movie" placeholder="料理の動画を選択" id="movie" accept="video/*">
        </div>
        <div class="form_group">
          <label for="url">参考記事のURL</label>
          <input type="url" name="url" placeholder="urlを入力" id="url">
          @error('url')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <div class="form_group">
          <label for="recipe">料理の作り方</label>
          <textarea name="recipe" id="recipe" cols="100" rows="20"></textarea>
          @error('recipe')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <button type="submit">保存</button>
      </form>
    </div>
  </section>
  @endsection