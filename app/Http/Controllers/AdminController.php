<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

   public function dashboard(Request $request)
   {
      $message = '';
      $totaluser = DB::table('users')->count();
      $totalsinger = DB::table('singer')->count();
      $totalsong = DB::table('song')->count();
      $totallisten = DB::table('song')->sum('listen');
      $data = DB::table('song')->orderByDesc('listen')->limit(6)->get();
      $songs = [];
      $listens = [];
      foreach ($data as $song) {
         $songs[] = $song->song;
         $listens[] = $song->listen;
      }
      if ($request->action) {
         return response($songs);
      }
      $listens = json_encode($listens);
      return view('layouts.admin.homeadmin', compact('message', 'listens', 'totaluser', 'totalsinger', 'totalsong', 'totallisten'));
   }
   public function index(Request $request)
   {
      $message = '';
      if ($request->action) {
         $action = $request->action;
         $id = $request->id;
         if ($action = 'delete') {
            DB::table('users')->where('id', $id)->delete();
            DB::table('comment')->where('id_user', $id)->delete();
            DB::table('albums')->where('id_user', $id)->delete();
            DB::table('history')->where('id_user', $id)->delete();
            $message = 'Xóa thành công username - ' . $request->username;
         }
      }
      $dbuser = DB::table('users')->simplePaginate(6);

      return view('layouts.admin.dashboard', compact('dbuser', 'message'));
   }
   public function formusers(Request $request)
   {
      $kind = 1;
      $dbuser = [];
      $message = '';
      if ($request->findmember) {
         $username = $request->userusername;
         $check = DB::table('users')->where('username', $username)->exists();
         if ($check) {
            $dbuser = DB::table('users')->where('username', $username)->get();
            $message = "Đã tìm thấy  $username !";
         } else {
            $message = "Account  $username không tồn tại !";
         }
         return view('layouts.admin.findaccount', compact('dbuser', 'message', 'username'));
      } else if ($request->change || $request->creat) {
         $username = $request->userusername;
         if ($request->change) {
            if ($request->userpasswork) {
               $password = password_hash($request->userpasswork, null);
               DB::table('users')->where('username', $username)->update(["password" => $password]);
            }
            if ($request->level) {
               $level = $request->level;
               DB::table('users')->where('username', $username)->update(["level" => $level]);
            }
            $message = "Thay đổi account $username thành công";
         } else if ($request->creat) {
            $check = DB::table('users')->where('username', $username)->exists();
            if (!$check) {
               $password = password_hash($request->userpasswork, null);
               DB::table('users')->insert(["username" => $username, "password" => $password]);
               $message = "Tạo tài khoản $username thành công!";
            } else {
               $message = "Tài khoản $username đã tồn tại";
               return view('layouts.admin.account', compact('dbuser', 'message'));
            }
         }

         $dbuser = DB::table('users')->where('username', $username)->first();
      } else if ($request->action) {
         $action = $request->action;
         $id = $request->id;
         if ($action == 'edit') {
            $dbuser = DB::table('users')->where('id', $id)->first();
         }
      }
      return view('layouts.admin.account', compact('dbuser', 'message'));
   }
   public function finduser()
   {
      $message = '';
      $dbuser = '';
      $username = '';
      return view('layouts.admin.findaccount', compact('dbuser', 'message', 'username'));
   }

   // Xử lý song
   public function showsongs(Request $request)
   {
      $message = '';
      if ($request->action) {
         $action = $request->action;
         $id = $request->id;
         if ($action == "delete") {
            $dbsong=DB::table('song')->where('id', $id)->first();
            $this->delefile($dbsong->poster);
            $this->delefile($dbsong->link);
            DB::table('song')->where('id', $id)->delete();
            DB::table('history')->where('id_song', $id)->delete();
            DB::table('comment')->where('id_song', $id)->delete();
            DB::table('albums')->where('id_song', $id)->delete();
            $message = "Xóa thành công bài hát có id =" . $id;
         }
      }

      $dbsongs = DB::table('song')->orderByDesc('create_at')->simplePaginate(4);
      return view('layouts.admin.singer.homesinger', compact('dbsongs', 'message'));
   }
   protected function delefile($link)
   {
      $pathLink = public_path() . "/" . $link;
      if (file_exists($pathLink)) {
         unlink($pathLink);
         return true;
      }
      return false;
   }
   protected function uploadfile($filename, $link = 'uploads/')
   {
      $target_dir = $link;
      $target_file = $target_dir . uniqid() . basename($_FILES[$filename]["name"]);
      if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
         return $target_file;
      } else {
         move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file);
         return $target_file;
      }
   }
   public function formmusic(Request $request)
   {
      $id = '';
      $song = [];
      $message = '';
      if ($request->addsong) {

         if ($request->uploadposter && $request->linkMusic) {
            $namesong = trim($request->namesong);
            $des = trim($request->des);
            $time = trim($request->time);
            $poster = $this->uploadfile("uploadposter");
            $link = $this->uploadfile("linkMusic");
            DB::table('song')->insert(["id_singer" => $request->singer,"time"=>$time,"singer" => $des, "song" => $namesong, "poster" => $poster, "link" => $link]);
            $message = "Thêm thành công bài hát $namesong";
            $song = DB::table('song')->orderByDesc('create_at')->first();
         }
      } else if ($request->editsong) {
         $id = $request->idsong;
         if ($request->uploadposter) {
            $poster = $this->uploadfile("uploadposter");
            $oldposter = DB::table('song')->where('id', $id)->first()->poster;
            $this->delefile($oldposter);
            DB::table('song')->where('id', $id)->update(["poster" => $poster]);
         }
         if ($request->linkMusic) {
            $link = $this->uploadfile("linkMusic");
            $oldlink = DB::table('song')->where('id', $id)->first()->link;
            $this->delefile($oldlink);
            DB::table('song')->where('id', $id)->update(["link" => $link]);
         }
         $namesong = trim($request->namesong);
         $des = trim($request->des);
         $time = trim($request->time);
         DB::table('song')->where('id', $id)->update(["id_singer" => $request->singer,"time"=>$time, "song" => $namesong, "singer" => $des]);
         $message = "Thay đổi thành công $namesong";
      }
      if ($request->action == "edit") {
         $id = $request->id;
      }
      if (!empty($id)) {
         $song = DB::table('song')->where('id', $id)->first();
      }

      $dbsingers = DB::table('singer')->get();
      return view('layouts.admin.singer.changemusic', compact('message', 'dbsingers', 'song'));
   }
   public function songsfind(Request $request)
   {
      $message = '';
      $dbsongs = [];
      if ($request->findsong) {
         if ($request->song) {
            $song = $request->song;
            $dbsongs = DB::table('song')->where('song', "like", "%$song%")->simplePaginate(2);
         } else if ($request->singer) {
            $singer = $request->singer;
            $dbsongs = DB::table('song')->where('singer', 'like', "%$singer%")->simplePaginate(2);
         } else if ($request->id) {
            $dbsongs = DB::table('song')->where('id', $request->id)->simplePaginate(2);
         }
         if (!empty($dbsongs[0]->song)) {
            $message = 'Đã tìm thấy !';
         } else {
            $message = 'Không tìm thấy !';
         }
      }

      return view('layouts.admin.singer.findmusic', compact('message', 'dbsongs'));
   }

   public function singers(Request $request)
   {
      $message = '';
      if ($request->action == 'delete') {
         $id = $request->id;
         $imgssinger = DB::table('singer')->where('id_singer', $id)->first()->avata;
         $this->delefile($imgssinger);
         $listidmusic=DB::table('song')->where('id_singer', $id)->get();
         foreach($listidmusic as $idsong){
            $this->delefile($idsong->link);
            DB::table('comment')->where('id_song', $idsong->id)->delete();
            DB::table('albums')->where('id_song', $idsong->id)->delete();
            DB::table('history')->where('id_song', $idsong->id)->delete();
         }
         DB::table('song')->where('id_singer', $id)->delete();
         DB::table('singer')->where('id_singer', $id)->delete();

         $message = "Xóa thành công ca sĩ có id =" . $id;
      }
      $dbsingers = DB::table("singer")->orderByDesc('ngaytao')->simplePaginate(4);
      return view('layouts.admin.musican.showmusian', compact('message', 'dbsingers'));
   }

   public function singersEdit(Request $request)
   {
      $message = '';
      $singer = '';
      $id = $request->id;
      if ($request->addsinger) {
         if ($request->uploadposter) {
            $name = trim($request->namesinger);
            $ngaysinh = trim($request->ngaysinh);
            $avata = $this->uploadfile('uploadposter');
            DB::table('singer')->insert(['avata' => $avata, 'singer' => $name, 'birthday' => $ngaysinh]);
            $message = "Thêm thành công ca sĩ $name";
            $singer = DB::table('singer')->where('singer', $name)->first();
         }
      } elseif ($request->editsinger) {
         $idsinger = $request->idsinger;
         if ($request->uploadposter) {
            $imgposter = DB::table('singer')->where('id_singer', $idsinger)->get()[0]->avata;
            $this->delefile($imgposter);
            $avata = $this->uploadfile('uploadposter');
            DB::table('singer')->where('id_singer', $idsinger)->update(['avata' => $avata]);
         }
         if ($request->namesinger) {
            DB::table('singer')->where('id_singer', $idsinger)->update(['singer' => trim($request->namesinger)]);
         }
         if ($request->ngaysinh && !empty($request->ngaysinh)) {
            DB::table('singer')->where('id_singer', $idsinger)->update(['birthday'=>$request->ngaysinh]);
         }
         $message = "Thay đổi thông tin thành công";
         $id = $idsinger;
         $singer = DB::table('singer')->where('id_singer', $id)->first();
         // dd($request->all());
      }
      if (!empty($id)) {
         $singer = DB::table('singer')->where('id_singer', $id)->first();
      }
      return view('layouts.admin.musican.editaccount', compact('message', 'singer'));
   }
   public function singersfind(Request $request){
      $message='';
      $dbsingers='';
      if($request->finsmusian){
         if($request->namesinger){
            $namesinger=$request->namesinger;
            $dbsingers=DB::table('singer')->where('singer','like',"%$namesinger%")->get();
         }
         else if($request->id){
            $dbsingers=DB::table('singer')->where('id_singer',$request->id)->get();
         }
         if(!empty($dbsingers[0]->singer)){
            $message="Đã tìm thấy";
         } else  $message="Không tìm thấy";
      }
   
      return view('layouts.admin.musican.findmusian', compact('message', 'dbsingers'));
   }


}
