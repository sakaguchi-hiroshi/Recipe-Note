@extends('layouts.index')
  @section('title', 'Recipe Note')
  @section('my_menu')
    
    <a href="{{ route('myrecipes.myrecipe', ['value' => 'myrecipe']) }}" class="mr_link">マイレシピ</a>
    <a href="{{ route('myrecipes.form')}}" class="wr_link">レシピを書く</a>
  @endsection
  @section('main')
    <section class="contents">
      <div class="box">
        <div class="left_container">
          <h2 class="left_container_heading">レシピ関連サービス</h2>
          <ul class="services">
            <li class="posts_recipe">
              <a href="{{ route('posts.post', ['value' => 'post']) }}">投稿レシピ一覧</a>
            </li>
            <li class="movie">
              <a href="{{ route('posts.post', ['value' => 'movie']) }}">投稿レシピ動画一覧</a>
            </li>
          </ul>
          <h2 class="left_container_heading">
            <a href="{{ url('/services/premium')}}" class="ps_link">プレミアムサービス</a>
          </h2>
          <ul class="services">
            <li class="reports-order">
              <a href="{{ route('posts.order')}}">人気順検索</a>
            </li>
            <li class="accesses-order">
              <a href="/posts/access/order">レシピランキング</a>
            </li>
          </ul>
        </div>
        <div class="right_container">
          <div class="part-of-postrecipe">
            @foreach($posts as $post)
            <form action="{{ route('myrecipes.show')}}" id="apost" name="apost" method="post">
              @csrf
              <input type="hidden" name="recipe_id" value="{{$post->id}}">
              <div class="recipe_pictures">
                <div class="image-area">
                  <a name="asend" href="javascript:apost[{{$loop->index}}].submit()">
                    <img src="{{ asset('storage/'.$post->image->path)}}" alt="レシピの画像">
                  </a>
              </div>
              </div>
              <div class="recipe_texts">
                <p class="recipe-title">
                  <a name="asubmit" href="javascript:apost[{{$loop->index}}].submit()">
                    {{$post->title}}
                  </a>
                </p>
                <p class="recipe">
                  <a name="asubmit" href="javascript:apost[{{$loop->index}}].submit()">
                    {{$post->recipe}}
                  </a>
                </p>
              </div>
            </form>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ mix('js/bookmark.js') }}"></script>
    <script src="https://kit.fontawesome.com/b8e0fd0230.js" crossorigin="anonymous"></script>
  @endsection