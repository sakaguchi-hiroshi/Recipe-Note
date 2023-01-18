@extends('layouts.app')
  @section('title', 'Recipe詳細画面')
  @section('main')
  <section class="contents">
      <div class="box">
        <div class="head_container">
          <h2 class="head_container_title"><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a></h2>
        </div>
        <div class="main_container">
          <div class="main_contents">
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
              @if(isset($myrecipe->url))
              <p class="recipe-url">
                <a href="{{$myrecipe->url}}" target="_blank" rel="noopener noreferrer">
                  {{$myrecipe->url}}
                </a>
              </p>
              @endif
              @if(isset($myrecipe->recipe))
              <p class="recipe">
                {{$myrecipe->recipe}}
              </p>
              @endif
            </div>
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
            @if(isset($report))
            <div class="recipe-report">
              <div class="report-header">
                <h3 class="report-header-title">レポート</h3>
                <div class="report-count">
                  <span>{{$post->reports_count}}</span>件
                </div>
              </div>
              <div class="report-content">
                <div class="report-item-wrapper">
                  <div class="report-item">
                    <form id="reportform" name="reportform" action="{{ route('reports.form')}}" method="post">
                      @csrf
                      <input type="hidden" name="post_id" value="{{$post->id}}">
                      @if(isset($report->image))
                      <div class="report-image-area">
                        <img src="{{ asset('storage/'.$report->image->path)}}" alt="レポートレシピの画像">
                      </div>
                      @else
                      <div class="report-coment-area">
                        <p class="report-date-time">
                          {{ $report->created_at->format('Y年m月d日 H:i:s')}}
                        </p>
                        <p class="report-coment">
                          {{$report->coment}}
                        </p>
                      </div>
                      @endif
                      @if(!($post->user_id == Auth::id()))
                      <button type="submit">レポートを書く</button>
                      @endif
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endsection