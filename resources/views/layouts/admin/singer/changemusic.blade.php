@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
Xử lý bài hát
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

<h1 class="text-center mt-4">Xử lý bài hát</h1>
<form method="POST" action="{{route('song.add')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="@if(!empty($song->song)){{$song->id}}@endif" name="idsong">
    <div class="mb-3">
      <label for="songname" class="form-label">Tên bài hát</label>
      <input type="text" required placeholder="Tên bài hát ..." value="@if(!empty($song->song)){{$song->song}}@endif"  required name="namesong" class="form-control fs-3" required id="songname" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>

    <div class="mb-3">
        <label for="singerdes" class="form-label">Mô tả</label>
        <input placeholder="Ca sĩ tham gia" required type="text" value="@if(!empty($song->song)){{$song->singer}}@endif"  name="des" class="form-control fs-3" required id="singerdes" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
      </div>

      <div class="mb-3">
          <h2>Ảnh poster</h2>
          <img src="{{asset('')}}@if(!empty($song->poster)){{$song->poster}}@endif" @if(empty($song->poster)) hidden @endif alt="">
        <div class="content_upload_img">
            <label for="mypicture">
                <i class="fa-solid fa-cloud-arrow-up image_icon"></i>
                <h4>Upload Icon</h4>
                <img class="uploadimg" src="" alt="" hidden>
            </label>
            <input  type="file"  hidden id="mypicture" name="uploadposter">
        </div>
      </div>

      <div class="mb-3">
        <label for="music" class="form-label">Link nhạc</label>
        <input type="file"  name="linkMusic" id="music">
      </div>

      <div class="mb-3" style="width: 200px;">
        <label for="time" class="form-label">Thời gian phát</label>
        <input  placeholder="4:30"  type="text" value="@if(!empty($song->song)){{$song->time}}@endif" required  name="time" class="form-control fs-3" required id="time" aria-describedby="emailHelp">
        <div id="timess" class="form-text"></div>
      </div>


      <div class="mb-3">
        <h2>Ca sĩ</h2>
      <select style="width: 200px;"  name="singer" required >
        @if(!empty($song->song))<option value="{{$song->id_singer}}">{{$song->singer}} </option> @endif
          @foreach ($dbsingers as $singer)
          <option value="{{$singer->id_singer}}">{{$singer->singer}} </option>
          @endforeach
      </select>
      </div>
      <div class="mt-5">
        @if(!empty($song->song))<button type="submit" name="editsong" value="2" class="btn-danger btn-submitform">Sửa bài hát</button>    @else  <button type="submit" name="addsong" value="2" class="btn-danger btn-submitform">Thêm bài hát</button>@endif
           
        <button type="button"  class="btn-warning btn-submitform"><a href="{{route('users.show')}}">Come Back</a></button>
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
    $$("#music").addEventListener('change',function(e){
       if(!e.target.files[0].name.includes('mp3')){
            e.target.value=""
            alert('Vui lòng up file đúng đạng mp3');
       }
    });
</script>
@endsection
