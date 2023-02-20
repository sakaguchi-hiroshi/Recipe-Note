@extends('layouts.app')
  @section('title', 'Management')
  @section('pageCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/managements/manage.css')}}">
  @endsection
  @include('layouts.header.first')
  @include('layouts.header.second_ttl_only')
  @section('main')
    <section class="main-section">
      <h2 class="main-section-headline">ユーザー 一覧</h2>
      <form class="search-form" action="{{ route('managements.manage')}}" method="post">
        @csrf
        <input type="text" class="keyword" name="keyword" value="@if(isset($keyword)) {{$keyword}} @endif" placeholder="名前、又はE-Mail">
        <button class="search-btn" data-indicate-content="user">検索</button>
        <a href="{{ route('managements.manage')}}" class="clear-btn">クリア</a>
      </form>
      <table class="user-table">
        <tr class="user-table-row">
          <th class="user-table-headline">USER_ID</th>
          <th class="user-table-headline">権限名</th>
          <th class="user-table-headline">名前</th>
          <th class="user-table-headline">E-MAIL</th>
        </tr>
        @foreach($items as $item)
        <tr class="user-table-row">
          <td class="user-table-data">{{ $item->id }}</td>
          <td class="user-table-data">{{ $item->permission->name }}</td>
          <td class="user-table-data">{{ $item->name }}</td>
          <td class="user-table-data">{{ $item->email }}</td>
          <td class="user-table-data">
            <form class="table-data-form" action="{{route('managements.user_info')}}" method="get">
              @csrf
              <input type="hidden" name="user_id" value="{{$item->id}}">
              <button class="table-data-form-btn" type="submit">詳細画面</button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
      @if(empty($items->all()))
        <p class="message">ユーザー情報がありません</p>
      @endif
    </section>
    <div class="paginate">
      {{ $items->appends(request()->input())->links() }}
    </div>
  @endsection

  @include('layouts.footer.first')