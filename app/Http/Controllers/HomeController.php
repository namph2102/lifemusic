<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;

use function PHPSTORM_META\registerArgumentsSet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function handTime($time)
    {
        $date1 = date("Y-m-d H:i:s");
        $date2 = $time;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        if (!empty($years)) return " $years năm trước";
        if (!empty($months)) return " $months tháng trước";
        if (!empty($days)) return "$days ngày trước";
        if (!empty($hours)) return "$hours giờ trước";
        if (!empty($minutes)) return "$minutes phút trước";
        if (!empty($seconds)) return "$seconds  giây trước";
        if (!$diff) return "Vừa xong";
    }
    public function index()
    {
        $dbase = new ProductModel();
        $dbsongAll = $dbase->getValues('song', 'all', 'listen');
        $dbsongnew = $dbase->getValues('song', 3, 'create_at');
        $dbSingers = $dbase->getArtist('all');
        $dbuser='';
        if(!empty($_COOKIE['username'])){
            $checkusername=DB::table('users')->where('username',$_COOKIE['username'])->exists();
            if($checkusername){
                $dbuser=DB::table('users')->where('username',$_COOKIE['username'])->first();
            }
        }
        $topSong=DB::table('song')->orderByDesc('listen')->first();

        return view('layouts.home', compact('dbsongnew', 'dbsongAll', 'dbSingers','topSong','dbuser'));
    }
    public function form(Request $request)
    {
        $data = [
            'message' => '',
            'status' => 404,
            'messUsername' => '',
            'messPassword' => ''
        ];
        $action = $request->action;
        $username = $request->username;
        $checkuser = DB::table('users')->where('username', $username)->exists();
        if ($action == 'check') {
            if ($checkuser) {
                $data["message"] = "Tài khoản  ''$username'' đã tồn tại !";
            } else {
                $data["message"] = "";
            }
        } else if ($action = 'regester') {
            if (!$checkuser) {
                $password = password_hash($request->password, null);
                DB::table('users')->insert(['username' => $username, 'password' => $password]);
                $data['status'] = 200;
                setcookie("username", $username, time() + (86400 * 30*30), "/");
            } else {
                $data["message"] = "Tài khoản ''$username'' đã tồn tại !";
            }
        }


        return response($data);
    }
    public function login(Request $request)
    {
        $data = [
            'message' => '',
            'status' => 404,
            'messUsername' => '',
            'messPassword' => ''
        ];
        $action = $request->action;
        $username = $request->username;
        $checkuser = DB::table('users')->where('username', $username)->exists();

        if ($action = 'login') {
            $data['message'] = '';
            if (!$checkuser) {
                $data["messUsername"] = "Tài khoản ''$username'' không tồn tại";
            } else {
                $data["messUsername"] = '';
                $dbuser = DB::table('users')->where('username', $username)->first();
                $password = $request->password;
                if (password_verify($password, $dbuser->password)) {
                    $data["messPassword"] = '';
                    $data["status"] = 200;
                    setcookie("username", $username, time() + (86400 * 30*30), "/");
                } else {
                    $data["messPassword"] = 'Mật khẩu không chính xác !';
                }
            }
        }
        return response($data);
    }
    public function uploadimage(Request $request){
        $image=$request->upload;
        if(!empty($_COOKIE['username'])) {
            if($request->action){
                return response(DB::table('users')->where('username',$_COOKIE['username'])->get());
            }
            DB::table('users')->where('username',$_COOKIE['username'])->update(['avata'=>$image]);
        }
        return response($_COOKIE['username']);
    }

    // danh sách phát và lịch sử phát
    public function playlist(Request $request){
        $action = $request->action;
        $id_song=$request->id;
         $checkuser= DB::table('users')->where("username",$_COOKIE['username'])->exists();
       
        if(!empty($_COOKIE['username']) &&  $checkuser) {
            $id_user=DB::table('users')->where("username",$_COOKIE['username'])->first()->id;
            if($action=='getvalue'){
                $dbalbums=DB::table('albums')->where("id_user",$id_user)->get();
                $dbhistory=DB::table('history')->where("id_user",$id_user)->get();
                return response(['dbalbums'=>$dbalbums,'dbhistory'=>$dbhistory]);
            }else if($action=='recent'){
                DB::table('history')->where("id_user",$id_user)->where("id_song",$id_song)->delete();
                DB::table('history')->insert(["id_user"=>$id_user,"id_song"=>$id_song]);
            } else if($action=="add"){
                DB::table('albums')->insert(["id_user"=>$id_user,"id_song"=>$id_song]);
            }else if($action=="delete"){
                DB::table('albums')->where("id_user",$id_user)->where("id_song",$id_song)->delete();
            }
        }
    }

    public function getMusicArtist(Request $request){
        $idSinger=$request->id;
        $dbsongnew =DB::table('song')->where('id_singer',$idSinger)->orderByDesc('create_at')->get();
        $dbase = new ProductModel();
        
        return  response([
         'status'=>200,
         'message'=>"Get List music singer",
         'data'=>$dbsongnew,
         'singer'=>$dbase->getArtist($idSinger)
        ]);
    }
    public function binhluan(Request $request){
        $id_song=$request->id;
        $action=$request->action;

       if($action=="add") {
            $id_user=DB::table('users')->where("username",$_COOKIE['username'])->first()->id;
            $comment=$request->comment;
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $date = date("Y-m-d H:i:s", time());
            DB::table('comment')->insert(['id_song'=>$id_song,"id_user"=> $id_user,"content"=>$comment,"ngaytao"=>$date]);  
        }
        $data=DB::table('comment')
        ->leftJoin('users','users.id','=','comment.id_user')
        ->where('id_song',$id_song)
        ->orderByDesc('ngaytao')
        ->get();
        foreach($data as $user){
            $user->ngaytao=$this->handTime($user->ngaytao);
        }
        return response($data); 
    }
    public function checkuser(Request $request){
        $check=DB::table('users')->where("username",$request->username)->exists();
        return response($check);
    }   


    public function uploadview(Request $request){
        if($request->action=='listen'){
            DB::table('song')->where('id',$request->id)->increment('listen',1);
        }elseif($request->action=='addheart'){
            DB::table('song')->where('id',$request->id)->increment('loves',1);
        }elseif($request->action=='reduceheart'){
            DB::table('song')->where('id',$request->id)->decrement('loves',1);
        }
    }
    public function updatetime(Request $request){
        $idsong=$request->id;
        $time=$request->time;
        DB::table('song')->where('id',$idsong)->update(['time'=>$time]);
    }
    public function logout(){
        setcookie("username", '', time() - (86400 * 30*30), "/");
        return redirect()->back();
    }
    public function chinhsach(){
        return view('masterlayout.chinhsach');
    } 
    public function baomat(){
        return view('masterlayout.baomat');
    } 
    public function changepassword(Request $request){
        $username=trim($request->username);
        $kind=0;
        if(DB::table('users')->where('username',$username)->doesntExist()){
            $kind=1;
        }else if(!password_verify(trim($request->password),DB::table('users')->where('username',$username)->first()->password)){
            $kind=2;
        }else if($request->action){
            $newpassword=password_hash(trim($request->newpassword),null);
            DB::table("users")->where('username',$username)->update(['password'=>$newpassword]);
            $kind=3;
        }
        return response($kind);  
    }
}

