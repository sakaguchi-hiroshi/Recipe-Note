@extends('layouts.index')
  @section('title', 'Myrecipe Form')
  @section('my_menu')
  <a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a>
  @endsection
  @section('main')
  <section class="contents">
    <div class="box">
      <form action="/reports/add" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ old('user_id', $user_id) }}">
        <input type="hidden" name="post_id" value="{{ old('post_id', $post_id) }}">
        <div class="form_group">
          <label for="image">料理画像</label>
          <input type="file" name="image" placeholder="料理の画像を選択" id="image" accept="image/*" capture="camera" />
        </div>
        <div class="form_group">
          <label for="coment">料理の作り方</label>
          <textarea name="coment" id="coment" cols="30" rows="4">{{ old('coment')}}</textarea>
          @error('coment')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <button type="submit">保存</button>
      </form>
    </div>
  </section>
  @endsection