@extends('layout.dashboard')
@section('section_dashboard')
    
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
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
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100 align-items-center">
                                <h5>Logging</h5>
                                <form
                                id="filter"
                                method="GET"
                                action="{{route('auth.developer.logging')}}"
                                >
                                @if(request()->has('type') or request()->has('users'))
                                <button onclick="window.location.href='{{route("auth.developer.logging")}}'" 
                                type="button" class="btn btn-outline-primary icon-btn b-r-4"> <i class="ph-duotone  ph-arrow-clockwise"></i></button>
                                @endif
                                &nbsp;
                                <button type="button" class="btn btn-outline-primary icon-btn b-r-4"
                                data-bs-toggle="modal" data-bs-target="#filterModal"> 
                                    <i class="ti ti-filter"></i>
                                </button>
                                <!-- <select name="type" 
                                onchange="document.getElementById('filter').submit()" 
                                class="my-2 px-4 py-2" aria-label="Default select example">
                                    <option selected disabled>--- Filter ---</option>

                                    <option 
                                    @if(request()->query('type') === 'Info')
                                    selected
                                    @endif
                                    value="Info"
                                    >Info</option>

                                    <option 
                                    @if(request()->query('type') === 'Warning')
                                    selected
                                    @endif
                                    value="Warning">Warning</option>

                                    <option 
                                    @if(request()->query('type') === 'Error')
                                    selected
                                    @endif
                                    value="Error">Errors</option>

                                </select> -->
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Users</th>
                                            <th scope="col">IP</th>
                                            <th scope="col">Method</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($log as $i => $row)
                                            <tr>
                                                <td>{{ $row->created_at }}</td>
                                                <td>
                                                    @if ($row->type === 'Error')
                                                        <span class="badge text-bg-danger">Error</span>
                                                    @elseif($row->type === 'Warning')
                                                        <span class="badge text-bg-warning">Warning</span>
                                                    @else
                                                        <span class="badge text-bg-success">Info</span>
                                                    @endif
                                                </td>
                                                <td class="f-w-500">{{ $row->title }}</td>
                                                <td class="text-secondary f-w-600">
                                                    {{ $row->pengguna->name ?? null }}
                                                </td>
                                                <td><span class="badge text-light-primary">{{ $row->ip4 }}</span></td>
                                                <td class="text-success f-w-500">{{ $row->method }}</td>
                                                <td>
                                                    <button data-bs-toggle="modal"
                                                    data-bs-target="#modalLogging"
                                                    data-id-log="{{$row->id_logging}}"
                                                    data-users-name="{{$row->pengguna->name ?? null}}"
                                                    data-type="{{$row->type}}"
                                                    data-payload="{{json_encode($row->data)}}"
                                                    data-ip="{{$row->ip4}}"
                                                    data-method="{{$row->method}}"
                                                    data-device="{{$row->device}}"
                                                    data-platform="{{$row->platform}}"
                                                    data-browser="{{$row->browser}}"
                                                    data-agent="{{$row->agent}}"
                                                    data-browser-version="{{$row->browser_version}}"
                                                    data-url="{{$row->url}}"
                                                    data-title="{{$row->title}}"
                                                    data-deskripsi="{{$row->deskripsi}}"
                                                    data-status="{{$row->status_code}}"
                                                    data-created_at="{{$row->created_at}}"
                                                    type="button" class="btn btn-outline-primary icon-btn b-r-4"> <i class="ti ti-capture"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination mb-3">
                                <!-- Prev Link -->
                                @php

                                $params = [];

                                if(request()->has('users')){
                                    $params['users'] = request()->get('users');
                                }

                                if(request()->has('type')){
                                    $params['type'] = request()->get('type');
                                }

                                @endphp
                                <a 
                                    @if ($log->onFirstPage()) 
                                        class="disabled" 
                                        href="javascript:void(0);" 
                                    @else 
                                        @php 
                                            $prev = $params; 
                                            $prev['page'] = $log->currentPage() - 1;
                                        @endphp                                        
                                        href="{{route('auth.developer.logging.pagination',$prev)}}"
                                    @endif
                                    class="prev">« Prev</a>

                                <!-- Page Number Links -->
                                @php
                                    $currentPage = $log->currentPage();
                                    $lastPage = $log->lastPage();
                                    $pageLimit = 5; // Number of page links to show
                                    $halfLimit = floor($pageLimit / 2);
                                @endphp

                                <!-- Show pages around the current page, with ellipsis for more pages -->
                                @foreach(range(max(1, $currentPage - $halfLimit), min($lastPage, $currentPage + $halfLimit)) as $i)
                                    @php
                                    $num = $params;
                                    $num['page'] = $i;
                                    @endphp
                                    <a                                         
                                        href="{{ route('auth.developer.logging.pagination', $num)}}"                                         
                                        class="{{ $currentPage == $i ? 'active' : '' }}"
                                    >{{ $i }}</a>
                                @endforeach
                                

                                <!-- Ellipsis after if there are pages after the current range -->
                                @if($currentPage < $lastPage - $halfLimit)
                                    @php
                                        $last = $params;
                                        $last['page'] = $lastPage;
                                    @endphp
                                    <a                                     
                                    href="{{ route('auth.developer.logging.pagination', $last)}}"
                                    >...</a>
                                @endif

                                <!-- Next Link -->
                                <a 
                                    @if (!$log->hasMorePages()) 
                                        class="disabled" 
                                        href="javascript:void(0);" 
                                    @else
                                        @php
                                        $next = $params;
                                        $next['page'] = $log->currentPage() + 1;
                                        @endphp
                                        href="{{route('auth.developer.logging.pagination', $next)}}"
                                    @endif
                                    class="next">Next »</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="filterModal" aria-modal="true" role="dialog">
        <div class="modal-dialog app_modal_sm">
          <div class="modal-content">
            <div class="modal-header bg-primary-800">
              <h1 class="modal-title fs-5 text-white" id="filterModal2">Filtering Logging</h1>
              <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
          </div>
          <div class="modal-body ">
            <div class="app-form">
                <form
                method="GET"
                action="{{route('auth.developer.logging')}}"
                >
                <div class="mb-3">
                    <label class="form-label">Type Logging</label>
                    <select name="type" class="form-select">
                        <option selected readonly disabled>~~~ Type Logging ~~~</option>
                        <option 
                        @if(request()->query('type') === 'Info')
                        selected
                        @endif
                        value="Info"
                        >Info</option>

                        <option 
                        @if(request()->query('type') === 'Warning')
                        selected
                        @endif
                        value="Warning">Warning</option>

                        <option 
                        @if(request()->query('type') === 'Error')
                        selected
                        @endif
                        value="Error">Errors</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Users Log</label> 
                    <select name="users" class="userSelect" style="width: 100%;">
                        @foreach($users as $row)
                        <option value="{{$row->id_users}}">{{$row->name}}</option>
                        @endforeach
                    </select>   
                </div>

            </div>
          </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-light-primary">Simpan Filter</button>
          </form>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="modalLogging" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalLogging">Data Logging</h6>
                    <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="app-form">
                        <div class="mb-3 form-control" >
                            <ul id="dataLog" style="overflow: auto;">
                                
                            </ul>
                        </div>
                        <div class="form-control">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header code-header">
                                            <h5>Pesan Deskripsi</h5>
                                            <a  aria-expanded="true" class="">
                                              <i class="ti ti-question-mark source" data-source="av1"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-justify" id="pesanError">
                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data Payload Request</label>
                            <pre id="payload" class="language-json">
                                
                            </pre>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="downloadPdf" class="btn btn-light-primary icon-btn b-r-4">
                    <i class="ti ti-arrow-bar-to-down"></i></button>
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_custom')
<script>

$(document).ready(function () {
    $('.userSelect').select2({
        dropdownParent: $('#filterModal .modal-body'),
    });
});

 
const logingModal = document.getElementById('modalLogging')
logingModal.addEventListener('show.bs.modal',(e) => {
    const btn = event.relatedTarget;

    const idLog = btn.getAttribute('data-id-log');
    const usersName = btn.getAttribute('data-users-name');
    const type = btn.getAttribute('data-type');
    const payload = btn.getAttribute('data-payload');
    const ip = btn.getAttribute('data-ip');
    const method = btn.getAttribute('data-method');
    const device = btn.getAttribute('data-device');
    const platform = btn.getAttribute('data-platform');
    const browser = btn.getAttribute('data-browser');
    const agent = btn.getAttribute('data-agent');
    const browserVersion = btn.getAttribute('data-browser-version');
    const url = btn.getAttribute('data-url');
    const title = btn.getAttribute('data-title');
    const deskripsi = btn.getAttribute('data-deskripsi');
    const status = btn.getAttribute('data-status');
    const createdAt = btn.getAttribute('data-created_at');

    const logData = [
        { label: 'ID Log', value: idLog },
        { label: 'Nama Pengguna', value: usersName },
        { label: 'Tipe', value: type },
        { label: 'IP Address', value: ip },
        { label: 'Method', value: method },
        { label: 'Device', value: device },
        { label: 'Platform', value: platform },
        { label: 'Browser', value: browser },
        { label: 'User Agent', value: agent },
        { label: 'Browser Version', value: browserVersion },
        { label: 'URL', value: url },
        { label: 'Title', value: title },
        { label: 'Status Code', value: status },
        { label: 'Created At', value: createdAt }
    ];

    const tombolPdf = logingModal.querySelector('#downloadPdf')
    tombolPdf.addEventListener('click',(e) => {
        let url = `{{route('service_developer_report_log_detail')}}?id=${idLog}`
        window.location.href = url
    });

    const dataLogTable = logingModal.querySelector('#dataLog');
    dataLogTable.classList.add('list-group', 'list-group-flush'); // Adds Bootstrap list group styling
    let listLog = ''
    logData.forEach(item => {        
           
        let listItem = `
            <li class="ist-group-item d-flex justify-content-between align-items-center flex-wrap">
            <span class="font-weight-bold text-primary">${item.label}:</span> 
            <span class="text-muted">${item.value}</span>
            </li>
        `;
        listLog += listItem        
    });
    dataLogTable.innerHTML = listLog
    logingModal.querySelector('#pesanError').textContent = deskripsi
    // // Payload
    const parsedData = JSON.parse(payload); 
    const jsonDisplay = logingModal.querySelector('#payload');
    jsonDisplay.textContent = JSON.stringify(JSON.parse(parsedData),null,4)
})

</script>
@endsection
