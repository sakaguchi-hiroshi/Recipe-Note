@extends('layouts.app')
  @section('title', 'Myrecipe')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/myrecipes/myrecipe.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second')
  @section('main')
    <h2 class="main-headline">マイレシピ</h2>
    <form class="search-form" action="{{ route('myrecipes.myrecipe', ['value' => $value])}}" method="get">
      @csrf
      <input type="hidden" value="{{Auth::id()}}">
      <input type="text" class="keyword" name="keyword">
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
        @foreach($myrecipes as $myrecipe)
          <figure class="recipe-figure">
            @if(isset($myrecipe->image))
              <form id="show-form" class="recipe-form-show" action="{{ route('myrecipes.show')}}" method="get">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
                <button type="submit" class="recipe-figure-btn">
                  <img class="recipe-figure-image" src="{{ $myrecipe->image->path }}" alt="レシピの画像">
                </button>
              </form>
            @else
              <p class="message">画像がありません</p>
            @endif
            @if(isset($myrecipe->movie))
              <button class="recipe-figure-btn" type="submit" form="show-form">
                <video class="recipe-figure-movie" preload controls src="{{ $myrecipe->movie->path }}" alt="レシピの動画"></video>
              </button>
            @endif
            <figcaption class="recipe-figure-caption">
              <button class="recipe-figure-btn" type="submit" form="show-form">
                <h3 class="recipe-headline">{{$myrecipe->title}}</h3>
              </button>
              @if(isset($myrecipe->url))
                <p class="recipe-url">
                  <a href="{{$myrecipe->url}}" target="_blank" rel="noopener noreferrer">
                    {{$myrecipe->url}}
                  </a>
                </p>
              @endif
              @if(isset($myrecipe->recipe))
                <p class="recipe-caption">
                  {{$myrecipe->recipe}}
                </p>
              @endif
            </figcaption>
          </figure>
          <div class="third-container">
            @if($value == 'myrecipe')
              @if(isset($myrecipe->image))
                <form class="recipe-form" action="/myrecipes/image/delete" method="post">
                  @csrf
                  <input type="hidden" name="image_path" value="{{$myrecipe->image->path}}">
                  <input type="hidden" name="image_id" value="{{$myrecipe->image->id}}">
                  <button class="image-delete-btn" type="submit">画像を削除</button>
                </form>
              @endif
              @if(isset($myrecipe->movie))
                <form class="recipe-form" action="/myrecipes/movie/delete" method="post">
                  @csrf
                  <input type="hidden" name="movie_path" value="{{$myrecipe->movie->path}}">
                  <input type="hidden" name="movie_id" value="{{$myrecipe->movie->id}}">
                  <button class="movie-delete-btn" type="submit">動画を削除</button>
                </form>
              @endif
              <form class="recipe-form" action="{{ route('posts.confirm')}}" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
                <button class="recipe-form-btn" type="submit">投稿する</button>
              </form>
              <form class="recipe-form" action="{{ route('myrecipes.edit')}}" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
                <button class="recipe-form-btn" type="submit">編集する</button>
              </form>
              <form class="recipe-form" action="/myrecipes/delete" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
                <button class="recipe-form-btn" type="submit">削除する</button>
              </form>
            @endif
            @if($value == 'post')
              <form class="recipe-form" action="/posts/delete" method="post">
                @csrf
                <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
                <button class="recipe-form-btn" type="submit">投稿から削除する</button>
              </form>
            @endif
          </div>
        @endforeach
        @if(empty($myrecipes->all()))
          <p class="message">条件に合うレシピがありません</p>
        @endif
      </div>
    </section>
    <div class="paginate">
      {{ $myrecipes->appends(request()->input())->links() }}
    </div>
  @endsection

  @include('layouts.footer.first')
