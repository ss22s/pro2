<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
    .wrapper {
        height:50%;
        /* height: auto; */
        width: 80%;
        /* overflow-x: hidden; */
        overflow:auto;
        /* position: relative; */
        position:fixed;
        left:30%;
        /* top:250px; */
        /* margin-bottom:50px; */
        }
</style>
<script>
    if('{{$regok}}' == 1){
        alert("予約完了しました！");
    } else if('{{$regok}}' == 2){
        alert("削除完了しました！");
    } else if('{{$regok}}' == 3){
        alert('予約を変更しました！');
    } else if('{{$regok}}' == 4){
        alert('予約変更を中断しました');
    }

    function select(name,id){
            $('#selected').text(name);  
            $('#selectedd').text("");
            // console.log(id);
            $("#place").val(id);
            $("*").removeClass("selectedd");   
            $("#date").val("");
            if($("#date").val() == ""){
                document.getElementById("button").disabled = true;
            }
        }
        function selectt(day,mark,placeI,placeN){
            // console.log(mark);
            // console.log(placeN);
            if(mark !=="✕"){
                if($('.selected').id != placeI){
                    $("*").removeClass("selected");
                    $('#' + placeI).addClass("selected");
                   
                }
                $('#selectedd').text(day);
                $('#selected').text(placeN); 
                $('#date').val(day);
                $("#place").val(placeI);
                
                //どちらも選択されたら
                if(($('#selected').text() != "") && ($('#selected').text() != "")){
                    // console.log("tuua");
                    document.getElementById("button").disabled = false;
                }
            } else {
                alert(placeN + "の" + day +"は空きがありません！");
                // $('#selectedd').text("");
            }
           
        }
</script>
@extends('layouts.reserlay')
@section('content')
   <div id="sub">
   <!-- <div id="head"><span id="title">〇〇市ワクチン予約サイト</span></div> -->
        <div class="Ssize">
        予約したい場所をクリックすることで、その場所の日毎の空き状況を確認できます。<br>
        ○：余裕あり　△:予約残少　✕:空き無し<br>
        予約したい場所、日付が決定したら<span class="th">「決定」</span>ボタンを押してください。<br>    
    </div>
        <div class="th">今選択している病院:<span id="selected"></span></div>
        <div class="th">今選択している日付:<span id="selectedd"></span></div>
        
        <form action = "/selectTime" method="post">
            <input type="hidden" id="date" name="date" value="value">
            <input type="hidden" id="place" name="place" value="val">
            @if(Session::get('from') != null)
            <input type="hidden" id="preDid" name="prekeyDid" value="{{ $prekeyDid }}">
            <input type="hidden" id="keyres" name="keyres" value="{{ $keyres }}">
            @endif
                @csrf
            <button type="submit" id="button" class="buttoncss" disabled>決定</button>
        </form>
   </div>

    <div class="wrapper">
        <main>
        <table class="table">
            <tr>
                <th>病院名</th> 
                <th>住所</th>
                <!-- <th>日付</th>  -->
            </tr> 
            <tr>
            <nav id="global-nav">
            @foreach($places as $key => $place)
            <tbody>
                <tr class="sub-menu" id="{{ $place->place_id }}" onclick="select('{{ $place->place_name }}','{{ $place->place_id }}')">
                    <td>{{ $place->place_name }}</td>
                    <td>{{ $place->address }}</td>
                    <td>▽</td>
                    <tr class="sub-menu-nav not-active" id="">
                        <td class="th">日付</td>
                        <td class="th">空き状況</td>
                    <td></td>
                    @foreach($resdatas as  $resdata)
                        {{-- @if($resdata->year ==  2022 && $resdata->month == 03) --}}   
                        <!-- <tr> -->
                        @foreach( $resdata as $res)
                        @if($res->place_id == $place->place_id)
                        <tr class="sub-menu-nav res not-active" id="{{ $res->mark }}" onclick="selectt('{{ $res->reservation_date }}','{{ $res->mark }}','{{$res->place_id}}','{{$place->place_name}}')">
                                <!-- <td colspan="2"> -->
                                <div>
                                    
                                     <td>{{ $res->reservation_date }}</td>   
                                     <td>{{ $res->mark }}</td> 
                                     <!-- <td>{{ $res->place_id}}</td> -->
                                     <!-- <td>選択</td>   -->
                                </div>
                                <!-- </td> -->
                        </tr>
                        @endif
                            @endforeach
                        {{-- @endif --}}
                        <!-- </tr> -->
                    @endforeach
    </tr>
                </tr>
            </tbody>
            @endforeach
            </tr>   

        </table>
            
         </main>
@endsection