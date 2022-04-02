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


class mypageController extends Controller
{
    public function display(Request $request){
        
        //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

            $keyDid = $request->input('keyresd');//reservation_data_id
            $keyres = $request->input ('keyres');//reserve_id

            // echo $keyres;
        //日時
        $resdata = reservation_data::where('reservation_data_id',$keyDid)->get();
        $date = $resdata[0]['reservation_date'];
        $time = $resdata[0]['reservation_time'];
        //病院名
        $keypl = reservation_data::select('place_id')->where('reservation_data_id',$keyDid)->get();
        // $pl = place::where('place_id',$keypl[0]['place_id'])->get();
        $pl = place::where('place_id',$keypl[0]['place_id'])->get();
        $place = $pl[0]['place_name'];
        $placeid = $pl[0]['place_id'];

        //  ユーザの予約
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

                $rid = reserve::select('reserve_id')->where('reservation_data_id',$residget['reservation_data_id'])->first();
                $reserves[$keynum]['reserve_id'] = $rid['reserve_id'];
                // echo "<br>2" . $reserves[$keynum];
                $keynum++;
            }
            //押されたボタンによってview変える
            if ($request->get('dataget') == 'delete') {
                return view('mypageD',compact('keyDid','date','time','place','auths','reserves','keyres'));
            } else if($request->get('dataget') == 'change'){
                session(['from' => 'change']);
                return view('mypageC',compact('keyDid','date','time','place','placeid','auths','reserves','keyres'));
            }
            
    }
    public function confirm(Request $request){

        $prekeyDid = $request->input('prekeyDid');//変更前のreservation_data_id
        $keyDid = $request->input('Did');//reservation_data_id
        $keyres = $request->input ('keyres');//reserve_id

        // echo "<br>変更前reservation_data_id:" . $prekeyDid;
        // echo "<br>次のreservation_data_id:" . $keyDid;
        // echo "<br>reserve_id:" . $keyres;

        //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

        //変更前の日時
        $preresdata = reservation_data::where('reservation_data_id',$prekeyDid)->get();
        $predata['date'] = $preresdata[0]['reservation_date'];
        $predata['time'] = $preresdata[0]['reservation_time'];
        // //病院名
        $prekeypl = reservation_data::select('place_id')->where('reservation_data_id',$prekeyDid)->get();
        // $pl = place::where('place_id',$keypl[0]['place_id'])->get();
        $pl = place::where('place_id',$prekeypl[0]['place_id'])->get();
        $predata['place'] = $pl[0]['place_name'];
        $predata['placeid'] = $pl[0]['place_id'];



        // echo $predata['date'];
        //変更後の日時
        $resdata = reservation_data::where('reservation_data_id',$keyDid)->get();
        $afterdata['date'] = $resdata[0]['reservation_date'];
        $afterdata['time'] = $resdata[0]['reservation_time'];
        //病院名
        $keypl = reservation_data::select('place_id')->where('reservation_data_id',$keyDid)->get();
        // $pl = place::where('place_id',$keypl[0]['place_id'])->get();
        $pl = place::where('place_id',$keypl[0]['place_id'])->get();
        $afterdata['place'] = $pl[0]['place_name'];
        $afterdata['placeid'] = $pl[0]['place_id'];



        //  ユーザの予約
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

                $rid = reserve::select('reserve_id')->where('reservation_data_id',$residget['reservation_data_id'])->first();
                $reserves[$keynum]['reserve_id'] = $rid['reserve_id'];
                // echo "<br>2" . $reserves[$keynum];
                $keynum++;
            }

        // echo $date;
        // echo "";

        return view('changeConfirm',compact('prekeyDid','keyDid','keyres','afterdata','auths','reserves','predata'));
    }


}
