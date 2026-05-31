<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestionar Horarios</h1>
            <p class="text-sm text-gray-500 mt-1">Añade, edita o elimina horarios de las líneas</p>
        </div>
        <a href="/admin" class="text-sm text-gray-600 hover:text-gray-900 transition flex items-center gap-1">
            ← Volver al panel
        </a>
    </div>

    <div class="bg-white border rounded-xl shadow-sm p-5 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Añadir Nuevo Horario</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
            <div>
                <label for="add-linea" class="block text-xs font-medium text-gray-600 mb-1">Línea</label>
                <select id="add-linea" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">Cargando líneas...</option>
                </select>
            </div>
            <div>
                <label for="add-parada" class="block text-xs font-medium text-gray-600 mb-1">Parada</label>
                <input id="add-parada" type="text" placeholder="Ej: Plaza Constitución" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label for="add-sentido" class="block text-xs font-medium text-gray-600 mb-1">Sentido</label>
                <select id="add-sentido" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="ida">Ida</option>
                    <option value="vuelta">Vuelta</option>
                </select>
            </div>
            <div>
                <label for="add-dia" class="block text-xs font-medium text-gray-600 mb-1">Día</label>
                <select id="add-dia" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="L-D">L-D (Todos)</option>
                    <option value="L-V">L-V</option>
                    <option value="S">Sábado</option>
                    <option value="D">Domingo</option>
                </select>
            </div>
            <div>
                <label for="add-hora" class="block text-xs font-medium text-gray-600 mb-1">Hora</label>
                <input id="add-hora" type="time" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label for="add-orden" class="block text-xs font-medium text-gray-600 mb-1">Orden</label>
                <div class="flex gap-2">
                    <input id="add-orden" type="number" min="0" value="1" class="w-full rounded border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <button onclick="addHorario()" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                        Añadir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full sm:w-auto">
            <select id="filter-linea" onchange="loadHorarios()" class="rounded border-gray-300 px-3 py-2 text-sm bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <option value="">Todas las líneas</option>
            </select>
            <select id="filter-sentido" onchange="loadHorarios()" class="rounded border-gray-300 px-3 py-2 text-sm bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <option value="">Todos sentidos</option>
                <option value="ida">Ida</option>
                <option value="vuelta">Vuelta</option>
            </select>
            <select id="filter-dia" onchange="loadHorarios()" class="rounded border-gray-300 px-3 py-2 text-sm bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <option value="">Todos los días</option>
                <option value="L-D">L-D</option>
                <option value="L-V">L-V</option>
                <option value="S">Sábado</option>
                <option value="D">Domingo</option>
            </select>
        </div>
        <div class="text-sm text-gray-500">
            <span id="count-badge" class="bg-gray-100 px-3 py-1 rounded-full font-medium text-gray-700">0 registros</span>
        </div>
    </div>

    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b text-xs font-semibold text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3">Línea</th>
                        <th class="px-6 py-3">Parada</th>
                        <th class="px-6 py-3 text-center">Sentido</th>
                        <th class="px-6 py-3 text-center">Día</th>
                        <th class="px-6 py-3 text-center">Hora</th>
                        <th class="px-6 py-3 text-center">Orden</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="horarios-tbody" class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">Cargando horarios...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Editar Horario</h3>
        <input type="hidden" id="edit-id">
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit-linea" class="block text-xs font-medium text-gray-600 mb-1">Línea</label>
                <select id="edit-linea" class="w-full rounded border-gray-300 px-3 py-2 text-sm"></select>
            </div>
            <div>
                <label for="edit-sentido" class="block text-xs font-medium text-gray-600 mb-1">Sentido</label>
                <select id="edit-sentido" class="w-full rounded border-gray-300 px-3 py-2 text-sm">
                    <option value="ida">Ida</option>
                    <option value="vuelta">Vuelta</option>
                </select>
            </div>
            <div class="col-span-2">
                <label for="edit-parada" class="block text-xs font-medium text-gray-600 mb-1">Parada</label>
                <input id="edit-parada" type="text" class="w-full rounded border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="edit-dia" class="block text-xs font-medium text-gray-600 mb-1">Día</label>
                <select id="edit-dia" class="w-full rounded border-gray-300 px-3 py-2 text-sm">
                    <option value="L-D">L-D</option>
                    <option value="L-V">L-V</option>
                    <option value="S">Sábado</option>
                    <option value="D">Domingo</option>
                </select>
            </div>
            <div>
                <label for="edit-hora" class="block text-xs font-medium text-gray-600 mb-1">Hora</label>
                <input id="edit-hora" type="time" class="w-full rounded border-gray-300 px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label for="edit-orden" class="block text-xs font-medium text-gray-600 mb-1">Orden de Parada</label>
                <input id="edit-orden" type="number" min="0" class="w-full rounded border-gray-300 px-3 py-2 text-sm">
            </div>
        </div>
        
        <div class="flex justify-end gap-2 mt-6">
            <button onclick="closeEditModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium transition">
                Cancelar
            </button>
            <button onclick="saveEdit()" class="px-5 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                Guardar Cambios
            </button>
        </div>
    </div>
</div>

<script>
    let lineasData = [];

    async function init() {
        try {
            const res = await fetch(`${API_BASE}/api/horarios/lineas`);
            if (res.ok) lineasData = await res.json();
        } catch (e) { 
            console.warn("Ruta primaria fallida, intentando fallback...", e);
        }

        if (!lineasData || !lineasData.length) {
            try {
                const res = await fetch(`${API_BASE}/api/routes`);
                const data = await res.json();
                if (data && data.routes) {
                    lineasData = data.routes.map(r => ({ id: r.id, codigo: r.id, nombre: r.name }));
                }
            } catch (err) {
                console.error("Error cargando líneas.", err);
            }
        }

        populateSelects();
        await loadHorarios();
    }

    function populateSelects() {
        const selects = [
            { id: 'add-linea', defaultText: 'Seleccione una línea...' },
            { id: 'filter-linea', defaultText: 'Todas las líneas' },
            { id: 'edit-linea', defaultText: 'Seleccione una línea...' }
        ];

        selects.forEach(item => {
            const el = document.getElementById(item.id);
            if (!el) return;
            
            let optionsHTML = `<option value="">${item.defaultText}</option>`;
            
            if (Array.isArray(lineasData)) {
                lineasData.forEach(l => {
                    optionsHTML += `<option value="${l.id}">${l.codigo || l.id} – ${l.nombre}</option>`;
                });
            }
            el.innerHTML = optionsHTML;
        });
    }

    async function loadHorarios() {
        const filterLineaEl = document.getElementById('filter-linea');
        const filterSentidoEl = document.getElementById('filter-sentido');
        const filterDiaEl = document.getElementById('filter-dia');
        const tbody = document.getElementById('horarios-tbody');

        const lineaId = filterLineaEl ? filterLineaEl.value : '';
        const sentido = filterSentidoEl ? filterSentidoEl.value : '';
        const diaTipo = filterDiaEl ? filterDiaEl.value : '';

        let queryParams = [];
        if (lineaId) queryParams.push(`linea_id=${encodeURIComponent(lineaId)}`);
        if (sentido) queryParams.push(`sentido=${encodeURIComponent(sentido)}`);
        if (diaTipo) queryParams.push(`dia_tipo=${encodeURIComponent(diaTipo)}`);

        const url = `${API_BASE}/api/horarios${queryParams.length ? '?' + queryParams.join('&') : ''}`;

        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error(`HTTP Error: ${res.status}`);
            
            const data = await res.json();
            
            if (document.getElementById('count-badge')) {
                document.getElementById('count-badge').textContent = `${data.length} registros`;
            }
            renderTable(data);
        } catch (e) {
            console.error("Error al obtener horarios:", e);
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="7" class="px-6 py-8 text-center text-red-500 font-medium">Error de conexión con el servidor de horarios.</td></tr>`;
            }
        }
    }

    function renderTable(data) {
        const tbody = document.getElementById('horarios-tbody');
        if (!tbody) return;

        if (!data || !data.length) {
            tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No se encontraron horarios</td></tr>';
            return;
        }

        tbody.innerHTML = data.map(h => {
            const badgeColor = h.linea_color || '#6B7280';
            const sentidoStyle = h.sentido === 'ida' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700';
            const sentidoTexto = h.sentido === 'ida' ? '→ Ida' : '← Vuelta';
            const horaFormateada = h.hora ? h.hora.substring(0, 5) : '--:--';

            return `
                <tr class="hover:bg-gray-50/70 transition">
                    <td class="px-6 py-3.5">
                        <span class="inline-block px-2.5 py-1 rounded text-xs font-bold text-white" style="background: ${badgeColor}">
                            ${h.linea_codigo || h.linea_id}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 font-medium text-gray-800">${h.parada}</td>
                    <td class="px-6 py-3.5 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium ${sentidoStyle}">
                            ${sentidoTexto}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-center text-gray-600 text-xs font-medium">${h.dia_tipo}</td>
                    <td class="px-6 py-3.5 text-center font-mono font-bold text-gray-800">${horaFormateada}</td>
                    <td class="px-6 py-3.5 text-center text-gray-500">${h.orden_parada}</td>
                    <td class="px-6 py-3.5 text-center whitespace-nowrap">
                        <button onclick="openEdit(${JSON.stringify(h).replace(/"/g, '&quot;')})" class="text-blue-600 hover:text-blue-800 p-1 mx-0.5 transition" title="Editar">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button onclick="deleteHorario(${h.id})" class="text-red-500 hover:text-red-700 p-1 mx-0.5 transition" title="Borrar">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function addHorario() {
        const body = {
            linea_id: parseInt(document.getElementById('add-linea').value),
            parada: document.getElementById('add-parada').value,
            sentido: document.getElementById('add-sentido').value,
            dia_tipo: document.getElementById('add-dia').value,
            hora: document.getElementById('add-hora').value,
            orden_parada: parseInt(document.getElementById('add-orden').value) || 0
        };

        if (!body.linea_id || !body.parada || !body.hora) {
            alert('Por favor, rellene los campos obligatorios: línea, parada y hora.');
            return;
        }

        try {
            const res = await fetch(`${API_BASE}/api/horarios`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });

            if (res.ok) {
                document.getElementById('add-parada').value = '';
                document.getElementById('add-hora').value = '';
                loadHorarios();
            } else {
                const err = await res.json();
                alert(err.error || 'Ocurrió un error al procesar la solicitud.');
            }
        } catch (e) { 
            alert('Error de conexión: ' + e.message); 
        }
    }

    function openEdit(h) {
        document.getElementById('edit-id').value = h.id;
        document.getElementById('edit-linea').value = h.linea_id;
        document.getElementById('edit-parada').value = h.parada;
        document.getElementById('edit-sentido').value = h.sentido;
        document.getElementById('edit-dia').value = h.dia_tipo;
        document.getElementById('edit-hora').value = h.hora ? h.hora.substring(0, 5) : '';
        document.getElementById('edit-orden').value = h.orden_parada;
        
        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    async function saveEdit() {
        const id = document.getElementById('edit-id').value;
        const body = {
            linea_id: parseInt(document.getElementById('edit-linea').value),
            parada: document.getElementById('edit-parada').value,
            sentido: document.getElementById('edit-sentido').value,
            dia_tipo: document.getElementById('edit-dia').value,
            hora: document.getElementById('edit-hora').value,
            orden_parada: parseInt(document.getElementById('edit-orden').value) || 0
        };

        try {
            const res = await fetch(`${API_BASE}/api/horarios/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });

            if (res.ok) {
                closeEditModal();
                loadHorarios();
            } else {
                alert('No se pudo actualizar el horario.');
            }
        } catch (e) { 
            alert('Error de conexión: ' + e.message); 
        }
    }

    async function deleteHorario(id) {
        if (!confirm('¿Está seguro de que desea eliminar este horario?')) return;
        try {
            const res = await fetch(`${API_BASE}/api/horarios/${id}`, { method: 'DELETE' });
            if (res.ok) {
                loadHorarios();
            }
        } catch (e) { 
            alert('Error al eliminar: ' + e.message); 
        }
    }

    document.addEventListener('DOMContentLoaded', init);
</script>