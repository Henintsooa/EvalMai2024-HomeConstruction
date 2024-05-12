<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recette</title>
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
                  {{-- <img src="../assets/images/logos/dark-logo.svg" width="180" alt=""> --}}
                  <img src="../assets/images/logos/logo.png" width="150" alt="">

                </a>
                <p class="text-center">Créer un compte</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="name" value={{old('name')}}>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500"  />

                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="email" value={{old('email')}}>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500"  />
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" value={{old('password')}}>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500"  />
                  </div>
                  <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        
                    <x-text-input id="password_confirmation" class="form-control"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500"  />
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Créer</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Déjà un compte?</p>
                    <a class="text-primary fw-bold ms-2"  href="{{ route('login') }}">Connexion</a>
                  </div>
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