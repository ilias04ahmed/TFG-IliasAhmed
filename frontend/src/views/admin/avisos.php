<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tablón de Avisos</h1>
        <a href="/admin" class="text-blue-600 hover:underline text-sm font-medium">← Volver al Panel</a>
    </div>

    <div class="bg-white border rounded-lg mb-8 shadow-sm" id="aviso-form-card">
        <div class="px-6 py-4 border-b bg-blue-600 rounded-t-lg">
            <h2 class="text-lg font-semibold text-white" id="form-title">Nuevo Aviso</h2>
        </div>
        
        <form id="aviso-form" class="p-6">
            <input type="hidden" id="aviso-id" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="aviso-titulo" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                    <input type="text" id="aviso-titulo" required maxlength="150" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500" placeholder="Ej: Avería en zona Tarajal">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="aviso-tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select id="aviso-tipo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 bg-white">
                            <option value="info">Información</option>
                            <option value="averia">Avería</option>
                            <option value="retraso">Retraso</option>
                            <option value="cambio_ruta">Cambio de Ruta</option>
                        </select>
                    </div>
                    <div>
                        <label for="aviso-linea" class="block text-sm font-medium text-gray-700 mb-1">Líneas afectadas (Ctrl+Click)</label>
                        <select id="aviso-linea" multiple size="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 bg-white">
                            <option value="">Todas las líneas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="aviso-mensaje" class="block text-sm font-medium text-gray-700 mb-1">Mensaje *</label>
                <textarea id="aviso-mensaje" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500" placeholder="Describe el aviso con detalle..."></textarea>
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 font-medium shadow-sm transition">
                    <span id="btn-submit-text">Publicar Aviso</span>
                </button>
                <button type="button" id="btn-cancel" onclick="cancelEdit()" style="display:none;" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 font-medium">
                    Cancelar
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Avisos Publicados</h2>
            <span id="avisos-count" class="text-sm text-gray-500"></span>
        </div>
        
        <div id="avisos-list" class="divide-y divide-gray-200">
            <div class="p-8 text-center text-gray-400">
                <p>Cargando avisos...</p>
            </div>
        </div>
    </div>
    
    <div id="pagination-controls" class="bg-gray-50 px-6 py-3 border border-t-0 border-gray-200 rounded-b-lg flex items-center justify-between hidden">
        <button id="btn-prev-page" class="px-3 py-1.5 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">Anterior</button>
        <span class="text-sm text-gray-700">Página <span id="current-page" class="font-bold">1</span> de <span id="total-pages" class="font-bold">1</span></span>
        <button id="btn-next-page" class="px-3 py-1.5 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">Siguiente</button>
    </div>
</div>

<div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
    <div class="bg-gray-800 text-white px-6 py-3 rounded-lg shadow-xl flex items-center space-x-2">
        <span id="toast-icon"></span>
        <span id="toast-message"></span>
    </div>
</div>

<script>
    let editingId = null;
    let currentPage = 1;
    const limitPerPage = 10;

    const TIPO_CONFIG = {
        info: { icon: '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', label: 'Información', badge: 'bg-blue-100 text-blue-800' },
        averia: { icon: '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>', label: 'Avería', badge: 'bg-red-100 text-red-800' },
        retraso: { icon: '<svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', label: 'Retraso', badge: 'bg-yellow-100 text-yellow-800' },
        cambio_ruta: { icon: '<svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>', label: 'Cambio Ruta', badge: 'bg-purple-100 text-purple-800' }
    };

    async function loadLineas() {
        try {
            const res = await fetch(`${API_BASE}/api/routes`);
            const data = await res.json();
            const select = document.getElementById('aviso-linea');
            
            const routes = data.routes || data;
            
            if (Array.isArray(routes)) {
                routes.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = `${r.id} - ${(r.name || r.nombre)}`;
                    select.appendChild(opt);
                });
            }
        } catch (e) {
            console.error('Petó la carga de líneas en el form:', e);
        }
    }

    async function loadAvisos(page = 1) {
        currentPage = page;
        try {
            const res = await fetch(`${API_BASE}/api/avisos?all=1&page=${currentPage}&limit=${limitPerPage}`);
            const data = await res.json();
            
            const avisos = data.items || data;
            const container = document.getElementById('avisos-list');
            const countEl = document.getElementById('avisos-count');
            const pagControls = document.getElementById('pagination-controls');

            if (!avisos.length && currentPage === 1) {
                container.innerHTML = `<div class="p-8 text-center text-gray-500"><p>No hay avisos publicados aún</p></div>`;
                countEl.textContent = '0 avisos';
                pagControls.classList.add('hidden');
                return;
            }

            countEl.textContent = data.total !== undefined 
                ? `${data.total} aviso(s)` 
                : `${avisos.length} aviso(s)`;

            if (data.total_paginas !== undefined && data.total_paginas > 1) {
                pagControls.classList.remove('hidden');
                document.getElementById('current-page').textContent = data.pagina;
                document.getElementById('total-pages').textContent = data.total_paginas;
                document.getElementById('btn-prev-page').disabled = data.pagina <= 1;
                document.getElementById('btn-next-page').disabled = !data.hay_mas;
                
                document.getElementById('btn-prev-page').onclick = () => loadAvisos(data.pagina - 1);
                document.getElementById('btn-next-page').onclick = () => loadAvisos(data.pagina + 1);
            } else {
                pagControls.classList.add('hidden');
            }

            container.innerHTML = avisos.map(a => {
                const cfg = TIPO_CONFIG[a.tipo] || TIPO_CONFIG.info;
                const fecha = new Date(a.creado_en).toLocaleDateString('es-ES', {
                    day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });
                
                const cssInactivo = !a.activo ? 'opacity-50' : '';
                const badgeColor = a.activo ? cfg.badge : 'bg-gray-100 text-gray-500';

                return `
                <div class="px-6 py-4 hover:bg-gray-50 transition ${cssInactivo}" id="aviso-${a.id}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-1">
                                <span>${cfg.icon}</span>
                                <h3 class="text-sm font-semibold text-gray-900 truncate">${escapeHtml(a.titulo)}</h3>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full ${badgeColor}">${cfg.label}</span>
                                ${a.linea_codigo ? `<span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Línea ${a.linea_codigo}</span>` : ''}
                                ${!a.activo ? '<span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 text-gray-500">Inactivo</span>' : ''}
                            </div>
                            <p class="text-sm text-gray-600 mt-1">${escapeHtml(a.mensaje)}</p>
                            <p class="text-xs text-gray-400 mt-2">${fecha}</p>
                        </div>
                        
                        <div class="flex items-center space-x-1 ml-4 flex-shrink-0">
                            <button onclick="toggleAviso(${a.id}, ${a.activo})" title="Activar/Desactivar" class="p-2 rounded-md hover:bg-gray-100 text-gray-500">
                                ${a.activo ? '❌' : '✅'}
                            </button>
                            <button onclick="editAviso(${a.id})" title="Editar" class="p-2 rounded-md hover:bg-blue-50 text-blue-500">
                                ✏️
                            </button>
                            <button onclick="deleteAviso(${a.id})" title="Eliminar" class="p-2 rounded-md hover:bg-red-50 text-red-500">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>`;
            }).join('');

        } catch (e) {
            console.error('Error cargando la lista del tablón:', e);
            document.getElementById('avisos-list').innerHTML = `<div class="p-8 text-center text-red-500"><p>Error conectando con la API</p></div>`;
        }
    }

    document.getElementById('aviso-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const selectLinea = document.getElementById('aviso-linea');
        const selectedLineas = Array.from(selectLinea.selectedOptions).map(opt => opt.value);
        
        let lineasToPost = selectedLineas.includes("") || selectedLineas.length === 0 ? [null] : selectedLineas;

        const baseData = {
            titulo: document.getElementById('aviso-titulo').value,
            mensaje: document.getElementById('aviso-mensaje').value,
            tipo: document.getElementById('aviso-tipo').value
        };

        try {
            if (editingId) {
                baseData.activo = true;
                baseData.linea_id = lineasToPost[0]; 
                
                const res = await fetch(`${API_BASE}/api/avisos/${editingId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(baseData)
                });
                
                if (res.ok) {
                    showToast('Aviso actualizado', 'success');
                    cancelEdit();
                    loadAvisos(currentPage);
                } else {
                    const err = await res.json();
                    showToast(err.error || 'Fallo al actualizar', 'error');
                }
            } else {
                let successCount = 0;
                let errorMsg = null;
                
                for (const lid of lineasToPost) {
                    const data = { ...baseData, linea_id: lid };
                    const res = await fetch(`${API_BASE}/api/avisos`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });
                    
                    if (res.ok) {
                        successCount++;
                    } else {
                        const err = await res.json();
                        errorMsg = err.error;
                    }
                }

                if (successCount > 0) {
                    showToast(`Se publicaron ${successCount} avisos`, 'success');
                    cancelEdit();
                    loadAvisos();
                } else if (errorMsg) {
                    showToast(errorMsg, 'error');
                }
            }
        } catch (error) {
            console.error('Error enviando aviso:', error);
            showToast('Error de comunicación con el servidor', 'error');
        }
    });

    async function editAviso(id) {
        try {
            const res = await fetch(`${API_BASE}/api/avisos?all=1`);
            const avisos = await res.json();
            const aviso = avisos.find(a => a.id === id);
            
            if (!aviso) return;

            document.getElementById('aviso-id').value = aviso.id;
            document.getElementById('aviso-titulo').value = aviso.titulo;
            document.getElementById('aviso-mensaje').value = aviso.mensaje;
            document.getElementById('aviso-tipo').value = aviso.tipo;
            
            const selectLinea = document.getElementById('aviso-linea');
            const lineaVal = aviso.linea_id || '';
            
            Array.from(selectLinea.options).forEach(opt => {
                opt.selected = (opt.value == lineaVal);
            });

            document.getElementById('form-title').textContent = 'Editar Aviso';
            document.getElementById('btn-submit-text').textContent = 'Guardar Cambios';
            document.getElementById('btn-cancel').style.display = 'inline-block';
            editingId = id;

            document.getElementById('aviso-form-card').scrollIntoView({ behavior: 'smooth' });
        } catch (e) {
            showToast('No se pudo cargar el aviso', 'error');
        }
    }

    function cancelEdit() {
        editingId = null;
        document.getElementById('aviso-form').reset();
        document.getElementById('aviso-id').value = '';
        document.getElementById('form-title').textContent = 'Nuevo Aviso';
        document.getElementById('btn-submit-text').textContent = 'Publicar Aviso';
        document.getElementById('btn-cancel').style.display = 'none';
    }

    async function toggleAviso(id, currentlyActive) {
        try {
            const res = await fetch(`${API_BASE}/api/avisos?all=1`);
            const avisos = await res.json();
            const aviso = avisos.find(a => a.id === id);
            
            if (!aviso) return;

            aviso.activo = !currentlyActive;
            const updateRes = await fetch(`${API_BASE}/api/avisos/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(aviso)
            });

            if (updateRes.ok) {
                showToast(currentlyActive ? 'Aviso ocultado' : 'Aviso reactivado', 'success');
                loadAvisos(currentPage);
            }
        } catch (e) {
            showToast('Fallo al cambiar estado', 'error');
        }
    }

    async function deleteAviso(id) {
        if (!confirm('¿Seguro que te quieres cargar este aviso? No se puede deshacer.')) return;
        
        try {
            const res = await fetch(`${API_BASE}/api/avisos/${id}`, { method: 'DELETE' });
            if (res.ok) {
                showToast('Aviso borrado', 'success');
                loadAvisos(currentPage);
            }
        } catch (e) {
            showToast('No se pudo borrar', 'error');
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const iconContainer = document.getElementById('toast-icon');
        
        iconContainer.innerHTML = type === 'success' ? '✅' : '⚠️';
        document.getElementById('toast-message').textContent = message;
        
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    loadLineas();
    loadAvisos();
</script>