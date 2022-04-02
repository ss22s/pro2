<!-- 使わない -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規予約</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <style>
        body{
            margin-right: auto;
            margin-left: auto;
            width: 700px;
        }
    </style>
</head>
<script>
	$(function(){
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
    @if()
        <h1>新規予約</h1>
    @endif
    
    <form class="checkform"  method="post" action="/checkuser">
        <h2>接種券番号</h2>
        <input type="text" pattern="^[0-9]{10}" id="vaccination_num" name="vaccination_num" required><br>
        <h2>生年月日</h2>
        <input type="text" pattern="^[0-9]{4}" id="year" name="year" required>年<input type="text" pattern="[0-9]{2}" id="month" name="month" required>月<input type="text" pattern="[0-9]{2}" id="date" name="date" required>日
        @csrf
        <p><input type="submit" value="送信"></p>
        <a href="/selectPlace" method="post">次へ</a>
    </form> 
    <form action="/newRegister" method="post">
        <input type="hidden" name="val" value="newReserve">
        @csrf
        <button type="submit">新規登録</button>はこちら
</body>
</html>