<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
  content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template">
  <meta name="keywords"
  content="admin template, ra-admin admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="la-themes">
  <link rel="icon" href="{{asset('dashboard/images/logo/favicon.png')}}" type="image/x-icon">
  <link rel="shortcut icon" href="{{asset('dashboard/images/logo/favicon.png')}}" type="image/x-icon">
  <title>The Connect Id | Official Dashboard Marketing</title>

  <!-- Animation css -->
  <link rel="stylesheet" href="{{asset('dashboard/vendor/animation/animate.min.css')}}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

  <!-- wheather icon css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/weather/weather-icons.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/weather/weather-icons-wind.css')}}">

  <!--flag Icon css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/flag-icons-master/flag-icon.css')}}">

  <!-- tabler icons-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/tabler-icons/tabler-icons.css')}}">

  <!-- prism css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/prism/prism.min.css')}}">

  <!-- apexcharts css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/apexcharts/apexcharts.css')}}">

  <!-- glight css -->
  <link rel="stylesheet" href="{{asset('dashboard/vendor/glightbox/glightbox.min.css')}}">

  <!-- slick css -->
  <link rel="stylesheet" href="{{asset('dashboard/vendor/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('dashboard/vendor/slick/slick-theme.css')}}">

  <!-- Data Table css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/datatable/jquery.dataTables.min.css')}}">

  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/bootstrap/bootstrap.min.css')}}">

  <!-- vector map css -->
  <link rel="stylesheet" href="{{asset('dashboard/vendor/vector-map/jquery-jvectormap.css')}}">


  <!-- apexcharts css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/apexcharts/apexcharts.css')}}">

  <!-- simplebar css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/simplebar/simplebar.css')}}">

  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/css/style.css')}}">

  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/css/responsive.css')}}">

  <!-- Quill JS Text Editor -->
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

  <!-- Flatpciker -->
  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/flatpicker/flatpickr.min.css')}}">

  <!-- Toatify css-->
  <link rel="stylesheet" href="{{asset('dashboard/vendor/notifications/toastify.min.css')}}">
  <!-- Toatify js-->
  <script src="{{asset('dashboard/vendor/notifications/toastify-js.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{asset('dashboard/vendor/select/select2.min.css')}}">
  

</head>

<body>
  @yield('example_popup')

  <div class="app-wrapper">

   

    <!-- Menu Navigation starts -->
    <nav>
      <div class="app-logo">
        <a class="logo d-inline-block">
          <img src="{{asset('utils/logo.png')}}">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
      </div>
      <div class="app-nav" id="app-simple-bar">
      <ul class="main-nav p-0 mt-2 mb-4">                                                
        <!-- Buat Naro Menu -->

        @if(Auth::check())

        

        @endif
        {{-- NEW MENU --}}
        @if(!empty($menu['newMenu']))
            @foreach($menu['newMenu'] as $badge)

                @if(count($badge->sub_menu))
                    <li class="menu-title" id="badge-{{$badge->id_badge_menu}}"><span>{{ $badge->name }}</span></li>
                @endif

                {{-- SUB MENU --}}
                @if(!empty($badge->sub_menu))

                    @foreach($badge->sub_menu as $sub)
                        @if(count($sub->menu) >= 1)

                            {{-- SUB MENU WITH CHILD --}}
                            <li id="sub-{{$sub->id_sub_menu}}">
                                <a data-bs-toggle="collapse" href="#collapse-{{ $sub->id_sub_menu }}" aria-expanded="false">
                                    {!! $sub->icon !!}
                                    {{ $sub->name }}
                                </a>

                                <ul class="collapse" id="collapse-{{ $sub->id_sub_menu }}">

                                    {{-- CHILD MENU --}}
                                    @foreach($sub->menu as $child)

                                        @if(empty($child->role) || $child->role === Auth::user()->roles)

                                        @if(Auth::user()->roles != 'Developer')

                                        @hasPermissionsUsersMenuTab($child->url,Auth::user()->id_users,'show')
                                        <li>
                                          <a href="{{ route($child->route_name) }}">{{ $child->name }}</a>
                                        </li> 
                                        @endif
                                        @else
                                        <li>
                                          <a href="{{ route($child->route_name) }}">{{ $child->name }}</a>
                                        </li> 
                                        @endif

                                        @else
                                        <script>
                                            const badge = document.getElementById('badge-{{$badge->id_badge_menu}}')
                                            badge.classList.add('d-none')

                                            const sub = document.getElementById('sub-{{$sub->id_sub_menu}}')
                                            sub.classList.add('d-none')
                                        </script>
                                        @endif

                                    @endforeach

                                </ul>
                            </li>

                        @else
                            {{-- NO SUB (Single Menu) --}}
                            @php $child = $sub->menu->first(); @endphp
                            @if($child != null)
                            @if(empty($child->role) || $child->role === auth()->user()->role_users)


                            <li class="no-sub">
                              <a href="{{ route($child->route_name) }}">
                                {!! $sub->icon !!} {{ $child->name }}
                              </a>
                            </li>


                            @endif
                            @endif

                        @endif
                    @endforeach

                @endif

            @endforeach
        @endif



      </ul>
    </div>

    <div class="menu-navs">
      <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
      <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>

  </nav>
  <!-- Menu Navigation ends -->

  <div class="app-content">
    <div class="">

      <!-- Header Section starts -->
      <header class="header-main">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
              <span class="header-toggle me-3">
                <i class="ph ph-circles-four"></i>
              </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

              <ul class="d-flex align-items-center">  
                <li class="">
                  <i class="ph-bold f-s-20 head-icon ph-plugs-connected" id="webSocketKonek"></i>
                </li>
                <li class="header-dark">
                  <div class="sun-logo head-icon">
                    <i class="ph ph-moon-stars"></i>
                  </div>
                  <div class="moon-logo head-icon">
                    <i class="ph ph-sun-dim"></i>
                  </div>
                </li>                                
                <li class="header-notification">
                  <a href="#" class="d-block head-icon position-relative" role="button" data-bs-toggle="offcanvas"
                  data-bs-target="#notificationcanvasRight" aria-controls="notificationcanvasRight">
                  <i class="ph ph-bell"></i>
                  <span
                  id="notifDefault"
                  class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower
                  d-none
                  "></span>
                </a>
                <div class="offcanvas offcanvas-end header-notification-canvas" tabindex="-1"
                id="notificationcanvasRight" aria-labelledby="notificationcanvasRightLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="notificationcanvasRightLabel">Notification</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body app-scroll p-0">
                  <div class="head-container" id="messageBox">

                                                                                          
                  </div>
                    </li>
                    <li class="header-profile">
                      <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas"
                      data-bs-target="#profilecanvasRight" aria-controls="profilecanvasRight">
                      <img src="{{asset('dashboard/images/avtar/woman.jpg')}}" alt="avtar" class="b-r-10 h-35 w-35">
                    </a>

                    <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1" id="profilecanvasRight"
                    aria-labelledby="profilecanvasRight">
                    <div class="offcanvas-body app-scroll">
                      <ul class="">
                        <li>
                          <div class="d-flex-center">
                            <span class="h-45 w-45 d-flex-center b-r-10 position-relative bg-secondary">
                              <img src="/wp-content/profile/{{Auth::user()->profile}}" alt="" class="img-fluid b-r-10">
                            </span>
                          </div>
                          <div class="text-center mt-2">
                            <h6 class="mb-0"> {{Auth::user()->name}}</h6>
                            <p 
                            onclick="hay()" 
                            class="f-s-12 mb-0 text-secondary">lauradesign@gmail.com</p>
                          </div>
                        </li>

                        <li class="app-divider-v dotted py-1"></li>
                        <li>
                          <a 
                          data-bs-toggle="modal"
                          data-bs-target="#updateProfile"
                          class="f-w-500">
                          <i class="ph-duotone  ph-user-circle pe-1 f-s-20"></i> Profile Details
                        </a>
                      </li>                          
                      <li class="app-divider-v dotted py-1"></li> 
                      <li>
                        <form id="logout" action="{{route('service_logout')}}" method="POST">
                          @csrf
                          <a href="#" class="f-w-500" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                            <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Logout
                          </a>
                        </form>

                      </li>

                    </ul>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </header>
    <!-- Header Section ends -->

    @yield('section_dashboard')


    <!-- tap on top -->
    <div class="go-top">
      <span class="progress-value">
        <i class="ti ti-arrow-up"></i>
      </span>
    </div>

    <!-- Footer Section starts-->
    <footer>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-9 col-12">
            <ul class="footer-text">
              <li>
                <p class="mb-0">Copyright © 2025 The Connect Id. All rights reserved 💖</p>
              </li>
              <li> <a href="#"> V1.0.0 </a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <ul class="footer-text text-end">
              <li> <a href="document.html"> Need Help <i class="ti ti-help"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer Section ends-->
  </div>

  <!-- modal -->

    <!--customizer-->
    <div id="customizer"></div>

    <div class="modal fade" id="updateProfile" tabindex="-1" aria-modal="true" role="dialog">
     <div class="modal-dialog app_modal_sm">
      <div class="modal-content">
       <div class="modal-header bg-primary-800">
        <h1 class="modal-title fs-5 text-white" id="updateProfile2">Small Modal</h1>
        <button type="button" class="fs-5 border-0 bg-none  text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
      </div>
      <div class="modal-body">
        <form 
        action="{{route('auth.service.update.profile')}}"       
        method="POST"
        enctype="multipart/form-data" 
        >@csrf @method('PUT')
        <div class="app-form">
          <div class="mb-3">
           <label for="username-input" class="form-label">Name</label>
           <div class="icon-form">
            <i class="ti ti-user"></i>
            <input type="text" 
            value="{{auth()->user()->name}}" name="name" 
            required class="form-control pa-s-34"
            placeholder="Your Name" id="username-input">
          </div>
        </div>
        <div class="mb-3">
         <label for="username-input" class="form-label">Email</label>
         <div class="icon-form">
          <i class="ti ti-user"></i>
          <input type="text" 
          value="{{auth()->user()->email}}" 
          required name="email" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
         <label for="username-input" class="form-label">Linkedin</label>
         <div class="icon-form">
          <i class="ti ti-brand-linkedin"></i>
          <input type="text" 
          value="{{auth()->user()->linkedln}}" 
          name="linkedln" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
         <label for="username-input" class="form-label">Facebook</label>
         <div class="icon-form">
          <i class="ti ti-brand-facebook"></i>
          <input type="text" 
          value="{{auth()->user()->facebook}}" 
          name="facebook" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
         <label for="username-input" class="form-label">Twitter</label>
         <div class="icon-form">
          <i class="ti ti-brand-twitter"></i>
          <input type="text" 
          value="{{auth()->user()->twitter}}" 
          name="twitter" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
         <label for="username-input" class="form-label">Whatasaap</label>
         <div class="icon-form">
          <i class="ti ti-brand-whatsapp"></i>
          <input type="text" 
          value="{{auth()->user()->whatsaap}}" 
          name="whatsaap" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
         <label for="username-input" class="form-label">Alamat</label>
         <div class="icon-form">
          <i class="ti ti-map-pin"></i>
          <input type="text" 
          value="{{auth()->user()->address}}" 
          name="alamat" class="form-control pa-s-34"
          placeholder="Your Name" id="username-input">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Profile Avatar</label>
        <div class="d-flex align-items-center gap-3">
          <!-- Preview Avatar -->
          <div class="avatar-preview-wrapper">
            <img id="profilePreview" src="https://placehold.co/400x600/000000/FFFFFF/png" alt="Avatar Preview" class="rounded-circle border border-2 border-primary shadow-lg" style="width: 100px; height: 100px; object-fit: contain;">
          </div>

          <!-- Upload Button -->
          <div class="flex-grow-1">
            <input type="file" class="form-control" id="avatarProfile" name="profile" 
            accept=".png, .jpg, .jpeg">
            <small class="form-text text-muted d-block mt-1">
              Max 2MB. Format: JPG, PNG, GIF
            </small>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="hapusAvatar" style="display: none;">
              <i class="ph-bold ph-trash"></i> Hapus
            </button>
          </div>
        </div>
        <div class="mt-1">
          <span id="profileError" class="text-danger"></span>
        </div>
      </div>
      <div class="mb-3">
        <label for="password-input" class="form-label">Change Password</label>
        <div class="icon-form">
          <i onclick="lookPass(this)" style="cursor: pointer;" class="ph-fill  ph-eye"></i>
          <input type="password" name="password" class="form-control pa-s-34"
          placeholder="Change Password" id="password-input">
        </div>
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


<!-- Websocket Required -->
<script src="{{asset('dashboard/js/pusher.min.js')}}"></script>
<script src="{{asset('dashboard/js/echo.iife.js')}}"></script>
<script src="{{asset('dashboard/js/axios.min.js')}}"></script>

<script>
    console.log(Notification.permission)
    if ("Notification" in window) {
        if (Notification.permission === "denied") {
          Notification.requestPermission()      
        }
    }


    window.Pusher = Pusher; // Deklarasi Pusher

    window.Echo = new Echo({ // Melakukan Configurasi Websocket
        broadcaster: 'reverb',
        key: '{{env("REVERB_APP_KEY")}}',
        wsHost: '{{env("HOST_WEBSOCKET")}}', // Host  Dari Websocket
        wsPort: 8080,
        forceTLS: false,
        enabledTransports: ['ws'],         
        authEndpoint: '/broadcasting/auth',
    });

    const socketIcon = document.getElementById('webSocketKonek')

     // Mmberikan Informasi JIka Websocket Terkonek 
    window.Echo.connector.pusher.connection.bind('connected', function() {
        console.log('✅ Notification Connected!');
        socketIcon.classList.add('text-success')        
    });   
    // Memberikan Informasi Jika Websocket Tidak Terkonek
    window.Echo.connector.pusher.connection.bind('disconnected', function() {
        console.log('❌ WebSocket Disconnected!');
        socketIcon.classList.remove('text-success')        
    });

    // Memberikan Informasi Jika Websocket Tidak Tersedia
    window.Echo.connector.pusher.connection.bind('unavailable', function() {
        console.log('❌ Notification unavailable!');        
        socketIcon.classList.remove('text-success')
    });

    // Memberikan Informasi Jika Websocket Gagal Connect
    window.Echo.connector.pusher.connection.bind('failed', function() {
        console.log('❌ Notification failed!');
        socketIcon.classList.remove('text-success')
        
    }); 
    const idUsers = @json(auth()->user()->id_users)    

    Echo.private(`notification.${idUsers}`)
        .listen('.notification',(e) => {  
          new Audio("{{asset('utils/notif.mp3')}}").play();
          let message = `Hay {{auth()->user()->name}} Ada Pesan Masuk Dari ${e.payload.from.name}`
          const route = "{{route('auth.project.task.detail',':pesan')}}"
          const newRoutes = route.replace(':pesan',e.payload.slug)
          // Meanmpilkan Popup Notifiaksi
          Toastify({
            text: message,
            duration: 2000,
            position: "right",
            style: {
              background: "rgb(var(--primary),1)",
            },
            onClick:() => {
               window.location.href = newRoutes
            }
          }).showToast();

          // Memunculkan Notifikasi
          const containerNotifikasi = document.getElementById('messageBox')
          const bellNotif = document.getElementById('notifDefault')
          
          let html = `
             <div class="notification-message head-box">
              <div class="message-images">
                <span class="bg-light-dark h-35 w-35 d-flex-center b-r-10 position-relative">
                  <i class="ph ph-bell-ringing f-s-18"></i>
                </span>
              </div>
              <div class="message-content-box flex-grow-1 ps-2">
                <a href="${newRoutes}" class="f-s-15 text-secondary mb-0">Hey <span class="f-w-500 text-secondary">{{auth()->user()->name}}</span>, Ada Pesan Masuk Dari <span class="f-w-500 text-secondary">@${e.payload.from.name}</span> : ${e.payload.message ? e.payload.message.substring(0,100) : ''}</a>
                <span class="badge text-light-secondary mt-2"> sep 23 </span>
              </div>
            </div>
          `
          containerNotifikasi.insertAdjacentHTML('afterbegin',html)
          bellNotif.classList.remove('d-none')          
          if (document.hidden) {     
            new Notification("Pesan Masuk The Connect", {
              body: message,
              icon: "http://localhost:8000/utils/logo.png"
            });
          }
        }).error(err => {
          console.log('Notification Not Exitst',err)
        })
    Echo.join(`notification.${idUsers}`)
      .here(payload => console.log(payload))


    document.addEventListener('DOMContentLoaded', function() {
            const avatarUpload = document.getElementById('avatarProfile');
            const avatarPreview = document.getElementById('profilePreview');
            const removeAvatar = document.getElementById('hapusAvatar');
            const avatarError = document.getElementById('profileError');
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

</script>


<!-- latest jquery-->
<script src="{{asset('dashboard/js/jquery-3.6.3.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('dashboard/vendor/select/select2.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('dashboard/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- Simple bar js-->
<script src="{{asset('dashboard/vendor/simplebar/simplebar.js')}}"></script>

<!-- phosphor js -->
<script src="{{asset('dashboard/vendor/phosphor/phosphor.js')}}"></script>

<!-- vector map plugin js -->
<script src="{{asset('dashboard/vendor/vector-map/jquery-jvectormap-2.0.5.min.js')}}"></script>
<script src="{{asset('dashboard/vendor/vector-map/jquery-jvectormap-world-mill.js')}}"></script>

<!-- slick-file -->
<script src="{{asset('dashboard/vendor/slick/slick.min.js')}}"></script>

<!--cleave js  -->
<script src="{{asset('dashboard/vendor/cleavejs/cleave.min.js')}}"></script>

<!-- apexcharts-->
<script src="{{asset('dashboard/vendor/apexcharts/apexcharts.min.js')}}"></script>

<!-- data table js-->
<script src="{{asset('dashboard/vendor/datatable/jquery.dataTables.min.js')}}"></script>

<!-- Glight js -->
<script src="{{asset('dashboard/vendor/glightbox/glightbox.min.js')}}"></script>



<!-- Customizer js-->
<script src="{{asset('dashboard/js/customizer.js')}}"></script>

<!-- Ecommerce js-->
<script src="{{asset('dashboard/js/ecommerce_dashboard.js')}}"></script>

<!-- prism js-->
<script src="{{asset('dashboard/vendor/prism/prism.min.js')}}"></script>


<!-- chart js -->
<script src="{{asset('dashboard/vendor/chartjs/chart.js')}}"></script>

<!-- App js-->
<script src="{{asset('dashboard/js/script.js')}}"></script>
<script src="{{asset('dashboard/js/slick.js')}}"></script>

<!-- sweetalert js-->
<script src="{{asset('dashboard/vendor/sweetalert/sweetalert.js')}}"></script>

<!-- js -->
<script src="{{asset('dashboard/js/sweet_alert.js')}}"></script>



@yield('js_custom')


@if($errors->any())
<script>
    const message = '{{$errors->first()}}'
    Toastify({
      duration: 3000,
      text: `${message}. STATUS : (${status})`,
      close:true,
      style:{
        background:'#FA6868',
        color:'#fff'
      }
    }).showToast()
</script>
@endif

@if(session('success'))
<script>
    const message = "{{session('success')}}"
    Toastify({
      duration: 3000,
      text: `${message}. STATUS : (${status})`,
      close:true,
      style:{
        background:'#628141',
        color:'#fff'
      }
    }).showToast()
</script>
@endif

</body>

</html>