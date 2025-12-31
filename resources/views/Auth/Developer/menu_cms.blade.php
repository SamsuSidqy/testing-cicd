@extends('layout.dashboard')
@section('section_dashboard')

<main>
    <div class="container-fluid p-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4><i class="ph ph-tree-structure me-2"></i>Menu Management</h4>
                    <p>Kelola menu navigasi untuk sistem CMS</p>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal">
                    <i class="ph ph-plus-circle me-2"></i>Tambah Menu
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#badgeModal" onclick="reseFormsBadgeUpdate()">
                    <i class="ph ph-plus-circle me-2"></i>Tambah Badges
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subModal" onclick="resetFormsSubUpdate()">
                    <i class="ph ph-plus-circle me-2"></i>Tambah Sub
                </button>
                </div>
            </div>
        </div>

        <!-- Menu Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Menu</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="menuTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Route Name</th>
                                <th>Class Name</th>
                                <th>Method</th>
                                <th>Parent Folder</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="menuTableBody">
                            @foreach($menus as $i => $data)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->url}}</td>
                                <td>{{$data->route_name}}</td>
                                <td>{{$data->class_name}}</td>
                                <td>{{$data->metode}}</td>
                                <td>{{$data->parrent_folder}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info"
                                        type="button" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateMenuModal"
                                        data-id="{{$data->id_menu_cms}}"
                                        data-name="{{$data->name}}"
                                        data-sub="{{$data->sub}}"
                                        data-role="{{$data->role}}"
                                        data-url="{{$data->url}}"
                                        >
                                        <i class="ph-bold  ph-note-pencil"></i>    
                                        </button>

                                        <button 
                                        type="button" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteMenuModal"
                                        data-id="{{$data->id_menu_cms}}"
                                        class="btn btn-sm btn-danger">
                                            <i class="ph-bold  ph-trash"></i>
                                        </button>

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

    <!-- Modal Form -->
    <div class="modal fade" id="menuModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ph ph-plus-circle me-2"></i>Tambah Menu Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="menuForm"
                    method="POST" 
                    action="{{route('service_developer_menu_create')}}" 
                    >@csrf
                        <input type="hidden" id="menuId">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" required placeholder="Menu Dashboard">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">URL <span class="required">*</span></label>
                                <input type="text" name="url" class="form-control" id="url" required placeholder="/dashboard">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Route Name</label>
                                <input type="text" name="route_name" class="form-control" id="routeName" placeholder="dashboard.index">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Class Name</label>
                                <input type="text" name="class_name" class="form-control" id="className" placeholder="Jangan Ada Spasi & Character">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sub</label>
                                <select class="form-select" id="method" name="sub">
                                    <option selected disabled>Pilih Sub</option>
                                    @foreach($submenu as $data)
                                    <option value="{{$data->id_sub_menu}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Parent Folder</label>
                                <input type="text" placeholder="Jangan Ada Spasi & Character" class="form-control" name="parrent_folder">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Roles</label>
                                <select name="role" class="form-select" id="method">
                                    <option disabled selected >Pilih Role</option>
                                    <option value="Developer">Developer</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Employe">Employe</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name Views</label>
                                <input type="text" name="name_views" class="form-control"
                                placeholder="Jangan Ada Spasi & Character">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Method</label>
                            <input type="text" class="form-control" id="subMenu" placeholder="Jangan Ada Spasi & Character" name="metode">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ph ph-x me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-floppy-disk me-2"></i>Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Badge -->
    <div class="modal fade" id="badgeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ph ph-plus-circle me-2"></i>Tambah Badge Baru
                    </h5>
                    <button type="button" 
                    class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form
                    action="{{route('service_developer_badge_delete')}}"
                    method="POST"
                    id="formDeleteBadge"
                    >@csrf @method('PUT')
                        
                    </form>
                    <form id="menuFormBadges"
                    update="{{route('service_developer_badge_update')}}"
                    create="{{route('service_developer_badge_create')}}"
                    action="{{route('service_developer_badge_create')}}" 
                    method="POST" 
                    >@csrf                      

                        <div class="mb-3">
                            <label class="form-label">Nama Badges</label>
                            <input type="text" name="name" class="form-control" id="badgeName">
                            <small class="text-muted">Contoh: Dashboard, Master Barang</small>
                        </div>

                        <div class="table-responsive mb-3">
                            <table id="menuTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="menuTableBody">
                                    @foreach($badges as $i => $data)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$data->name}} ({{count($data->sub_menu)}})</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button 
                                                type="button"  
                                                id="tombolUpdateBadge{{$data->id_badge_menu}}" 
                                                data-id="{{$data->id_badge_menu}}"
                                                data-name="{{$data->name}}"
                                                onclick="updateBadges('{{$data->id_badge_menu}}')" 
                                                class="btn btn-sm btn-info">
                                                    <i class="ph-bold  ph-pencil-line"></i>
                                                </button>
                                                @if(count($data->sub_menu) < 1)
                                                <button 
                                                type="button" 
                                                onclick="deleteBadge('{{$data->id_badge_menu}}')" 
                                                class="btn btn-sm btn-danger">
                                                    <i class="ph-bold  ph-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ph ph-x me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-floppy-disk me-2"></i>Simpan Badge
                            </button>
                        </div>
                    </form>                 

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sub -->
    <div class="modal fade" id="subModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ph ph-plus-circle me-2"></i>Tambah Sub Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form
                    action="{{route('service_developer_sub_delete')}}"
                    method="POST"
                    id="formDeleteSub"
                    >@csrf @method('put')   
                    </form>
                    <form id="menuFormSub" 
                    update="{{route('service_developer_sub_update')}}"
                    create="{{route('service_developer_sub_create')}}"
                    action="{{route('service_developer_sub_create')}}" 
                    method="POST" 
                    >@csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Sub</label>
                            <input type="text" name="name" class="form-control" id="nameSub">
                            <small class="text-muted">Contoh: Dashboard, Master Barang</small>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Badges</label>
                            <select name="badge" class="form-select" id="badgeSub">
                                <option disabled selected >Pilih Badge</option>
                                @foreach($badges as $data)
                                <option value="{{$data->id_badge_menu}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama Icons Icons</label>
                            <input type="text" name="icon" placeholder="Contoh : <i class='ph-duotone  ph-address-book'></i>" class="form-control" id="iconSub">
                            <small class="text-muted">Cari Di : <a href="https://phosphoricons.com/">phosphoricons.com                              
                            </a></small>
                        </div>
                        
                        <div class="table-responsive mb-3">
                            <table id="menuTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="menuTableBody">
                                    @foreach($submenu as $i => $data)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$data->name}} ({{count($data->menu)}})</td>
                                        <td>{!! $data->icon !!}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button 
                                                type="button" 
                                                onclick="updateMenuSub('{{$data->id_sub_menu}}')" 
                                                data-id="{{$data->id_sub_menu}}"
                                                data-name="{{$data->name}}"
                                                data-badge="{{$data->badge}}"
                                                data-icon="{{$data->icon}}"
                                                id="tombolUpdateSub{{$data->id_sub_menu}}"
                                                class="btn btn-sm btn-info">
                                                <i class="ph-bold  ph-pencil-line"></i>
                                                </button>
                                                @if(count($data->menu) < 1)
                                                <button 
                                                onclick="deleteSub('{{$data->id_sub_menu}}')" 
                                                type="button" 
                                                class="btn btn-sm btn-danger">
                                                    <i class="ph-bold  ph-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ph ph-x me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-floppy-disk me-2"></i>Simpan Badge
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateMenuModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ph ph-plus-circle me-2"></i>Update Menu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form
                    action="{{route('service_developer_menu_update')}}"
                    method="POST"
                    >@csrf @method('PUT')
                        <input type="hidden" readonly id="idMenu" name="id_menu">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Roles</label>
                                <select name="role" class="form-select" id="roleMenu">
                                    <option disabled selected >Pilih Role</option>
                                    <option value="Developer">Developer</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Employe">Employe</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                 id="nameMenu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sub</label>
                                <select class="form-select" id="subMenu" name="sub">
                                    <option selected disabled>Pilih Sub</option>
                                    @foreach($submenu as $data)
                                    <option value="{{$data->id_sub_menu}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ph ph-x me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-floppy-disk me-2"></i>Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>

    <div class="modal fade" id="deleteMenuModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white">
                        <i class="ph ph-trash me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">                    
                    <h5 class="fw-bold text-danger" id="deleteMenuName">
                        Yakin Ingin Menghapus ?  
                        @if(!env('APP_DEBUG'))
                        <b>( Sedang Mode Prodution )</b>
                        @else

                        @endif
                    </h5>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ph ph-x me-2"></i>Batal
                    </button>

                    <form id="deleteMenuForm" 
                    action="{{route('service_developer_menu_delete')}}" 
                    method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" readonly name="id_menu" id="menuId">
                        <button type="submit" class="btn btn-danger">
                            <i class="ph ph-trash me-2"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>

@endsection

@section('js_custom')
<script src="{{asset('custom/js/menu_cms.js')}}"></script>

<script>
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
