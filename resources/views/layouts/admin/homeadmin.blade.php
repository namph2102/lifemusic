@extends('masterlayout.layoutAdmin')
@section('meta')
<link rel="stylesheet" href="{{asset('admin/admincss/admin.css')}}">
@endsection

@section('title')
   Trang Chủ
@endsection
<div class="message">
    @empty(!$message)
        <h6>{{$message}}</h6>
    @endempty
</div>
@section('container')
<div class="direct">
     <a >Trang chủ</a>
</div>

<h1 class="text-center mt-4">Trang Quản lý chung</h1>

<div class="home container">
    <div class="manage--content row w-100">
        <div class="manager--box col-lg-3 col-md-4 col-6">
            <h3 class="manager--title"> Tài khoảng</h3>
            <span class="manager--title"><i class="fa-solid fa-user"></i> {{$totaluser}}</span>
        </div>
        <div class="manager--box col-lg-3 col-md-4 col-6">
            <h3 class="manager--title"> Bài Hát</h3>
            <span class="manager--title"><i class="fa-solid fa-music"></i> {{$totalsong}}</span>
        </div>
        <div class="manager--box col-lg-3 col-md-4 col-6">
            <h3 class="manager--title"> Ca Sĩ</h3>
            <span class="manager--title"><i class="fa-solid fa-user-secret"></i> {{$totalsinger}}</span>
        </div>
        <div class="manager--box col-lg-3 col-md-4 col-6">
            <h3 class="manager--title">Lượt nghe</h3>
            <span class="manager--title"><i class="fa-solid fa-headphones-simple"></i> {{number_format($totallisten)}}</span>
        </div>

    </div>
    <div>
        <canvas id="myChart"></canvas>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $.get('/admin/home',{action:'getvale'},function (datarest) {
        const labels =datarest;
    const chartdata = {
        labels: labels,
        datasets: [{
          label: 'Top Listen',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: {{$listens}},
        }]
      };
    
      const config = {
          type: 'line',
          data: chartdata,
          options: {}
        };
        const myChart = new Chart(
          document.getElementById('myChart'),
          config
        );

        
    })

 
  

        
</script>
@endsection


