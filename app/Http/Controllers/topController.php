<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
//use Model
use App\Models\place;
use App\Models\reservation_data;
use App\Models\reserve;
use App\Models\reserve_person;
use Illuminate\Support\Facades\DB;

// use App\Common\gettopClass;

class topController extends Controller
{
     //top
     public function toppage(Request $request){
        //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

        //  予約情報関連
        $places = place::all();
        $now = new Carbon('today');
        $keynum2 = 0;

        //changeから来たか判定
        if(session()->get('from') != null){
            $prekeyDid = $request->input('prekeyDid');
            $keyres = $request->input('keyres');
        } else{
            $prekeyDid = null;
            $keyres = null;
        }
        //login
        if(session()->get('login') == 'login'){
            session()->forget('login');
        }
        
        //判定用など
        $regok = 0;
        // echo $keyDid;
        // gettopClass::gettop();

        foreach($places as $place){
            $key = $place->place_id;
            // echo $key;
            $resdatas[$keynum2] = reservation_data::select('reservation_date')->where('place_id',$key)->whereDate('reservation_date',">=",$now)->distinct()->get();
            // echo $resdatas[$keynum2];
            $keynum = 0;
            foreach($resdatas[$keynum2] as $value){
                //placeid
                
                $resdatas[$keynum2][$keynum]['place_id'] = $key;
                //日付データ関連
                $resdatas[$keynum2][$keynum]['year'] =  date('Y', strtotime($resdatas[$keynum2][$keynum]['reservation_date']));
                $resdatas[$keynum2][$keynum]['month'] =  date('m', strtotime($resdatas[$keynum2][$keynum]['reservation_date']));
                //キャパ計算
                $cap = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('capacity');
                $resdatas[$keynum2][$keynum]['capacity'] = $cap ;
                //予約可能人数計算
                $Reserved = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('reserve_counts');
                $cancel = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('cancel');
                $resdatas[$keynum2][$keynum]['reserve_avail'] = $cap - $Reserved + $cancel;
                //割合
                $resdatas[$keynum2][$keynum]['ratio'] = $Reserved / $cap ;
                //予約6割以上で△
                if($resdatas[$keynum2][$keynum]['ratio'] == 1){
                    $resdatas[$keynum2][$keynum]['mark'] = "✕";
                } else if($resdatas[$keynum2][$keynum]['ratio'] >= 0.6){
                    $resdatas[$keynum2][$keynum]['mark'] = "△";
                } else {
                    $resdatas[$keynum2][$keynum]['mark'] = '○';
                }
                // echo $resdatas[$keynum2][$keynum];
                // echo "<br>";
                $keynum++;
                
            }
            
            $keynum2++;
        }
        
        //  ユーザの予約
        if ( Auth::check() ) {
            // ログイン済みのときの処理
            $residgets = reserve::select('reservation_data_id')->where('users_id',$auths->id)->where('cancel',0)->get();

            $keynum = 0;
            $reserves = null;
            foreach($residgets as $residget){
                $reserves[$keynum] = reservation_data::where('reservation_data_id',$residget['reservation_data_id'])->first();
                //場所の名前
                $pid = $reserves[$keynum]['place_id'];
                // echo $pid;
                // echo "<br><br>1" . $reserves[$keynum];
                $pname = place::where('place_id',$pid)->first();
                $reserves[$keynum]['place_name'] = $pname['place_name'];
                // echo "<br>2" . $reserves[$keynum];
                $rid = reserve::select('reserve_id')->where('reservation_data_id',$residget['reservation_data_id'])->first();
                $reserves[$keynum]['reserve_id'] = $rid['reserve_id'];
                $keynum++;
            }
            
            return view('/top',compact('places','resdatas','auths','reserves','regok','prekeyDid','keyres'));
        } else {
          // ログインしていないときの処理
          return view('/top',compact('places','resdatas','auths','regok','prekeyDid','keyres'));
          }
        
    }

    

}
