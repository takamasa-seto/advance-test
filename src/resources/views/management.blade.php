@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/management.css') }}">
@endsection

@section('content')
  <div class="contact-form__content">
    <div class="contact-form__heading">
      <h2>管理システム</h2>
      <form class="form" action="/management/search" method="post">
        @csrf
        <div class="form__group__set">
          <div class="form__group fullname__form__group">
            <div class="form__group-title">
              <span class="form__label--item">お名前</span>
            </div>
            <div class="form__group-content">
              <div class="form__input--text">
                <input type="text" name="fullname" value="{{ Session::has('fullname') ? Session::get('fullname') : '' }}">
              </div>
            </div>
          </div>
          <div class="form__group gender__form__group">
            <div class="form__group-title">
              <span class="form__label--item">性別</span>
            </div>
            <div class="form__group-content">
              <div class="form__input--radio">
                <input type="radio" name="gender" id="all" value="0" {{ Session::has('gender') ? (Session::get('gender') == '0' ? 'checked' : '') : 'checked' }}/>
                  <label for="all" class="radio">全て</label>
                <input type="radio" name="gender" id="male" value="1" {{ Session::has('gender') ? (Session::get('gender') == '1' ? 'checked' : '') : '' }}/>
                  <label for="male" class="radio">男性</label>
                <input type="radio" name="gender" id="female" value="2" {{ Session::has('gender') ? (Session::get('gender') == '2' ? 'checked' : '') : '' }}/>
                  <label for="female" class="radio">女性</label>
              </div>
            </div>
          </div>
        </div>
        <div class="form__group create_date__form__group">
          <div class="form__group-title">
            <span class="form__label--item">登録日</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="created_at_from" value="{{ Session::has('created_at_from') ? Session::get('created_at_from') : '' }}">
            </div>
          </div>
          <span  class="form__label--tilde">~</span>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="created_at_to" value="{{ Session::has('created_at_to') ? Session::get('created_at_to') : '' }}">
            </div>
          </div>
        </div>
        <div class="form__group email__form__group">
          <div class="form__group-title">
            <span class="form__label--item">メールアドレス</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="email" value="{{ Session::has('email') ? Session::get('email') : '' }}">
            </div>
          </div>
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit" name="search" value='search'>検索</button>
          <button class="form__button-repair" type="submit" name="reset" value='reset'>リセット</button>
        </div>
      </form>
    </div>
  </div>
  <div class="search-table__group">
    {{ $contacts->links('layouts.pagenation') }}
    <table>
      <tr class="search-table__row">
        <th class="search-table__header">
          <span>ID</span>
          <span>お名前</span>
          <span>性別</span>
          <span>メールアドレス</span>
          <span>ご意見</span>
        </th>
      </tr>
      @foreach ($contacts as $contact)
      <tr class="search-table__row">
        <td  class="search-table__item">
          <span>{{ $contact['id'] }}</span>
          <span title="{{ $contact['fullname'] }}">{{ $contact['fullname'] }}</span>
          <span>
            @if ($contact['gender'] == '1')
              男性
            @elseif ($contact['gender'] == '2')
              女性
            @endif
          </span>
          <span title="{{ $contact['email'] }}">{{ $contact['email'] }}</span>
          <span title="{{ $contact['opinion'] }}">{{ $contact['opinion'] }}</span>
        </td>
        <td class="search-table__item">
          <form action="/management/delete" method="post">
            @method('DELETE')
            @csrf
            <div class="delete-form__button">
              <input type="hidden" name="id" value="{{ $contact['id'] }}">
              <button class="delete-form__button-submit" type="submit">削除</button>
            </div>
          </form>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
@endsection