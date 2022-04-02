<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規予約</title>
    <link rel="stylesheet" type="text/css" href="/css/all.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<script>
    var key = 1;
</script>
<body>
    <div>
   <h2>予約一覧</h2>
    @if($reserves === "notdata")
    <div class="usergroup">
            <p class="">登録者情報</p>
        <h5>接種券番号 <span class="lineon">{{ $userdata ->tickets_number }}</span><h5>
        <h5>生年月日 <span class="lineon">{{ $userdata ->birthday }}</span><h5>
    </div>
    <h3>予約はまだありません</h3>
    @else
        @foreach($reserves as $reserve) 
            <div class="group">
                <h3>接種券番号 <span class="lineon">{{ $userdata ->tickets_number }}</span><h3>
                <h3>生年月日 <span class="lineon">{{ $userdata ->birthday }}</span><h3>
                <h3>予約会場 <span class="lineon">{{ $reserve ->place_name }}</span></h3>
                <h3>予約日時 <span class="lineon">{{ $reserve ->reservation_date }}　{{ $reserve ->reservation_time }}</span></h3>
                <a href="">削除</a> <a href="/">変更</a>
            </div>
        @endforeach
    @endif
   <div>
</body>

</html>
    