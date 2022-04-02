<?php

namespace app\Common;

use App\Models\place;
use App\Models\reservation_data;
use App\Models\reserve;
use App\Models\reserve_person;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class gettopClass
{
    public static function gettop()
    {
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
        
    }
}