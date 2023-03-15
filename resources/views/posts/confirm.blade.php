@extends('layouts.app')
  @section('title', 'Recipe投稿確認画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/posts/confirm.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
  <section class="main-section">
    <h2 class="main-section-headline">Recipe投稿確認</h2>
      @foreach ($errors->all() as $error)
        <li class="error-message">{{$error}}</li>
      @endforeach
      <figure class="recipe-figure">
        @if(isset($myrecipe->image))
          <img class="recipe-figure-image" src="{{ $myrecipe->image->path }}" alt="レシピの画像">
        @endif
        @if(isset($myrecipe->movie))
          <video class="recipe-figure-movie" preload controls src="{{ $myrecipe->movie->path }}" alt="レシピの動画"></video>
        @endif
        <figcaption class="recipe-figure-caption">
          <h3 class="recipe-headline">{{$myrecipe->title}}</h3>
          @if(isset($myrecipe->recipe))
            <p class="recipe-caption">
              {{$myrecipe->recipe}}
            </p>
          @endif
        </figcaption>
      </figure>
      <form class="recipe-form" action="/posts/add" method="post">
        @csrf
        <input type="hidden" name="recipe_id" value="{{ old('recipe_id', $myrecipe->id)}}">
        <input type="hidden" name="image_id" value="{{$myrecipe->image_id}}">
        <input type="hidden" name="title" value="{{$myrecipe->title}}">
        <input type="hidden" name="recipe" value="{{$myrecipe->recipe}}">
        <button class="recipe-form-btn" type="submit">この内容で投稿する</button>
      </form>
      <form class="recipe-form" action="{{ route('myrecipes.edit')}}" method="post">
        @csrf
        <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
        <button class="recipe-form-btn" type="submit">編集する</button>
      </form>
    </section>
  @endsection

  @include('layouts.footer.first')
