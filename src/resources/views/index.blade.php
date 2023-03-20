@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script>
    function Zenkaku2hankaku(str) {
      tmp = str.replace("ー", "-");  /* やりそうな文字だから追加 */
      return tmp.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
      });
    }
    function zipcode2address(zipcode_obj, address_txt) {
      str = zipcode_obj.value;
      zipcode_obj.value = Zenkaku2hankaku(str);
      AjaxZip3.zip2addr(zipcode_obj, '', address_txt, address_txt);
    }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var first_name = document.getElementById('first_name');
      var last_name = document.getElementById('last_name');
      var email = document.getElementById('email')
      
      first_name.addEventListener("change", function(){
        document.getElementById("fullname").value = first_name.value + ' ' + last_name.value;
      });
      last_name.addEventListener("change", function(){
        document.getElementById("fullname").value = first_name.value + ' ' + last_name.value;
      });
    });
  </script>
  <div class="contact-form__content">
    <div class="contact-form__heading">
      <h2>お問い合わせ</h2>
    </div>
    <form class="form" name="contact_form" action="/contacts/confirm" method="post">
      @csrf
      <div class="form__group fullname__form__group">
        <div class="form__group-title">
          <span class="form__label--item">お名前</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <div class="form__group-content--fullname">
            <div class="form__input--text">
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"/>
              <p class="form__example">例&#xFF09; 山田</p>
            </div>
            <div class="form__input--text">
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"/>
              <p class="form__example">例&#xFF09; 太郎</p>
            </div>
            <input type="hidden" id="fullname" name="fullname" value="{{ old('fullname') }}"/>
          </div>
          <div class="form__error">
            @error('fullname')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group gender__form__group">
        <div class="form__group-title">
          <span class="form__label--item">性別</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--radio">
            <input type="radio" name="gender" id="male" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }} />
              <label for="male" class="radio">男性</label>
            <input type="radio" name="gender" id="female" value="2" {{ old('gender') == '2' ? 'checked' : '' }} />
              <label for="female" class="radio">女性</label>
          </div>
        </div>
      </div>
      <div class="form__group email__form__group">
        <div class="form__group-title">
          <span class="form__label--item">メールアドレス</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="email" id="email" name="email" value="{{ old('email') }}"/>
            <p class="form__example">例&#xFF09; test@example.com</p>
          </div>
          <div class="form__error">
            @error('email')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group postcode__form__group">
        <div class="form__group-title">
          <span class="form__label--item">郵便番号</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <span>〒</span>
          <div class="form__input--text">
            <input type="text" name="postcode" value="{{ old('postcode') }}"
            onChange="zipcode2address(this, 'address');"/>
            <p class="form__example">例&#xFF09; 123-4567</p>
          </div>
          <div class="form__error">
            @error('postcode')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group address__form__group">
        <div class="form__group-title">
          <span class="form__label--item">住所</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="text" name="address" value="{{ old('address') }}"/>
            <p class="form__example">例&#xFF09; 東京都渋谷区千駄ヶ谷1-2-3</p>
          </div>
          <div class="form__error">
            @error('address')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group building_name__form__group">
        <div class="form__group-title">
          <span class="form__label--item">建物名</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="text" name="building_name" value="{{ old('building_name') }}"/>
            <p class="form__example">例&#xFF09; 千駄ヶ谷マンション101</p>
          </div>
          <div class="form__error">
            @error('building_name')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group opinion__form__group">
        <div class="form__group-title">
          <span class="form__label--item">ご意見</span>
          <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <textarea name="opinion" maxlength="120">{{ old('opinion') }}</textarea>
          </div>
          <div class="form__error">
            @error('opinion')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit" type="submit">確認</button>
      </div>
    </form>
  </div>
@endsection