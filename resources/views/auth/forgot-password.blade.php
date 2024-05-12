<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  {{-- <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" /> --}}
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card">
      <div class="card-body">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Mot de passe oublié? Entrez votre email et le nouveau mot de passe') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <!-- Email Address -->
          <div>
            <x-input-label for="email" :value="__('Email')"  />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus class="form-control" />
            <!-- Afficher les erreurs pour le champ Email -->
            @error('email')
              <div class="text-red-500 mt-2">{{ $message }}</div>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <x-input-label for="password" :value="__('Password')"  />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus class="form-control" />
            <!-- Afficher les erreurs pour le champ Password -->
            @error('password')
              <div class="text-red-500 mt-2">{{ $message }}</div>
            @enderror
          </div>

          <div class="flex items-center justify-end mt-4">
            {{-- <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button > --}}
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Retour à la connexion') }}</a>
            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Créer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
