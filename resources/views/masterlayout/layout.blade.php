<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('image/newlogo.png')}}">
    <meta name="description"
    content="Life & Muisc là website nghe nhạc miễn phí, cập nhập liên tục, mải mê ganh đua theo phù du chẳng lối thoát. Đời trôi đi mãi rồi một ngày mới thấy giấc mơ qua rồi ">
<meta itemprop="description" content="Life & Muisc là website nghe nhạc miễn phí, cập nhập liên tục, mải mê ganh đua theo phù du chẳng lối thoát. Đời trôi đi mãi rồi một ngày mới thấy giấc mơ qua rồi .">
<meta name="twitter:description" content="Life & Muisc là website nghe nhạc miễn phí, cập nhập liên tục, mải mê ganh đua theo phù du chẳng lối thoát. Đời trôi đi mãi rồi một ngày mới thấy giấc mơ qua rồi .">
<meta property="og:type" content="website" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <link rel="stylesheet" href="{{asset("css/login.css")}}">
    <link rel="stylesheet" href="{{asset("css/explore.css")}}">
    <link rel="stylesheet" href="{{asset("css/download.css")}}">
    @yield('meta')
 
</head>
<body>
    @yield('container')
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script>
    const api=JSON.parse('<?php echo json_encode($dbsongAll);?>');
</script>

<script src="{{asset("js/style.js")}}"></script>
<script src="{{asset("js/music.js")}}"></script>
<script src="{{asset("js/login.js")}}"></script>
<script src="{{asset("js/explore.js")}}"></script>
<script src="{{asset("js/download.js")}}"></script>
@yield('js')