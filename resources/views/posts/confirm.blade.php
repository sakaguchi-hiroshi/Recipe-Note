@extends('layouts.app')
  @section('title', 'Recipe投稿確認画面')
  @section('main')
  <section class="contents">
      <div class="box">
        <div class="head_container">
          <h2 class="head_container_title"><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a></h2>
        </div>
        <div class="main_container">
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
          <div class="main_content">
            <div class="recipe_pictures">
              @if(isset($myrecipe->image))
              <div class="image-area">
                <img src="{{ asset('storage/'.$myrecipe->image->path)}}" alt="レシピの画像">
              </div>
              @endif
              @if(isset($myrecipe->movie))
              <div class="movie-area">
                <video preload controls src="{{ asset('storage/'.$myrecipe->movie->path)}}" alt="レシピの動画"></video>
              </div>
              @endif
            </div>
            <div class="recipe_texts">
              <p class="recipe-title">
                {{$myrecipe->title}}
              </p>
              @if(isset($myrecipe->recipe))
              <p class="recipe">
                {{$myrecipe->recipe}}
              </p>
              @endif
            </div>
            <form action="/posts/add" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{ old('recipe_id', $myrecipe->id)}}">
              <input type="hidden" name="image_id" value="{{$myrecipe->image_id}}">
              <input type="hidden" name="title" value="{{$myrecipe->title}}">
              <input type="hidden" name="recipe" value="{{$myrecipe->recipe}}">
              <button type="submit">この内容で投稿する</button>
            </form>
            <form action="{{ route('myrecipes.edit')}}" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <button type="submit">編集する</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  @endsection