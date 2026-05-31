<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Reportes</h1>
            <p class="text-sm text-gray-500 mt-1">Responde a las incidencias y problemas reportados por los usuarios.</p>
        </div>
        <a href="/admin" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
            <h2 class="text-sm font-semibold text-gray-700">Todos los Reportes</h2>
            <button onclick="loadReportes(1)" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizar
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b text-xs font-semibold text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3">ID / Fecha</th>
                        <th class="px-6 py-3">Usuario</th>
                        <th class="px-6 py-3">Mensaje</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody id="reportes-body" class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Cargando reportes...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="pagination-controls" class="bg-gray-50 px-6 py-3 border-t flex items-center justify-between hidden">
            <button id="btn-prev-page" class="px-3 py-1.5 border border-gray-300 rounded text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Anterior
            </button>
            <span class="text-xs text-gray-600">
                Página <span id="current-page" class="font-bold text-gray-800">1</span> de <span id="total-pages" class="font-bold text-gray-800">1</span>
            </span>
            <button id="btn-next-page" class="px-3 py-1.5 border border-gray-300 rounded text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Siguiente
            </button>
        </div>
    </div>
</div>

<div id="responder-modal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full overflow-hidden">
        <div class="bg-blue-600 px-5 py-4 text-white flex justify-between items-center">
            <h3 class="text-lg font-semibold">Responder Reporte #<span id="modal-reporte-id"></span></h3>
            <button type="button" onclick="closeModal()" class="text-white hover:text-blue-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-5">
            <div class="mb-4 bg-gray-50 p-3 rounded text-xs text-gray-700 border border-gray-100">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Mensaje del usuario:</span>
                <p id="modal-mensaje-usuario" class="whitespace-pre-wrap leading-relaxed text-gray-800"></p>
            </div>

            <form id="responder-form" onsubmit="submitRespuesta(event)">
                <input type="hidden" id="reporte_id">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Estado</label>
                        <select id="estado" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="resuelto">Resuelto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Respuesta Rápida</label>
                        <select id="preset" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" onchange="applyPreset()">
                            <option value="">(Escribir respuesta libre)</option>
                            <option value="Hemos recibido tu reporte. Muchas gracias por avisarnos.">Reporte confirmado</option>
                            <option value="Ya estamos trabajando en solucionar este problema.">En proceso</option>
                            <option value="La incidencia ha sido resuelta con éxito.">Incidencia resuelta</option>
                            <option value="No hemos podido replicar el error. ¿Podrías darnos más detalles?">Solicitar más detalles</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Mensaje de Respuesta</label>
                    <textarea id="respuesta_admin" rows="4" class="w-full rounded border-gray-300 p-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Escribe aquí la respuesta oficial..." required></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                        Guardar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const REPORTES_API = API_BASE + '/api/admin/reportes';
    let reportesData = [];
    let currentPage = 1;
    const limitPerPage = 15;

    // Carga inicial de datos desde la API
    function loadReportes(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('reportes-body');
        const pagControls = document.getElementById('pagination-controls');
        
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                    <div class="inline-block animate-spin h-5 w-5 border-2 border-blue-500 border-t-transparent rounded-full align-middle mr-2"></div>
                    Cargando información...
                </td>
            </tr>`;

        fetch(`${REPORTES_API}?page=${currentPage}&limit=${limitPerPage}`)
            .then(res => res.json())
            .then(data => {
                // Soportar tanto si viene paginado como un array directo
                reportesData = data.items || data;
                
                // Configurar controles de paginación si existen datos de páginas
                if (data.total_paginas !== undefined && data.total_paginas > 1) {
                    pagControls.classList.remove('hidden');
                    document.getElementById('current-page').textContent = data.pagina;
                    document.getElementById('total-pages').textContent = data.total_paginas;
                    
                    const prevBtn = document.getElementById('btn-prev-page');
                    const nextBtn = document.getElementById('btn-next-page');

                    prevBtn.disabled = data.pagina <= 1;
                    nextBtn.disabled = !data.hay_mas;
                    
                    prevBtn.onclick = () => loadReportes(data.pagina - 1);
                    nextBtn.onclick = () => loadReportes(data.pagina + 1);
                } else {
                    pagControls.classList.add('hidden');
                }

                renderTable();
            })
            .catch(err => {
                console.error("Error al obtener los reportes:", err);
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Error al cargar reportes. Verifique el servidor backend.</td></tr>';
                pagControls.classList.add('hidden');
            });
    }

    // Pinta las filas de la tabla
    function renderTable() {
        const tbody = document.getElementById('reportes-body');

        if (reportesData.length === 0) {
            const mensajeVacio = currentPage === 1 ? 'No hay reportes registrados.' : 'No quedan más reportes en esta página.';
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">${mensajeVacio}</td></tr>`;
            return;
        }

        let html = '';
        
        reportesData.forEach(r => {
            const fecha = new Date(r.creado_en).toLocaleString();
            
            // Estilos dinámicos del estado
            let stateStyle = 'bg-gray-100 text-gray-700';
            if (r.estado === 'en_proceso') stateStyle = 'bg-amber-100 text-amber-800';
            if (r.estado === 'resuelto') stateStyle = 'bg-green-100 text-green-800';

            // Tratamiento de la vista previa de la respuesta
            let previewRespuesta = '<span class="italic text-gray-400">Sin respuesta</span>';
            if (r.respuesta_admin) {
                previewRespuesta = r.respuesta_admin.length > 30 
                    ? r.respuesta_admin.substring(0, 30) + '...' 
                    : r.respuesta_admin;
            }

            // Sanitización básica para inyección de texto simple
            const userSanitizado = limpiaTexto(r.username);
            const msgSanitizado = limpiaTexto(r.mensaje);
            const textoEstado = r.estado.replace('_', ' ').toUpperCase();

            html += `
            <tr class="hover:bg-gray-50/60 transition">
                <td class="px-6 py-3.5">
                    <div class="font-bold text-gray-800">#${r.id}</div>
                    <div class="text-xs text-gray-400 mt-0.5">${fecha}</div>
                </td>
                <td class="px-6 py-3.5 font-medium text-gray-700">${userSanitizado}</td>
                <td class="px-6 py-3.5 max-w-xs">
                    <p class="text-xs text-gray-600 line-clamp-2" title="${msgSanitizado}">${msgSanitizado}</p>
                    <div class="mt-1 text-[11px] text-gray-400">Resp: ${limpiaTexto(previewRespuesta)}</div>
                </td>
                <td class="px-6 py-3.5">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold ${stateStyle}">
                        ${textoEstado}
                    </span>
                </td>
                <td class="px-6 py-3.5 whitespace-nowrap">
                    <button onclick="openModal(${r.id})" class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-white border border-gray-200 hover:border-blue-400 px-3 py-1 rounded shadow-xs transition">
                        Responder
                    </button>
                </td>
            </tr>`;
        });
        
        tbody.innerHTML = html;
    }

    // Modal: Abrir y Cerrar
    function openModal(id) {
        const reporte = reportesData.find(r => r.id === id);
        if (!reporte) return;

        document.getElementById('modal-reporte-id').textContent = reporte.id;
        document.getElementById('modal-mensaje-usuario').textContent = reporte.mensaje;
        document.getElementById('reporte_id').value = reporte.id;
        document.getElementById('estado').value = reporte.estado;
        document.getElementById('respuesta_admin').value = reporte.respuesta_admin || '';
        document.getElementById('preset').value = '';

        document.getElementById('responder-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('responder-modal').classList.add('hidden');
    }

    // Lógica de respuestas rápidas
    function applyPreset() {
        const presetVal = document.getElementById('preset').value;
        if (!presetVal) return;
        
        document.getElementById('respuesta_admin').value = presetVal;
        
        const estadoSelect = document.getElementById('estado');
        if (presetVal.includes('resuelt')) {
            estadoSelect.value = 'resuelto';
        } else if (presetVal.includes('trabajando') || presetVal.includes('proceso')) {
            estadoSelect.value = 'en_proceso';
        }
    }

    // Enviar el formulario al backend
    function submitRespuesta(e) {
        e.preventDefault();
        const id = document.getElementById('reporte_id').value;
        const estado = document.getElementById('estado').value;
        const respuesta_admin = document.getElementById('respuesta_admin').value;

        fetch(`${REPORTES_API}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ estado, respuesta_admin })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok' || data.success) {
                closeModal();
                loadReportes(currentPage);
            } else {
                alert('Error al guardar: ' + (data.error || 'Error desconocido'));
            }
        })
        .catch(err => {
            console.error("Error en la petición:", err);
            alert('Error de conexión con el servidor.');
        });
    }

    // Función auxiliar simple para evitar romper el HTML
    function limpiaTexto(str) {
        if (!str) return '';
        return str.toString()
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // Carga inicial
    document.addEventListener('DOMContentLoaded', () => loadReportes(1));
</script>