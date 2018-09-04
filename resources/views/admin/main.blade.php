@extends('layouts.admin')

@section('content')

    <section class="section">
      <h1 class="section-header">
        <div>Dashboard</div>
      </h1>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-12">
          <div class="card card-sm-3">
            <div class="card-icon bg-primary">
              <i class="ion ion-person"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Active User</h4>
              </div>
              <div class="card-body">
                {{ $stats['users'] }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="card card-sm-3">
            <div class="card-icon bg-danger">
              <i class="ion ion-ios-paper-outline"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Activities</h4>
              </div>
              <div class="card-body">
                {{ $stats['activities'] }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="card card-sm-3">
            <div class="card-icon bg-warning">
              <i class="ion ion-paper-airplane"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Submission</h4>
              </div>
              <div class="card-body">
                {{ $stats['submissions'] }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="card card-sm-3">
            <div class="card-icon bg-success">
              <i class="ion ion-record"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Forms</h4>
              </div>
              <div class="card-body">
                {{ $stats['forms'] }}
              </div>
            </div>
          </div>
        </div>                  
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Recent User Activities</h4>
            </div>
            <div class="card-body">             
              <ul class="list-unstyled list-unstyled-border">
                @foreach($activities as $data)
                <li class="media">
                  <img class="mr-3 rounded-circle" width="50" src="{{ $data->user->user_img_profile }}" alt="avatar">
                  <div class="media-body">
                    <div class="float-right"><small>{{ $data->created_at }}</small></div>
                    <div class="media-title">{{ $data->user->user_name }}</div>
                    <small>{{ $data->sip_trx_user_logs_desc }}</small>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection

@section('footer')
  <script>
  var ctx = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      datasets: [{
        label: 'Statistics',
        data: [460, 458, 330, 502, 430, 610, 488],
        borderWidth: 2,
        backgroundColor: 'rgb(87,75,144)',
        borderColor: 'rgb(87,75,144)',
        borderWidth: 2.5,
        pointBackgroundColor: '#ffffff',
        pointRadius: 4
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            stepSize: 150
          }
        }],
        xAxes: [{
          gridLines: {
            display: false
          }
        }]
      },
    }
  });
  </script>
@endsection