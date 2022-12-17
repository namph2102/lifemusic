<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('image/newlogo.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @yield('meta')
        <title>@yield('title')</title>
    
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <div class="toggle--icon">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div class="logo">
               <a href="{{route('music.trangchu')}}" target="_blank" rel="noopener noreferrer"> <img src="{{asset('image/logo.png')}}" alt="Music Life"></a>
            </div>
            <nav>
                <div class="sub__nav-title">
                    <div class="nav-item">
                      <a href="{{route('users.home')}}">
                        <i class="fa-solid fa-house"></i>
                        <span class="nav-sub_item">Trang Chủ</span>
                      </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{route('users.show')}}">
                            <i class="fa-solid fa-users"></i>
                          <span class="nav-sub_item">Tài khoản</span>
                        </a>
                      </div>
                      <div class="nav-item">
                        <a href="{{route('song.show')}}">
                            <i class="fa-solid fa-music"></i>
                          <span class="nav-sub_item">Bài Hát</span>
                        </a>
                      </div>
                      <div class="nav-item">
                        <a href="{{route('singer.show')}}">
                            <i class="fa-solid fa-user-secret"></i>
                          <span class="nav-sub_item">Ca Sĩ</span>
                        </a>
                      </div>
                </div>
            </nav>
            
        </div>

        <div class="content">
          @yield('container')
        </div>
    </div>
</body>

<script>
    const $$=document.querySelector.bind(document);
    const $$l=document.querySelector.bind(document);
    const sidebar=$$(".sidebar");
    $$(".toggle--icon").onclick=()=>{
        sidebar.classList.toggle('open');
        if(sidebar.className.includes("open")){
            $$(".toggle--icon").innerHTML=`<i class="fa-solid fa-angle-right"></i>`;
        }else{
            $$(".toggle--icon").innerHTML=`<i class="fa-solid fa-angle-left"></i>`;
        }
    }
</script>
@yield('js')
</html>