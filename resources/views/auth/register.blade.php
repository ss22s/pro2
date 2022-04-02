@extends('layouts.app')

<link rel="stylesheet" href="/css/validationEngine.jquery.css" type="text/css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/languages/jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript"></script>
    <script type="text/javascript" src="js/all.js"></script>

    <script>
        jQuery(document).ready(function(){
        jQuery("#regiForm").validationEngine();
        });
        function ShowLength( str ) {
            document.getElementById("inputlength").innerHTML = "現在:" + str.length + "文字入力";
        }
    </script>

    <style>   
        body{
            margin-right: auto;
            margin-left: auto;
            width: 600px;
        }
        select{
            width: 100px;
        }
        .row{
            margin-top: 50px;
        }
        h1{
            text-align: center;
        }
        .btn{
            width: 200px;
            padding: 10px;
            box-sizing: border-box;
            cursor: pointer;
        }
        .inlineSet{
            display:inline-flex;
        }   
    </style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1>{{ __('Register') }}</h1></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="regiForm">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end"><h3>{{ __('Name') }}</h3></label>
                            <span style="color:navy;">ワクチン接種希望者の氏名を入力してください。</span>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="氏名" class="form-control @error('name') is-invalid @enderror validate[required]" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"><h3>{{ __('E-Mail Address') }}</h3></label>
                            <span style="color:navy;">予約情報を受け取るメールアドレスを入力してください。</span>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="メールアドレス" class="form-control @error('email') is-invalid @enderror validate[required,custom[email]]" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end"><h3>{{ __('Password') }}</h3></label>
                            <span style="color:navy;">お好きなパスワードを入力してください。（ログインに必要です）</span>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="パスワード" class="form-control @error('password') is-invalid @enderror validate[required]" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end"><h3>{{ __('Confirm Password') }}</h3></label>
                            <span style="color:navy;">パスワードを再入力してください。</span>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" placeholder="パスワード(確認用)" class="form-control validate[required]" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <!-- 追加 -->
                        <div class="row mb-3">
                            <div>
                                <label for="tickets_number" class="col-md-4 col-form-label text-md-end"><h3>{{ __('tickets_number') }}</h3></label>
                                <span style="color:navy;">10桁の接種券番号を入力してください。</span>
                                <span class="inlineSet"><span id="inputlength">現在:0文字入力</span></span>
                            </div>
                            
                            <div class="col-md-6">
                                <input id="tickets_number" type="text" placeholder="10桁の接種券番号を入力" class="form-control validate[required,custom[number],minSize[10],maxSize[10]]]" name="tickets_number" onkeyup="ShowLength(value);">
                            </div>
                            
                        </div>

                        <div class="row mb-3">
                            <label for="year" class="col-md-4 col-form-label text-md-end"><h3>{{ __('birthday') }}</h3></label>
                            <span style="color:navy;">ワクチン接種希望者の生年月日を入力してください。</span><br>

                            <select id="year" name="year" class="form-control validate[required]">
                                <option value="">----</option>
                            </select>年                                            
                            <select id="month" name="month" class="form-control validate[required]">
                                <option value="">--</option>
                            </select>月                                                        
                            <select id="date" name="date" class="form-control validate[required]">
                                <option value="">--</option>
                            </select>日  
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            ログインの場合は<a href="{{ route('login') }}">こちら</a>
        </div>
    </div>
</div>
@endsection
