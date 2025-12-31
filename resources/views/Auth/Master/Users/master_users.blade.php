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
    <main>
        <div class='container-fluid'>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column gap-2">
                            <h5>Master Users</h5>  
                        </div>
                        <div class="card-body">
                            <form 
                            enctype="multipart/form-data" 
                            action="{{route('auth.service.create.user')}}" 
                            method="POST" 
                            class="row g-3 app-form" id="form-validation">
                                @csrf
                                <div class="col-md-6">
                                    <label for="userName" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="userName" name="name">
                                    <div class="mt-1">
                                        <span id="userNameError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email">
                                    <div class="mt-1">
                                        <span id="emailError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                    <div class="mt-1">
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St">
                                    <div class="mt-1">
                                        <span id="addressError" class="text-danger"></span>
                                    </div>
                                </div> 

                                <div class="col-md-6">
                                    <label class="form-label">Whatsaap</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">
                                        <i class="ph-fill f-s-18 ph-whatsapp-logo"></i>    
                                        </span>
                                        <input type="text" name="whatsapp" class="form-control b-r-right" placeholder="Link Whatsaap (Optional)" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Linkedin</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">
                                        <i class="ph-bold f-s-18 ph-linkedin-logo"></i>    
                                        </span>
                                        <input type="text" name="linkedln" class="form-control b-r-right" placeholder="Link Linkedin (Optional)" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <label class="form-label">Facebook</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">
                                        <i class="ph-bold f-s-18 ph-facebook-logo"></i>    
                                        </span>
                                        <input type="text" name="facebook" class="form-control b-r-right" placeholder="Link Facebook (Optional)" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <label class="form-label">Twitter</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">
                                        <i class="ph-bold f-s-18 ph-twitter-logo"></i>    
                                        </span>
                                        <input type="text" name="twitter" class="form-control b-r-right" placeholder="Link Twitter (Optional)" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <select class="form-select" name="roles" id="validationDefault04" required="">
                                      <option selected="" disabled="" value="">Choose...</option>
                                      <option value="Developer">Developer</option>
                                      <option value="Manager">Manajer</option>
                                      <option value="Admin">Admin</option>
                                      <option value="Employe">Employe</option>
                                  </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Profile Avatar</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Preview Avatar -->
                                        <div class="avatar-preview-wrapper">
                                            <img id="avatarPreview" 
                                                 src="https://placehold.co/400x600/000000/FFFFFF/png" 
                                                 alt="Avatar Preview" 
                                                 class="rounded-circle border border-2 border-primary shadow-lg" 
                                                 style="width: 100px; height: 100px; object-fit: contain;">
                                        </div>
                                        
                                        <!-- Upload Button -->
                                        <div class="flex-grow-1">
                                            <input type="file" 
                                                   class="form-control" 
                                                   id="avatarUpload" 
                                                   name="profile"
                                                   accept="image/png, image/jpeg, image/jpg, image/gif">
                                            <small class="form-text text-muted d-block mt-1">
                                                Max 2MB. Format: JPG, PNG, GIF
                                            </small>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger mt-2" 
                                                    id="removeAvatar" 
                                                    style="display: none;">
                                                <i class="ph-bold ph-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <span id="avatarError" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button 
                                    @hasPermissionsUsers($finalUri,auth()->user()->id_users,'create')
                                    @else
                                    disabled="true"
                                    @endhasPermissionsUsers
                                    type="submit" value="Submit" class="btn btn-primary">Submit form</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-8">
                <div class="card equal-card ">
                  <div class="card-header">
                    <h5>Master Users</h5>
                  </div>
                  <div class="card-body p-0">
                    <div id="myTable">
                      <div class="list-table-header d-flex justify-content-sm-between mb-3"> 
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <form id="add_employee_form">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee
                                </h1>
                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="employee mb-3">
                                  <input type="hidden" id="id-field">
                                  <label class="form-label">Employee :</label>
                                  <input class="form-control" type="text" id="employee-field" placeholder="employee" required="">
                                </div>

                                <div class="email mb-3">
                                  <label class="form-label">Email :</label>
                                  <input class="form-control" type="email" id="email-field" placeholder="email" required="">
                                </div>

                                <div class="contact mb-3">
                                  <label class="form-label">contact :</label>
                                  <input class="form-control" type="text" id="contact-field" placeholder="contact" required="">
                                </div>

                                <div class="date mb-3">
                                  <label class="form-label">date :</label>
                                  <input class="form-control" type="date" id="date-field" required="">
                                </div>

                                <div class="status mb-3">
                                  <label class="form-label">status :</label>
                                  <select class="form-select" id="status-field" aria-label="Default select example">
                                    <option value="">Status</option>
                                    <option value="success">Active</option>
                                    <option value="danger">Block</option>
                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer add">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Close">
                                <input type="submit" class="btn btn-primary" id="add-btn" value="Add">
                                <button class="btn btn-success" id="edit-btn" style="display: none;">Edit</button>
                              </div>
                            </div>
                          </div>
                          </form>
                        </div>

                        <form class="app-form app-icon-form">
                          <div class="position-relative ">
                            <input type="search" class="form-control search" placeholder="Search..." aria-label="Search" name="s">
                            <i class="ti ti-search text-dark"></i>
                          </div>
                        </form>
                      </div>

                      <div class="overflow-auto app-scroll">
                        <table class="table table-bottom-border  list-table-data align-middle mb-0">
                          <thead>
                            <tr class="app-sort">
                              <th class="d-none">ID</th>
                              <th class="sort" data-sort="employee" scope="col">Profile</th>
                              <th class="sort" data-sort="email" scope="col">Name</th>
                              <th class="sort" data-sort="contact" scope="col">Email</th>
                              <th class="sort" data-sort="date" scope="col">Joining Date</th>
                              <th class="sort" data-sort="action" scope="col">Employee</th>
                              <th class="sort" data-sort="action" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="t-data">
                            @foreach($users as $row)

                            @if(auth()->user()->roles === 'Developer' && $row->id_users != auth()->user()->id_users)
                            <tr class=""> 
                              <td class="employee">
                                  <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden text-bg-primary">
                                    <img 
                                    @if($row->profile)
                                    src="/wp-content/profile/{{$row->profile}}"
                                    @else
                                    src="https://placehold.co/400x400" 
                                    @endif
                                    alt="avtar" class="img-fluid">
                                  </div>
                              </td>
                              <td class="email">{{$row->name}}</td>
                              <td class="contact">{{$row->email}}</td>
                              <td class="date">{{$row->created_at}}</td>
                              <td class="status">
                                @if($row->roles === 'Manager')
                                    <span class="badge bg-success-subtle text-dark text-uppercase">{{$row->roles}}</span>
                                    @elseif($row->roles === 'Admin')
                                    <span class="badge bg-info-subtle text-dark text-uppercase">{{$row->roles}}</span>
                                    @elseif($row->roles === 'Employe')
                                    <span class="badge bg-primary text-dark text-uppercase">{{$row->roles}}</span>
                                @endif
                              </td>
                              <td class="edit">
                                <button 
                                data-id="{{$row->id_users}}"
                                data-name="{{$row->name}}"
                                data-email="{{$row->email}}"
                                data-linkedln="{{$row->password}}"
                                data-whatsaap="{{$row->whatsaap}}"
                                data-facebook="{{$row->facebook}}"
                                data-twitter="{{$row->twitter}}"
                                data-address="{{$row->address}}"
                                data-roles="{{$row->roles}}"
                                class="btn edit-item-btn btn-sm btn-success"  data-bs-toggle="modal" data-bs-target="#updateUsersModal">Edit</button>
                              </td>
                              <td class="remove">
                                @if(count($row->tasks) == 0)
                                <button class="btn remove-item-btn btn-sm btn-danger"
                                id-user="{{$row->id_users}}"
                                data-bs-target="#hapusUsersModal"
                                data-bs-toggle="modal"
                                >Remove</button>
                                @endif
                              </td>
                            </tr>
                            @else

                                @if($row->roles != 'Developer' && $row->id_users != auth()->user()->id_users)
                                <tr class=""> 
                                  <td class="employee">
                                      <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden text-bg-primary bg-primary">
                                        @if($row->profile)
                                        <img src="/wp-content/profile/{{$row->profile}}" alt="avtar" class="img-fluid">
                                        @endif
                                      </div>
                                  </td>
                                  <td class="email">{{$row->name}}</td>
                                  <td class="contact">{{$row->email}}</td>
                                  <td class="date">{{$row->created_at}}</td>
                                  <td class="status">
                                    @if($row->roles === 'Manajer')
                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Block</span>
                                    @elseif($row->roles === 'Admin')

                                    @elseif($row->roles === 'Employe')

                                    @endif
                                  </td>
                                  <td class="edit">
                                    <button class="btn edit-item-btn btn-sm btn-success" 
                                    @hasPermissionsUsers($finalUri,auth()->user()->id_users,'updated')
                                    @else
                                    disabled
                                    @endhasPermissionsUsers
                                    data-id="{{$row->id_users}}"
                                    data-name="{{$row->name}}"
                                    data-email="{{$row->email}}"
                                    data-linkedln="{{$row->password}}"
                                    data-whatsaap="{{$row->whatsaap}}"
                                    data-facebook="{{$row->facebook}}"
                                    data-twitter="{{$row->twitter}}"
                                    data-address="{{$row->address}}"
                                    data-roles="{{$row->roles}}"
                                    data-bs-toggle="modal" data-bs-target="#updateUsersModal">Edit</button>
                                  </td>
                                  <td class="remove">
                                    @if(count($row->tasks) == 0)
                                    <button class="btn remove-item-btn btn-sm btn-danger"
                                    id-user="{{$row->id_users}}"
                                    @hasPermissionsUsers($finalUri,auth()->user()->id_users,'delete')
                                    @else
                                    disabled
                                    @endhasPermissionsUsers
                                    data-bs-target="#hapusUsersModal"
                                    data-bs-toggle="modal"
                                    >Remove</button>
                                    @endif
                                  </td>
                                </tr>
                                @endif

                            @endif

                            @endforeach
                            </tbody>
                        </table>
                      </div>
                      <div class="list-pagination">
                        
                        <ul class="pagination">
                            <li>
                                <a 
                                @if($users->onFirstPage())
                                style="cursor:not-allowed;"
                                @else

                                @if(request()->has('s'))
                                href="{{route('auth.dashboard.master.user.pagination',[
                                'page' => $users->currentPage() - 1, 's' => request()->query('s')
                                ])}}"
                                @else
                                href="{{route('auth.dashboard.master.user.pagination',[
                                'page' => $users->currentPage() - 1])}}"
                                @endif

                                @endif
                                class="page"><< Prev</a>
                            </li>
                            @php
                                $currentPage = $users->currentPage();
                                $lastPage = $users->lastPage();
                                $pageLimit = 5; // Number of page links to show
                                $halfLimit = floor($pageLimit / 2);
                            @endphp
                            @foreach(range(max(1, $currentPage - $halfLimit), min($lastPage, $currentPage + $halfLimit)) as $i)
                            <li 
                            @if($i == $users->currentPage())
                            class="active"
                            @endif
                            >
                                <a class="page" href="{{route('auth.dashboard.master.user.pagination',$i)}}" data-i="1" data-page="4">{{$i}}</a>
                            </li>
                            @endforeach

                            @if($currentPage < $lastPage - $halfLimit)
                            <li>
                                <a href="{{ route('auth.dashboard.master.user.pagination', ['page' => $lastPage]) }}">...</a>
                            </li>
                            @endif

                            <li>
                                <a 
                                @if(!$users->hasMorePages())
                                style="cursor:not-allowed;"
                                @else

                                @if(request()->has('s'))
                                href="{{route('auth.dashboard.master.user.pagination',[
                                'page' => $users->currentPage() + 1, 's' => request()->query('s')
                                ])}}"
                                @else
                                href="{{route('auth.dashboard.master.user.pagination', $users->currentPage() + 1)}}"
                                @endif

                                @endif
                                class="page">>> Next</a>
                            </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>            

            </div>
        </div>
    </main>

    <div class="modal fade" id="updateUsersModal" tabindex="-1" role="dialog"
     aria-modal="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header bg-primary-800">
              <h1 class="modal-title fs-5 text-white" id="updateModal2">Update Data Users</h1>
              <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
          </div>
          <div class="modal-body">  
            <form
            action="{{route('auth.service.update.user')}}"
            method="POST"
            >@csrf @method('PUT')
            <div class="app-form">
                <input type="hidden" name="id_users" readonly id="id_users">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input class="form-control" name="name" id="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" name="password" id="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Linkedin</label>
                    <input class="form-control" name="linkedln" id="linkedln">
                </div>
                <div class="mb-3">
                    <label class="form-label">Faceook</label>
                    <input class="form-control" name="facebook" id="facebook">
                </div>
                <div class="mb-3">
                    <label class="form-label">Whatsaap</label>
                    <input class="form-control" name="whatsaap" id="whatsaap">
                </div>
                <div class="mb-3">
                    <label class="form-label">Twitter</label>
                    <input class="form-control" name="twitter" id="twitter">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input class="form-control" name="alamat" id="alamat">
                </div>
                <div class="mb-3">
                    <label class="form-label">Roles</label>
                    <select class="form-control" name="roles" id="roles">
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manajer</option>
                        <option value="Employe">Employe</option>
                    </select>
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

<div class="modal fade" id="hapusUsersModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning ">
        <h5 class="modal-title text-white" id="exampleModalToggleLabel12">Anda Yakin Menghapus Users ?</h5>
        <button type="button" class="btn-close m-0 fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>    
    <div class="modal-footer">
        <form
        method="POST"
        action="{{route('auth.service.delete.user')}}"
        >@csrf @method('put')
        <button type="submit" id="hapusBtn" name="id_users" class="badge text-light-warning fs-6">Hapus</button>
        </form>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarUpload = document.getElementById('avatarUpload');
            const avatarPreview = document.getElementById('avatarPreview');
            const removeAvatar = document.getElementById('removeAvatar');
            const avatarError = document.getElementById('avatarError');
            const defaultAvatar = 'https://placehold.co/600x400/000000/FFFFFF/png';

            // Preview gambar saat file dipilih
            avatarUpload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                avatarError.textContent = '';

                if (file) {
                    // Validasi ukuran file (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        avatarError.textContent = 'Ukuran file maksimal 2MB';
                        avatarUpload.value = '';
                        return;
                    }

                    // Validasi tipe file
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        avatarError.textContent = 'Format file harus JPG, PNG, atau GIF';
                        avatarUpload.value = '';
                        return;
                    }

                    // Baca dan tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        avatarPreview.src = event.target.result;
                        removeAvatar.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Hapus avatar
            removeAvatar.addEventListener('click', function() {
                avatarPreview.src = defaultAvatar;
                avatarUpload.value = '';
                removeAvatar.style.display = 'none';
                avatarError.textContent = '';
            });
        });
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

@section('js_custom')
<script>

    const deleteUsers = document.getElementById('hapusUsersModal')
    deleteUsers.addEventListener('show.bs.modal',(e) => {
        let btn = e.relatedTarget;
        const id = btn.getAttribute('id-user')

        deleteUsers.querySelector('#hapusBtn').value = id
    });

    const updatemodal = document.getElementById('updateUsersModal')
    updatemodal.addEventListener('show.bs.modal',(e) => {
        console.log(true)
        let btn = e.relatedTarget

        const id = btn.getAttribute('data-id')
        console.log(id)
        const name = btn.getAttribute('data-name')
        const email = btn.getAttribute('data-email')
        const linkdln =  btn.getAttribute('data-linkedln')
        const wa = btn.getAttribute('data-whatsaap')
        const fb = btn.getAttribute('data-facebook')
        const twiter = btn.getAttribute('data-twitter')
        const alamat =  btn.getAttribute('data-address')
        const roles = btn.getAttribute('data-roles')

        updatemodal.querySelector('#id_users').value = id
        updatemodal.querySelector('#name').value = name
        updatemodal.querySelector('#email').value = email
        updatemodal.querySelector('#roles').value = roles
        updatemodal.querySelector('#linkdln').value = linkdln
        updatemodal.querySelector('#whatsapp').value = wa
        updatemodal.querySelector('#twiter').value = twiter
        updatemodal.querySelector('#alamat').value = alamat
        updatemodal.querySelector('#facebook').value = fb
    })
</script>
@endsection