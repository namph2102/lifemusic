@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
Quản lý Ca sĩ
@endsection

@section('container')
<div class="direct">
    <a href="{{route('users.home')}}">Admin</a> > <a href="{{route("singer.show")}}" >Danh sách bài hát</a>
</div>
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
<div class="singer">
    <button class="btn "><a href="{{route('singer.edit')}}">Thêm ca sĩ</a></button>
    <button class="btn "><a href="{{route('singer.find')}}">Tìm Kiếm ca sĩ</a></button>
</div>
<table class="table text-white table-striped" id="table_singer">
    <thead>
      <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Avata</th>
          <th>Ngày sinh</th>
          <th colspan="2">Operation</th>
         </tr>
    </thead>
     <tbody>
    
         @foreach ($dbsingers as $singer)
         <tr>
         <td>{{$singer->id_singer}}</td>
         <td class="song-title">{{$singer->singer}}</td>
         <td><img src="{{asset('')}}{{$singer->avata}}" alt=""></td>
         <td class="song-fullname text-capitalize">{{date("d/m/Y",strtotime($singer->birthday))}}</td>
         <td><a href="{{route('singer.edit',["action"=>"edit","id"=>$singer->id_singer])}}"><i class="fa-solid fa-pen-to-square"></i></a></td>
         <td><a href="{{route('singer.show',["action"=>"delete","id"=>$singer->id_singer])}}"><i class="fa-solid fa-trash-can"></i></a></td>
          </tr>
         @endforeach
  
     
     </tbody>
  </table>
  <div class="panation">
    {{$dbsingers->links()}}
  </div>
@endsection