<!DOCTYPE html>
<!-- 使わない -->
<html lang="ja">
<head>
    <meta charset="UTF-8">
    @if( $keyReg == 'new')
        <title>新規予約</title>
    @else
        <title>ログイン</title>
    @endif
    <link rel="stylesheet" type="text/css" href="/css/all.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<script>
	$(function(){
        
        var keyR = null;
        var keyR = '{{$keyReg}}';
        $("#keyreg").val(keyR);
        console.log(keyR);
			$("#vaccination_num, #year, #month, #date").change(function(){
					var str = $(this).val();
					str = str.replace( /[Ａ-Ｚａ-ｚ０-９－！”＃＄％＆’（）＝＜＞，．？＿［］｛｝＠＾～￥]/g, function(s) {
							return String.fromCharCode(s.charCodeAt(0) - 65248);
					});
					$(this).val(str);
			}).change();
	});
</script>
<body>
    @if( $keyReg == 'new')
        <h1>新規予約</h1>
        <form class="checkform"  method="post" action="/selectPlace">
    @else
        <h1>ログイン</h1>
        <form class="checkform"  method="post" action="/mypage">
    @endif
        <h2>接種券番号</h2>
        <span style="color:navy;">登録済みの接種券番号を入力してください。</span><br>
        <input type="text" value="" pattern="^[0-9]{10}" id="vaccination_num" name="vaccination_num" required><br>
        <h2>生年月日</h2>
        <span style="color:navy;">登録済みの生年月日を入力してください。</span><br>
        <input type="text" value="" pattern="^[0-9]{4}" id="year" name="year" required>年<input type="text" value="" pattern="[0-9]{2}" id="month" name="month" required>月<input type="text" value="" pattern="[0-9]{2}" id="date" name="date" required>日
        <h2>パスワード</h2>
        <input type="password" name="password">
        @csrf
        <input type="hidden" id="keyreg" name="keyreg" value="">
        <p>
            <input type="submit" value="送信">
        </p>
        <!-- @if( $keyReg == 'new')
            <a href="/selectPlace" >次へ</a>
        @else
            <a href="/mypage">次へ</a>
        @endif -->
    </form> 
    <p>
    <form action="/newRegister" method="post">
        <input type="hidden" name="from" value="newReserve">
        @csrf
        <button type="submit">新規登録</button>はこちら
    </form>
    </p>
</body>
</html>