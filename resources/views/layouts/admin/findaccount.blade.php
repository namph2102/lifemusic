@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
Tìm kiếm  bài hát
@endsection

@section('container')
<div class="direct">
  <a href="{{route('users.home')}}">Admin</a>><a href="{{route('users.show')}}">Quản lý bài hát</a>><a href="{{route('users.find')}}">Tìm kiếm Tài khoản</a>
</div>
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
<h1 class="text-center mt-4">Tìm Kiếm Theo UserName</h1>
<form method="POST" action="{{route('users.edit')}}">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">UserName</label>
      <input type="text" required value="@if(!empty($username)){{$username}} @endif"  required name="userusername" class="form-control fs-3" required id="exampleInputEmail1" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>
  <div class="mt-5">
    <button type="submit" name="findmember" value="2" class="btn-danger btn-submitform">Tìm kiếm tài khoản</button>        
    <button type="button"  class="btn-warning btn-submitform"><a href="{{route('users.show')}}">Come Back</a></button>
  </div>
  </form>
  @if(!empty($dbuser))

  <table class="table text-white table-striped">
    <thead>
      <tr>
          <th>STT</th>
          <th>UserName</th>
         
          <th>Level</th>
          <th colspan="2">Operation</th>
         </tr>
    </thead>
     <tbody>
       <?php $i=1;?>
         @foreach ($dbuser as $user)
         <tr>
          <td>{{$i++}}</td>
          <td> {{$user->username}}</td>
          <td class="permission"><button class="btn {{$user->level}}">{{$user->level}}</button></td>
          <td><a href="{{route('users.edit',["action"=>"edit","id"=>$user->id])}}"><i class="fa-solid fa-pen-to-square"></i></a></td>
          <td><a href="?action=delete&id={{$user->id}}&username={{$user->username}}"><i class="fa-solid fa-trash-can"></i></a></td>
      </tr>
         @endforeach

     </tbody>
  </table>
  @endif
</div>

@endsection