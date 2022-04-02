<!-- <!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="/css/all.css">-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--<title>時間選択</title>-->
    <style>
        .wrapper {
            height:auto;
            width: 80%;
            /* weight:800px; */
            /* overflow-x: hidden; */

            /* overflow:scroll; */
            /* position: relative; */
            position:fixed;
            left:30%;
            /* top:250px; */
            /* margin-bottom:50px; */
            }
            .thb{
                font-weight:bold;
                text-align:center;
                opacity:0.5;
            }
    </style>
    <script>
        function select(time,res){
            console.log(time);
            var keydid = res;
            $('#selected').text(time);
            $(function(){
                $("#Did").val(keydid);
            })
        }
        $(function(){
            // var keyid = '{{--{{$resPid}}--}}';
            // $("#Pid").val(keyid);
            $('.colums').click(function(){
                $("*").removeClass("selected");
                $(this).addClass("selected");
                document.getElementById("button").disabled = false;
            });
        });
    </script>
    <!--
</head>
<body> -->
@extends('layouts.reserlay')
@section('content')
        <div id="sub">
           
            <div class="Ssize">
            現在選択している病院、日付の時間別空き状況が見れます。<br>
            予約したい時間が決定したら<span class="th">「決定」</span>ボタンを押してください。<br>
            病院、日付を選択しなおしたい時は<a href="/">こちら</a><br>
      
            </div>
        @foreach($place as $place)
            <div class="thb">今選択している病院:<span id="selectedd">{{ $place->place_name }}</span></div>
        @endforeach
        <div class="thb" >今選択している日付:<span id="selectedd">{{ $date }}</span></div>
        <div class="th">今選択している時間:<span id="selected"></span></div>
        @if( Session::get('from')  == 'change')
        <form action = "/changeConfirm" method="post">
        @endif
        <form action = "/reserveConfirm" method="post">
            <!-- <input type="hidden" id="date" name="date" value="value">
            <input type="hidden" id="place" name="place" value="val"> -->
            <input type="hidden" id="preDid" name="prekeyDid" value="{{ $prekeyDid }}">
            <input type="hidden" id="keyres" name="keyres" value="{{ $keyres }}">
            <input type="hidden" id="Did" name="Did" value="val">
                @csrf
            <button type="submit" id="button" class="buttoncss" disabled>決定</button>
        </form>
   </div>

    <div class="wrapper">
        <main>
        <!--
            <h2>選択している日付:{{ $date }}</h2> -->
        <table class="table text-center">
            <tr>
                <th class="text-center">時間</th> 
                <th class="text-center">残り人数</th> 
            </tr> 
            
            @foreach($resdatas as $resdata)
            @if($resdata->reserve_avail != 0)
                <tr class="colums" onclick="select('{{ $resdata->reservation_time }}',{{ $resdata->reservation_data_id }})">
                    <td>{{ $resdata->reservation_time }}</td>
                    <td>{{ $resdata->reserve_avail }}</td>
                    <!-- <td>{{ $resdata }}</td> -->
                </tr>
            @endif
            @endforeach
</tr>   
</table>
<!-- <form action="/reserveConfirm" method="post">
    <input type="hidden" id="Did" name="Did" value="value">
    <input type="hidden" id="Pid" name="Pid" value="value">
    @csrf
    <button type="submit" id="button" disabled>送信</button>
</form> -->
@endsection    
<!-- </body>
</html> -->
