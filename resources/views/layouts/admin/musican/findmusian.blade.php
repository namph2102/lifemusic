@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
Tìm kiếm ca sĩ
@endsection

@section('container')
<div class="direct">
    <a href="{{route('users.home')}}">Admin</a> > <a href="{{route('singer.show')}}">Danh sách ca sĩ</a> > <a href="{{route('singer.find')}}">Tìm kiếm bài hát</a> 
</div>
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
<form method="POST" action="{{route('singer.find')}}">
    @csrf
    <div class="mb-3">
      <label for="idmusic" class="form-label">Id</label>
      <input type="text"  value=""  name="id" class="form-control fs-3"  id="idmusic" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>

    <div class="mb-3">
        <label for="namesinger" class="form-label">Tên ca sĩ</label>
        <input type="text"  value=""  name="namesinger" class="form-control fs-3"  id="namesinger" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mt-5">
        <button type="submit" name="finsmusian" value="2" class="btn-danger btn-submitform">Tìm kiếm ca sĩ</button>        
        <button type="button" class="btn-warning btn-submitform"><a href="{{route('song.show')}}">Come Back</a></button>
      </div>
  </form>
  @if(!empty($dbsingers[0]->singer))
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


@endif
</div>

@endsection