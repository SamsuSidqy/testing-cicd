@extends('layout.dashboard')
@section('section_dashboard')
<main>
   <div class='container-fluid'>
      <div class="row">
         <div class="col-md-5 col-lg-5 col-xxl-3 order--3-lg">
            <div class="card education-profile-card">
               <div class="card-body">
                  <div class="profile-header">
                     <h5 class="header-title-text">Profile</h5>
                  </div>
                  <div class="profile-top-content mt-lg-5">
                     <div class="h-80 w-80 d-flex-center b-r-50 overflow-hidden bg-secondary">
                        <img src="/wp-content/profile/{{auth()->user()->profile}}" alt="" class="img-fluid">
                     </div>
                     <h6 class="text-dark f-w-600 mb-0">{{auth()->user()->name}}</h6>
                     <p class="text-secondary f-s-13 mb-0">{{auth()->user()->email}}</p>
                     <div class="mb-5">
                        <a data-bs-toggle="modal" data-bs-target="#updateProfile" role="button" class="btn btn-light-secondary">Change Profile</a>
                     </div>                     
                  </div>
                  <div class="profile-content-box">
                     <div class="profile-details"
                     onclick="window.location.href='{{auth()->user()->linkedln}}'" 
                     >
                        <p class="f-s-18 mb-0"><i class="ph-bold  ph-linkedin-logo"></i></p>
                        <span class="badge text-light-primary"></span>
                     </div>
                     <div class="profile-details"
                     onclick="window.location.href='{{auth()->user()->facebook}}'" 
                     >
                        <p class="f-s-18 mb-0"><i class="ph-fill  ph-facebook-logo"></i></p>
                        <span class="badge text-light-secondary"></span>
                     </div>
                     <div class="profile-details"
                     onclick="window.location.href='{{auth()->user()->whatsaap}}'" 
                     >
                        <p class="f-s-18 mb-0"><i class="ph-bold  ph-whatsapp-logo"></i></p>
                        <span class="badge text-light-success"></span>
                     </div>
                     <div class="profile-details"
                     onclick="window.location.href='{{auth()->user()->twitter}}'" 
                     >
                        <p class="f-s-18 mb-0"><i class="ph-fill  ph-twitter-logo"></i></p>
                        <span class="badge text-light-info"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7 col-lg-7 col-xxl-4 order--3-lg">
            <div class="row">
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-success">
                     <div class="card-body">
                        <i class="ph-duotone  ph-calendar-check icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-duotone  ph-calendar-check text-success f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$task_complete}}</h4>
                           <p class="f-w-500 mb-0">Task Completed</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-warning">
                     <div class="card-body">
                        <i class="ph-duotone  ph-hand-coins icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-duotone  ph-hand-coins text-dark f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$task_progress}}</h4>
                           <p class="f-w-500 mb-0">Task Progress</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-info">
                     <div class="card-body">
                        <i class="ph-bold  ph-briefcase icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-bold  ph-briefcase text-info f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$total_task}}</h4>
                           <p class="f-w-500 mb-0">Total Tasks</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-info">
                     <div class="card-body">
                        <i class="ph-bold  ph-projector-screen-chart icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-bold  ph-projector-screen-chart text-info f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$total_project}}</h4>
                           <p class="f-w-500 mb-0">Total Projek</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-danger">
                     <div class="card-body">
                        <i class="ph-fill  ph-warning-octagon icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-fill  ph-warning-octagon text-danger f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$task_priority}}</h4>
                           <p class="f-w-500 mb-0">Tasks Priority</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="card courses-cards card-dark">
                     <div class="card-body">
                        <i class="ph-bold  ph-clock-countdown icon-bg"></i>
                        <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                        <i class="ph-bold  ph-clock-countdown text-dark text-dark f-s-24"></i>
                        </span>
                        <div class="mt-5">
                           <h4>{{$task_terlambat}}</h4>
                           <p class="f-w-500 mb-0">Task Terlambat</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>


         </div>                
         
                        
      </div>

      <!-- Chart -->
      <div class="row chart-js-chart">

         <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5>Tren Tasks Complete</h5>
              @php
              use Carbon\Carbon;

              // Mendapatkan tahun sekarang
              $years = collect(range(0, 3))->map(function ($year) {
                return Carbon::now()->subYears($year)->year;
              });
              @endphp
              <form method="GET" action="{{route('auth.dashboard')}}" id="formTask">
              <select name="tsk" onchange="document.getElementById('formTask').submit()" 
              id="trenTask" class="form-select 
              @if(request()->has('tsk'))
              border-primary 
              @endif              
              my-3" aria-label="Default">               

             @foreach($years as $thn)
                <option value="{{$thn}}" 
                        @if(request()->get('tsk') == $thn) selected @endif>
                    {{$thn}}
                </option>
             @endforeach


             </select>
               </form>
           </div>
           <div class="card-body">
               <canvas id="taskComplete" width="48" height="24" style="display: block; box-sizing: border-box; height: 24px; width: 48px;"></canvas>
           </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5>Trend Project</h5>
              <form id="pjkform" method="GET">
               @if(request()->has('tsk'))
               <input type="hidden" name="tsk" value="{{request()->get('tsk')}}">
               @endif
              <select id="trenProject" onchange="document.getElementById('pjkform').submit()" 
              class="form-select
              @if(request()->has('pjk'))
              border-primary 
              @endif
              my-3" aria-label="Default select example" name="pjk"> 
              @foreach($years as $thn)
                <option value="{{$thn}}" 
                        @if(request()->get('pjk') == $thn) selected @endif>
                    {{$thn}}
                </option>
              @endforeach             
              </select>
              </form>
           </div>
           <div class="card-body">
               <canvas id="trendProject" width="48" height="24" style="display: block; box-sizing: border-box; height: 24px; width: 48px;"></canvas>
           </div>
          </div>
        </div>

      </div>

   </div>
</main>
@endsection


@section('js_custom')

<!-- Trend Task Completed -->

@php
$dataTrend = [];
$dataTrendLate = [];
$dataTrendProject = [];

foreach($trend_task as $i => $row){
   $dataTrend[] = round($row);
}
foreach($trend_task_late as $i => $row){
   $dataTrendLate[] = $row;
}
foreach($trend_project as $i => $row){
   $dataTrendProject[] = $row;
}


@endphp

<script>
  
    const ctx = document.getElementById('taskComplete').getContext('2d');    
    const taskCompletionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr','Mei','Jun','Jul','Agust','Sept','Oct','Nov','Dec'],
            datasets: [{
                label: 'Task Selesai',
                data: @json($dataTrend),
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                tension: 0.4,                
                pointRadius: 5,
                pointBackgroundColor: '#4CAF50'
            },{
               label : 'Task Terlambat',
               data: @json($dataTrendLate),
                borderColor: '#FFE52A',
                backgroundColor: 'rgba(255, 255, 0, 0.5)',
                tension: 0.4,                
                pointRadius: 5,
                pointBackgroundColor: '#FFE52A'

            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {                    
                    ticks:{
                     precision: 0,
                     callback: function(value) {
                       return Number.isInteger(value) ? value : null;
                     }
                    },
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Task'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Periode 2025'
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('trendProject');

    
    const projectBarChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr','Mei','Jun','Jul','Agust','Sept','Oct','Nov','Dec'],
        datasets: [{
          label: 'Jumlah Proyek',
          data: @json($dataTrendProject), // Contoh total proyek per bulan
          backgroundColor: '#4caf50', // warna batang
          borderColor: '#388e3c',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,        
        scales: {
          y: {            
            beginAtZero: true,
            ticks: {
              stepSize: 1,   // agar angka bulat
              precision: 0
            },
            title: {
              display: true,
              text: 'Jumlah Proyek'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Periode 2025'
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          }
        }
      }
    });



</script>
@endsection