@extends('layouts.app')
  @section('title', 'Recipe Note')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/recipenotes/index.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second')
  @section('main')
    <section class="main-section">
      <div class="first-container">
        <h2 class="first-container-headline">レシピ関連サービス</h2>
        <ul class="first-container-list">
          <li class="first-container-list-item">
            <a class="list-item-posts" href="{{ route('posts.post', ['value' => 'post']) }}">投稿レシピ一覧</a>
          </li>
          <li class="first-container-list-item">
            <a class="list-item-movies" href="{{ route('posts.post', ['value' => 'movie']) }}">投稿レシピ動画一覧</a>
          </li>
        </ul>
        <h2 class="first-container-headline">
          <a href="{{ url('/services/premium')}}" class="ps-link">プレミアムサービス</a>
        </h2>
        <ul class="first-container-list">
          <li class="first-container-list-item">
            <a class="list-item-order-favoriet" href="{{ route('posts.orders.bookmark')}}">人気順検索</a>
          </li>
          <li class="first-container-list-item">
            <a class="list-item-order-access" href="/posts/access/order">レシピランキング</a>
          </li>
        </ul>
      </div>
      <div class="second-container">
        @foreach($posts as $post)
        <form id="show-form" class="recipe-form-show" action="{{ route('myrecipes.show')}}" method="get">
          @csrf
          <input type="hidden" name="recipe_id" value="{{$post->id}}">
          <figure class="recipe-figure">
            <button class="recipe-figure-btn" type="submit">
              <img class="recipe-figure-image" src="{{ $post->image->path }}" alt="レシピの画像">
            </button>
            <figcaption class="recipe-figure-caption">
              <button class="recipe-figure-btn" type="submit" form="show-form">
                <h3 class="recipe-headline">{{$post->title}}</h3>
              </button>
              <p class="recipe-caption">
                {{$post->recipe}}
              </p>
            </figcaption>
          </figure>
        </form>
        @endforeach
      </div>
    </section>
  @endsection

  @include('layouts.footer.first')
