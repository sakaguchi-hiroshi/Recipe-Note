@extends('layouts.app')
  @section('title', 'ユーザー別投稿一覧')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/managements/user_info.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
    <section class="main-section">
      <h2 class="main-section-headline">ユーザー別投稿一覧</h2>
      <table class="user-table">
        <tr class="user-table-row">
          <th class="user-table-headline">USER_ID</th>
          <th class="user-table-headline">権限名</th>
          <th class="user-table-headline">名前</th>
          <th class="user-table-headline">E-MAIL</th>
        </tr>
        <tr class="user-table-row">
          <td class="user-table-data">{{ $item->id }}</td>
          <td class="user-table-data">{{ $item->permission->name }}</td>
          <td class="user-table-data">{{ $item->name }}</td>
          <td class="user-table-data">{{ $item->email }}</td>
          <td class="user-table-data">
            <form class="table-data-form" action="/managements/user/delete" method="post">
              @csrf
              <input type="hidden" name="user_id" value="{{$item->id}}">
              <button class="table-data-form-btn" type="submit">退会させる</button>
            </form>
          </td>
        </tr>
      </table>
      @foreach($posts as $post)
      <figure class="recipe-figure">
        <img class="recipe-figure-image" src="{{ $post->myrecipe_colection->image->path }}" alt="レシピの画像">
        <figcaption class="recipe-figure-caption">
          <h3 class="recipe-headline">{{$post->myrecipe_colection->title}}</h3>
          <p class="recipe-caption">
            {{$post->myrecipe_colection->recipe}}
          </p>
        </figcaption>
      </figure>
      <form class="recipe-form" action="{{ route('managements.user_post')}}" method="get">
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <button type="submit" class="recipe-form-btn">詳細を見る</button>
      </form>
      @endforeach
    </section>
    <div class="paginate">
      {{ $posts->appends(request()->input())->links() }}
    </div>
  @endsection

  @include('layouts.footer.first')
