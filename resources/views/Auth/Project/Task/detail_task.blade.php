@extends('layout.dashboard')
@section('section_dashboard')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-6 order-xxl-2">
                    <!-- project activity -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                                <!-- Info Section -->
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 gap-md-3 flex-wrap w-100 w-lg-auto">
                                    <!-- Connection Icon & Title -->
                                    <div class="d-flex align-items-center text-center gap-2">
                                        <i class="ph-bold f-s-20 ph-globe text-success" id="koneksi">
                                            
                                        </i>
                                        <h5 class="mb-0">{{$task->name}}</h5>
                                    </div>

                                    <!-- PIC -->
                                    <div class="d-flex align-items-center gap-2">
                                        <i id="picOnline" class="ph-fill f-s-20 f-s-md-25 ph-user-gear"></i>
                                        <span class="text-nowrap small">PIC ({{$task->project_task->users->name}})</span>
                                    </div>

                                    <!-- Pekerja -->
                                    <div class="d-flex align-items-center gap-2">
                                        <i id="techOnline" class="ph-fill f-s-20 f-s-md-25 ph-user-plus"></i>
                                        <span class="text-nowrap small">({{$task->anggota->name}})</span>
                                    </div>
                                </div>

                                <!-- Button Section -->
                                <div class="w-100 w-lg-auto mt-2 mt-lg-0">
                                    @if($task->responsibility == auth()->user()->id_users)
                                    <button 
                                    @hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'create')
                                    @else
                                    disabled="true"
                                    @endhasPermissionsUsers
                                    @if($task->status === 'Progress')
                                    @if(boolean_deadline($task->deadline))
                                    type="button" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#kirimAsigsment"
                                    class="btn btn-light-twitter b-r-22 d-inline-flex align-items-center justify-content-center w-100 w-lg-auto">
                                    <i class="ti ti-clipboard f-s-18 me-1"></i> 
                                    <span class="d-none d-sm-inline">Kerjakan</span>
                                    <span class="d-inline d-sm-none">Kerjakan</span>
                                </button>
                                @else
                                disabled
                                type="button" 
                                class="btn btn-danger b-r-22 d-inline-flex align-items-center justify-content-center w-100 w-lg-auto">
                                <i class="ti ti-clipboard f-s-18 me-1"></i> 
                                <span class="d-none d-md-inline">Deadline Sudah Lewat</span>
                                <span class="d-inline d-md-none">Deadline Sudah Lewat</span>
                            </button>
                            @endif
                            @else
                            type="button" 
                            class="btn btn-success b-r-22 d-inline-flex align-items-center justify-content-center w-100 w-lg-auto">
                            <i class="ph-bold f-s-18 me-1 ph-seal-check"></i> 
                            <span class="d-none d-sm-inline">Task Completed</span>
                            <span class="d-inline d-sm-none">Selesai</span>
                            </button>
                            @endif
                            @else
                            <button 
                            @hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'create')
                            @else
                            disabled="true"
                            @endhasPermissionsUsers
                            @if($task->status === 'Progress')
                            data-bs-target="#updateStatus"
                            data-bs-toggle="modal"
                            type="button" 
                            class="btn btn-info b-r-22 d-inline-flex align-items-center justify-content-center w-100 w-lg-auto">
                            <i class="ti ti-check f-s-18 me-1"></i> 
                            <span class="d-none d-sm-inline">Perbarui Status</span>
                            <span class="d-inline d-sm-none">Update</span>
                            @else
                            data-bs-target="#openStatus"
                            data-bs-toggle="modal"
                            type="button" 
                            class="btn btn-light b-r-22 d-inline-flex align-items-center justify-content-center w-100 w-lg-auto">
                            <i class="ph f-s-18 me-1 ph-ticket"></i> 
                            <span class="d-none d-sm-inline">Buka Progress</span>
                            <span class="d-inline d-sm-none">Buka Progres</span>
                            @endif
                        </button>
                        @endif
                    </div>
                </div>
            </div>
                        <div class="card-body" id="chatBody" style="height: 500px; overflow-y: auto;">
                            <ul class="app-timeline-box" id="message-chat">
                                @foreach($forum as $chat)

                                @if($chat->type === 'Pesan')
                                <li class="timeline-section">
                                    <div class="timeline-icon">
                                        <span class="
                                        @if($task->responsibility != $chat->users->id_users)
                                            text-light-info 
                                        @else
                                            text-light-success
                                        @endif
                                        h-35 w-35 d-flex-center b-r-50">
                                        {{strtoupper(substr($chat->users->name, 0, 1))}}
                                        </span>
                                    </div>
                                    <div class="timeline-content pt-0 ">
                                        <div class="d-flex f-s-16">
                                            <p class="
                                            @if($task->responsibility != $chat->users->id_users)
                                            text-info 
                                            @else
                                            text-success
                                            @endif
                                            f-s-16 mb-0">{{$chat->users->name}}

                                            </p> &nbsp;<span class="text-secondary ms-2"> <span class="badge text-outline-success me-2">
                                            Mengirim Pesan</span>
                                            @if($task->responsibility != $chat->users->id_users)
                                            PCI
                                            @endif
                                            </span>

                                        </div>
                                        <p class="">                                          
                                            {{ \Carbon\Carbon::parse($chat->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm:ss') }}
                                        </p>
                                        <div class="timeline-border-box me-2 ms-0 mt-3">
                                            <h6 class="mb-0">Pesan</h6>
                                            <p class="mb-4 text-secondary">
                                                {{$chat->message}}
                                            </p>

                                            @if($chat->files)

                                            <div class="border rounded p-2 overflow-auto d-block d-lg-none">
                                              <div class="d-flex flex-row flex-nowrap gap-3">
                                                @foreach($chat->files as $file)

                                                  @if($file->type === 'image')
                                                  <div class="card text-center" style="min-width:140px; height:180px;">
                                                    <img src="{{route('auth.service.look.file.task',$file->name_file)}}" 
                                                         class="card-img-top object-fit-contain" 
                                                         style="height:130px; width:100%;" 
                                                         alt="image">
                                                    <div class="card-body">
                                                      <small class="text-truncate d-block">
                                                          <a href="{{route('auth.service.look.file.task',$file->name_file)}}" download="{{$file->name_file}}" >
                                                              <i class="ph-fill f-s-18 ph-download-simple"></i>
                                                          </a>
                                                      </small>
                                                    </div>
                                                  </div>
                                                  @else
                                                  <div class="card text-center d-flex justify-content-center" style="min-width:140px; height:180px;">
                                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                      <div class="fs-1">📄</div>
                                                      <small class="text-truncate d-block">
                                                          <a href="{{route('auth.service.look.file.task',$file->name_file)}}" download="{{$file->name_file}}">
                                                              <i class="ph-fill f-s-18 ph-download-simple"></i>
                                                          </a>
                                                      </small>
                                                    </div>
                                                  </div>
                                                  @endif

                                                @endforeach
                                              </div>
                                            </div>
                                            
                                            <div class="d-none d-lg-block">
                                            <div class="row">
                                                @foreach($chat->files as $file)

                                                @if($file->type === 'image')                                                
                                                <div class="col-sm-4 mb-2">
                                                    <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                                        <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;">
                                                            <img src="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;" 
                                                            alt="">
                                                            <a href="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            download="{{$file->name_file}}">
                                                            <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" class="ph-fill  ph-cloud-arrow-down"></i>   
                                                            </a>
                                                        </div>
                                                    </a>
                                                </div>

                                                @else

                                                <div class="col-sm-4 mb-2">
                                                    <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                                        <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;" class="bg-secondary">                            
                                                            <a href="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            download="{{$file->name_file}}">
                                                            @php
                                                            $extension = pathinfo($file->name_file, PATHINFO_EXTENSION);
                                                            @endphp
                                                            <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" 
                                                            @if($extension === 'pdf')
                                                            class="ph  ph-file-pdf"
                                                            @elseif($extension === 'docx')
                                                            class="ph ph-file-doc"
                                                            @elseif($extension === 'zip')
                                                            class="ph ph-file-zip"
                                                            @else
                                                            class="ph-fill  ph-cloud-arrow-down"
                                                            @endif
                                                            ></i>   
                                                            </a>
                                                            <i style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); font-size: 9px; color: white;" class="fas fa-download">
                                                                {{$file->name_file}}
                                                            </i>
                                                        </div>
                                                    </a>
                                                </div>

                                                @endif

                                                @endforeach
                                            </div>

                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </li> 
                                @else
                                <li class="timeline-section">
                                    <div class="timeline-icon">
                                        <span class="
                                        @if($task->responsibility != $chat->users->id_users)
                                            text-light-info 
                                        @else
                                            text-light-success
                                        @endif
                                        h-35 w-35 d-flex-center b-r-50">
                                        {{strtoupper(substr($chat->users->name, 0, 1))}}
                                        </span>
                                    </div>
                                    <div class="timeline-content pt-0 ">
                                        <div class="d-flex f-s-16">
                                            <p class="
                                            @if($task->responsibility != $chat->users->id_users)
                                            text-info 
                                            @else
                                            text-success
                                            @endif
                                            f-s-16 mb-0">{{$chat->users->name}}

                                            </p> &nbsp;<span class="text-secondary ms-2"> <span class="badge text-outline-success me-2">
                                            Mengirim Tugas</span>
                                            @if($task->responsibility != $chat->users->id_users)
                                            PCI
                                            @endif
                                            </span>

                                        </div>
                                        <p class="">                                          
                                            {{ \Carbon\Carbon::parse($chat->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm:ss') }}
                                        </p>
                                        <div class="timeline-border-box me-2 ms-0 mt-3">
                                            <h6 class="mb-0">
                                                @if($chat->type === 'Pesan')
                                                Pesan
                                                @else
                                                Lampiran Tugas
                                                @endif
                                            </h6>
                                            <p class="mb-4 text-secondary">
                                                {{$chat->message}}
                                            </p>

                                            @if($chat->files)

                                            <div class="border rounded p-2 overflow-auto d-block d-lg-none">
                                              <div class="d-flex flex-row flex-nowrap gap-3">
                                                @foreach($chat->files as $file)

                                                  @if($file->type === 'image')
                                                  <div class="card text-center" style="min-width:140px; height:180px;">
                                                    <img src="{{route('auth.service.look.file.task',$file->name_file)}}" 
                                                         class="card-img-top object-fit-contain" 
                                                         style="height:130px; width:100%;" 
                                                         alt="image">
                                                    <div class="card-body">
                                                      <small class="text-truncate d-block">
                                                          <a href="{{route('auth.service.look.file.task',$file->name_file)}}" download="{{$file->name_file}}" >
                                                              <i class="ph-fill f-s-18 ph-download-simple"></i>
                                                          </a>
                                                      </small>
                                                    </div>
                                                  </div>
                                                  @else
                                                  <div class="card text-center d-flex justify-content-center" style="min-width:140px; height:180px;">
                                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                      <div class="fs-1">📄</div>
                                                      <small class="text-truncate d-block">
                                                          <a href="{{route('auth.service.look.file.task',$file->name_file)}}" download="{{$file->name_file}}">
                                                              <i class="ph-fill f-s-18 ph-download-simple"></i>
                                                          </a>
                                                      </small>
                                                    </div>
                                                  </div>
                                                  @endif

                                                @endforeach
                                              </div>
                                            </div>

                                            <div class="d-none d-lg-block">
                                            <div class="row ">
                                                @foreach($chat->files as $file)

                                                @if($file->type === 'image')                                                
                                                <div class="col-sm-4 mb-2">
                                                    <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                                        <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;">
                                                            <img src="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;" 
                                                            alt="">
                                                            <a href="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            download="{{$file->name_file}}">
                                                            <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" class="ph-fill  ph-cloud-arrow-down"></i>   
                                                            </a>
                                                        </div>
                                                    </a>
                                                </div>

                                                @else

                                                <div class="col-sm-4 mb-2">
                                                    <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                                        <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;" class="bg-secondary">                            
                                                            <a href="{{route('auth.service.look.file.task',$file->name_file)}}"
                                                            download="{{$file->name_file}}">
                                                            @php
                                                            $extension = pathinfo($file->name_file, PATHINFO_EXTENSION);
                                                            @endphp

                                                            <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" 
                                                            @if($extension === 'pdf')
                                                            class="ph  ph-file-pdf"
                                                            @elseif($extension === 'docx')
                                                            class="ph ph-file-doc"
                                                            @elseif($extension === 'zip')
                                                            class="ph ph-file-zip"
                                                            @else
                                                            class="ph-fill  ph-cloud-arrow-down"
                                                            @endif
                                                            ></i>   
                                                            </a>
                                                            <i style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); font-size: 9px; color: white;" class="fas fa-download">
                                                                {{$file->name_file}}
                                                            </i>
                                                        </div>
                                                    </a>
                                                </div>

                                                @endif

                                                @endforeach
                                            </div>
                                            </div>

                                            @endif

                                        </div>
                                    </div>
                                </li> 

                                @endif

                                @endforeach                                                  
                            </ul>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                                @if($task->status === 'Progress') 
                                <div class="flex-grow-1">
                                    <div class="input-group" id="pesanGroup">                                        
                                        <textarea type="text" 
                                        id="pesanTask" style="height: calc(1.5em + 0.75rem + 2px); overflow: hidden;" 
                                        class="form-control b-r-6" placeholder="Type a message"
                                            aria-label="Recipient's username"></textarea>
                                        @csrf    
                                        <button disabled id="tombolSend" onclick="kirimPesan()" class="btn btn-sm btn-primary ms-2 me-2 b-r-4" 
                                        type="button"><i
                                        class="ti ti-send"></i> Send</button>
                                    </div>
                                </div>
                                               
                                 
                                <div class="d-none d-sm-block">
                                    <input type="file" 
                                    accept=".docx,.pdf,.zip,.png,.jpg,.jpeg" 
                                    class="d-none" multiple id="filesLampiran" name="file[]"> 
                                     @if($task->responsibility != auth()->user()->id_users)
                                    <button id="uploadTombol" onclick="document.getElementById('filesLampiran').click()" 
                                    type="button" class="btn btn-sm btn-light-success position-relative h-35 w-35 text-center d-flex justify-content-center align-items-center">
                                        <i class="ti ti-paperclip"></i>
                                        <span id="fileUpload" class="d-none position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success badge-notification">
                                        10
                                      </span>
                                    </button>
                                    @endif
                                </div>
                                <div>
                                     @if($task->responsibility != auth()->user()->id_users)
                                    <div class="btn-group dropdown-icon-none d-sm-none">
                                        <a class="h-35 w-35 d-flex-center ms-1" role="button" data-bs-toggle="dropdown"
                                            data-bs-auto-close="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                                            <li
                                             onclick="document.getElementById('filesLampiran').click()"
                                            ><a class="dropdown-item">
                                                <i class="ti ti-paperclip"></i>
                                                <span class="f-s-13" id="mobileFiles">Lampiran</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>                              

                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end project activity -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2 justify-content-between flex-sm-row flex-column">
                                <h5>Lampiran Files</h5>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="recentdatatable" class="table table-bottom-border  recent-table align-middle table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>                       
                                            <th scope="col">Last Created At</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recent_key_body">
                                        @foreach($files as $row)

                                        @php
                                        $extension = pathinfo($row->name_file, PATHINFO_EXTENSION);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div>
                                                    @if($extension === 'pdf')
                                                     <img src="{{asset('dashboard/images/icons/pdf.png')}}" class="w-20 h-20" alt="">
                                                    @elseif($extension === 'docx')
                                                     <img src="{{asset('dashboard/images/icons/file.png')}}" class="w-20 h-20" alt="">
                                                    @elseif($extension === 'zip')
                                                     <img src="{{asset('dashboard/images/icons/zip.png')}}" class="w-20 h-20" alt="">
                                                    @else
                                                    <img src="{{asset('dashboard/images/icons/gallary.png')}}" class="w-20 h-20" alt="">
                                                    @endif
                                                    <span class="ms-2 table-text">{{$row->name_file}}</span>
                                                </div>
                                            </td>                                                    
                                            <td class="text-danger f-w-500">
                                                {{\Carbon\Carbon::parse($row->created_at)->locale('id')->translatedFormat('d F Y')}}
                                            </td>
                                            <td class="d-flex">
                                                <div class="dropdown folder-dropdown">
                                                    <a class="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                <ul class="dropdown-menu" style="">
                                                    <li>
                                                        <a class="dropdown-item view-item-btn"
                                                         href="{{route('auth.service.look.file.task',$row->name_file)}}" download="{{$row->name_file}}">
                                                            <i class="ti ti-download text-primary me-2">  </i>Download
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>                                            
                                        </td>
                                    </tr>
                                    @endforeach     
                            </tbody>
                        </table>
                    </div>
                </div>

                </div>


                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="updateStatus" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary ">
            <h5 class="modal-title text-white" id="exampleModalToggleLabel4">Update Status Task</h5>
            <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">            
        </div>
        <div class="modal-footer">
            <form 
            action="{{route('auth.service.update.status.task')}}"
            method="POST">@csrf @method('PUT')
            <input type="hidden" name="status" value="1">
            <button 
            name="id_tasks" 
            value="{{$task->id_tasks}}" 
            type="submit" class="badge text-light-primary fs-6">
            Completed</button></form>
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

    <div class="modal fade" id="openStatus" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-secondary ">
            <h5 class="modal-title text-white" id="exampleModalToggleLabel4">Update Status Task</h5>
            <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">            
        </div>
        <div class="modal-footer">
            <form 
            action="{{route('auth.service.update.status.task')}}"
            method="POST">@csrf @method('PUT')
            <input type="hidden" readonly name="status">
            <button 
            name="id_tasks" 
            value="{{$task->id_tasks}}" 
            type="submit" class="badge text-light-secondary fs-6">
            Buka Tasks</button></form>
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="kirimAsigsment" tabindex="-1"aria-modal="true" role="dialog">
        <div class="modal-dialog app_modal_sm">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="exampleModal2">Kirim Assigsment</h1>
                    <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
                </div>
                <div class="modal-body ">
                    <div class="d-flex gap-2">

                        <div class="d-flex flex-column gap-2">
                            <div class="app-form">
                                <form enctype="multipart/form-data" id="formAsigsment">
                                    @csrf
                                <div class="mb-3">
                                    <label class="form-label">Files (JPEG, PNG, JPG, PDF, DOCX, ZIP)</label>
                                    <input type="file" name="files[]" id="assigsment" accept=".jpeg, .png, .jpg, .pdf, .docx, .zip"
                                    multiple class="form-control">
                                    <input type="hidden" readonly name="name" value="{{auth()->user()->name}}">
                                    <input type="hidden" readonly name="sender" 
                                    value="{{auth()->user()->id_users}}">
                                    <input type="hidden" readonly name="tasks" value="{{$task->id_tasks}}">
                                </div>
                                </form>
                                <div class="mb-3" class="form-control">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="row" id="dataAssigsment">   

                                             <div class="d-flex text-center justify-content-center align-items-center d-none" id="loadingAsign">
                                                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>    
                                            </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="SendAsigsment()" type="button" class="btn btn-light-primary">
                    Kirim Assigsment</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_custom')
<script>
    /*
    |--------------------------------------------------------------------------
    | Melakukan Koneksi Ke Websocket Untuk Diskusi
    |--------------------------------------------------------------------------
    */

    const tombolSend = document.getElementById('tombolSend') // Tombol Sending Pesan    

    // Cek Koneksi
    const signal = document.getElementById('koneksi') // Icon KOneksi Untuk Memberitahu Konek / Tidak


    // Mmberikan Informasi JIka Websocket Terkonek 
    window.Echo.connector.pusher.connection.bind('connected', function() {
        console.log('✅ WebSocket Connected!');
        if (signal) {
            signal.classList.replace('text-danger','text-success')

            signal.innerHTML = ''
        }
        if (tombolSend) {
            tombolSend.classList.remove('disabled')
        }

    });    


    // Memberikan Informasi Jika Websocket Tidak Terkonek
    window.Echo.connector.pusher.connection.bind('disconnected', function() {
        console.log('❌ WebSocket Disconnected!');
        if (signal) {
                signal.classList.replace('text-success','text-danger')
                signal.innerHTML = ''
            }
        if (tombolSend) {
            tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            tombolSend.setAttribute('disabled','true')
        }
    });

    // Memberikan Informasi Jika Websocket Tidak Tersedia
    window.Echo.connector.pusher.connection.bind('unavailable', function() {
        console.log('❌ WebSocket unavailable!');
        if (signal) {
                signal.classList.replace('text-success','text-danger')
                signal.innerHTML = ''
            }
        if (tombolSend) {
            tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            tombolSend.setAttribute('disabled','true')
        }
    });

    // Memberikan Informasi Jika Websocket Gagal Connect
    window.Echo.connector.pusher.connection.bind('failed', function() {
        console.log('❌ WebSocket failed!');
        if (signal) {
                signal.classList.replace('text-success','text-danger')
                signal.innerHTML = ''
            }
        if (tombolSend) {
            tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            tombolSend.setAttribute('disabled','true')
        }
    });


     const taskId = @json($task->id_tasks); // Deklarasi Untuk Terhubung Room Diskusi Berdasarkan Id Task
     const idPic = @json($task->project_task->users->id_users) // Deklarasi Id PIC

     const picConn = document.getElementById('picOnline') // Icon Online
     const techCon = document.getElementById('techOnline') // Icon Online

     Echo.join(`task.forum.${taskId}`)
        .here((users) => {                        
            console.log('Online',users)
            users.map(item => {
                if (item.users.id_users == idPic) {
                    if (picConn.classList.contains('text-success')) {

                    }else{
                        picConn.classList.add('text-success')
                    }
                }else{
                    if (techCon.classList.contains('text-success')) {

                    }else{
                        techCon.classList.add('text-success')
                    }
                }
            })
        
        })
        .joining((user) => {
            console.log('Join',user)
            if (user.users.id_users == idPic) {
                if (picConn.classList.contains('text-success')) {

                }else{
                    picConn.classList.add('text-success')
                }
            }else{
                if (techCon.classList.contains('text-success')) {

                }else{
                    techCon.classList.add('text-success')
                }
            }
        })
        .leaving((user) => {
            console.log('Left',user)
            if (user.users.id_users == idPic) {
                if (picConn.classList.contains('text-success')) {
                    picConn.classList.remove('text-success')
                }
            }else{
                if (techCon.classList.contains('text-success')) {
                    techCon.classList.remove('text-success')
                }
            }
        })
        .error(err => console.log(err))
     // Melakukan Listening Pada Pesan Yang Masuk
     Echo.channel(`task.forum.${taskId}`)
        .listen('TaskForum', function (e) {   
            console.log(e)
            const idresponse = "{{auth()->user()->id_users}}"            
            const responsibilityClass = parseInt(e.user) == parseInt(idresponse) ? "text-light-primary  h-35 w-35 d-flex-center b-r-50" : "text-light-success  h-35 w-35 d-flex-center b-r-50"
            const nameClass = parseInt(e.user) == parseInt(idresponse) ? "text-primary f-s-16 mb-0" : "text-success f-s-16 mb-0"

            const PCI = parseInt(e.user) == parseInt(idresponse) ? "" : "PCI"

            let pesanFiles = ''
            let fileRoute = "{{ route('auth.service.look.file.task', ':name') }}"; 
            if (e.message.files) {
                e.message.files.map(e => {                 
                  let fileUrl = fileRoute.replace(':name', e.name_file);
                  if (e.type === 'image') {
                      pesanFiles += `
                        <div class="col-sm-4 mb-2">
                            <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;">
                                    <img src="${fileUrl}"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;" 
                                        alt="">
                                    <a href="${fileUrl}"
                                        download="${e.name_file}">
                                        <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" class="ph-fill  ph-cloud-arrow-down"></i>   
                                    </a>
                                </div>
                            </a>
                        </div>
                      `  
                  }else{
                    pesanFiles += `
                        <div class="col-sm-4 mb-2">
                            <a class="glightbox" data-glightbox="type: image; zoomable: true;">
                                <div style="position: relative; width: 100%; padding-bottom: 66.67%; overflow: hidden;" class="bg-secondary">
                                                                       
                                    <i style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); font-size: 9px; color: white;" class="fas fa-download">
                                        ${e.name_file}
                                    </i>
                                    <a href="${fileUrl}"
                                        download="${e.name_file}">
                                        <i style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 30px; color: white;" class="ph-fill  ph-cloud-arrow-down"></i>   
                                    </a>
                                </div>
                            </a>
                        </div>
                    `
                  }
                })
            }

            let mesageComponent = document.getElementById('message-chat')
            let messageCOmponent = `
                <li class="timeline-section">
                    <div class="timeline-icon">
                        <span class="${responsibilityClass}">
                        ${e.name.charAt(0).toUpperCase()}
                        </span>
                    </div>
                    <div class="timeline-content pt-0 ">
                        <div class="d-flex f-s-16">
                            <p class="${nameClass}"
                            >${e.name}
                            </p>&nbsp;<span class="text-secondary ms-2"> <span class="badge text-outline-success me-2">
                            ${e.type === 'Pesan' ? 'Mengirim Pesan' : 'Mengirim Tugas'}</span> 
                            ${PCI}    
                            </span>

                        </div>
                        <p class="">
                            ${e.message.waktu}
                        </p>
                        <div class="timeline-border-box me-2 ms-0 mt-3">
                            <h6 class="mb-0">${e.type === 'Pesan' ? 'Pesan' : 'Lampiran'}</h6>
                            <p class="mb-4 text-secondary">${e.message.pesan ? e.message.pesan : ''}</p>
                            <div class="row">
                                ${e.message.files ? pesanFiles : '' }
                            </div>
                        </div>
                     </div>
                </li>            
            `
            mesageComponent.insertAdjacentHTML('beforeend',messageCOmponent)
            // const scrollHeight = document.body.scrollHeight;
            // window.scrollTo(0, scrollHeight);            

            const bodyChat = document.getElementById('chatBody')
            bodyChat.scrollTop = bodyChat.scrollHeight;

            if (tombolSend) {
                tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            }
        })
        .error((error) => {
            console.error('❌ Echo Error:', error);
            if (signal) {
                signal.classList.replace('text-success','text-danger')
            }
            if (tombolSend) {
                tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
                tombolSend.setAttribute('disabled','true')
            }
        });       

    console.log('Subscribed channels:', window.Echo.connector.pusher.channels);
    console.log('Echo initialized:', window.Echo);


    //Melakukan Preview Pada File Assigsment Yang Di Upload
    const uploadAssigsment = document.getElementById('assigsment')
    uploadAssigsment.addEventListener('change',(e) => {
        const asign = document.getElementById('dataAssigsment')
        let html = ''
        asign.querySelector('#loadingAsign').classList.replace('d-none','d-block')
        for (let i = 0; i < uploadAssigsment.files.length; i++) {
            const file = uploadAssigsment.files[i];
            const urls = URL.createObjectURL(file);

            if (file.type.startsWith('image/')) {    
                html +=`
                    <div class="col-6 col-sm-3 col-lg-6 mb-3">
                        <div class="imagebox">
                            <a  class="glightbox"
                                data-glightbox="title:Description Right; description: You can set the position of the description ;descPosition: right;">
                                <img src="${urls}" class="img-fluid"
                                    alt="image">
                                </a>
                        </div>
                    </div> 
                `
            }else{
                html += `
                    <div class="col-6 col-sm-3 col-lg-6 mb-3">
                    <div class="imagebox ">
                    <a  class="glightbox"
                    data-glightbox="title:Description Right; description: You can set the position of the description ;descPosition: right;">
                    <div class="img-fluid bg-primary d-flex justify-content-center align-items-center align-self-center"
                    style="min-width: 150px; height:150px;" 
                    alt="image">
                    <i class="ti f-s-18 ti-file"></i>&nbsp; Files       
                    </div>
                    </a>
                    </div>
                    </div> 
                `
            }
        }        
        asign.innerHTML = html
    })

    // Melakukan Pemberitahuan Informasi File Ynag Di Upload Saat Kirim Pesan Dengan Files
    const upload = document.getElementById('fileUpload')
    const filesInput = document.getElementById('filesLampiran')
    const mobileupload = document.getElementById('mobileFiles')
    filesInput.addEventListener('change',(e) => {
        console.log(true)
        upload.classList.replace('d-none','d-block');
        upload.textContent = filesInput.files.length
        mobileupload.textContent = `Lampiran (${filesInput.files.length})`
    })

    // Melakukan Disabled Pada Tombol Kirim Saat Pesan Belum Tersedia / Tertulis
    const inputPesan = document.getElementById('pesanTask')
    inputPesan.addEventListener('input',(e) => {
        if (inputPesan.value.trim() === "") {
            tombolSend.disabled = true            
        }else{
            tombolSend.disabled = false
        }
    })


    // Menampilkan Pesan Error 
    function pesanError(pesan,status){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'error',
            title: `${pesan}. STATUS:${status}`
        })
    }

    // Melakukan Pengiriman Assigsment
    function SendAsigsment(){
        if (tombolSend) {
            tombolSend.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
        }
        const forms = document.getElementById('formAsigsment')
        const formData = new FormData(forms);
        formData.append('type','Tugas')
        formData.append('message','Mengirim Tugas')
        const url ="{{route('auth.service.create.broadcast.task')}}"

        const modals = document.getElementById('kirimAsigsment')
        var modal = bootstrap.Modal.getInstance(modals);
        modal.hide();
        modals.querySelector('#assigsment').value = ''
        modals.querySelector('#dataAssigsment').innerHTML = ''       

        axios.post(url,formData,{
            headers:{
                'Content-Type' : 'multipart/form-data',
            }
        }).then(resp => {

        }).catch(err => {
            pesanError('Pesan Gagal Terkirim',err.response.status)
            if (tombolSend) {
                tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            }
        })
    }


    // Melakukan Pengiriman Pesan Diskusi
    function kirimPesan(){
        if (tombolSend) {
            tombolSend.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
        }
        const group = document.getElementById('pesanGroup')
        const csrf = group.querySelector('input[name="_token"]').value
        const url ="{{route('auth.service.create.broadcast.task')}}"
        
        const pesan = document.getElementById('pesanTask')

        const fileInput = document.getElementById('filesLampiran');
        const formData = new FormData();

        if (fileInput.files.length) {
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                formData.append('files[]', file);
            }            
        }

        formData.append('tasks','{{$task->id_tasks}}')
        formData.append('name','{{auth()->user()->name}}')
        formData.append('sender',"{{auth()->user()->id_users}}")
        formData.append('message',pesan.value)

        axios.post(url,formData,{
            headers:{
                'Content-Type' : 'multipart/form-data',
                'X-CSRF-TOKEN' : csrf
            }
        }).then(response => {
            console.log(response.data)
            inputPesan.value = ''
            upload.classList.replace('d-block','d-none');
            upload.classList.textContent = ''
        }).catch(err => {
            console.log(err)
            if (tombolSend) {
                tombolSend.innerHTML = `<i class="ti ti-send"></i> Send`
            }
            pesanError('Pesan Gagal Terkirim',err.response.status)
            upload.classList.replace('d-block','d-none');
            upload.classList.textContent = ''
        })      

    }
</script>
@endsection
