<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Client</title>
  {{-- <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" /> --}}
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/logo.png" width="150" alt="">
                </a>
                <p class="text-center">Login</p>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="GET" action="{{ route('loginClient') }}">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Numéro</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
                    @error('numero')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>        
                  <button type="submit"  class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Connecter</button>
                    {{-- @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="text-primary fw-bold ms-2"
                        >
                            Admin
                        </a>
                    @endif --}}
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>