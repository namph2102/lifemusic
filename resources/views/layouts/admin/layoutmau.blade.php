@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
   Chỉnh sửa tài khoản
@endsection
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
@section('container')
<div class="direct">
    <a href="">Admin</a> > <a >Xử lý Tài khoản</a>
</div>
@endsection