@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
   Chỉnh sửa tài khoản
@endsection

@section('container')
<div class="direct">
    <a href="">Admin</a> > <a >Xử lý ca sĩ</a>
</div>
<h1 class="text-center mt-4">Xử Lý ca sĩ</h2>
    <div class="message">
        @empty(!$message)
            <h6>{{$message}}</h6>
        @endempty
    </div>
<form method="POST" action="{{route('singer.edit')}}" enctype="multipart/form-data">
    @csrf
    <input name="idsinger" type="text" value="@if(!empty($singer->id_singer)){{$singer->id_singer}}@endif" hidden>
    <div class="mb-3">
      <label for="namesinger" class="form-label">Tên ca sĩ</label>
      <input type="text"  value="@if(!empty($singer->singer)){{$singer->singer}} @endif" required  name="namesinger" class="form-control fs-3"  id="namesinger" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>

    <div class="mb-3">
        <label for="ngaysinh" class="form-label">Ngày sinh</label>
        <input type="date"  value="@if(!empty($singer->birthday)){{date("d/m/Y",strtotime($singer->birthday))}} @endif"  name="ngaysinh" class="form-control fs-3"  id="ngaysinh" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">@if(!empty($singer->birthday)){{date("d/m/Y",strtotime($singer->birthday))}} @endif</div>
    </div>

    <div class="mb-3">
        <h2>Ảnh đại diện</h2>
        <img src="{{asset('')}}@if(!empty($singer->avata)){{$singer->avata}}@endif" @if(empty($singer->avata)) hidden @endif alt="">
      <div class="content_upload_img">
          <label for="mypicture">
              <i class="fa-solid fa-cloud-arrow-up image_icon"></i>
              <h4>Upload Icon</h4>
              <img class="uploadimg" src="" alt="" hidden>
          </label>
          <input  type="file"  hidden id="mypicture" name="uploadposter">
      </div>
    </div>
  <div class="mt-5">
    @if(empty($singer->id_singer))
    <button type="submit" name="addsinger" value="2" class="btn-danger btn-submitform">Thêm ca sĩ</button>
    @else 
    <button type="submit" name="editsinger" value="2" class="btn-danger btn-submitform">Thay đổi</button> 
    @endif
          
    <button type="button"  class="btn-warning btn-submitform"><a href="{{route('singer.show')}}">Come Back</a></button>
  </div>
  </form>
@endsection

@section('js')
<script>
      var upload = document.querySelector('#mypicture');
    let content_upload_img = document.querySelector('.content_upload_img .uploadimg');
    let form_products = document.querySelector('.form_create_profile');
    upload.addEventListener('change', function (event) {
        uploadedFile = URL.createObjectURL(this.files[0]);
        if (content_upload_img.src == "") {
            content_upload_img.hidden = false;
            content_upload_img.src = uploadedFile;
        }
        else {
            content_upload_img.hidden = false;
            content_upload_img.src = "";
            content_upload_img.src = uploadedFile;
        }
    })

</script>
@endsection