@extends('masterlayout.layout')

@section('meta')
<title>Life & Music</title>
@endsection

@section('container')
<input type="text" value="0" hidden id="userid">
<div class="container__web--music">
    <input type="checkbox" hidden name="" id="menucheck" >
    <menu class="open">
        <div class="menu--brand">
            <img  onclick="openMenuSub(this,0)" class="logo" src="{{asset("image/logo.png")}}" alt="">
        </div>
        <nav>
            <p class="nav--header">MENU</p>
            <ul>
                <li title="Home"><a onclick="openMenuSub(this, 0)" class="menuactive" href="javascript:void(0)">
                        <i class="fa-solid fa-house"></i>
                        <span class="nav--title">Home</span>
                    </a>
                </li>
                <li title="Expolore">
                    <a href="javascript:void(0)" id="explore" class="menuactive" onclick="openMenuSub(this,3)">
                        <i class="fa-regular fa-compass"></i>
                        <span class="nav--title">Explore</span>
                    </a>
                </li>
                <li title="Music">
                    <a class="openMenuSub showonmobile hidden" onclick="openMenuSub(this,0)" href="javascript:void(0)">
                        <i class="fa-solid fa-icons"></i>
                        <span class="nav--title">Music</span>
                    </a>
                </li>
                <li title="Artists">
                    <a class="openMenuSub showonmobile" onclick="openMenuSub(this,1)" href="javascript:void(0)">
                        <i class="fa-solid fa-user-secret"></i>
                        <span class="nav--title">Artists</span>
                    </a>
                </li>
                <li title="Trend">
                    <a class="openMenuSub showonmobile" onclick="openMenuSub(this,2)" href="javascript:void(0)">
                        <i class="fa-solid fa-dumpster-fire"></i>
                        <span class="nav--title">Trend</span>
                    </a>
                </li>
            </ul>
            <p class="nav--header mt-2">LIBRARY</p>
            <ul>
                <li title="Recent">
                    <a href="javascript:void(0)" id="history" class="menuactive" onclick="openMenuSub(this,4)">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span class="nav--title">History</span>
                    </a>
                </li>
                <li title="PlayList">
                    <a href="javascript:void(0)"  id="albmumsss" class="menuactive"  onclick="openMenuSub(this,5)">
                        <i class="fa-solid fa-record-vinyl"></i>
                        <span class="nav--title">Albums</span>
                    </a>
                </li>
                <li title="Downloads">
                    <a  class="menuactive" id="DownLoadapp" href="javascript:void(0)" onclick="openMenuSub(this,6)">
                        <i class="fa-solid fa-download"></i>
                        <span class="nav--title">DownLoad app</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div id="close__menu" class="close__menu--mobile">
            <label for="menucheck">
                <i class="fa-solid fa-xmark"></i>
            </label>
        </div>
    </menu>
    <main>
        <div class="menu--brand__mobile w-100">
            <img class="logo" src="{{asset("image/logo.png")}}" alt="">
        </div>
        <div class="menu--main">
            <div class="menu--main__container row">
                <div class="d-lg-none d-block col-1">
                    <label for="menucheck">
                        <div class="menu-navbar">
                            <i class="fa-solid fa-bars fs-1"></i>
                        </div>
                    </label>
                </div>
                <ul class="list--menu__item col-3 d-lg-flex d-none">
                    <li>
                        <a class="openMenuSub active" onclick="openMenuSub(this,0)">MUSIC</a>
                    </li>
                    <li class="mx-3">
                        <a onclick="openMenuSub(this,1)" id="artists" class="openMenuSub openMenuSub_artists">ARTISTS</a>
                    </li>
                    <li>
                        <a class="openMenuSub" id="trend" onclick="openMenuSub(this,2)">TREND</a>
                    </li>
                </ul>
                <div class="menu--search col-lg-5 col-md-8 col-12 mt-2 mt-md-0  ">
                    <div class="box__search">
                        <input id="search" type="text" placeholder="What do yon want to listen to?">
                        <i onclick="forcusinput()" class="fa-solid fa-magnifying-glass"></i>
                       
                        <span id="speaking" class="ms-2" style="min-width:40px; text-align:center" onclick="openSpeaking()"><i title="Bấm vào đây để nói"  class="fa-solid fa-microphone"></i></span>
                    </div>
                    <div class="result__search hidden">
                        <div class="result__search--key">
                            Tìm kiếm theo ký tự : <code id="result__search">ABC</code>
                        </div>
                        <ul class="list_result__search">
                            {{-- <li>
                                <a class="singer" href="javascript:void(0)">
                                    <img class="singer--poster" src="{{asset("image/lisa.jpg")}}" alt="">
                                    <div class="singer--imf ps-2">
                                        <h3 class="singer--name">Lalisa</h3>
                                        <p class="singer--des">lisa</p>
                                    </div>
                                </a>
                            </li> --}}

                        </ul>
                    </div>
                </div>

                <div class="user--profile  col-lg-3 col-md-3 col-sm-4 col-7">
                    <div class="profile--notice">
                        <div class="main--notice guide__menufirst box__flex-style btn_submenu">
                            <i class="fa-solid fa-shirt"></i>
                            <span class="total--notice">Theme</span>
                            <div class="submenu--settings hidden">
                                <div class="clothes__defaut">
                                    <h5>Default Interface</h5>
                                    <div class="box__clothes">
                                        <div onclick="chagenBgDefault(1)" class="clothes__color bgdefault">

                                        </div>
                                        <div onclick="chagenBgDefault(2)" class="clothes__color bgwhite">

                                        </div>

                                        <div onclick="chagenBgDefault(3)" class="clothes__color bgblue">

                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <h6><code>Change Your Theme</code></h6>
                                        <div class="col-6">
                                            <h6>Menu</h6>
                                            <input style="height: 40px; cursor: pointer;" class="w-100" type="color"
                                                name="" id="menu__color">
                                        </div>
                                        <div class="col-6">
                                            <h6>Background</h6>
                                            <input style="height: 40px; cursor: pointer;" class="w-100" type="color"
                                                name="" id="container__color">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main--settings guide__menufirst box__flex-style btn_submenu">
                            <i class="fa-solid fa-gear"></i>
                            <span class="total--notice">Settings</span>
                            <div class="submenu--settings hidden">
                                <ul>
                                    {{-- <li><a href="javascript:void(0)"> Giới thiệu</a></li>
                                    <li><a href="javascript:void(0)"> Liên hệ</a></li>
                                    <li><a href="javascript:void(0)"> Quảng cáo</a></li> --}}
                                    <li><a target="_blank" rel="noopener noreferrer" href="{{route('chinhsach')}}"> Thỏa thuận sử dụng</a></li>
                                    <li><a target="_blank" rel="noopener noreferrer" href="{{route('baomat')}}"> Chính sách bảo mật</a></li>
                                </ul>
                            </div>
                        </div>
                        <label for="uploadfile" class="main--uploadfile guide__menufirst box__flex-style">
                            <i class="fa-solid fa-image"></i>
                            <span style="min-width: 100px;" class="total--notice">Thay Avata</span>
                      
                            <input  type="file" name="uploadfile" hidden id="uploadfile">
                           
                        </label>
                        <div class="main--profiles guide__menufirst btn_submenu">
                            <img id="avatauser"  src="@if(!empty($dbuser)){{$dbuser->avata}} @else image/newavata.png @endif" alt="">
                            <span id="avatausername" style="min-width: 140px;" class="total--notice"> Profile </span>
                            <div  class="submenu--settings hidden">
                                <ul>
                                  <li id="open-login" class="@if(!empty($dbuser))hidden @endif"><a> Login</a></li>
                                  <li class="open-sign"><a>Regester</a></li>    
                                  <li id="open-changepassword" class="@if(empty($dbuser))hidden @endif"><a> Change Password</a></li>                    
                                <li id="logout"  class="@if(empty($dbuser))hidden @endif"><a onclick="logout()" href="{{route('logout')}}">Logout</a></li>
                                <li class="@if(empty($dbuser && $dbuser->level=='admin')) hidden @endif"><a rel="noopener noreferrer" target="_blank"  href="{{route('users.home')}}">Admin</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <article class="mt-lg-0 mt-2" id="container__all">
            {{-- <audio controls src="/public/uploads/3.mp3"></audio> --}}
            <div id="music__container" class="menu__leftsearch">
                <div class="singer__background" style="background-image:url({{asset("image/singer.png)")}}">
                </div>
                <div class="d-inline-block">
                    <p class="fs-6">Treding</p>
                    <h2 class="singer-name">{{$topSong->singer}}</h2>
                    <p class="fs-6">{{$topSong->song}}</p>
                </div>
                <div class="music--box__header">
                    <button id="playmain_home" data-id="{{$topSong->id}}" class="btn-play">Play Now <i
                            class="ms-2 fa-solid fa-play"></i></button>
                    <button class="btn-add" onclick="getplaylist(1,this)"><i class="fa-solid fa-plus"></i></button>
                </div>
                <div class="music--topchart music--Billboard mt-4">
                    <div class="music--topchart__head">
                        <h2>New Release </h2>
                        <p><span style="cursor: pointer;" onclick="openMenuSub(this,2)" >See All</span></p>
                    </div>
                    <div class="list--topchart_singer">
                        @foreach($dbsongnew as $song)
                        <a onclick="musicplayClick({{$song->id}}),toastMessage('Phát bài hát {{$song->song}}');" class="topchart_singer--box">
                            <span class="brand"></span>
                            <img src="{{$song->poster}}" alt="">
                            <p class="singer--name">{{$song->song}}</p>
                            <p class="singer--des">{{$song->singer}}</p>
                        </a>
                        
                        @endforeach
                    </div>
                </div>
                <div class="music--topchart mt-4" id="music--artist">
                    <div class="music--topchart__head">
                        <h2>Top Artists</h2>
                        <p><span  onclick="openMenuSub(this,1)" style="cursor: pointer;" >See All</span></p>
                    </div>
                    <div class="row ">
                        <?php 
                            $dem=0;
function makeupNumber($number){
    if ($number >= 1000000) {
        return round($number / 1000000,1)."M";
    } else if ($number >= 1000) {
        return round($number / 1000,1)."K";
    }   
    return $number;
                         }
                            ?>
                        @foreach ($dbSingers as $singer)
                        <?php $dem++;?>
                        <a onclick="getListAblums({{$singer->id_singer}})" class="topchart_singer--box col-lg-3 col-xl-2 col-md-3 col-4 <?php echo ($dem>6)?"hidden":"";?>">
                            <img src="{{$singer->avata}}" alt="">
                            <p class="singer--name">{{$singer->singer}}</p>
                            <p class="singer--des">{{makeupNumber($singer->totalListen)}} player</p>
                        </a>
                        @endforeach
                       
                        {{-- <a onclick="getListAblums(3)" class="topchart_singer--box col-lg-3 col-xl-2 col-md-3 col-4">
                            <img src="{{asset("image/lisa.jpg")}}" alt="">
                            <p class="singer--name">Lisa</p>
                            <p class="singer--des">8.5M player</p>
                        </a> --}}
                      
                    </div>
                </div>
            </div>
            <div id="id_astists" class="menu__leftsearch hidden">
                <!-- getListAblums(idsinger) -->
                <div class="row">
                    <?php $dem=0;?>
                    @foreach ($dbSingers as $singer)
                    <?php $dem++;?>

                    <div class="col-xl-3 col-md-4 col-6 <?php echo ($dem>16)?"hidden":"";?>" onclick="getListAblums({{$singer->id_singer}})">
                        <div class="box_astist">
                            <img src="{{$singer->avata}}" alt="">
                            <div class="artists__des">
                                <h2 class="artists__des--singer">{{$singer->singer}}</h2>
                                <p class="artists__des--song__des">{{makeupNumber($singer->totalListen)}} player</p>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach

                    
                </div>
            </div>
            <div id="id_trends" class="menu__leftsearch hidden">
                <h1 class="fs-4"># Top 10 HOT TREND</h1>
                <!-- musicArtists(Element,id,index) -->
                {{-- <div class="playlists" data-id="1">
                    <div class="playlist--box__item d-flex-align-center-justify-between">
                        <div onclick="musicplayClick(1)"
                            class="playlist__singer d-flex-align-center-justify-between">
                            <div class="playlist__song-rank">1</div>
                            <div class="playlists__avata">
                                <img src="{{asset("image/lisa.jpg")}}" alt="">
                                <div class="playlists__avata--wave">
                                    <div class="playlists__avata--pause">
                                        <i class="fa-solid fa-play"></i>
                                    </div>
                                    <div class="playlists__avata--playing hidden">
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                        <div class="bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h2 class="playlist__singer-song m-0">Wasdasdasdsating for you</h2>
                                <p class="playlist__singer-name m-0">Lissadsadsasdaa</p>
                            </div>
                        </div>
                    </div>
                    <div class="playlist__singer-time">
                        4:30
                    </div>
                    <div class="playlist__controller d-flex-align-center-justify-between">
                        <div class="playlist__heart me-2">
                            <i class="fa-regular fa-heart"></i>
                            <i class="fa-solid fa-heart text-danger hidden"></i>
                        </div>
                        <div class="playlist__option">
                            <i class="fa-solid fa-ellipsis"></i>
                            <div class="playlist__option-box">
                                <div class="option_box-song">
                                    <div>
                                        <img src="{{asset("image/lisa.jpg")}}" alt="">
                                    </div>
                                    <div>
                                        <h3 class="fs-6">Quân Hữu Vận</h3>
                                        <div class="fs-6">
                                            <i class="fa-regular fa-heart"></i>
                                            <span class="total_heart me-2">34k</span>
                                            <i class="fa-solid fa-headphones"></i>
                                            <span class="total_heart">2.6M</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="option_box--controller">
                                    <ul>
                                        <li>
                                            <a href="" download>
                                                <i class="fa-solid fa-download"></i>
                                                Tải xuống
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <i class="fa-solid fa-play"></i>
                                                Phát
                                            </a>
                                        </li>
                                        <li onclick="getplaylist(3)">
                                            <a>
                                                <i class="fa-solid fa-plus"></i>
                                                Thêm vào playlist
                                            </a>
                                        </li>
                                        <li onclick="getbinhluan(1)">
                                            <a>
                                                <i class="fa-solid fa-comment"></i>
                                                Bình Luận
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
               
            </div>
            <div id="sub_astists" class="row hidden">
                <div class="col-xl-3 col-12">
                    <div
                        class="sub_astists-header d-xl-block d-sm-flex d-block text-xl-center text-sm-left text-center align-xl-center">
                        <div>
                            <img class="sub_astists--avata" src="{{asset("image/lisa.jpg")}}" alt="">
                        </div>
                        <div class="sub_astists-singer_des">
                            <h3 class="m-0 singer_des--fullname">Lisa</h3>
                            <p class="singer_des--subtitle m-0">Date: <span>21/02/2002</span> </p>
                            <div class="total_follows m-0"><i class="fa-solid fa-headphones-simple me-1"></i> <span>12000</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-12 mt-4 mt-xl-0 sub_astists-_list__music">
                 
                    
                </div>
            </div>
            <!-- Code phần container ở đoạn này nha ! -->
            <div id="box-explore" class="box-expl  menu__leftsearch hidden">
                <div class="first-page">
                    <div class="box-heart" onclick="getListAblums(3)" title="Danh sách nhạc">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="content">
                        <div class="title-1">Favorite of Heart</div>
                        <div class="title-2">Album songs</div>
                        <div class="user">
                            <img src="@if(!empty($dbuser)){{$dbuser->avata}}@else{{asset("image/lisa.jpg")}}@endif" alt="">
                            <span>@if(!empty($dbuser)){{$dbuser->username}}@else Lisa @endif</span>
                           
                        </div>
                    </div>
                </div>
                <div class="second-page" id="content-page-explore">
                    <div class="content" id="in-content-explore">
                        <div class="icon"><i class="fas fa-music"></i></div>
                        <div class="box-title">
                            <div class="title-1">Songs you like will appear here</div>
                            <div class="title-2">Save songs by tapping the heart icon</div>
                        </div>
                        <div class="button-find">
                            <button id="find-song">Find songs</button>
                        </div>
                    </div>
                    <div id="subexplore" class="subexplore__container hidden">
                        <div class="header-explore">
                            <h1 class="recent_playlist-title title-explore">Find Song</h1>
                            <div class="search">
                                <input id="explore_search" type="text" placeholder="Nhập tên bài hát, nghệ sĩ ">
                                <button id="explore_search--btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="explore__container">
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần recent và playlist  đừng đụng vào cái này-->
            <div id="recent_playlist" class="menu__leftsearch hidden">
                <h1 class="recent_playlist--title"># History</h1>
                <div class="recent__playlist--container">
                
                </div>  
            </div>
            <!-- Phần Download (Trương Tươc Phi) -->
            <div id="download-page" class="page-download hidden">
                <div id="page-no-list">
                    <div class="icon-download">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="content-download">
                        <h3 class="title">Let’s To My App</h3>
                        <p class="content">Sorry My App not compelete</p>
                    </div>
                    <div onclick="toastMessage(`App chưa hoàn thành !`)" class="button-find-download">
                        <button id="find-song-download"><a class="text-white" href="javascript:void(0)">Download Here</a></button>
                    </div>
                </div>
                <div id="list-download" class="page-list-download hidden">
                    <div class="box-header">
                        <div class="in-header">
                            <div class="picture-music-download">
                                <img src="" alt="">
                            </div>
                            <div class="box-title-download">
                                <p class="title-dl">MY PLAYLIST</p>
                                <h3 class="main-title">Dowload playlist</h3>
                                <div class="user">
                                    <img src="" alt="">
                                    <span class="name-user">Adree</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End ! -->
            <div id="footer_container">

            </div>
        </article>
       
    </main>
</div>
<div id="modal__comment" data-des="Modal" class="hidden">
</div>
<div class="modal__comment-container hidden">
    <div class="modal__comment--close" onclick="close_comment()">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <h2>Bình Luận</h2>
    <hr>
    <div class="list__user">
        <ul>
            <li>
                <div>
                    <img src="{{asset("image/lisa.jpg")}}" alt="">
                </div>
                <div class="user__comment-ifm">
                    <div>
                        <user-name>hoài Name</user-name> . <user-time>1 giờ trước</user-time>
                    </div>
                    <p class="user-content">Bài dasdsa asdnasdnasd sdandnsa asdnnasd asdnnasd asndnasdn nsdandsa
                        nasdndsa nasdndnas nasnasdn nasdnasdn nsadnasdn nasdnsdan nasndsanasd nasdnsahát hay quá</p>
                </div>
            </li>
        </ul>
        <div class="conments__container__submit" onsubmit="return false" method="POST" id="form__chatting">
            <p class="text-danger text-center warning_chatting col-12 pt-1 fs-6 hidden"><a
                    href="#form__chatting_direct" onclick="openElement(this,'#form__login')" class="fw-bold fs-5"
                    style="text-decoration: none; cursor: pointer;" rel="noopener noreferrer"><em>Đăng nhập</em></a>
                để bình luận bình luận...!</p>
            <input class="chating" name="comments" id="chatting"  rows="1" maxlength="101"
                placeholder="Viết bình luận...">
            <button type="submit" id="btn_Binhluan" class="btn btn-success" onclick=""><i
                    class="fa-solid fa-share pe-1"></i>Gửi</button>
        </div>
    </div>
</div>
<div id="music__player">
    <div class="row music__player--container mx-sm-0 mx-3">
        <div class="col-md-3 col-0 d-md-block d-none">
            <div class="song__ifm" id="song__ifm">
                <img class="playing" src="{{asset("image/lisa.jpg")}}" alt="">
                <div>
                    <marquee behavior="" direction="">Cứ Child thôi</marquee>
                    <p class="song--des m-0">Chillies, Suni Hạ Linh, Rhymastic
                    </p>
                </div>

            </div>
        </div>
        <div class="col-md-6 col-12 player__control--container">
            <div class="player__control-btn">
                <div class="control-btn btn_repeat" title="Phát Lại">
                    <i class="fa-solid fa-repeat"></i>
                </div>
                <div class="control-btn preSong" title="Bài Hát Trước">
                    <i class="fa-solid fa-backward-step"></i>
                </div>
                <div id="btn_playing" class="control-btn btn-play">
                    <i class="fa-solid fa-circle-play"></i>
                </div>
                <div class="control-btn nextSong" title="Bài Hát Kế Tiếp">
                    <i class="fa-solid fa-forward-step"></i>
                </div>
                <div class="control-btn btn_random" title="Phát Ngẫu Nhiên">
                    <i class="fa-solid fa-shuffle"></i>
                </div>
            </div>
            <div class="progress-block">
                <span class="time__current">00:00</span>
                <audio  preload="metadata" id="audio" src="{{asset("uploads/1.mp3")}}"  type="audio/mp3">
                   
                </audio>
              
                <div class="sub_progress">
                    <div class="slide__sub_progress"></div>
                </div>
                <div class="main__progress">
                    <div class="progress-block--timestamp">
                        09:04
                    </div>
                  
                    <input  value="0" type="range"  min="0" max="100"  id="progress-range" class="progress-range">
                </div>
                <span class="time__duration">02:00</span>
            </div>
        </div>
        <div class="col-0 col-md-3 progress-volume d-md-flex d-none">
            <span class="change__kindof--volumn me-2"><i class="fa-solid fa-volume-high"></i> </span>
            <input value="1" type="range" id="range__volume" min="0" max="1" step="0.01">
            <div class="box_process--volume">
                <div class="sub_process--volume"></div>
            </div>
        </div>
    </div>
</div>
<div id="bg-login" class="hidden">
    <!-- Phần Login (Trương Tước Phi) -->
    <div id="show-from">
        <form action="" id="form-login">
            <div class="btn-closer" id="close"><i class="fa-solid fa-xmark"></i></div>
            <div class="title-box">Login</div>
            <div class="element-form">
                <label for="account">Username</label>
                <input class="form__input" data-name="username" value="@if(!empty($dbuser)){{$dbuser->username}} @endif" type="text" id="account" name="" placeholder="Username">
                <div class="error noti-error"></div>
            </div>
            <div class="element-form">
                <label for="password">Password</label>
                <input  class="form__input" data-name="password" type="password" id="password" name="" placeholder="Password">
                <div class="error noti-error"></div>
            </div>
            <div class="element-form">
                <a href="">Forgot your password?</a>
            </div>
            <div class="element-form style-btn-login">
                <div class="box-remember">
                    <input type="checkbox" name="" id="remember1">
                    <label for="remember">Remember me</label>
                </div>
                <div class="btn-login">
                    <button type="submit">Log in</button>
                </div>
            </div>
            <div class="element-or">
                <span>or</span>
            </div>
            <div class="oder-login">
                <div class="btn-order-log" onclick="toastMessage(`Chức năng đang phát triển`)">
                    <div> <i class="fa-brands fa-square-facebook"></i></div>
                    <div class="content">Continue with Facebook</div>
                </div>
                <div class="btn-order-log" onclick="toastMessage(`Chức năng đang phát triển`)">
                    <div><i class="fa-brands fa-apple"></i></div>
                    <div class="content">Continue with Apple</div>
                </div>
                <div class="btn-order-log" onclick="toastMessage(`Chức năng đang phát triển`)">
                    <div><i class="fa-brands fa-google"></i></div>
                    <div class="content">Continue with Google</div>
                </div>
            </div>
            <div class="atc-sign">
                <div class="title">Don't have an account?</div>
                <button type="button" id="switch-sign">Sign up for Life & music</button>
            </div>
        </form>
        <!-- Hết Phần Login -->
        <form action="" id="form-sign">
            <div class="btn-closer" id="close-sign"><i class="fa-solid fa-xmark"></i></div>
            <div class="title-box">Sign in</div>
            <div class="element-form">
                <label for="account">Username</label>
                <input class="form__input" data-name="username" type="text" id="account-1" name="" placeholder="Username">
                <div class="error noti-error"></div>
            </div>
            <div class="element-form">
                <label for="password">Password</label>
                <input class="form__input" data-name="password" type="password" id="password-1" name="" placeholder="Password">
                <div class="error noti-error"></div>
            </div>
            <div class="element-form">
                <label for="password">Confirm password</label>
                <input class="form__input" data-name="comfirm password"   type="password" id="password-2" name="" placeholder="Confirm password">
                <div class="error noti-error"></div>
            </div>
            <!-- <div class="element-form">
                <a href="">Forgot your password?</a>
            </div> -->
            <div class="element-form style-btn-login">
                <div class="box-remember">
                    <input type="checkbox" name="" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <div class="btn-login">
                    <button type="submit" class="open-sign">Sign in</button>
                </div>
            </div>
            <div class="element-or">
                <span>or</span>
            </div>
            <div class="oder-login order-sign">
                <div onclick="toastMessage(`Chức năng đang phát triển`)" class="btn-order-log backgrond-oder-sing">
                    <div> <i class="fa-brands fa-square-facebook"></i></div>
                    <!-- <div class="content">Continue with Facebook</div> -->
                </div>
                <div onclick="toastMessage(`Chức năng đang phát triển`)" class="btn-order-log backgrond-oder-sing">
                    <div><i class="fa-brands fa-apple"></i></div>
                    <!-- <div class="content">Continue with Apple</div> -->
                </div>
                <div onclick="toastMessage(`Chức năng đang phát triển`)" class="btn-order-log backgrond-oder-sing">
                    <div><i class="fa-brands fa-google"></i></div>
                    <!-- <div class="content">Continue with Google</div> -->
                </div>
            </div>
            <div class="atc-sign">
                <div class="title">Have an account</div>
                <button type="button" id="switch-log">login for Life & music</button>
            </div>
        </form>
        <!-- Phần sign in -->

        <!--đổi mât khảu-->
      
    </div>
</div>

<div class="bg-changepasswork hidden">
  
    <form  id="form-changepass">
        <div class="btn-closer" onclick="closeChangepassword()" id="close-password"><i class="fa-solid fa-xmark"></i></div>
        <div class="title-box">Change Password</div>
        <div class="element-form">
            <label for="account">Username</label>
            <input class="form__input" id="changepassUser" value="@if(!empty($dbuser)){{trim($dbuser->username)}}@endif" data-name="username" type="text"  name="" placeholder="Username">
            <div class="error noti-error"></div>
        </div>
        <div class="element-form">
            <label for="password">Password</label>
            <input  id="change_password" data-name="password" type="password"  name="" placeholder="Password">
            <div class="error noti-error" id="error__pas"></div>
        </div>
        <div class="element-form">
            <label  for="password">New Password</label>
            <input class="form__input" id="change_newpassword" data-name="new password" type="password"  name="" placeholder="New password">
            <div class="error noti-error" id="error__newpass"></div>
        </div>
        <div class="element-form style-btn-chanepassword mt-4">
            <div class="btn-login">
                <button type="button" class="open-changepassword">Change</button>
            </div>
        </div>
    </form>
</div>
<div id="toast">
    <!-- <div class="toast__container active">
        <span class="toast__notice">Thêm vào thư viện thành công</span> <button onclick="closeElement('#toast','active')" class="btn text-white">X</button>
    </div> -->
</div>


@endsection

@section('js')
    
@endsection