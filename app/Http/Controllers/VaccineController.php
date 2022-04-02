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
use App\Models\User;
use Illuminate\Support\Facades\DB;



class VaccineController extends Controller

{
    //新規登録
    public function register(Request $request){
        $return  = $request->input('from');

        $familyNM  = $request->input('familyname');
        $firstNM  = $request->input('firstname');
        $num  = $request->input('number');
        $yaer  = $request->input('yaer');
        $month  = $request->input('month');
        $date  = $request->input('date');
        $mail  = $request->input('mailad');
        $pass  = $request->input('password');
        $rowCount = reserve_person::count();

        DB::table('reserve_people')->insert([
            'Reserve_person_id' => $rowCount+1,
            'tickets_number' => $num,
            'birthday' => $yaer.'-'.$month.'-'.$date,
            'pass' => $pass,
            'email' => $mail,
            'family_name' => $familyNM,
            'first_name' => $firstNM
        ]);
        //まずmodal
        session()->flash('flashmessage','登録完了しました');
        return view("login");
        //
        if($return == "top"){
            return view('top');
        } else {
            $keyReg = "login";
            $misscheck = "✕";
            echo $misscheck;
            return view("login",compact('keyReg','misscheck'));
        } 
    }
    //ログイン
    // public function login(Request $request){
    //     $keyReg = $request->input('obje');
    //     $misscheck = "✕";
    //     return view('/login', compact('keyReg','misscheck'));
    // }
    //新規予約画面へ
    public function newRegister(Request $request){
        $keyReg = $request->input('from');
        return view('/newRegister', compact('keyReg'));
    }

    //DBに入力されたデータがあるかチェック
    public function checkuser(Request $request){
        //認証成功したらcheck変数をtrueに
        $keyReg = $request->input('keyreg');
        $check = false;

        //予約変更でselectplaceに行くときは認証はいらないので飛ばす
        if($keyReg =="change"){
            $check = true;
        }

        //認証
        $Vnum = $request->input('vaccination_num');
        $year = $request->input('year');
        $month = $request->input('month');
        $date = $request->input('date');
        $ymd = $year.'-'.$month.'-'.$date;
        $pas = $request->input('password');

        $item = reserve_person::where('tickets_number',$Vnum)->where('birthday',$ymd)->where('pass',$pas)->first();

        if($item != null){
            $check = true;
            $resPid = $item['Reserve_person_id'];
        }


        if($check){
            if($keyReg == "new"){
            //新規登録からの場合
                $places = place::all();
                return view('vaccine/selectPlace',compact('places','resPid'));
            
            } else if($keyReg == "conf"){
            //予約確認の場合
                //予約情報
                $residgets = reserve::select('reservation_data_id')->where('reserve_person_id',$resPid)->get();
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
                    $keynum++;
                }
                //予約者情報
                $userdata = reserve_person::where('reserve_person_id',$resPid)->first();
                if($reserves == null){
                    $reserves = "notdata";
                }
                return view('/mypage',compact('reserves','userdata'));
            
            } else if ($keyReg == "change"){
                //予約変更の場合
                $places = place::all();
                $resPid = $request->input('Pid');
                return view('vaccine/selectPlace',compact('places','resPid'));
            }
        } else {
            $misscheck ="入力されたデータが間違っています";
            return view("/login",compact('misscheck','keyReg'));
        }
    }

    //場所選択
    // public function place(){    
    //     $places = place::all();
    //     $resPid = 2;
    //     return view('vaccine/selectPlace',compact('places','resPid'));
    // }

    //日選択
    // public function day(Request $request){
    //     $key = $request->input('place');
    //     //渡す値
    //     $resPid = $request->input('Pid');
    //     // $resdatas = reservation_data::where('place_id',$key)->get();
    //     $place = place::select('place_name')->where('place_id',$key)->get();
    //     //現在日時
    //     $now = new Carbon('today');
    //     $resdatas = reservation_data::select('reservation_date')->where('place_id',$key)->whereDate('reservation_date',">=",$now)->distinct()->get();
        
    //     $keynum = 0;
    //     foreach($resdatas as $value){
    //         //placeid
    //         $resdatas[$keynum]['place_id'] = $key;
    //         //日付データ関連
    //         $resdatas[$keynum]['year'] =  date('Y', strtotime($resdatas[$keynum]['reservation_date']));
    //         $resdatas[$keynum]['month'] =  date('m', strtotime($resdatas[$keynum]['reservation_date']));
    //         //キャパ計算
    //         $cap = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('capacity');
    //         $resdatas[$keynum]['capacity'] = $cap ;
    //         //予約可能人数計算
    //         $Reserved = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('reserve_counts');
    //         $cancel = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->sum('cancel');
    //         $resdatas[$keynum]['reserve_avail'] = $cap - $Reserved + $cancel;
    //         //割合
    //         $resdatas[$keynum]['ratio'] = $Reserved / $cap ;
    //         //予約6割以上で△
    //         if($resdatas[$keynum]['ratio'] == 1){
    //             $resdatas[$keynum]['mark'] = "✕";
    //         } else if($resdatas[$keynum]['ratio'] >= 0.6){
    //             $resdatas[$keynum]['mark'] = "△";
    //         } else {
    //             $resdatas[$keynum]['mark'] = '○';
    //         }
    //         $keynum++;
             
    //     }
    //     return view('vaccine/selectDay',compact('resdatas','place','resPid'));
    // }

    //時間選択
    public function Time(Request $request){
        //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

        if(session()->get('login') == null){
            // echo "not login";

            $key = $request->input('place');
            $keyday = $request->input('date');
            $prekeyDid = $request->input('prekeyDid');
            $keyres = $request->input('keyres');
        
        //渡す用
        $pl = place::where('place_id',$key)->get();
        $plac = $pl[0]['place_name'];
    //    echo $plac;
        $place = place::select('place_name')->where('place_id',$key)->get();
        $date =   $keyday; 
        $resdatas = reservation_data::where('reservation_date',$keyday)->where('place_id',$key)->get();
        $resPid = $request->input('Pid');
        
        session(['key' => $key]);
        session(['place' => $plac]);
        session(['date' => $date]);

        //time
        $now = new Carbon('now');
        $keynum = 0;
        if($keyday == $now){
            $resdatas[$keynum]['reservation_time'] = reservation_data::where('reservation_date',$keyday)->where('place_id',$key)->whereDate('reservation_date',">=",$now)->get();
        }

        foreach($resdatas as $value){
            //placeid
            $resdatas[$keynum]['place_id'] = $key;
            //date
            $resdatas[$keynum]['reservation_date'] = $keyday;
            //キャパ計算
            $cap = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('capacity');
            $resdatas[$keynum]['capacity'] = $cap ;
            //予約可能人数計算
            $Reserved = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('reserve_counts');
            $cancel = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('cancel');
            $resdatas[$keynum]['reserve_avail'] = $cap - $Reserved + $cancel;
            $keynum++;   
        }    
        // echo $place;

    } else { //loginから来たら

        // echo "login";
        $key = session()->get('key');
        $keyday = session()->get('date');
        $prekeyDid = null;
        $keyres = null;
        
        //渡す用
        $pl = place::where('place_id',$key)->get();
        // $plac = $pl[0]['place_name'];
        $place = place::select('place_name')->where('place_id',$key)->get();
        $date =   $keyday; 
        $resdatas = reservation_data::where('reservation_date',$keyday)->where('place_id',$key)->get();
        
        
        //time
        $now = new Carbon('now');
        $keynum = 0;
        if($keyday == $now){
            $resdatas[$keynum]['reservation_time'] = reservation_data::where('reservation_date',$keyday)->where('place_id',$key)->whereDate('reservation_date',">=",$now)->get();
        }

        foreach($resdatas as $value){
            //placeid
            $resdatas[$keynum]['place_id'] = $key;
            //date
            $resdatas[$keynum]['reservation_date'] = $keyday;
            //キャパ計算
            $cap = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('capacity');
            $resdatas[$keynum]['capacity'] = $cap ;
            //予約可能人数計算
            $Reserved = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('reserve_counts');
            $cancel = DB::table('reservation_datas')->where('place_id',$key)->where('reservation_date',$value['reservation_date'])->where('reservation_time',$value['reservation_time'])->sum('cancel');
            $resdatas[$keynum]['reserve_avail'] = $cap - $Reserved + $cancel;
            $keynum++;   
        } 
        session()->forget('login');   
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
                 $rid = reserve::select('reserve_id')->where('reservation_data_id',$residget['reservation_data_id'])->first();
                $reserves[$keynum]['reserve_id'] = $rid['reserve_id'];
                // echo "<br>2" . $reserves[$keynum];
                $keynum++;
            }
            
            return view('vaccine/selectTime',compact('place','resdatas','date','auths','reserves','prekeyDid','keyres'));
        } else {
          // ログインしていないときの処理
          return view('vaccine/selectTime',compact('place','resdatas','date','auths','prekeyDid','keyres'));
          }

    }

    //予約確認
    public function confirm(Request $request){

         //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

        if(session()->get('login') == null){
            $keyDid = $request->input('Did');
            session(['keyDid' => $keyDid]);
       
        } else {
            $keyDid = session()->get('keyDid');

        }
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

        session()->forget('login');  

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
                $rid = reserve::select('reserve_id')->where('reservation_data_id',$residget['reservation_data_id'])->first();
                $reserves[$keynum]['reserve_id'] = $rid['reserve_id'];
                // echo "<br>2" . $reserves[$keynum];
                $keynum++;
            }

            return view('reserveConfirm',compact('keyDid','date','time','place','placeid','auths','reserves'));
        } else {

        // return view('reserveConfirm',compact('keyDid','keyPid','Tnum','date','time','place','placeid'));
            return view('reserveConfirm',compact('keyDid','date','time','place','placeid','auths'));
        }
    }

    

    public function resRegister(Request $request){
        //  ユーザ認証関連
            //ログイン情報取得
            $auths = Auth::user();

            //chageじゃないとき
            if(session()->get('from') != null){
                $keyDid = $request->input('keyresd');
                $keyres = $request->input('keyres');
            } else{
                $keyDid = null;
                $keyres = null;
            }

        $reservation_data_id = $request->input('Did');
        $reserve_person_id = $auths->id;
        $rowCount = reserve::count();
        $today = date("Y-m-d");

        DB::table('reserves')->insert([
            'reserve_id' => $rowCount+1,
            'users_id' => $reserve_person_id,
            'reservation_data_id' => $reservation_data_id,
            'created_at' => $today,
            'updated_at' => null,
        ]);
        DB::table('reservation_datas')->where('reservation_data_id',$reservation_data_id)->increment('reserve_counts');
        $regok = 1;

        //  予約情報関連
        $places = place::all();
        $now = new Carbon('today');
        $keynum2 = 0;

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

        //  ユーザの予約 ここは確実にログイン済み
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
            
            return view('/top',compact('places','resdatas','auths','reserves','regok','keyDid','keyres')); 
    }

   
    public function ses_get(Request $request){
        $sesdata = $request->session()->get('msg');
        return view('/session',['session_data' => $sesdata]);
    }

    public function ses_put(Request $request){
        $msg = $request->input;
        $request->session()->put('msg',$msg);
        return redirect('/session');
    }

    public function index(Request $request){
        $user = Auth::user();
        return redirect('/session');
    }

    // //view共通
    public function boot(){
        
    }
}
