@extends('layouts.app')
  @section('title', '投稿詳細')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/managements/user_post.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
  <section class="main-section">
    <h2 class="main-section-headline">投稿詳細</h2>
    <figure class="recipe-figure">
      <img class="recipe-figure-image" src="{{ $post->myrecipe_colection->image->path }}" alt="レシピの画像">
      @if(isset($post->myrecipe_colection->movie))
        <video class="recipe-figure-movie" preload controls src="{{ $post->myrecipe_colection->movie->path }}" alt="レシピの動画"></video>
      @endif
      <figcaption class="recipe-figure-caption">
        <h3 class="recipe-headline">{{$post->myrecipe_colection->title}}</h3>
        <p class="recipe-caption">
          {{$post->myrecipe_colection->recipe}}
        </p>
      </figcaption>
    </figure>
    <form class="recipe-form" action="/managements/user/post/delete" method="post">
      @csrf
      <input type="hidden" name="post_id" value="{{$post->id}}">
      <button type="submit" class="recipe-form-btn">投稿から削除する</button>
    </form>
  </section>
  @endsection

  @include('layouts.footer.first')
