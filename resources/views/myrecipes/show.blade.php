@extends('layouts.app')
  @section('title', 'Recipe詳細画面')
  @section('main')
  <section class="contents">
      <div class="box">
        <div class="head_container">
          <h2 class="head_container_title"><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a></h2>
          <form action=""></form>
        </div>
        <div class="main_container">
          <div class="main_content">
            <div class="recipe_pictures">
              @if(isset($myrecipe->image))
              <img src="{{ asset('storage/'.$myrecipe->image->path)}}" alt="レシピの画像">
              @endif
              @if(isset($myrecipe->movie))
              <video preload controls src="{{ asset('storage/'.$myrecipe->movie->path)}}" alt="レシピの動画"></video>
              @endif
            </div>
            <div class="recipe_texts">
              {{$myrecipe->title}}
              <br>
              @if(isset($myrecipe->url))
              <a href="{{$myrecipe->url}}" target="_blank" rel="noopener noreferrer">
              {{$myrecipe->url}}
              </a>
              @endif
              @if(isset($myrecipe->recipe))
              {{$myrecipe->recipe}}
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  @endsection