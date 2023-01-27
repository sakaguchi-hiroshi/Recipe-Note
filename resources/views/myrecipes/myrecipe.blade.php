@extends('layouts.index')
  @section('title', 'Myrecipe')
  @section('my_menu')
    <ul class="main_menu">
      <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'bookmark']) }}">お気に入りレシピ</a></li>
      <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}">自分の書いたレシピ</a></li>
      <li><a href="{{ route('myrecipes.myrecipe', ['value' => 'post']) }}">自分の投稿レシピ</a></li>
    </ul>
    <a href="{{ route('myrecipes.form')}}" class="wr_link">レシピを書く</a>
  @endsection
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
            <form action="{{ route('myrecipes.show')}}" id="apost" name="apost" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <div class="recipe_pictures">
                @if(isset($myrecipe->image))
                <div class="image-area">
                  <a name="asubmit" href="javascript:apost[@json($loop->index)].submit();">
                    <img src="{{ asset('storage/'.$myrecipe->image->path)}}" alt="レシピの画像">
                  </a>
                </div>
                @else
                <p>画像がありません</p>
                @endif
                @if(isset($myrecipe->movie))
                <div class="movie-area">
                  <video preload controls src="{{ asset('storage/'.$myrecipe->movie->path)}}" alt="レシピの動画"></video>
                </div>
                @endif
              </div>
              <div class="recipe_texts">
                <p class="recipe-title">
                  <a name="asubmit" href="javascript:apost[@json($loop->index)].submit()">
                    {{$myrecipe->title}}
                  </a>
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
                  <a name="asubmit" href="javascript:apost[@json($loop->index)].submit()">
                    {{$myrecipe->recipe}}
                  </a>
                </p>
                @endif
              </div>
            </form>
            @if($value == 'myrecipe')
            @if(isset($myrecipe->image))
            <form action="/myrecipes/image/delete" method="post">
              @csrf
              <input type="hidden" name="image_path" value="{{$myrecipe->image->path}}">
              <input type="hidden" name="image_id" value="{{$myrecipe->image->id}}">
              <button type="submit">画像を削除する</button>
            </form>
            @endif
            @if(isset($myrecipe->movie))
            <form action="/myrecipes/movie/delete" method="post">
              @csrf
              <input type="hidden" name="movie_path" value="{{$myrecipe->movie->path}}">
              <input type="hidden" name="movie_id" value="{{$myrecipe->movie->id}}">
              <button type="submit">動画を削除する</button>
            </form>
            @endif
            @if( !($myrecipe->posts()->exists()) )
            <form action="{{ route('posts.confirm')}}" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <button type="submit">投稿する</button>
            </form>
            @endif
            <form action="{{ route('myrecipes.edit')}}" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <button type="submit">編集する</button>
            </form>
            <form action="/myrecipes/delete" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <button type="submit">削除する</button>
            </form>
            @endif
            @if($value == 'post')
            <form action="/posts/delete" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$myrecipe->id}}">
              <button type="submit">投稿から削除する</button>
            </form>
            @endif
            @endforeach
          </div>
          
        </div>
      </div>
    </section>
  @endsection