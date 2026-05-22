<x-guest-layout>

    <div class="text-center mb-5">

        <div class="sisal-login-avatar">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h2 class="sisal-login-title">
            Bienvenido
        </h2>

        <p class="sisal-login-subtitle">
            Accede al sistema de alertas SISAL
        </p>

    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST"
          action="{{ route('login') }}"
          id="loginForm">

        @csrf

        <div class="mb-4">

            <label class="form-label sisal-label">
                Correo electrónico
            </label>

            <div class="input-group sisal-input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       class="form-control sisal-input"
                       placeholder="Ingresa tu correo electrónico">

            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />

        </div>

        <div class="mb-3">

            <label class="form-label sisal-label">
                Contraseña
            </label>

            <div class="input-group sisal-input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       class="form-control sisal-input"
                       placeholder="Ingresa tu contraseña">

                <button type="button"
                        class="btn sisal-password-toggle"
                        onclick="togglePassword()">

                    <i class="bi bi-eye" id="toggleIcon"></i>

                </button>

            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="form-check">

                <input class="form-check-input"
                       type="checkbox"
                       id="remember_me"
                       name="remember">

                <label class="form-check-label" for="remember_me">
                    Recordarme
                </label>

            </div>

            @if (Route::has('password.request'))

                <a class="sisal-forgot-link"
                   href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>

            @endif

        </div>

        <button type="submit"
                class="btn sisal-login-btn w-100"
                id="loginBtn">

            <span class="btn-text">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                INICIAR SESIÓN
            </span>

            <span class="btn-loading d-none">
                <span class="spinner-border spinner-border-sm me-2"></span>
                Ingresando...
            </span>

        </button>

    </form>

    <script>

        function togglePassword() {

            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {

            document.querySelector('.btn-text').classList.add('d-none');
            document.querySelector('.btn-loading').classList.remove('d-none');

            document.getElementById('loginBtn').disabled = true;

        });

    </script>

</x-guest-layout>
