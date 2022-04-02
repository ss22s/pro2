<!DOCTYPE html>
<head>
    <!-- <link rel="stylrsheet" type="text/css" src="css/all.css"> -->
    <link rel="stylesheet" href="/css/validationEngine.jquery.css" type="text/css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/languages/jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.pwdMeasure.min.js"></script>
    <script type="text/javascript"></script>
    <script type="text/javascript" src="js/all.js"></script>

    <script>
        jQuery(document).ready(function(){
        jQuery("#regiForm").validationEngine();
        });

        // $(window).on('load',function(){
        //     $('#myModal').modal('show');
        // });

	    $(function(){
			$("#number").change(function(){
				var str = $(this).val();
				str = str.replace( /[Ａ-Ｚａ-ｚ０-９－！”＃＄％＆’（）＝＜＞，．？＿［］｛｝＠＾～￥]/g, function(s) {
					return String.fromCharCode(s.charCodeAt(0) - 65248);
			    });
				$(this).val(str);
			}).change();

            // $("*").focusin(function(){
            //     if()
            // });
	    });
        $(function () {
			$('#passwd').pwdMeasure();
		});
        function ShowLength( str ) {
            document.getElementById("inputlength").innerHTML = str.length + "文字入力";
        }
    </script>
    <title>新規登録</title>
    <style>
        /* *{
            overflow:hidden;
        } */
        body{
            margin-right: auto;
            margin-left: auto;
            width: 600px;
        }
        .border{
            border:solid 2px;
            width: 160px;
            text-align:center;
            margin-top: 50px;
            margin-right: auto;
            margin-left: auto;
        }
        .red{
            color:red;
        }

        .pm-indicator {
            width: 220px;
            height: 10px;
            margin:5px 0;
            padding:1.1em 1em;
            color:#2c3e50;
            font-size:12px;
            text-align:center;
            border:1px solid #ccc;
            border-radius:2px;
            background:#e4e4e4;
            text-shadow:1px 1px 0 rgba(255,255,255,.8);
            -webkit-transition:all .2s ease-in-out;
            transition:all .2s ease-in-out;
        }
  
        .pm-indicator.very-weak,
        .pm-indicator.not-match {
            border-color:#be1d30;
            background-color:#ffc3cf;
        }
  
        .pm-indicator.weak {
            border-color:#ff787d;
            background-color:#ffe6e5;
        }
  
        .pm-indicator.strong {
            border-color:#78bc42;
            background-color:#bceea6;
        }
  
        .pm-indicator.very-strong {
            border-color:#4f85a7;
            background-color:#68c6d7;
        }
       
        select{
            width: 100px;
        }     
        .inlineSet{
            display:inline-flex;
        }   
    </style>
</head>
<body>
    <h1>新規登録</h1>
    @if(Session::has('flashmessage'))
        <!-- モーダルウィンドウの中身 -->
        <div class="modal fade" id="myModal" tabindex="-1"
            role="dialog" aria-labelledby="label1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        {{ session('flashmessage') }}
                    </div>
                    <div class="modal-footer text-center">
                    </div>
                </div>
            </div>
        </div>
    @endif
    <form action="/register" method="post" id="regiForm">
        <h3>氏名</h3>
        <span style="color:navy;">ワクチン接種希望者の氏名を入力してください。</span><br>
        <input type="text" value="" name="familyname" placeholder="姓" class=validate[required]> <input type="text" value="" name="firstname" placeholder="名前" class="validate[required]">
        
        <h3>接種券番号(10桁)</h3>
        <span style="color:navy;">10桁の接種券番号を入力してください。</span><br>

        <input type="text" name="number" value="" placeholder="10桁の接種券番号を入力" maxlength="" id="number" class=validate[required,custom[number],minSize[10],maxSize[10]]] onkeyup="ShowLength(value);">
        <span class="inlineSet"><span id="inputlength">0文字入力</span></span>

        <h3>生年月日</h3>
        <span style="color:navy;">ワクチン接種希望者の生年月日を入力してください。</span><br>
        <select id="year" name="yaer" class=validate[required]>
            <option value="" class=validate[required]>----</option>
        </select> 年
        <select id="month" name="month" class=validate[required]>
            <option value="" class=validate[required]>--</option>
        </select> 月
        <select id="date" name="date" class=validate[required]>
            <option value="" class=validate[required]>--</option>
        </select> 日
        
        <h3>メールアドレス</h3>
        <span style="color:navy;">予約情報を受け取るメールアドレスを入力してください。</span><br>

        <input type="text" name="mailad" value="" placeholder="メールアドレス" class="validate[required,custom[email]]">
        
        <h3>パスワード</h3>
        <span style="color:navy;">お好きなパスワードを入力してください。（ログインに必要です）</span><br>
        <div class="col-sm-8">
			<input type="password" name="password" value="" placeholder="パスワード" id="passwd" class=validate[required]>
		</div>
        <div id="pm-indicator" class="pm-indicator"></div> 
         <!-- <input type="text" name="password" value="abcd" placeholder="パスワード" id="passwd"> --> 
        
        <h3>パスワード(二回目)</h3>
        <span style="color:navy;">パスワードを再入力してください。</span><br>

        <input type="password"  name="password" value="" placeholder="パスワード(二回目)" class=validate[required]>
        <p>
            @if ($keyReg === 'top')
                top
                <input type="hidden" name="from" value="top">
            @else
                newReserve
                <input type="hidden" name="from" value="newReserve">
            @endif
        </p>
        @csrf
        <button type="submit" id="button" >送信</button>
    </form>
    
</body>   
</html>
