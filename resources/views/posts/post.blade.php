@extends('layouts.index')
  @section('title', 'Myrecipe')
  @section('my_menu')
  <a href="{{ route('myrecipes.form')}}" class="wr_link">レシピを書く</a>
  @endsection
  @section('main')
    <section class="contents">
      <div class="box">
        <div class="head_container">
          <ul class="main_menu">
            <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'bookmark']) }}">お気に入りレシピ</a></li>
            <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}">自分の書いたレシピ</a></li>
            <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'post']) }}">自分の投稿レシピ</a></li>
          </ul>
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
            @foreach($posts as $post)
            <form action="{{ route('myrecipes.show')}}" id="apost" name="apost" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$post->id}}">
              <div class="recipe_pictures">
                @if($value == 'post')
                <div class="image-area">
                  <a name="asubmit" href="javascript:apost[{{$loop->index}}].submit()">
                    <img src="{{ asset('storage/'.$post->myrecipe_colection->image->path)}}" alt="レシピの画像">
                  </a>
                </div>
                @endif
                @if($value == 'movie')
                <div class="movie-area">
                  <video preload controls src="{{ asset('storage/'.$post->myrecipe_colection->movie->path)}}" alt="レシピの動画"></video>
                </div>
                @endif
              </div>
              <div class="recipe_texts">
                <p class="recipe-title">
                  <a name="asubmit" href="javascript:apost[{{$loop->index}}].submit()">
                    {{$post->myrecipe_colection->title}}
                  </a>
                </p>
                <p class="recipe">
                  <a name="asubmit" href="javascript:apost[{{$loop->index}}].submit()">
                    {{$post->myrecipe_colection->recipe}}
                  </a>
                </p>
              </div>
            </form>
            @endforeach
          </div>
        </div>
      </div>
    </section>
  @endsection