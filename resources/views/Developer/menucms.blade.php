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
				<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="resetForm()">
					<i class="ph ph-plus-circle me-2"></i>Tambah Menu
				</button>
				<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#badgeModal" onclick="resetForm()">
					<i class="ph ph-plus-circle me-2"></i>Tambah Badges
				</button>
				<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subModal" onclick="resetForm()">
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
								<th>Parent</th>
								<th>Sub Menu</th>
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
							<!-- <div class="col-md-6 mb-3">
								<label class="form-label">Roles</label>
								<select name="roles" class="form-select" id="method">
									<option disabled selected >Pilih Role</option>
									<option value="Developer">Developer</option>
									<option value="Admin">Admin</option>
									<option value="Manager">Manager</option>
									<option value="Employe">Employe</option>
								</select>
							</div> -->
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
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<form id="menuForm"
					action="{{route('service_developer_badge_create')}}" 
					method="POST" 
					>@csrf						

						<div class="mb-3">
							<label class="form-label">Nama Badges</label>
							<input type="text" name="name" class="form-control" id="subMenu">
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
										<td>{{$data->name}}</td>
										<td>
											<div class="d-flex gap-2">
												<button class="btn btn-sm btn-info">
													<i class="ph-bold  ph-pencil-line"></i>
												</button>
												<button class="btn btn-sm btn-danger">
													<i class="ph-bold  ph-trash"></i>
												</button>
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
					<form id="menuForm" action="{{route('service_developer_sub_create')}}" 
					method="POST" 
					>@csrf

						<div class="mb-3">
							<label class="form-label">Nama Sub</label>
							<input type="text" name="name" class="form-control" id="subMenu">
							<small class="text-muted">Contoh: Dashboard, Master Barang</small>
						</div>

						<div class="mb-2">
							<label class="form-label">Badges</label>
							<select name="badge" class="form-select" id="method">
								<option disabled selected >Pilih Badge</option>
								@foreach($badges as $data)
								<option value="{{$data->id_badge_menu}}">{{$data->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="mb-2">
							<label class="form-label">Nama Icons Icons</label>
							<input type="text" name="icon" placeholder="Contoh : <i class='ph-duotone  ph-address-book'></i>" class="form-control" id="subMenu">
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
										<td>{{$data->name}}</td>
										<td>{!! $data->icon !!}</td>
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

</main>

@endsection