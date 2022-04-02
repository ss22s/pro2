<!-- 
{{ $predata['date']}}<br>
{{ $predata['time']}} -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
    .wrapper {
        height: 65%;
        width: 80%;
        /* width:auto; */
        /* overflow-x: hidden; */

        overflow:auto;
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
    .left{
        color:blue;
        font-weight:bold;
    }
    .right{
        color:darkorange;
        font-weight:bold;
    }
    #ya{
        text-align:center;
        font-size:4rem;
        margin-top:25%;
    }
    .flex{
        display:flex;
    }
    .flex div{
        width:100%;
    }
    .preth{
        font-weight:bold;
        /* text-align:center; */
        margin-top:3%;
        display: inline-block; 
    }
</style>
@extends('layouts.reserlay')
@section('content')
<div id="sub">
    変更
            <div class="Ssize">
            変更する内容に間違いがないことを確認してください。<br>
            <span class="left">左</span>が変更前である現在の予約情報です。<span class="right">右</span>が変更後のデータです。<br>
            間違いがなければ<span class="th">「<span class="right">変更する</span>」</span>をクリックしてください。 <br>
            新しい予約情報に間違いや変更したい点がある場合はその項目の横にあるボタンをクリックしてください。項目ごとの変更になります。<br>
            </div>        
   </div>
    <div class="wrapper">
        <main>
            <!-- 変更前 -->
            <div class="flex">
                <div class="group">        
                    <span class="left">変更前：</span>
                    <div class="space">
                        <span class="preth">接種券番号:{{ $auths->tickets_number }}
                        
                        </span>
                    
                    </div>
                    <div class="space">
                    
                        <span class="preth">現在予約されている接種場所:{{ $predata['place'] }}
                            
                        </span>
                    </div>
                    <div class="space">
                        <span class="preth">現在予約されている日:{{ $predata['date'] }}  
                            
                        </span>
                    </div>
                    <div class="space">
                        <span class="preth">現在予約されている時間:{{ $predata['time'] }} 
                        
                        </span>
                    </div>
                    @csrf
                    <!-- <input type="hidden" id="Did" name="keyresd" value="{{ $keyDid }}">
                    <input type="hidden" id="keyres" name="keyres" value="{{ $keyres }}">
                    <button formaction="/delete" type="submit" id="button" class="buttoncss tred">削除する</button> -->  
                </div>
                <span id="ya">→</span>
                <!-- 変更後 -->
                <div class="group">
                <form method="post">
                    <span class="right">変更後：</span> 
                        <input type="hidden" name="prekeyDid" value="{{ $prekeyDid }}">
                        <input type="hidden" name="keyres" value="{{ $keyres }}">
                    <div class="space">
                        <span class="th">接種券番号:{{ $auths->tickets_number }} 
                        </span>
                    </div>
                    <div class="space">
                        <span class="th">接種場所:{{ $afterdata['place'] }}
                            <span class="inlineSet">
                            
                                <button formaction="/" type="submit" class="btn">変更する</button>
                            </span>
                        </span>
                        <div class="care">※接種場所を変更すると、日時も選択していただくことになります。</div>
                    </div>
                    <div class="space">
                        <span class="th">選択している日:{{ $afterdata['date'] }}
                            <span class="inlineSet">
                                <input type="hidden" id="place" name="place" value="{{ $afterdata['placeid'] }}">
                                <button formaction="/" type="submit" class="btn">変更する</button>
                            </span>
                        </span>
                        <div class="care">※時間も選択していただくことになります。</div>
                    </div>
                    <div class="space">
                        <span class="th">選択している時間:{{ $afterdata['time'] }}
                            <span class="inlineSet">
                                <input type="hidden" id="date" name="date" value="{{ $afterdata['date'] }}">
                                <button formaction="/selectTime" type="submit" class="btn">変更する</a>
                            </span>
                        </span>
                    </div>
                    @csrf
                    <input type="hidden" id="Did" name="keyresd" value="{{ $keyDid }}">
                    <button formaction="/change" type="submit" id="button" class="buttoncss right">変更する</button>
                </form>
                        
                </div>
            </div>
        </main>
@endsection

