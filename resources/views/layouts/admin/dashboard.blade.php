@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection
@section('title')
    Trang Chủ
@endsection

@section('container')

        <div class="direct">
            <a href="{{route('users.home')}}">Admin</a>><a href="{{route('users.show')}}">Quản lý tài khoản</a>
        </div>
            <h1 class="text-center mt-4">Danh Sách Tài khoản</h1>
        <div class="account">
            <button class="btn "><a href="{{route('users.edit')}}">Thêm tài khoản</a></button>
            <button class="btn "><a href="{{route('users.find')}}">Tìm Kiếm tài khoản</a></button>
        </div>
        <div class="message">
                @empty(!$message)
                    <h6>{{$message}}</h6>
                @endempty
        </div>
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
      
      <div class="panation">
        {{$dbuser->links()}}
      </div>
@endsection
