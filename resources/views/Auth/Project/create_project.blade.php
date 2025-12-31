@extends('layout.dashboard')
@section('section_dashboard')
    @hasPermissionsUsers(request()->route()->uri(), Auth::user()->id_users, 'show')
    <main>
        <div class='container-fluid'>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column gap-2">
                            <h5>Membuat Project Baru</h5>

                        </div>
                        <div class="card-body">
                            <form class="row g-3 app-form" 
                            action="{{route('auth.service.create.project')}}" 
                            method="POST"
                            id="form-validation">@csrf
                                <div class="col-md-6">
                                    <label for="userName" class="form-label">Title Project</label>
                                    <input type="text" class="form-control" id="userName" name="title" placeholder="Judul Project">
                                    <div class="mt-1">
                                        <span id="userNameError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Deskripsi Project</label>
                                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi Projek"></textarea>
                                    <div class="mt-1">
                                        <span id="emailError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Start Project</label>
                                    <input name="start" type="text" class="form-control" id="startProject" placeholder="Tanggal Mulai Project">
                                    <div class="mt-1">
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">End Project</label>
                                    <input name="ended" type="text" class="form-control" id="endProject" placeholder="Tanggal Deadline Project">
                                    <div class="mt-1">
                                        <span id="addressError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Latitude</label>
                                    <input name="latitude" type="number" step="any" class="form-control" value="-6.388927251990873" placeholder="Latitude Location" id="latitude">
                                    <div class="mt-1">
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Longtitude</label>
                                    <input name="lontitude" value="106.85155970879208" type="number" step="any" class="form-control" placeholder="Lontitude Location" id="longitude">
                                    <div class="mt-1">
                                        <span id="addressError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="locationProject">
                                    <iframe class="form-control" src="https://www.google.com/maps?q=-6.388927251990873,106.85155970879208&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>                                
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Response</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $i => $data)
                                                <tr>
                                                    <td>{{$i + 1}}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center ">
                                                            <div
                                                                class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-primary me-2 simple-table-avtar">
                                                                <img src="/wp-content/profile/{{$data->profile}}" 
                                                                alt="" class="img-fluid">
                                                            </div>
                                                            <p class="mb-0 f-w-500 ">{{$data->name}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check 
                                                        form-switch">
                                                            <input 
                                                            name="users[]"
                                                            class="form-check-input" 
                                                            type="checkbox" value="{{$data->id_users}}" 
                                                            role="switch" id="switchCheckDefault">
                                                      </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button 
                                    @hasPermissionsUsers(request()->route()->uri(),auth()->user()->id_users,'create')
                                    @else
                                    disabled="true"
                                    @endhasPermissionsUsers
                                    type="submit" value="Submit" class="btn btn-primary">
                                    Buat Project Baru</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@else
@endif
@endsection

@section('js_custom')
<script src="{{asset('dashboard/vendor/flatpicker/flatpickr.js')}}"></script>
<script>
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

  endPicker = flatpickr("#endProject", {
    locale: "id",
    dateFormat: "d F Y",
    disableMobile: true
  });

  const latInput = document.getElementById('latitude');
  const lngInput = document.getElementById('longitude');
  const embedCodeBox = document.getElementById('locationProject');

  function updateMap() {
        const lat = latInput.value;
        const lng = lngInput.value;
            
        const mapUrl = `https://www.google.com/maps?q=${lat},${lng}&z=14&output=embed`;
    
            
        const embedCode = `<iframe class="form-control" src="${mapUrl}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
        embedCodeBox.innerHTML = embedCode;
   }     

   latInput.addEventListener('input', updateMap);
   lngInput.addEventListener('input', updateMap);

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

@endsection
