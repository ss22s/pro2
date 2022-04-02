<!-- 日時選択 -->
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="/css/all.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script>
    var key01 = null;
    
        function select(day,pla,mrk){
            if(mrk !== "✕"){                
                console.log("day:" + day);
                var day01 = day;
                console.log("place:" + pla);
                var placekey = pla;
                $(function(){
                    $("#date").val(day01);
                    $("#place").val(placekey);  
                })
            }
        }
        $(function(){
            var keyid = '{{$resPid}}';
            $("#Pid").val(keyid);  

            $('.colums').click(function(){
                if(this.id !== "✕"){
                    $("*").removeClass("selected");
                    $(this).addClass("selected");
                    document.getElementById("button").disabled = false;
                }
            });
        });
        $(function() {
            $( "#datepicker" ).datepicker();
        });
</script>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
            @foreach($place as $place)
                <h2>選択している病院:{{ $place->place_name }}</h2>
            @endforeach
<table class="table text-center">
            <tr>
                <th class="text-center">日付</th> 
            </tr> 
            @foreach($resdatas as  $resdata)
            {{-- @if($resdata->year ==  2022 && $resdata->month == 03) --}}
                <tr class="colums" id="{{ $resdata->mark }}" 
                onclick="select('{{ $resdata->reservation_date }}' ,
                {{ $resdata->place_id }},'{{ $resdata->mark }}')">
                    <td>{{ $resdata->reservation_date }}</td>
                    <td>{{ $resdata->mark }}</td>
                </tr>
            {{-- @endif --}}
            @endforeach
</tr>   
</table>       
<form action="/selectTime" method="post">
    <input type="hidden" id="date" name="date" value="value">
    <input type="hidden" id="place" name="place" value="val">
    <input type="hidden" id="Pid" name="Pid" value="value">
        @csrf
    <button type="submit" id="button" disabled>送信</button>
</form>

<!-- <div id="datepicker"></div> -->
</body>
</html>