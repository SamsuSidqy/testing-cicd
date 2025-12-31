@extends('layout.dashboard')
@section('section_dashboard')

<main>
    <div class='container-fluid'>
        <div class="row m-1">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Permissions Menu Users</h5>
                    </div>
                    <div class="card-body p-0">
                        @if(request()->has('detail'))
                        <div class="table-responsive">
                            <form method="POST" action="{{route('service_developer_permission_update')}}">
                                @csrf
                                <input type="hidden" name="id_users" value="{{request()->query('detail')}}">
                                <table class="table table-bottom-border table-striped-columns align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Create</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                            <th>Show</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($menu as $i => $menuItem)
                                        @php
                                        $perm = $permision[$menuItem->id_menu_cms] ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $menuItem->name }}</td>

                                            {{-- CREATE --}}
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="hidden"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][create]"
                                                    value="0">
                                                    <input class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][create]"
                                                    value="1"
                                                    {{ ($perm && $perm->create) ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- UPDATE --}}
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="hidden"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][updated]"
                                                    value="0">
                                                    <input class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][updated]"
                                                    value="1"
                                                    {{ ($perm && $perm->updated) ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- DELETE --}}
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="hidden"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][delete]"
                                                    value="0">
                                                    <input class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][delete]"
                                                    value="1"
                                                    {{ ($perm && $perm->delete) ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            {{-- SHOW --}}
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="hidden"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][show]"
                                                    value="0">
                                                    <input class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[{{ $menuItem->id_menu_cms }}][show]"
                                                    value="1"
                                                    {{ ($perm && $perm->show) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex gap-2 mt-3 mx-2 my-2">
                                    <button type="submit" class="btn btn-primary ">
                                        Simpan Permission
                                    </button>
                                    <button 
                                    class="btn btn-info" 
                                    type="button" onclick="window.location.href = window.location.origin + window.location.pathname">
                                        <i class="ph-duotone  ph-arrow-bend-down-left"></i>
                                    </button>

                                </div>
                            </form>

                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-bottom-border  table-striped-columns align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Rule</th>                
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $i => $data)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->roles}}</td>
                                        <td>
                                            <form>
                                                <button 
                                                name="detail" 
                                                value="{{$data->id_users}}" 
                                                class="btn btn-sm btn-info">
                                                <i class="ph-bold  ph-key"></i>
                                            </button>    
                                        </form>
                                    </td>
                                </tr>                    
                                @endforeach                
                            </tbody>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</main>

@endsection