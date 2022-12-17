@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
Tìm kiếm  bài hát
@endsection

@section('container')
<div class="direct">
    <a href="{{route('users.home')}}">Admin</a> > <a href="{{route('song.show')}}">Danh sách bài hát</a> > <a >Xử lý bài hát</a> 
</div>
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
<form method="POST" action="{{route('song.find')}}">
    @csrf
    <div class="mb-3">
      <label for="idmusic" class="form-label">Id</label>
      <input type="text"  value=""  name="id" class="form-control fs-3"  id="idmusic" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>

    <div class="mb-3">
        <label for="singder" class="form-label">Tên bài hát</label>
        <input type="text"  value=""  name="song" class="form-control fs-3"  id="singder" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
    </div>

    <div class="mb-3">
        <label for="singder" class="form-label">Người Hát</label>
        <input type="text"  value=""  name="singer" class="form-control fs-3"  id="singder" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
    </div>
  <div class="mt-5">
    <button type="submit" name="findsong" value="2" class="btn-danger btn-submitform">Tìm kiếm Bài hát</button>        
    <button type="button"  class="btn-warning btn-submitform"><a href="{{route('song.show')}}">Come Back</a></button>
  </div>
  </form>
  @if(!empty($dbsongs[0]->song))
  <table class="table text-white table-striped" id="table_singer">
    <thead>
      <tr>
          <th>ID</th>
          <th>Poster</th>
          <th>Tên Bài Hát</th>
          <th>Ca sĩ</th>
          <th colspan="2">Operation</th>
         </tr>
    </thead>
     <tbody>
    
         @foreach ($dbsongs as $song)
         <tr>
         <td>{{$song->id}}</td>
         <td class="song-title">{{$song->song}}</td>
         <td><img src="{{asset('')}}{{$song->poster}}" alt=""></td>
         <td class="song-fullname text-capitalize">{{$song->singer}}</td>
         <td><a href="{{route('song.add',["action"=>"edit","id"=>$song->id])}}"><i class="fa-solid fa-pen-to-square"></i></a></td>
         <td><a href="{{route('song.show',["action"=>"delete","id"=>$song->id])}}"><i class="fa-solid fa-trash-can"></i></a></td>
          </tr>
         @endforeach
  
     
     </tbody>
  </table>
  <div class="panation">
      {{$dbsongs->links()}}
    </div>

@endif
</div>

@endsection