@extends('layouts.index')
  @section('title', 'Myrecipe')
  @section('main')
    <section class="contents">
      <div class="box">
        <div class="head_container">
          <h2 class="head_container_title"><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a></h2>
          <div class="search_box">
            <form action="">
              <input type="text" class="search">
              <input type="submit" class="btn_submit">
            </form>
          </div>
        </div>
        <div class="main_container">
          <div class="main_content">
            @foreach($myrecipes as $myrecipe)
            <form action="{{ route('myrecipes.show')}}" id="myrecipe-a-form" method="get">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <div class="recipe_pictures">
                <a href="javascript:$('#myrecipe-a-form').submit()">
                  <img src="{{ asset('storage/'.$myrecipe->image->path)}}" alt="レシピの画像">
                </a>
              </div>
              <div class="recipe_texts">
                {{$myrecipe->title}}
                <br>
                {{$myrecipe->url}}
              </div>
              <button type="submit">詳細</button>
            </form>
            @endforeach
          </div>
          <ul class="main_menu">
            <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'bookmark']) }}">お気に入りレシピ</a></li>
            <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}">自分の書いたレシピ</a></li>
          </ul>
        </div>
      </div>
    </section>
    
  @endsection