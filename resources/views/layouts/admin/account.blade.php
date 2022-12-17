@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection
@section('title')
Xử Lý Tài khoản
@endsection
@section('container')
 
<div class="direct">
  <a href="{{route('users.home')}}">Admin</a>><a href="{{route('users.show')}}">Quản lý tài khoản</a>><a href="{{route('users.edit')}}">Xử lý Tài khoản</a>
</div>
<div class="add">
<h1 class="text-center mt-4">Xử Lý Tài khoản</h2>
    <div class="message">
        @empty(!$message)
            <h6>{{$message}}</h6>
        @endempty
</div>
<form method="POST" action="{{route('users.edit')}}">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">UserName</label>
      <input type="text" value="@if(!empty($dbuser->username)){{$dbuser->username}} @endif" minlength="5" required name="userusername" class="form-control fs-3" required id="exampleInputEmail1" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">PassWord</label>
      <input type="password"  minlength="5" name="userpasswork"  class="form-control fs-3" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="">Chức Vụ</label>
        <select name="level" value="@if(!empty($dbuser->username)){{$dbuser->level}}@else member @endif"  class="form-select">
            @if(!empty($dbuser->username))
                @if($dbuser->level=='member')
                <option value="member">Member</option>
                <option value="admin">Admin</option>
                @else
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                
                @endif
            @endif
            @if(empty($dbuser->username))
            <option value="member">Member</option>
            <option value="admin">Admin</option>
         
            @endif
        </select>
    </div>

  <div class="mt-5">
    @if(!empty($dbuser->username))
    <button type="submit" name="change" value="2" class="btn-danger btn-submitform">Chỉnh Sửa</button>        
    @else
    <button type="submit" name="creat" value="2" class="btn-success btn-submitform">Tạo tài khoản</button>
    @endif
 
  
    <button type="button"  class="btn-warning btn-submitform"><a href="{{route('users.show')}}">Come Back</a></button>
  </div>
  </form>
</div>
@endsection