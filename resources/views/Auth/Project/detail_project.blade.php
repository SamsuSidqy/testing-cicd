@extends('layout.dashboard')
@section('section_dashboard')
@hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'show')
    <main>
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                	@if (auth()->user()->id_users === $project->project->pm)
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5>Data Tasks Proyek</h5>
                                <button type="button" 
                                data-bs-toggle="modal"
                                data-bs-target="#createTask"
                                class="btn btn-outline-primary icon-btn b-r-4"> <i class="ph-bold  ph-note-pencil"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Tasks</th>
                                            <th scope="col">Responsebility</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@foreach($task as $i => $tugas)
                                        <tr>
                                            <td>{{$i + 1}}</td>
                                            <td class="f-w-500">{{$tugas->name}}</td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    <p class="mb-0 f-w-500 ">
                                                    {{$tugas->anggota->name}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                               @if($tugas->status != 'Completed')
                                                {!! hitung_deadline($tugas->deadline) !!}
                                               @endif
                                                @if($tugas->extend_deadline)
                                                <span class="badge text-bg-warning">
                                                Extended Deadline</span>
                                                @endif
                                                @if($tugas->status != 'Progress')
                                                <span class="badge text-light-success">
                                                Completed
                                                </spam>
                                                @endif
                                            </td>
                                            <td>
                                                @if($tugas->status === 'Progress')
                                                <span class="badge text-light-primary">
                                                {{$tugas->status}}
                                                </span>
                                                @else
                                                <span class="badge text-light-success">
                                                {{$tugas->status}}
                                                </span>
                                                @endif
                                            </td>
                                            <td class="text-success f-w-500">
                                                <div class="d-flex gap-3 flex-wrap">

                                                    <a 
                                                    href="{{route('auth.project.task.detail',$tugas->slug)}}"
                                                        class="position-relative bg-light-primary px-2 py-1 b-r-10">
                                                        <i class="ph-bold f-s-22 ph-eye"></i>
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle p-1 bg-primary rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                    </a>

                                                    @if($tugas->status === 'Progress')
                                                    <a 
                                                    @hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'updated')
                                                    data-bs-target="#updateTasks" data-bs-toggle="modal"
                                                    @else                                      
                                                    style="cursor:not-allowed;"
                                                    @endhasPermissionsUsers             
                                                    data-id="{{$tugas->id_tasks}}"
                                                    data-name="{{$tugas->name}}"
                                                    data-response="{{$tugas->anggota->id_users}}"
                                                    data-deadline="{!! hitung_deadline($tugas->deadline) !!}"
                                                    data-deadlines="{{Carbon\Carbon::parse($tugas->deadline)->format('d F Y')}}"
                                                        class="position-relative bg-light-info px-2 py-1 b-r-10">
                                                        <i class="ph-light f-s-22 ph-note-pencil"></i>
                                                    </a>
                                                    @endif

                                                    @if($tugas->status === 'Progress')
                                                    <a 
                                                    @hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'delete')
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteTasks"
                                                    @else                                      
                                                    style="cursor:not-allowed;"
                                                    @endhasPermissionsUsers                  
                                                    data-id="{{$tugas->id_tasks}}"
                                                        class="position-relative bg-light-warning px-2 py-1 b-r-10">
                                                        <i class="ph-light f-s-22 ph-trash"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5>Tasks Proyek Anda</h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Tasks</th>
                                            <th scope="col">Responsebility</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@foreach($task as $i => $tugas)
                                    	@if($tugas->anggota->id_users === auth()->user()->id_users)
                                        <tr>
                                            <td>{{$i + 1}}</td>
                                            <td class="f-w-500">{{$tugas->name}}</td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    <p class="mb-0 f-w-500 ">
                                                    {{$tugas->anggota->name}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @if($tugas->status === 'Progress')
                                                {!! hitung_deadline($tugas->deadline) !!}
                                                @else
                                                <span class="badge text-light-success">
                                                Selesai
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                            	@if($tugas->status === 'Progress')
                                                <span class="badge text-light-primary">
                                                {{$tugas->status}}
                                                </span>
                                                @else
                                                <span class="badge text-light-success">
                                                {{$tugas->status}}
                                                </span>
                                                @endif
                                            </td>
                                            <td class="text-success f-w-500">
                                                <div class="d-flex gap-3 flex-wrap">

                                                    <a href="{{route('auth.project.task.detail',$tugas->slug)}}"
                                                        class="position-relative bg-light-primary px-2 py-1 b-r-10">
                                                        <i class="ph-bold f-s-22 ph-eye"></i>
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle p-1 bg-primary rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif


                </div>
                <div class="col-12">
                    <!-- About project -->
                    <div class="card">
                        <div class="card-header">
                            @if(round($persentase))
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated rounded"
                                style="width: {{round($persentase)}}%"> {{round($persentase)}}% </div>
                            @else                            
                            <div class="progress-bar bg-light progress-bar-striped" 
                            style="width: 100%">0 %</div>                        
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>{{ $project->project->title }}</h6>
                                <p class="text-muted">
                                    {{ $project->project->deskripsi }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="d-block d-sm-none d-flex overflow-x-auto gap-2">
                                    @foreach($project->project->member as $data)
                                        <div class="card team-box-card hover-effect" style="min-width: 250px;">
                                            <div class="mb-3 mt-2">
                                                    @if(auth()->user()->id_users === $project->project->pm)

                                                    @if($project->project->pm != $data->users->id_users)
                                                    <div class="dropdown">
                                                        <button class="bg-none border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical text-dark"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                                          <li
                                                          data-bs-toggle="modal"
                                                          data-bs-target="#confirmKickModal"
                                                          data-id-users="{{$data->users->id_users}}"
                                                          data-id-project="{{$project->project->id_projects}}"
                                                          >
                                                            <a class="dropdown-item" href="#">
                                                              <i class="ph-bold text-warning ph-arrow-square-out"></i> Kick User
                                                            </a>
                                                          </li>
                                                          </li>
                                                        </ul>
                                                      </div>
                                                      @else
                                                      <div class="mt-4"></div>
                                                      @endif

                                                      @endif
                                                </div>
                                                <div class="team-container mt-5">
                                                    <div class="team-pic">
                                                        <span
                                                            class="bg-secondary h-80 w-80 d-flex-center b-r-50 position-relative overflow-hidden">
                                                            <img src="/wp-content/profile/{{ $data->users->profile }}"
                                                                alt="" class="img-fluid b-r-50 ">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="taem-content">

                                                    <div class="mb-3 mt-3">
                                                        <h5>{{ $data->users->name }}</h5>
                                                        @if ($data->users->id_users === $project->project->pm)
                                                            <span class="badge text-bg-primary b-r-0">PIC</span>
                                                        @else
                                                            <span class="badge text-bg-secondary b-r-0">Anggota</span>
                                                        @endif
                                                    </div>

                                                    <p class="team-content-list text-muted  mb-3 ">
                                                        {{ $data->users->address }}
                                                    </p>

                                                    <div class="p-2 mb-3">
                                                        @if (!empty($data->users->facebook))
                                                            <button type="button"
                                                                onclick="window.location.href'{{ $data->users->facebook }}'"
                                                                class="btn btn-facebook icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-facebook text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->twitter))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->twitter }}'"
                                                                class="btn btn-twitter icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-twitter text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->linkedln))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->linkedln }}'"
                                                                class="btn btn-facebook icon-btn b-r-22 me-2"><i
                                                                    class="ph ph-linkedin-logo text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->whatsaap))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->whatsaap }}'"
                                                                class="btn btn-whatsapp icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-whatsapp text-white"></i></button>
                                                        @endif

                                                    </div>
                                                </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    @foreach ($project->project->member as $data)
                                        <div class=" col-md-6 col-xl-4 d-none d-sm-block">
                                            <div class="card team-box-card hover-effect overflow-hidden">
                                                <div class="mb-3 mt-2">
                                                    @if(auth()->user()->id_users === $project->project->pm)

                                                    @if($project->project->pm != $data->users->id_users)
                                                    <div class="dropdown">
                                                        <button class="bg-none border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical text-dark"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                                          <li
                                                          data-bs-toggle="modal"
                                                          data-bs-target="#confirmKickModal"
                                                          data-id-users="{{$data->users->id_users}}"
                                                          data-id-project="{{$project->project->id_projects}}"
                                                          >
                                                            <a class="dropdown-item" href="#">
                                                              <i class="ph-bold text-warning ph-arrow-square-out"></i> Kick User
                                                            </a>
                                                          </li>
                                                          </li>
                                                        </ul>
                                                      </div>
                                                      @else
                                                      <div class="mt-4"></div>
                                                      @endif

                                                      @endif
                                                </div>
                                                <div class="team-container mt-5">
                                                    <div class="team-pic">
                                                        <span
                                                            class="bg-secondary h-80 w-80 d-flex-center b-r-50 position-relative overflow-hidden">
                                                            <img src="/wp-content/profile/{{ $data->users->profile }}"
                                                                alt="" class="img-fluid b-r-50 ">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="taem-content">

                                                    <div class="mb-3 mt-3">
                                                        <h5>{{ $data->users->name }}</h5>
                                                        @if ($data->users->id_users === $project->project->pm)
                                                            <span class="badge text-bg-primary b-r-0">PIC</span>
                                                        @else
                                                            <span class="badge text-bg-secondary b-r-0">Anggota</span>
                                                        @endif
                                                    </div>

                                                    <p class="team-content-list text-muted  mb-3 ">
                                                        {{ $data->users->address }}
                                                    </p>

                                                    <div class="p-2 mb-3">
                                                        @if (!empty($data->users->facebook))
                                                            <button type="button"
                                                                onclick="window.location.href'{{ $data->users->facebook }}'"
                                                                class="btn btn-facebook icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-facebook text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->twitter))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->twitter }}'"
                                                                class="btn btn-twitter icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-twitter text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->linkedln))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->linkedln }}'"
                                                                class="btn btn-facebook icon-btn b-r-22 me-2"><i
                                                                    class="ph ph-linkedin-logo text-white"></i></button>
                                                        @endif

                                                        @if (!empty($data->users->whatsaap))
                                                            <button type="button"
                                                                onclick="window.location.href='{{ $data->users->whatsaap }}'"
                                                                class="btn btn-whatsapp icon-btn b-r-22 me-2"><i
                                                                    class="ti ti-brand-whatsapp text-white"></i></button>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if (auth()->user()->id_users === $project->project->pm)
                                <div 
                                class="d-flex justify-content-end align-items-center mx-2 my-2">
                                    <button 
                                    data-bs-target="#addUser"
                                    data-bs-toggle="modal"
                                    class="btn btn-sm btn-info">Tambah Anggota</button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- about project end  -->

                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Location Project
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <iframe class="form-control" src="https://www.google.com/maps?q={{$project->project->latitude}},{{$project->project->lontitude}}&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>



    <div class="modal fade" id="createTask" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog app_modal_sm">
            <div class="modal-content">
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="createTask">Buat Task Baru</h1>
                    <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
                </div>
                <div class="modal-body">
                	<form
                	action="{{route('auth.service.create.task')}}"
                	method="POST"
                	>@csrf
                	<input type="hidden" value="{{$project->project->id_projects}}" name="project">
                    <div class="app-form">
                    	<div class="mb-3">
                    		<label class="form-label">Nama Tasks</label>
                    		<input name="name" class="form-control" type="text">
                    	</div>
                        <div class="mb-3">
                            <label class="form-label">Deadline Tasks</label>
                            <input type="text" class="form-control" value="Tanggal Deadline" 
                            name="deadline" id="deadline">
                        </div>
                    	<div class="mb-3">
                    		<label class="form-label">Responsibility</label>
                    		<select name="responsibility" class="form-control">
                    			<option disabled selected>
                    			---- Responsibility Tugas ----</option>
                    			@foreach($project->project->member as $data)

                    			@if($data->users->id_users != $project->project->pm)
                    			<option value="{{$data->users->id_users}}" >{{$data->users->name}}</option>
                    			@endif

                    			@endforeach
                    		</select>
                    	</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-light-primary">Save changes</button>
                	</form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmKickModal" tabindex="-1" aria-modal="true" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-danger ">
                <h5 class="modal-title text-white" id="exampleModalToggleLabel9">
                    Anda Yakin Ingin Mengeluarkan User ? 
                </h5>
                <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">              
            </div>
            <div class="modal-footer">
                <form
                action="{{route('auth.service.update.project.kick')}}"
                method="POST"
                >@csrf @method('PUT')
                <input type="hidden" name="id_project" id="id_project" readonly>
                <input type="hidden" name="id_user" id="id_user" readonly>
                <button type="submit" class="badge text-light-danger fs-6">
                    Keluarkan
                </button></form>                
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="addUser" tabindex="-1" aria-modal="true" role="dialog" >
        <div class="modal-dialog app_modal_sm">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="createTask">
                    Tambah User Baru</h1>
                    <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
                </div>
                <div class="modal-body">
                    <form
                    action="{{route('auth.service.update.project.add')}}"
                    method="POST"
                    >@csrf @method('PUT')
                    <input type="hidden" readonly value="{{$project->project->id_projects}}" name="id_projects">
                    <div class="d-flex flex-column gap-2">
                        @foreach($users as $user)

                        @if($project->project->member->where('users.id_users',$user->id_users)->first())
                        @else
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div
                                    class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-primary me-2 simple-table-avtar">
                                    <img src="/wp-content/profile/{{$user->profile}}" 
                                    alt="" class="img-fluid">
                                </div>
                                <p>{{$user->name}}</p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="form-check 
                                    form-switch">
                                    <input 
                                    name="users[]"
                                    class="form-check-input" 
                                    type="checkbox" value="{{$user->id_users}}" 
                                    role="switch" id="switchCheckDefault">
                                </div>
                            </div>
                        </div>
                        @endif

                        @endforeach

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-info" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-light-info">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateTasks" tabindex="-1" aria-modal="true" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-secondary ">
                <h5 class="modal-title text-white" id="exampleModalToggleLabel9">
                    Melakukan Perubahan Tasks ? 
                </h5>
                <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form
                action="{{route('auth.service.update.task')}}"
                method="POST"
                >@csrf @method('PUT')
                <input type="hidden" readonly name="id_tasks" id="idTask">
                <div class="app-form">
                    <div class="mb-3">
                        <label class="form-label">Nama Task</label>
                        <input type="text" class="form-control" name="name" id="nameTask">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Responsebility</label>
                        <select class="form-control" name="responsibility" id="responsibility">
                            @foreach($project->project->member as $data)

                            @if($data->users->id_users != $project->project->pm)
                            <option value="{{$data->users->id_users}}" >{{$data->users->name}}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" >
                        <label class="form-label">Deadline Status</label>
                        <div class="form-control" id="deadlineTask">
                            
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Ubah Deadline</label>
                        <input type="text" value="" class="form-control" name="deadline" id="changeDeadline">
                    </div>
                </div>              
            </div>
            <div class="modal-footer">
                
                <button type="submit" class="badge text-light-secondary fs-6">
                Simpan Perubahan
                </button></form>                
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
    </div>

<div class="modal fade" id="deleteTasks" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger ">
        <h5 class="modal-title text-white" id="exampleModalToggleLabel9">
            Anda Yakin Ingin Menghapus Tasks ? 
        </h5>
        <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-footer">
        <form
        action="{{route('auth.service.delete.task')}}"
        method="POST"
        >@csrf @method('PUT')
        <button 
        name="id_tasks"
        id="idTask" 
        type="submit" class="badge text-light-danger fs-6">Hapus Tasks</button>
        </form>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
</div>
</div>

@endsection

@section('js_custom')
<script src="{{asset('dashboard/vendor/flatpicker/flatpickr.js')}}"></script>
<script>
  let endPicker;

  const startPicker = flatpickr("#deadline", {
    locale: "id",
    dateFormat: "d F Y",
    disableMobile: true,
  });

   const deleteModalTask = document.getElementById('deleteTasks')
   deleteModalTask.addEventListener('show.bs.modal',(e) => {
        let btn = e.relatedTarget

        const id = btn.getAttribute('data-id');
        deleteModalTask.querySelector('#idTask').value = id
   })

   const kickModal = document.getElementById('confirmKickModal')
   kickModal.addEventListener('show.bs.modal',(event) => {
        let btn = event.relatedTarget;

        const users = btn.getAttribute('data-id-users')
        const project = btn.getAttribute('data-id-project')

        kickModal.querySelector('#id_user').value = users
        kickModal.querySelector('#id_project').value = project
   })

   const updateTaskModal = document.getElementById('updateTasks')
   updateTaskModal.addEventListener('show.bs.modal',(event) => {
        let btn = event.relatedTarget;

        const idTask = btn.getAttribute("data-id")
        const name = btn.getAttribute('data-name')
        const response = btn.getAttribute('data-response')
        const deadline = btn.getAttribute("data-deadline")
        const dateDeatLine = btn.getAttribute('data-deadlines')

        const pickerDate = flatpickr("#changeDeadline", {
            locale: "id",
            dateFormat: "d F Y",
            disableMobile: true,
        });
        pickerDate.set('minDate',dateDeatLine)        

        updateTaskModal.querySelector('#nameTask').value = name
        updateTaskModal.querySelector('#idTask').value = idTask
        updateTaskModal.querySelector('#responsibility').value = response
        updateTaskModal.querySelector('#deadlineTask').innerHTML = deadline


   })

   function pesanError(pesan,status){        
        Toastify({
            duration: 3000,
            text: `${pesan}. STATUS : (${status})`,
            close:true,
            style:{
                background:'#FA6868',
                color:'#fff'
            }
        }).showToast()
    }

    function pesanSukses(pesan,status){
        Toastify({
            duration: 3000,
            text: `${pesan}. STATUS : (${status})`,
            close:true,
            style:{
                background:'#628141',
                color:'#fff'
            }
        }).showToast()
    }

</script>

@if($errors->any())
<script>
    const message = '{{$errors->first()}}'
    pesanError(message,400)
</script>
@endif

@if(session('success'))
<script>
    const message = "{{session('success')}}"
    pesanSukses(message,200)
</script>
@endif


@else 
<main>
    <div class="container-fluid">
        <h3>Anda Belum Memiliki Izin Untuk Melihat Projek. Hubungi Developer</h3>
    </div>
</main>                    
@endhasPermissionsUsers

@endsection