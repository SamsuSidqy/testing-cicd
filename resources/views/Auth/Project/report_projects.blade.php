@extends('layout.dashboard')
@section('section_dashboard')

@php
$uri = request()->route()->uri();

$finalUri;

$checkPagination = preg_match('#/page/\{page\}$#',$uri);
if($checkPagination){
    $finalUri = preg_replace('#/page/\{page\}$#', '', $uri);
}else{
    $finalUri = $uri;
}

@endphp

@hasPermissionsUsers($finalUri,auth()->user()->id_users,'show')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 5px;
    }

    .pagination a {
        text-decoration: none;
        padding: 8px 16px;
        margin: 0 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #333;
    }

    .pagination a:hover {
        background-color: #f0f0f0;
    }

    .pagination .active {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .pagination .prev, .pagination .next {
        font-weight: bold;
    }

    .pagination .prev:hover, .pagination .next:hover {
        background-color: #f0f0f0;
    }
</style>

<main>
    <div class='container-fluid'>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Cetak Laporan Projek</h5>
                  </div>
                  <div class="card-body">
                    <div class="app-form">   
                      <form
                      method="GET"
                      action="{{route('auth.project.reports')}}"
                      uri-api=""                      
                      >
                      <input type="hidden" readonly name="projek" value="true">
                      <div class="mb-3">
                        <label for="year" class="form-label">Periode Tahun <small class="text-secondary"> (Optional)</small></label>
                        <select name="t" class="form-select" id="year">
                          <option selected disabled selected value="">--- Select The Year ----</option>
                          @foreach($tahunProject as $row)
                          <option value="{{$row->tahun}}">{{$row->tahun}}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="mb-3">
                        <label for="month" class="form-label">Periode Bulan <small class="text-secondary"> (Optional)</small></label>
                        <select name="b" class="form-select" id="month">
                          <option selected disabled selected value="">--- Select The Months ----</option>
                          @foreach($bulanProject as $row)
                          <option value="{{$row->month}}">
                          {{\Carbon\Carbon::now()->month($row->month)->locale('id')->translatedFormat('F')}}
                          </option>
                          @endforeach
                        </select>
                      </div>       

                      <div class="mb-3">
                        <label class="form-label">PCI <small class="text-secondary"> (Optional)</small></label>
                        <select name="pci" class="pciSelect" id="pciSelect" style="width:100%">
                          <option selected readonly disabled>--- Pilih PCI ---</option>
                           @foreach($users as $row)

                            @if(auth()->user()->roles != 'Developer')

                              @if($row->roles != 'Developer')
                              <option value="{{$row->id_users}}" >{{$row->name}}</option>
                              @endif

                            @else
                            <option value="{{$row->id_users}}" >{{$row->name}}</option>
                            @endif
                            @endforeach
                        </select>
                      </div>                                                           

                      <div>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                      </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Cetak Laporan Progress Projek</h5>
                    </div>
                    <div class="card-body">
                        <form                                            
                        method="GET"              
                        action="{{route('auth.project.reports')}}" 
                        >
                        <input type="hidden" name="progres" value="true">
                        <div class="app-form">
                          <div class="mb-3">
                            <label class="form-label">Pilih Project</label>
                            <select required name="id" id="idProject" class="selectProject" style="width:100%;">
                              <option disabled value="" selected>--- Pilih Project ---</option>
                              @foreach($project as $row)
                              <option value="{{$row->id_projects}}">{{$row->title}} ({{count($row->member)}} Orang)</option>
                              @endforeach
                            </select>
                          </div>                           
                          <div>
                            <button type="submit" class="btn btn-primary">Cetak</button></form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div 
                @if(request()->has('projek') or request()->has('progres'))
                class="card"
                @else
                class="card d-none"
                @endif >
                    <div class="card-header">
                        @if(request()->has('projek') or request()->has('progres'))
                        <div class="app-dropdown">
                          <button class="btn btn-lg border-0 icon-btn show" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="true">
                            <i class="ti ti-dots"></i>
                          </button>
                          <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li class="dropdown-item" style="cursor:pointer;">

                              @php
                              $params = [];
                              if(request()->has('pci')){
                                $params['pci'] = request()->get('pci');
                              }else if(request()->has('t')){
                                $params['t'] = request()->get('t');
                              }else if(request()->has('b')){
                                $params['b'] = request()->get('b');
                              }else if(request()->has('id')){
                                $params['id'] = request()->get('id');
                              }
                              @endphp

                              @if(request()->has('projek'))
                              @php $params['tipe'] = 'pdf' @endphp
                              <a onclick="window.location.href='{{route('auth.service.reports.project',$params)}}'" class="">   
                                <i class="ph-bold  ph-file-pdf pe-2"></i>
                                <span> Download PDF</span>
                              </a>
                              @elseif(request()->has('progres'))
                              @php $params['files'] = 'pdf' @endphp
                              <a onclick="window.location.href='{{route('auth.service.reports.project.progress',$params)}}'" class="">   
                                <i class="ph-bold  ph-file-pdf pe-2"></i>
                                <span> Download PDF</span>
                              </a>
                              @endif
                            </li>
                            <li class="dropdown-item" style="cursor:pointer;">
                              @if(request()->has('projek'))
                              @php $params['tipe'] = 'excel' @endphp
                              <a onclick="window.location.href='{{route('auth.service.reports.project',$params)}}'" class="">
                               <i class="ph-bold  ph-file-xls pe-2"></i>
                                <span>Download Excel</span>
                              </a>
                              @elseif(request()->has('progres'))
                              @php $params['files'] = 'excel' @endphp
                              <a onclick="window.location.href='{{route('auth.service.reports.project.progress',$params)}}'" class="">
                               <i class="ph-bold  ph-file-xls pe-2"></i>
                                <span>Download Excel</span>
                              </a>
                              @endif
                            </li>                            
                            <li class="dropdown-divider"></li>
                            <li onclick="window.location.href='{{route('auth.project.reports')}}'" 
                            class="dropdown-item" style="cursor: pointer;">
                              <a class="">
                                <i class="ph-fill  ph-broom pe-2"></i>
                                Clear Report
                              </a>
                            </li>
                          </ul>
                        </div>  
                        @endif
                    </div>
                    <div class="card-body overflow-auto app-scroll" id="previewReport">
                        @if(request()->query('projek') && isset($report_project))                       
                        <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; font-family: Arial, sans-serif">
                              <!-- Header Laporan -->
                              <tr>
                                  <td
                                      colspan="7"
                                      style="
                                          text-align: center;
                                          padding: 15px;
                                          background-color: #2c3e50;
                                          color: white;
                                          font-size: 18px;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                      "
                                  >
                                      LAPORAN PROYEK THECONNECT
                                  </td>
                              </tr>
                              <tr>
                                  <td
                                      colspan="7"
                                      style="
                                          text-align: center;
                                          padding: 8px;
                                          background-color: #34495e;
                                          color: white;
                                          font-size: 12px;
                                          border: 1px solid #2c3e50;
                                      "
                                  >
                                      Periode &nbsp;: &nbsp; {{$report_project['periodeTitle']}}
                                  </td>
                              </tr>

                              <!-- Spacer -->
                              <tr>
                                  <td colspan="7" style="height: 10px"></td>
                              </tr>

                              <!-- Info Laporan -->
                              <tr>
                                  <td colspan="3" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                      <strong>Tanggal Cetak : &nbsp;</strong> {{\Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')}}
                                  </td>
                                  <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                      <strong>Periode : &nbsp;</strong> {{$report_project['periode']}}
                                  </td>
                                  <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                      <strong>Total Proyek : &nbsp;</strong> ({{count($report_project['project'])}}) Proyek
                                  </td>
                              </tr>

                              <!-- Spacer -->
                              <tr>
                                  <td colspan="7" style="height: 10px"></td>
                              </tr>

                              <!-- Header Tabel -->
                              <tr>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          text-align: center;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      No
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      Nama Proyek
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      Deskripsi
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      Tanggal Mulai
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      Tanggal Selesai
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          text-align: center;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      Presentase
                                  </td>
                                  <td
                                      style="
                                          padding: 10px;
                                          background-color: #34495e;
                                          color: white;
                                          font-weight: bold;
                                          border: 1px solid #2c3e50;
                                          font-size: 12px;
                                      "
                                  >
                                      PIC
                                  </td>
                              </tr>

                              <!-- Data Row 1 -->
                              @foreach($report_project['project'] as $i => $row)
                              <tr>
                                  <td
                                      style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px"
                                  >
                                      {{$i + 1}}
                                  </td>
                                  <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                      {{$row->title}}
                                  </td>
                                  <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                      {{$row->deskripsi}}
                                  </td>
                                  <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                      {{\Carbon\Carbon::parse($row->start)->locale('id')->translatedFormat('d F Y')}}
                                  </td>
                                  <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                      {{\Carbon\Carbon::parse($row->ended)->locale('id')->translatedFormat('d F Y')}}
                                  </td>

                                  @if(persentase_task($row->id_projects) == 100)
                                  <td
                                      style="
                                          padding: 8px;
                                          text-align: center;
                                          border: 1px solid #ddd;
                                          background-color: #8feb34;
                                          font-size: 11px;
                                          color: #fff;
                                      "
                                  >
                                      {{persentase_task($row->id_projects)}} %
                                  </td>
                                  @else
                                  <td
                                      style="
                                          padding: 8px;
                                          text-align: center;
                                          border: 1px solid #ddd;
                                          background-color: #f3f70c;
                                          font-size: 11px;
                                          color: black;
                                      "
                                  >
                                      {{persentase_task($row->id_projects)}} %
                                  </td>
                                  @endif
                                  <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                      {{$row->users->name}}
                                  </td>
                              </tr>
                              @endforeach
                          </table>
                        @endif 

                        @if(request()->has('progres') && isset($report_progres))
                        <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; font-family: Arial, sans-serif">
                        <!-- Header Laporan -->
                        <tr>
                            <td
                                colspan="7"
                                style="
                                    text-align: center;
                                    padding: 15px;
                                    background-color: #2c3e50;
                                    color: white;
                                    font-size: 18px;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                "
                            >
                                LAPORAN PROGRESS PROYEK
                            </td>
                        </tr>
                        <tr>
                            <td
                                colspan="7"
                                style="
                                    text-align: center;
                                    padding: 8px;
                                    background-color: #34495e;
                                    color: white;
                                    font-size: 12px;
                                    border: 1px solid #2c3e50;
                                "
                            >
                                PIC ({{$report_progres['project']->users->name}})
                            </td>
                        </tr>

                        <!-- Spacer -->
                        <tr>
                            <td colspan="7" style="height: 10px"></td>
                        </tr>

                        <!-- Info Laporan -->
                        <tr>
                            <td colspan="3" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                <strong>Tanggal Cetak : </strong> {{\Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')}}
                            </td>
                            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                <strong>Nama Proyek : </strong> &nbsp;{{$report_progres['project']->title}}
                            </td>
                            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px">
                                <strong>Total Tasks : </strong> &nbsp;({{count($report_progres['task'])}}) Tasks
                            </td>
                        </tr>

                        <!-- Spacer -->
                        <tr>
                            <td colspan="7" style="height: 10px"></td>
                        </tr>

                        <!-- Header Tabel -->
                        <tr>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    text-align: center;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                No
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                    width: 150px;
                                "
                            >
                                Nama Tasks
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                Pelaksana
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                Deadline
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                Pengerjaan
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                Status
                            </td>
                            <td
                                style="
                                    padding: 10px;
                                    background-color: #34495e;
                                    color: white;
                                    font-weight: bold;
                                    border: 1px solid #2c3e50;
                                    font-size: 12px;
                                "
                            >
                                Terakhir Updated
                            </td>
                        </tr>

                        <!-- Data Row 1 -->
                        @foreach($report_progres['task'] as $i => $row)
                        <tr>
                            <td
                                style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px"
                            >
                                {{$i + 1}}
                            </td>
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">{{$row->name}}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                {{$row->anggota->name}}
                            </td>
                            <td style="padding: 8px; text-align: right; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                {{\Carbon\Carbon::parse($row->deadline)->locale('id')->translatedFormat('d F Y')}}
                            </td>

                            @if($row->status === 'Completed') @if($row->extend_deadline)
                            <td
                                style="
                                    padding: 8px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    background-color: #e0e330;
                                    font-size: 11px;
                                    color: black;
                                "
                            >
                                Penambahan Waktu
                            </td>
                            @else
                            <td
                                style="
                                    padding: 8px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    background-color: #2debe7;
                                    font-size: 11px;
                                    color: black;
                                "
                            >
                                Tepat Waktu
                            </td>
                            @endif @else
                            <td
                                style="
                                    padding: 8px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    background-color: #e1eb31;
                                    font-size: 11px;
                                    color: black;
                                "
                            >
                                ON Progress
                            </td>
                            @endif @if($row->status === 'Completed')
                            <td
                                style="
                                    padding: 8px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    background-color: #13d90f;
                                    font-size: 11px;
                                    color: black;
                                "
                            >
                                Completed
                            </td>
                            @else
                            <td
                                style="
                                    padding: 8px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    background-color: #e1eb31;
                                    font-size: 11px;
                                    color: black;
                                "
                            >
                                Progress
                            </td>
                            @endif @if($row->activity)
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                {{\Carbon\Carbon::parse($row->activity->created_at)->locale('id')->translatedFormat('d F Y, H:i:s')}} WIB
                            </td>
                            @else
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px">
                                Belum Ada Aktifitas
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                        @endif

                    </div>
                    <div class="card-footer">

                      @php

                      $payload = null;
                      $params = [];
                      if(request()->has('projek')){
                        $payload = $report_project['project'];
                        $params['projek'] = true;
                        if(request()->has('t')){
                          $params['t'] = request()->get('t');
                        }else if(request()->has('b')){
                          $params['b'] = request()->get('b');
                        }else if(request()->has('pci')){
                          $params['pci'] = request()->get('pci');
                        }

                      }else if(request()->has('progres')){
                        $payload = $report_progres['task'];
                        $params['progres'] = true;
                        if(request()->has('id')){
                          $params['id'] = request()->get('id');
                        }
                      }
                      @endphp

                    @if(request()->has('progres') or request()->has('projek'))
                     <div class="pagination mb-2">
                       <!-- Prev Link -->

                       @php
                       $parameterPrev = $params;
                       $parameterPrev['page'] = $payload->currentPage() - 1;
                       @endphp

                       <a 
                       @if ($payload->onFirstPage())                       
                       class="disabled" 
                       href="javascript:void(0);" 
                       @else 
                       href="{{route('auth.project.reports.pagination',$parameterPrev)}}"
                       @endif
                       class="prev">« Prev</a>

                       <!-- Page Number Links -->
                       @php
                       $currentPage = $payload->currentPage();
                       $lastPage = $payload->lastPage();
                       $pageLimit = 5; // Number of page links to show
                       $halfLimit = floor($pageLimit / 2);
                       @endphp

                       <!-- Show pages around the current page, with ellipsis for more pages -->
                       @foreach(range(max(1, $currentPage - $halfLimit), min($lastPage, $currentPage + $halfLimit)) as $i)

                       @php
                       $parameterList = $params;
                       $parameterList['page'] = $i;
                       @endphp

                       <a 
                       href="{{ route('auth.project.reports.pagination',$parameterList) }}" 
                       class="{{ $currentPage == $i ? 'active' : '' }}"
                       >{{ $i }}</a>
                       @endforeach


                       <!-- Ellipsis after if there are pages after the current range -->
                       @if($currentPage < $lastPage - $halfLimit)
                       <a href="{{ route('auth.project.reports.pagination', ['page' => $lastPage]) }}">...</a>
                       @endif

                       <!-- Next Link -->
                       <a 
                       @if (!$payload->hasMorePages()) 
                       class="disabled" 
                       href="javascript:void(0);" 
                       @else

                       @php
                       $parameterNext = $params;
                       $parameterNext['page'] = $payload->currentPage() + 1;
                       @endphp

                       href="{{route('auth.project.reports.pagination',$parameterNext)}}"
                       @endif
                       class="next">Next »</a>
                     </div> 
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</main>

@else 
<main>
    <div class="container-fluid">
        <h3>Anda Belum Memiliki Izin Untuk Melihat Projek. Hubungi Developer</h3>
    </div>
</main>                    
@endhasPermissionsUsers

@endsection

@section('js_custom')
<script>

const formProyek = document.getElementById('proyekReport')
const formProgres = document.getElementById('formProgres')

const load = document.getElementById('reportPreviewLoading')


$(document).ready(function () {
    $('.pciSelect').select2();
});

$(document).ready(function () {
  $('.selectProject').select2();
})

@if(request()->has('progres') or request()->has('projek'))
window.scrollTo({
  top: document.body.scrollHeight,
  behavior: 'smooth' 
});
@endif




  
</script>
@endsection