<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Soporte Técnico</h1>
        <a href="/mis-rutas" class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver
        </a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-2xl p-4 mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p class="text-sm font-medium"><?= htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <p class="text-sm font-medium"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Enviar Nuevo Reporte o Incidencia
        </h2>

        <form action="/reportes" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
            
            <div class="mb-4">
                <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="4"
                    class="w-full rounded-xl border-2 border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none shadow-sm px-4 py-3 transition"
                    placeholder="Describe el problema que has encontrado..." required maxlength="500"></textarea>
                
                <div class="flex justify-between items-center mt-1.5">
                    <p class="text-xs text-gray-400">Los reportes se eliminan automáticamente tras 48 horas.</p>
                    <span class="text-xs text-gray-400"><span id="char-count">0</span> / 500</span>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Aceptar
                </button>
            </div>
        </form>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 mb-4">Tus Reportes Recientes</h2>

    <?php if (empty($reportes)): ?>
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-8 text-center text-gray-500">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <p class="text-lg font-medium">No tienes reportes activos</p>
            <p class="text-sm">Los reportes enviados aparecerán aquí durante 48 horas.</p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($reportes as $reporte): ?>
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800">
                                Reporte #<?= (int)$reporte['id']; ?>
                            </h3>
                            
                            <?php
                            // Asignación de estilos dinámicos según el estado del reporte
                            $badgeClass = 'bg-gray-100 text-gray-800';
                            if ($reporte['estado'] === 'en_proceso') {
                                $badgeClass = 'bg-amber-100 text-amber-800';
                            } elseif ($reporte['estado'] === 'resuelto') {
                                $badgeClass = 'bg-green-100 text-green-800';
                            }
                            
                            $textoEstado = str_replace('_', ' ', strtoupper($reporte['estado']));
                            ?>
                            
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold <?= $badgeClass; ?>">
                                <?= htmlspecialchars($textoEstado); ?>
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm whitespace-pre-wrap"><?= htmlspecialchars($reporte['mensaje']); ?></p>
                        
                        <p class="text-xs text-gray-400 mt-3 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Enviado el <?= htmlspecialchars($reporte['creado_en']); ?>
                        </p>
                    </div>

                    <?php if (!empty($reporte['respuesta_admin'])): ?>
                        <div class="bg-blue-50 p-4 border-l-4 border-blue-500">
                            <div class="flex items-start gap-3">
                                <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 mb-1">Respuesta del Administrador</h4>
                                    <p class="text-gray-700 text-sm whitespace-pre-wrap"><?= htmlspecialchars($reporte['respuesta_admin']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // Contador de caracteres dinámico para el textarea
    const campoMensaje = document.getElementById('mensaje');
    const visualizadorContador = document.getElementById('char-count');

    if (campoMensaje && visualizadorContador) {
        campoMensaje.addEventListener('input', function() {
            visualizadorContador.textContent = this.value.length;
        });
    }
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>