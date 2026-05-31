<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-teal-50">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-teal-500/5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">
            <div class="text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-teal-400 shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                    <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-teal-500">Horarios</span>
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500">
                    Consulta los horarios estáticos de todas las líneas de autobús de Ceuta
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Línea</label>
                    <select id="filter-linea" onchange="onLineaChange()"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Cargando...</option>
                    </select>
                </div>
                <div class="hidden">
                    <label
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Sentido</label>
                    <select id="filter-sentido" onchange="loadHorarios()"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="ida">Ida</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Día</label>
                    <select id="filter-dia" onchange="loadHorarios()"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Todos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Parada</label>
                    <select id="filter-parada" onchange="loadHorarios()"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Todas las paradas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div id="lineas-cards" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
        <div id="lineas-cards-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="horarios-container" class="bg-white rounded-t-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 text-center text-gray-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
                </svg>
                <p class="text-lg font-medium">Selecciona una línea para ver sus horarios</p>
            </div>
        </div>
        
        <div id="pagination-controls" class="bg-white border text-center border-gray-100 rounded-b-2xl shadow-lg px-6 py-4 flex items-center justify-between hidden">
            <button id="btn-prev-page" class="px-3 py-1.5 border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">Anterior</button>
            <span class="text-sm text-gray-500">
                Página <span id="current-page" class="font-bold text-gray-900">1</span> de <span id="total-pages" class="font-bold text-gray-900">1</span>
            </span>
            <button id="btn-next-page" class="px-3 py-1.5 border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">Siguiente</button>
        </div>
    </div>
</div>

<script>
    let allLineas = [];
    let currentColor = '#3B82F6';

    const DIA_LABELS = {
        'L-D': 'Lunes a Domingo',
        'L-V': 'Lunes a Viernes',
        'S': 'Sábado',
        'D': 'Domingo y Festivos'
    };

    async function init() {
        try {
            const res = await fetch(`${API_BASE}/api/horarios/lineas`);
            allLineas = await res.json();

            const sel = document.getElementById('filter-linea');
            sel.innerHTML = '<option value="">Selecciona una línea</option>';
            allLineas.forEach(l => {
                sel.innerHTML += `<option value="${l.id}" data-color="${l.color}">${l.codigo} – ${l.nombre}</option>`;
            });

            // Pintar tarjetas de linea
            renderLineCards();
        } catch (e) {
            console.error('Error loading lineas:', e);
        }
    }

    function renderLineCards() {
        const grid = document.getElementById('lineas-cards-grid');
        grid.innerHTML = allLineas.map(l => `
        <div class="group bg-white rounded-2xl border-2 border-gray-100 hover:border-blue-200 p-5 cursor-pointer transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
             data-id="${l.id}"
             onclick="selectLinea(${l.id})">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md"
                     style="background: ${l.color}">
                    ${l.codigo}
                </div>
                <div class="flex-grow min-w-0">
                    <h3 class="font-bold text-gray-900 truncate">${l.nombre}</h3>
                    <div class="flex flex-wrap gap-2 mt-1">
                        ${l.dias.map(d => `<span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">${d}</span>`).join('')}
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <div class="text-xs text-gray-400">Primera</div>
                    <div class="font-bold text-gray-800">${l.primera_salida.substring(0, 5)}</div>
                    <div class="text-xs text-gray-400 mt-1">Última</div>
                    <div class="font-bold text-gray-800">${l.ultima_salida.substring(0, 5)}</div>
                </div>
            </div>
        </div>
    `).join('');
    }

    function selectLinea(id) {
        document.getElementById('filter-linea').value = id;

        // Marcar la tarjeta seleccionada
        document.querySelectorAll('#lineas-cards-grid > div').forEach(function(card) {
            card.classList.remove('is-selected');
        });
        var cardSeleccionada = document.querySelector('#lineas-cards-grid > div[data-id="' + id + '"]');
        if (cardSeleccionada) {
            cardSeleccionada.classList.add('is-selected');
        }

        onLineaChange();
        document.getElementById('filter-linea').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    async function onLineaChange() {
        var lineaId = document.getElementById('filter-linea').value;
        if (!lineaId) {
            document.getElementById('horarios-container').innerHTML = `
            <div class="p-8 text-center text-gray-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
                </svg>
                <p class="text-lg font-medium">Selecciona una línea para ver sus horarios</p>
            </div>`;
            return;
        }

        // Actualizar color
        var linea = null;
        for (var i = 0; i < allLineas.length; i++) {
            if (allLineas[i].id == lineaId) linea = allLineas[i];
        }
        currentColor = linea ? linea.color : '#3B82F6';

        // Opciones de dia
        var diaSelect = document.getElementById('filter-dia');
        diaSelect.innerHTML = '<option value="">Todos los días</option>';
        if (linea && linea.dias) {
            for (var j = 0; j < linea.dias.length; j++) {
                var d = linea.dias[j];
                diaSelect.innerHTML += '<option value="' + d + '">' + (DIA_LABELS[d] || d) + '</option>';
            }
        }

        // Filtro de paradas
        try {
            var url = API_BASE + '/api/horarios/paradas?linea_id=' + lineaId + '&sentido=ida';
            var res = await fetch(url);
            var paradas = await res.json();
            var paradaSel = document.getElementById('filter-parada');
            paradaSel.innerHTML = '<option value="">Todas las paradas</option>';
            for (var k = 0; k < paradas.length; k++) {
                paradaSel.innerHTML += '<option value="' + paradas[k].parada + '">' + paradas[k].parada + '</option>';
            }
        } catch (e) { 
            console.log("Error al cargar paradas: " + e); 
        }

        loadHorarios();
    }

    var currentPage = 1;
    var limitPerPage = 20;

    async function loadHorarios(page) {
        if (page === undefined) page = 1;
        currentPage = page;
        var lineaId = document.getElementById('filter-linea').value;
        if (!lineaId) return;

        var container = document.getElementById('horarios-container');
        var pagControls = document.getElementById('pagination-controls');
        
        container.innerHTML = `
        <div class="p-8 text-center text-gray-500">
            <svg class="animate-spin h-8 w-8 mx-auto text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <p>Cargando horarios...</p>
        </div>`;
        pagControls.classList.add('hidden');

        var diaTipo = document.getElementById('filter-dia').value;
        var parada = document.getElementById('filter-parada').value;

        var url = API_BASE + '/api/horarios?linea_id=' + lineaId + '&sentido=ida';
        if (diaTipo) url += '&dia_tipo=' + diaTipo;
        if (parada) url += '&parada=' + encodeURIComponent(parada);

        try {
            var res = await fetch(url);
            var data = await res.json();
            
            var items = data.items || data;
            
            // Actualizar controles de paginacion
            if (data.total_paginas !== undefined && data.total_paginas > 1) {
                pagControls.classList.remove('hidden');
                document.getElementById('current-page').textContent = data.pagina;
                document.getElementById('total-pages').textContent = data.total_paginas;
                
                document.getElementById('btn-prev-page').disabled = data.pagina <= 1;
                document.getElementById('btn-next-page').disabled = !data.hay_mas;
                
                document.getElementById('btn-prev-page').onclick = function() { loadHorarios(data.pagina - 1); };
                document.getElementById('btn-next-page').onclick = function() { loadHorarios(data.pagina + 1); };
            }

            renderHorarios(items);
        } catch (e) {
            console.log('Error al cargar horarios: ' + e);
            container.innerHTML = `
            <div class="p-8 text-center text-red-500">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-medium">Error al cargar horarios</p>
            </div>`;
        }
    }

    function renderHorarios(data) {
        var container = document.getElementById('horarios-container');

        if (!data.length) {
            container.innerHTML = `
            <div class="p-8 text-center text-gray-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 5-8-5"></path>
                </svg>
                <p class="text-lg font-medium">No se encontraron horarios con esos filtros</p>
            </div>`;
            return;
        }

        // Agrupar por dia_tipo y sentido
        var grouped = {};
        for (var i = 0; i < data.length; i++) {
            var h = data[i];
            var keyStr = h.dia_tipo + '|' + h.sentido;
            if (!grouped[keyStr]) grouped[keyStr] = [];
            grouped[keyStr].push(h);
        }

        var html = '';
        var linea = null;
        for (var l = 0; l < allLineas.length; l++) {
            if (allLineas[l].id == data[0].linea_id) linea = allLineas[l];
        }
        var lineaNombre = linea ? linea.codigo + ' – ' + linea.nombre : data[0].linea_codigo;

        // Cabecera superior
        html += `
        <div class="horarios-header" style="--line-color: ${currentColor}">
            <div class="flex items-center gap-3">
                <div class="horarios-header__badge" style="background: var(--line-color)">
                    ${data[0].linea_codigo}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">${lineaNombre}</h2>
                    <p class="text-sm text-gray-500">${data.length} registros de horario</p>
                </div>
            </div>
        </div>`;

        var groupKeys = Object.keys(grouped).sort();
        for (var g = 0; g < groupKeys.length; g++) {
            var key = groupKeys[g];
            var parts = key.split('|');
            var dia = parts[0];
            var sentido = parts[1];
            var items = grouped[key];

            // Sacar las paradas unicas
            var paradasOrden = {};
            for (var m = 0; m < items.length; m++) {
                var it = items[m];
                if (!paradasOrden[it.parada] || it.orden_parada < paradasOrden[it.parada]) {
                    paradasOrden[it.parada] = it.orden_parada;
                }
            }
            
            var paradasList = Object.keys(paradasOrden).sort(function(a, b) {
                return paradasOrden[a] - paradasOrden[b];
            });

            // Ordenar horas
            var timesByStop = {};
            for (var p = 0; p < paradasList.length; p++) {
                timesByStop[paradasList[p]] = [];
            }
            for (var n = 0; n < items.length; n++) {
                var item = items[n];
                timesByStop[item.parada].push(item.hora.substring(0, 5));
            }
            for (var sp = 0; sp < paradasList.length; sp++) {
                timesByStop[paradasList[sp]].sort();
            }

            // Agrupar viajes
            var maxTrips = 0;
            for (var pt = 0; pt < paradasList.length; pt++) {
                var pLen = timesByStop[paradasList[pt]].length;
                if (pLen > maxTrips) maxTrips = pLen;
            }
            
            var tripGroups = [];
            for (var t = 0; t < maxTrips; t++) {
                var trip = {};
                for (var pp = 0; pp < paradasList.length; pp++) {
                    var curP = paradasList[pp];
                    if (timesByStop[curP][t]) {
                        trip[curP] = timesByStop[curP][t];
                    }
                }
                tripGroups.push(trip);
            }

            var sentidoLabel = 'Sentido Único (Circular)';
            var svgIcon = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
            var sentidoColor = 'blue';

            html += `
            <div class="border-b border-gray-100 last:border-0">
                <div class="px-6 py-4 bg-gray-50/50 flex items-center gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-${sentidoColor}-50 text-${sentidoColor}-700 text-sm font-semibold">
                        ${svgIcon} ${sentidoLabel}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        ${DIA_LABELS[dia] || dia}
                    </span>
                    <span class="text-xs text-gray-400 ml-auto">${tripGroups.length} salida(s)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="sticky left-0 bg-white z-10 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[200px]">
                                    Parada
                                </th>
                                ${tripGroups.map(function(_, idx) {
                                    return `
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[80px]">
                                        Salida ${idx + 1}
                                    </th>
                                    `;
                                }).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            ${paradasList.map(function(parada, idx) {
                                var bgClasses = '';
                                if (idx === 0) bgClasses = 'bg-blue-50/20';
                                if (idx === paradasList.length - 1) bgClasses = 'bg-green-50/20';
                                return `
                                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition-colors ${bgClasses}">
                                    <td class="sticky left-0 bg-white z-10 px-4 py-3 font-medium text-gray-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: ${currentColor}; opacity: ${idx === 0 || idx === paradasList.length - 1 ? '1' : '0.4'}"></span>
                                            ${parada}
                                        </div>
                                    </td>
                                    ${tripGroups.map(function(trip) {
                                        return `
                                        <td class="px-4 py-3 text-center font-mono text-gray-700 ${trip[parada] ? '' : 'text-gray-300'}">
                                            ${trip[parada] || '—'}
                                        </td>
                                        `;
                                    }).join('')}
                                </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                </div>
            </div>`;
        }

        container.innerHTML = html;
    }

    init();
</script>