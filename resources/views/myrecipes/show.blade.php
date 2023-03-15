@extends('layouts.app')
  @section('title', 'Recipe詳細画面')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/myrecipes/show.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second')
  @section('main')
    <h2 class="main-headline">Recipe詳細</h2>
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
        <figure class="recipe-figure">
          @if(isset($myrecipe->image))
            <div class="recipe-figure-item">
              <img class="recipe-figure-image" src="{{ $myrecipe->image->path }}" alt="レシピの画像">
            </div>
          @endif
          @if(isset($myrecipe->movie))
            <div class="recipe-figure-item">
              <video class="recipe-figure-movie" preload controls src="{{ $myrecipe->movie->path }}" alt="レシピの動画"></video>
            </div>
          @endif
          <figcaption class="recipe-figure-caption">
            <h3 class="recipe-headline">{{$myrecipe->title}}</h3>
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
        <div class="bookmark-container">
          @if(isset($post) && !($post->user_id == Auth::id()))
            @if(!$post->isLikedBy(Auth::user()))
              <span class="likes">
                <i class="fa-solid fa-heart like-toggle" data-post-id="{{$post->id}}"></i>
                <span class="like-counter">{{$post->bookmarks_count}}</span>
              </span>
            @elseif($post->isLikedBy(Auth::user()))
              <span class="likes">
                <i class="fa-solid fa-heart like-toggle liked" data-post-id="{{$post->id}}"></i>
                <span class="like-counter">{{$post->bookmarks_count}}</span>
              </span>
            @endif
          @elseif(isset($post))
            <span class="likes">
              <i class="fa-solid fa-heart liked"></i>
              <span class="like-counter">{{$post->bookmarks_count}}</span>
            </span>
          @endif
        </div>
        <div class="report-container">
          @if(isset($reports))
            <div class="report-container-header">
              <h3 class="report-container-headline">レポート</h3>
              <div class="report-count">
                <span class="count">{{$post->reports_count}}</span>件
              </div>
            </div>
            <div class="report-item-wrapper">
              @foreach($reports as $report)
                <div class="report-item">
                  @if(isset($report->image))
                    <div class="report-image-area">
                      <img class="report-image" src="{{ $report->image->path }}" alt="レポートレシピの画像">
                    </div>
                  @endif
                  <div class="report-coment-area">
                    <p class="report-date-time">
                      {{ $report->created_at->format('Y年m月d日 H:i:s')}}
                    </p>
                    <p class="report-coment">
                      {{$report->coment}}
                    </p>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
          @if(isset($post) && !($post->user_id == Auth::id()))
            <form class="recipe-form" action="{{ route('reports.form')}}" method="get">
              @csrf
              <input type="hidden" name="post_id" value="{{$post->id}}">
              <button type="submit">レポートを書く</button>
            </form>
          @endif
        </div>
      </div>
    </section>
  @endsection

  @include('layouts.footer.first')

  <script src="{{ mix('js/bookmark.js') }}"></script>
