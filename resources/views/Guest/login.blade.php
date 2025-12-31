<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Proyek The Connect</title>

  <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('custom/css/login.css')}}">

</head>
<body>

  <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height:100vh; padding: 20px;">
    <div class="row login-container w-100 g-0">
      <!-- Kolom Vector (disembunyikan pada perangkat kecil) -->
      <div class="col-12 col-md-6 d-none d-md-block">
          <div class="vector-section">
            <img src="{{asset('utils/vectoricon.png')}}" 
                 alt="Project Management Illustration" 
                 >
          </div>
        </div>

      <!-- Kolom Form Login -->
      <div class="col-12 col-md-6">
        <div class="form-section">

          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$errors->first()}}</strong>
            <buttonn type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{session('error')}}</strong>
            <buttonn type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          <div class="brand-title d-flex gap-2 mb-4">
          <img src="{{asset('utils/logo.png')}}">
          </div>
          <h1 class="brand-subtitle">Log in To Your Page</h1>   
          <div class="brand-sub">Welcome Back ! Log in to manage the project</div>       
          <div class="border mb-3 garis border-primary border-3"></div>
          <form class="d-flex flex-column gap-3" action="{{route('service_login')}}" method="POST">
            @csrf
            <div class="input-group mb-3">
              <span class="input-group-text bg-transparent" id="basic-addon1">
                <i class="bi bi-person-fill-check fs-4 fs-lg-2"></i>
              </span>
              <input type="text" name="email" class="form-control" placeholder="Email Anda" aria-label="Username" aria-describedby="basic-addon1">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text bg-transparent" id="basic-addon1">
                <i onclick="showPassword(this)" class="bi bi-lock-fill fs-4 fs-lg-2"></i>
              </span>
              <input type="password" id="pw" name="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
            </div>

            <!-- <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember">
              <label class="form-check-label" for="remember" style="font-size: 14px;">
                Ingat saya
              </label>
            </div> -->

            <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>

            <div class="text-center">
              <a href="#" class="forgot-link">Lupa password?</a>
            </div>
          </form>

          
        </div>
      </div>
    </div>
  </div>



  <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script>
    function showPassword(btn){      
      const pw = document.getElementById('pw')
      if (btn.classList.contains('bi-lock-fill')) {
        btn.classList.replace('bi-lock-fill','bi-unlock-fill')
        pw.setAttribute('type','text')
      }else{
        btn.classList.replace('bi-unlock-fill','bi-lock-fill')
        pw.setAttribute('type','password')
      }
    }
  </script>
</body>
</html>