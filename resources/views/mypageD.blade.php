<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
    .wrapper {
        height: auto;
        width: 70%;
        /* weight:800px; */
        /* overflow-x: hidden; */

        /* overflow:scroll; */
        /* position: relative; */
        position:fixed;
        left:30%;
        margin-top:20px;
        /* top:250px; */
        /* margin-bottom:50px; */
        }
    .space{
            margin:10px;
        }
    .tred{
        /* background-color:white; */
        color:red;
        display: inline-block;
    }
</style>
@extends('layouts.reserlay')
@section('content')
<div id="sub">
    削除画面
            <div class="Ssize">
            削除する内容に間違いがないことを確認してください。<br>
            間違いがなければ<span class="th">「削除する」</span>をクリックしてください。 <br>
            </div>        
   </div>
    <div class="wrapper">
        <main>
        <div>        
            <form method="post">
                <div class="space">
                    <span class="th">接種券番号:{{ $auths->tickets_number }}
                       
                    </span>
                   
                </div>
                <div class="space">
                   
                    <span class="th">選択している病院:{{ $place }}
                        
                    </span>
                </div>
                <div class="space">
                    <span class="th">選択している日:{{ $date }}  
                        
                    </span>
                </div>
                <div class="space">
                    <span class="th">選択している時間:{{ $time }} 
                       
                    </span>
                </div>
                @csrf
                <input type="hidden" id="Did" name="keyresd" value="{{ $keyDid }}">
                <input type="hidden" id="keyres" name="keyres" value="{{ $keyres }}">
                <button formaction="/delete" type="submit" id="button" class="buttoncss tred">削除する</button>
            </form>    
        </div>
        </main>
@endsection