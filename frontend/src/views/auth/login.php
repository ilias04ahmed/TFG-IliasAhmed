<div class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="text-blue-600 mb-3 flex justify-center">
            <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Inicia sesión en tu cuenta
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            O 
            <a href="/register" class="font-medium text-blue-600 hover:text-blue-700 transition">
                crea una cuenta nueva
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 border border-gray-200/80 rounded-xl shadow-xs sm:px-10">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="rounded-lg bg-red-50 p-4 mb-6 border border-red-100 flex gap-3">
                    <div class="text-red-400 flex-shrink-0">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-red-800">
                            <?php 
                            echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); 
                            unset($_SESSION['error']);
                            ?>
                        </h2>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mb-6 flex justify-center">
                <div id="g_id_onload"
                     data-client_id="<?php echo htmlspecialchars($googleClientId, ENT_QUOTES, 'UTF-8'); ?>"
                     data-login_uri="http://localhost/google-login"
                     data-auto_prompt="false">
                </div>
                <div class="g_id_signin"
                     data-type="standard"
                     data-size="large"
                     data-theme="outline"
                     data-text="signin_with"
                     data-shape="rectangular"
                     data-logo_alignment="left"
                     data-width="368">
                </div>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-400">o usa tu cuenta</span>
                </div>
            </div>

            <form class="space-y-5" action="/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">
                        Nombre de usuario
                    </label>
                    <div class="mt-1 relative rounded-md shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input id="username" name="username" type="text" required autocomplete="username"
                            class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                            placeholder="Ej: admin o usuario">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Contraseña
                    </label>
                    <div class="mt-1 relative rounded-md shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-xs">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>