@extends('layouts.app')
  @section('title', '投稿レシピ一覧')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/posts/post.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second')
  @section('main')
    <h2 class="main-headline">投稿レシピ一覧</h2>
    <form class="search-form" action="{{ route('posts.post', ['value' => $value]) }}" method="get">
      @csrf
      <input type="text" name="keyword" class="keyword">
      <input type="submit" class="search-btn">
    </form>
    <section class="main-section">
      <div class="first-container">
        <ul class="first-container-list">
          <li class="first-container-list-item">
            <a class="wr-link" href="{{ route('myrecipes.form')}}">レシピを書く</a>
          </li>
          <li class="first-container-list-item">
            <a class="bm-link" href="{{ route('myrecipes.myrecipe', ['value' => 'bookmark']) }}">お気に入りレシピ</a>
          </li>
          <li class="first-container-list-item">
            <a class="mr-link" href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}">自分の書いたレシピ</a>
          </li>
          <li class="first-container-list-item">
            <a class="mp-link" href="{{ route('myrecipes.myrecipe', ['value' => 'post']) }}">自分の投稿レシピ</a>
          </li>
        </ul>
      </div>
      <div class="second-container">
        @foreach($posts as $post)
          <figure class="recipe-figure">
            @if($value == 'post')
              <form id="show-form" action="{{ route('myrecipes.show')}}" method="get">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$post->myrecipe_colection->id}}">
                <button type="submit" class="recipe-figure-btn">
                  <img class="recipe-figure-image " src="{{ $post->myrecipe_colection->image->path }}" alt="レシピの画像">
                </button>
              </form>
            @endif
            @if($value == 'movie')
              <form id="show-form" action="{{ route('myrecipes.show')}}" method="get">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$post->myrecipe_colection->id}}">
                <button type="submit" class="recipe-figure-btn" form="show-form">
                  <video class="recipe-figure-movie" preload controls src="{{ $post->myrecipe_colection->movie->path }}" alt="レシピの動画"></video>
                </button>
              </form>
            @endif
            <figcaption class="recipe-figure-caption">
              <button class="recipe-figure-btn" type="submit" form="show-form">
                <h3 class="recipe-headline">{{$post->myrecipe_colection->title}}</h3>
              </button>
              <p class="recipe-caption">
                {{$post->myrecipe_colection->recipe}}
              </p>
            </figcaption>
          </figure>
        @endforeach
        @if(empty($posts->all()))
          <p class="message">条件に合うレシピがありません</p>
        @endif
      </div>
    </section>
    <div class="paginate">
      {{ $posts->appends(request()->input())->links() }}
    </div>
  @endsection

  @include('layouts.footer.first')
