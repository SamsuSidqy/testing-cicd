@extends('layout.dashboard')
@section('section_dashboard')
@hasPermissionsUsers('auth/project/me',auth()->user()->id_users,'show')
    <main>
        <div class='container-fluid'>
            <div class="row">

                @foreach($myproject as $data)
                <div class="col-md-6 col-xl-4 project-card">
                    <div class="card hover-effect" id="card1">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden">
                                    <i class="ph-duotone  ph-projector-screen-chart
                                    img-fluid f-s-30
                                    "></i>
                                </div>
                                <a href="{{route('auth.project.detail',$data->project->slug)}}" target="_blank" class="flex-grow-1 ps-2">
                                    <h6 class="m-0 text-dark f-w-600"> 
                                        {{substr($data->project->title,0,18)}}
                                        @if(strlen($data->project->title) > 18) ... @endif
                                    </h6>
                                </a>

                                @if($data->project->pm === Auth::user()->id_users)
                                <div class="dropdown">
                                    <button class="bg-none border-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical text-dark"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li 
                                        @hasPermissionsUsers(request()->route()->uri(),auth()->user()->id_users,'updated')
                                        style="cursor:pointer;
                                        @else
                                        style="cursor:not-allowed;;
                                        @endhasPermissionsUsers
                                        ">
                                            <a 
                                            @hasPermissionsUsers(request()->route()->uri(),auth()->user()->id_users,'updated')
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateProject"
                                            @endhasPermissionsUsers
                                            data-id="{{$data->project->id_projects}}"
                                            data-title="{{$data->project->title}}"
                                            data-deskripsi="{{$data->project->deskripsi}}"
                                            data-latitude="{{$data->project->latitude}}"
                                            data-lontitude="{{$data->project->lontitude}}"
                                            data-start="{{\Carbon\Carbon::parse($data->project->start)->format('d F Y')}}"
                                            data-ended="{{\Carbon\Carbon::parse($data->project->ended)->format('d F Y')}}"
                                            class="dropdown-item">
                                                <i class="ti ti-edit text-success"></i> Edit
                                            </a>
                                        </li>
                                        @if(persentase_task($data->project->id_projects) == 0)
                                        <li 
                                        @hasPermissionsUsers(request()->route()->uri(),auth()->user()->id_users,'delete')
                                        style="cursor:pointer;
                                        @else
                                        style="cursor:not-allowed;
                                        @endhasPermissionsUsers
                                        >
                                            <a class="dropdown-item " 
                                            data-id="{{$data->project->id_projects}}"
                                            @hasPermissionsUsers(request()->route()->uri(),auth()->user()->id_users,'delete')
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteProject"
                                            @endhasPermissionsUsers                          
                                            >
                                            <i class="ti ti-trash text-danger"></i> Delete
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <h6 class="text-dark f-s-14">Start Date : <span class="text-success">
                                    {{ \Carbon\Carbon::parse($data->project->start)->locale('id')->translatedFormat('d F Y') }}                                        
                                    </span>
                                    </h6>
                                    <h6 class="text-dark f-s-14">End Date : <span class="text-danger">{{ \Carbon\Carbon::parse($data->project->ended)->locale('id')->translatedFormat('d F Y') }}</span></h6>
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <p class="f-w-500 text-secondary">
                                        @if($data->project->pm === Auth::user()->id_users)
                                        <span class="badge text-bg-primary b-r-0">
                                        PIC
                                        </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <p class="text-muted f-s-14 text-secondary txt-ellipsis-2">
                            {{$data->project->deskripsi}}
                            </p>
                            <div class="text-end mb-2">
                                @if(persentase_task($data->project->id_projects) == 100)
                                <span class="badge text-light-success">Complete</span>
                                @else
                                <span class="badge text-light-primary">Progress</span>
                                @endif
                            </div>
                            <div class="progress w-100" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100">
                                <div class="progress-bar 
                                @if(persentase_task($data->project->id_projects) == 100)
                                bg-success
                                @else
                                bg-primary
                                @endif
                                " 
                                style="width: {{persentase_task($data->project->id_projects)}}%"> {{persentase_task($data->project->id_projects)}} % </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-dark f-w-600"><i class="ti ti-brand-wechat f-s-18"></i> {{count($data->project->member)}}
                                        Members</span>
                                </div>
                                <div class="col-6">

                                    <ul class="avatar-group float-end breadcrumb-start ">
                                        @foreach($data->project->member as $i => $member)

                                        @if($i < 5)
                                        <li class="h-30 w-30 d-flex-center b-r-50 text-bg-danger b-2-light position-relative"
                                            data-bs-toggle="tooltip" data-bs-title="Sabrina Torres">
                                            <img src="/wp-content/profile/{{$member->users->profile}}" alt=""
                                                class="img-fluid b-r-50 overflow-hidden">
                                        </li>     
                                        @endif                                
                                        @endforeach   
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </main>

    <div class="modal fade" id="updateProject" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog app_modal_sm">
          <div class="modal-content">
            <div class="modal-header bg-primary-800">
              <h1 class="modal-title fs-5 text-white" id="exampleModal2">Update Project</h1>
              <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
          </div>
          <div class="modal-body">              
          <div class="app-form">
            <form
            action="{{route('auth.service.update.project')}}"
            method="POST"
            >@csrf @method('PUT')
            <div class="mb-2">
                <input type="hidden" readonly name="id_project" id="idProjects">
                <label for="userName" class="form-label">Title Project</label>
                <input type="text" class="form-control" id="titleProject" name="title" placeholder="Judul Project">
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2">
                <label for="userName" class="form-label">Deskripsi Project</label>
                <textarea name="deskripsi" id="deskripsiProject" class="form-control" placeholder="Deskripsi Projek"></textarea>
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2">
                <label for="userName" class="form-label">Start Project</label>
                <input name="start" type="text" class="form-control" id="startProject" placeholder="Tanggal Mulai Project">                        
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2">
                <label for="userName" class="form-label">Ended Project</label>
                <input name="ended" type="text" class="form-control" id="endProject" placeholder="Tanggal Mulai Project">
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2">
                <label for="userName" class="form-label">Latitude Project</label>
                <input name="latitude" type="text" class="form-control" id="latitude" placeholder="Latitude Location">
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2">
                <label for="userName" class="form-label">Lontitude Project</label>
                <input name="lontitude" type="text" class="form-control" id="lontitude" placeholder="Lontitude Location">
                <div class="mt-1">
                    <span id="userNameError" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-2" id="mapsProject">
                
            </div>
          </div>
         </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-light-primary">Save changes</button></form>
      </div>
  </div>
</div>
</div>

<div class="modal fade" id="deleteProject" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger ">
        <h5 class="modal-title text-white" id="exampleModalToggleLabel9">
            Anda Yakin Ingin Menghapus Projek ? 
        </h5>
        <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-footer">
        <form
        action="{{route('auth.service.delete.project')}}"
        method="POST"
        >@csrf @method('PUT')
        <button 
        name="id_projects"
        id="idProject" 
        type="submit" class="badge text-light-danger fs-6">Hapus Project</button>
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
    const deleteModal = document.getElementById('deleteProject')
    deleteModal.addEventListener('show.bs.modal',(e) => {
        let btn = e.relatedTarget;
        const projectId = btn.getAttribute('data-id')
        deleteModal.querySelector('#idProject').value = projectId
    });

    const updateModal = document.getElementById('updateProject')
    updateModal.addEventListener('show.bs.modal',(e) => {
        let btn = e.relatedTarget;

        const projectId = btn.getAttribute('data-id');
        const projectTitle = btn.getAttribute('data-title');
        const projectDeskripsi = btn.getAttribute('data-deskripsi');
        const projectLatitude = btn.getAttribute('data-latitude');
        const projectLongitude = btn.getAttribute('data-lontitude');
        const projectStart = btn.getAttribute('data-start');
        const projectEnd = btn.getAttribute('data-ended');

        updateModal.querySelector('#titleProject').value = projectTitle
        updateModal.querySelector('#deskripsiProject').value = projectDeskripsi


        let endPicker;

          const startPicker = flatpickr("#startProject", {
            locale: "id",
            dateFormat: "d F Y",
            disableMobile: true,

            onChange: function(selectedDates) {
              const startDate = selectedDates[0];

              // SET batas minimum end project
              endPicker.set("minDate", startDate);

              // RESET end project kalau sebelumnya lebih kecil
              if (endPicker.selectedDates.length > 0 &&
                  endPicker.selectedDates[0] < startDate) {
                endPicker.clear();
              }
            }
          });

          startPicker.setDate(projectStart)

          endPicker = flatpickr("#endProject", {
            locale: "id",
            dateFormat: "d F Y",
            disableMobile: true
          });
          endPicker.setDate(projectEnd)
          endPicker.set('minDate',projectStart)

        updateModal.querySelector('#startProject').value = projectStart
        updateModal.querySelector('#endProject').value = projectEnd


        updateModal.querySelector('#latitude').value = projectLatitude
        updateModal.querySelector('#lontitude').value = projectLongitude

        updateModal.querySelector('#mapsProject').innerHTML = `
            <iframe class="form-control" src="https://www.google.com/maps?q=${projectLatitude},${projectLongitude}&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        `
        updateModal.querySelector('#idProjects').value = projectId

    });

    

      const latInput = document.getElementById('latitude');
      const lngInput = document.getElementById('longitude');
      const embedCodeBox = document.getElementById('mapsProject');

      function updateMap() {
            const lat = latInput.value;
            const lng = lngInput.value;
                
            const mapUrl = `https://www.google.com/maps?q=${lat},${lng}&z=14&output=embed`;
        
                
            const embedCode = `<iframe class="form-control" src="${mapUrl}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
            embedCodeBox.innerHTML = embedCode;
       }     

       latInput.addEventListener('input', updateMap);
       lngInput.addEventListener('input', updateMap);

</script>
@else 
<main>
    <div class="container-fluid">
        <h3>Anda Belum Memiliki Izin Untuk Melihat Projek. Hubungi Developer</h3>
    </div>
</main>                    
@endhasPermissionsUsers
@endsection

