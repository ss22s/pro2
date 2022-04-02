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
            margin:20px;
        }
    .tred{
        /* background-color:white; */
        color:red;
        display: inline-block;
    }
    .care{
        font-weight:bold;
        text-decoration:wavy underline red;
        font-size:0.7rem;
        margin-left:10px;
        /* margin-bottom:10px; */
    }
</style>
@extends('layouts.reserlay')
@section('content')
<div id="sub">
    予約変更画面
            <div class="Ssize">
            変更したい予約であることを確認してください。<br>
            変更したい項目の横にある<span class="th">「変更する」</span>をクリックしてください。 <br>
            </div>        
   </div>
    <div class="wrapper">
        <main>
        <div>        
            
        <form method="post">
                <div class="space">
                    @auth
                    <span class="th">接種券番号:{{ $auths->tickets_number }} 
                        <!-- <input type="hidden" class="Pid" name="Pid" value="value"> -->
                    </span>
                    @endauth
                </div>
                <input type="hidden" id="Did" name="prekeyDid" value="{{ $keyDid }}">
                <input type="hidden" id="keyres" name="keyres" value="{{ $keyres }}">

                <div class="space">
                   
                    <span class="th">選択している病院:{{ $place }}
                        <span class="inlineSet">
                            <input type="hidden" name="keyreg" value="change">
                            <button formaction="/" type="submit" class="btn">変更する</button>
                        </span>
                    </span>
                    <div class="care">※接種場所を変更すると、日時も選択していただくことになります。</div>
                </div>
                <div class="space">
                    <span class="th">選択している日:{{ $date }}  
                        <span class="inlineSet">
                            <input type="hidden" id="place" name="place" value="{{$placeid}}">
                            <button formaction="/" type="submit" class="btn">変更する</button>
                        </span>
                    </span>
                    <div class="care">※時間も選択していただくことになります。</div>
                </div>
                <div class="space">
                    <span class="th">選択している時間:{{ $time }} 
                        <span class="inlineSet">
                            <input type="hidden" id="date" name="date" value="{{$date}}">
                            <button formaction="/selectTime" type="submit" class="btn">変更する</a>
                        </span>
                    </span>
                </div>
                @csrf               

            </form>    
        </div>
        </main>
@endsection