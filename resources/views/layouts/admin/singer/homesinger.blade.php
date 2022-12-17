@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
  Quản lý bài hát
@endsection

@section('container')
<div class="direct">
    <a href="{{route('users.home')}}">Admin</a> > <a href="{{route("song.show")}}" >Danh sách bài hát</a>
</div>
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
    <h1 class="text-center mt-4">Danh Sách Bài Hát</h2>
<div class="singer">
    <button class="btn "><a href="{{route('song.add')}}">Thêm bài hát</a></button>
    <button class="btn "><a href="{{route('song.find')}}">Tìm Kiếm bài hát</a></button>
</div>
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
@endsection