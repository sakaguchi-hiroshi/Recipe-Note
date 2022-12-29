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
            <a href="{{ url('/posts/resipe')}}">投稿レシピ一覧</a>
          </li>
          <li class="movie">
            <a href="{{ url('/post/movie')}}">投稿レシピ動画一覧</a>
          </li>
        </ul>
        <h2 class="left_container_heading">
          <a href="{{ url('/membership/services')}}" class="ps_link">プレミアムサービス</a>
        </h2>
        <ul class="services">
          <li class="reports-order">
            <a href="/posts/report/order">人気順検索</a>
          </li>
          <li class="accesses-order">
            <a href="/posts/access/order">レシピランキング</a>
          </li>
        </ul>
      </div>
      <div class="right_container">
        レシピをランダムに5個
      </div>
    </div>
  </section>
  @endsection