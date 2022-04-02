<!-- 会場選択 -->
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="/css/all.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- <script src="resources/js/jquery/jquey-2.1.3.js"></script> -->
<script>
    var key01 = null;
        function select(key){
            var keypl = key;
                $("#place").val(keypl);
        }
        
        $(function(){
            var keyid = '{{$resPid}}';
            $("#Pid").val(keyid);      

            $('.colums').click(function(){
                $("*").removeClass("selected");
                $(this).addClass("selected");
                document.getElementById("button").disabled = false;
            });
        });
    
    </script>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table class="table text-center">
            <tr>
                <th class="text-center">病院名</th> 
                <th class="text-center">住所</th> 
            </tr> 
            <tr>
            @foreach($places as $key => $place)
                <tr class="colums" onclick="select({{ $place->place_id }},{{ $resPid }})">
                    <td>{{ $place->place_name }}</td>
                    <td>{{ $place->address }}</td>
                </tr>
            @endforeach
</tr>   
</table>
<form action="/selectDay" method="post">
    @csrf	
    <input type="hidden" id="place" name="place" value="value">
    <input type="hidden" id="Pid" name="Pid" value="value">
    
    <button type="submit" id="button" disabled>送信</button>
</form>


</body>
</html>

