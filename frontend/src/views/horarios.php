<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-teal-50">
    
    <header class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-teal-500/5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-teal-400 shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-teal-500">Horarios</span>
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500">
                    Consulta los horarios estáticos de todas las líneas de autobús de Ceuta
                </p>
            </div>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="filter-linea" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Línea</label>
                    <select id="filter-linea" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Cargando...</option>
                    </select>
                </div>
                <div>
                    <label for="filter-dia" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Día</label>
                    <select id="filter-dia" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Todos</option>
                    </select>
                </div>
                <div>
                    <label for="filter-parada" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Parada</label>
                    <select id="filter-parada" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm">
                        <option value="">Todas las paradas</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
        <div id="lineas-cards-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="horarios-container" class="bg-white rounded-t-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8 text-center text-gray-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
                </svg>
                <p class="text-lg font-medium">Selecciona una línea para ver sus horarios</p>
            </div>
        </div>
        
        <footer id="pagination-controls" class="bg-white border text-center border-gray-100 rounded-b-2xl shadow-lg px-6 py-4 flex items-center justify-between hidden">
            <button id="btn-prev-page" class="px-3 py-1.5 border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                Anterior
            </button>
            <span class="text-sm text-gray-500">
                Página <span id="current-page" class="font-bold text-gray-900">1</span> de <span id="total-pages" class="font-bold text-gray-900">1</span>
            </span>
            <button id="btn-next-page" class="px-3 py-1.5 border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                Siguiente
            </button>
        </footer>
    </main>
</div>

<script>
    // Variables globales para el estado de la página
    let listaLineas = [];
    let colorLineaActiva = '#3B82F6';
    let paginaActual = 1;

    const ETIQUETAS_DIAS = {
        'L-D': 'Lunes a Domingo',
        'L-V': 'Lunes a Viernes',
        'S': 'Sábado',
        'D': 'Domingo y Festivos'
    };

    // Renderizar las tarjetas superiores de las líneas
    function pintarTarjetas() {
        const grid = document.getElementById('lineas-cards-grid');
        grid.innerHTML = listaLineas.map(linea => `
            <div class="group bg-white rounded-2xl border-2 border-gray-100 hover:border-blue-200 p-5 cursor-pointer transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                 data-id="${linea.id}">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md"
                         style="background: ${linea.color}">
                        ${linea.codigo}
                    </div>
                    <div class="flex-grow min-w-0">
                        <h3 class="font-bold text-gray-900 truncate">${linea.nombre}</h3>
                        <div class="flex flex-wrap gap-2 mt-1">
                            ${linea.dias.map(d => `<span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">${d}</span>`).join('')}
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 text-sm">
                        <div class="text-xs text-gray-400">Primera</div>
                        <div class="font-bold text-gray-800">${linea.primera_salida.substring(0, 5)}</div>
                        <div class="text-xs text-gray-400 mt-1">Última</div>
                        <div class="font-bold text-gray-800">${linea.ultima_salida.substring(0, 5)}</div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Procesar y pintar la tabla cruzada de horarios
    function pintarTablaHorarios(datos) {
        const contenedor = document.getElementById('horarios-container');

        if (!datos || !datos.length) {
            contenedor.innerHTML = `
                <div class="p-8 text-center text-gray-300">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 5-8-5"></path>
                    </svg>
                    <p class="text-lg font-medium">No hay servicios disponibles para los filtros seleccionados</p>
                </div>`;
            return;
        }

        // Agrupar datos por tipo de día
        const datosAgrupados = {};
        datos.forEach(item => {
            const clave = `${item.dia_tipo}|${item.sentido}`;
            if (!datosAgrupados[clave]) {
                datosAgrupados[clave] = [];
            }
            datosAgrupados[clave].push(item);
        });

        const infoLinea = listaLineas.find(l => l.id == datos[0].linea_id);
        const nombreCompletoLinea = infoLinea ? `${infoLinea.codigo} – ${infoLinea.nombre}` : datos[0].linea_codigo;

        let html = `
            <div class="p-6 border-b border-gray-100 bg-white">
                <div class="flex items-center gap-3">
                    <div class="px-3 py-1 rounded-lg text-white font-bold text-sm shadow-sm" style="background: ${colorLineaActiva}">
                        ${datos[0].linea_codigo}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">${nombreCompletoLinea}</h2>
                        <p class="text-sm text-gray-500">${datos.length} registros cargados</p>
                    </div>
                </div>
            </div>`;

        Object.keys(datosAgrupados).sort().forEach(clave => {
            const [diaTipo] = clave.split('|');
            const registros = datosAgrupados[clave];

            // Obtener lista ordenada de paradas únicas
            const mapaParadas = {};
            registros.forEach(r => {
                if (!mapaParadas[r.parada] || r.orden_parada < mapaParadas[r.parada]) {
                    mapaParadas[r.parada] = r.orden_parada;
                }
            });
            const listaParadas = Object.keys(mapaParadas).sort((a, b) => mapaParadas[a] - mapaParadas[b]);

            // Organizar las horas por cada parada
            const horasPorParada = {};
            listaParadas.forEach(p => horasPorParada[p] = []);
            registros.forEach(r => horasPorParada[r.parada].push(r.hora.substring(0, 5)));
            listaParadas.forEach(p => horasPorParada[p].sort());

            // Agrupar los viajes en columnas verticales
            const maxViajes = Math.max(...listaParadas.map(p => horasPorParada[p].length), 0);
            const viajesColumnas = [];
            for (let i = 0; i < maxViajes; i++) {
                const columna = {};
                listaParadas.forEach(p => {
                    if (horasPorParada[p][i]) {
                        columna[p] = horasPorParada[p][i];
                    }
                });
                viajesColumnas.push(columna);
            }

            html += `
                <div class="border-b border-gray-100 last:border-0">
                    <div class="px-6 py-4 bg-gray-50/50 flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Sentido Único (Circular)
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            ${ETIQUETAS_DIAS[diaTipo] || diaTipo}
                        </span>
                        <span class="text-xs text-gray-400 ml-auto">${viajesColumnas.length} expedición(es)</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/30">
                                    <th class="sticky left-0 bg-slate-50 lg:bg-white z-10 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[200px]">Parada</th>
                                    ${viajesColumnas.map((_, idx) => `<th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[80px]">Salida ${idx + 1}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                ${listaParadas.map((parada, idx) => {
                                    let filaClase = '';
                                    if (idx === 0) filaClase = 'bg-blue-50/20';
                                    if (idx === listaParadas.length - 1) filaClase = 'bg-green-50/20';
                                    
                                    return `
                                        <tr class="group border-b border-gray-50 hover:bg-blue-50/30 transition-colors ${filaClase}">
                                            <td class="sticky left-0 bg-white group-hover:bg-blue-50/40 lg:group-hover:bg-slate-50 z-10 px-4 py-3 font-medium text-gray-800 whitespace-nowrap transition-colors">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: ${colorLineaActiva}; opacity: ${idx === 0 || idx === listaParadas.length - 1 ? '1' : '0.4'}"></span>
                                                    ${parada}
                                                </div>
                                            </td>
                                            ${viajesColumnas.map(v => `
                                                <td class="px-4 py-3 text-center font-mono text-gray-700 ${v[parada] ? '' : 'text-gray-300'}">
                                                    ${v[parada] || '—'}
                                                </td>
                                            `).join('')}
                                        </tr>`;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>`;
        });

        contenedor.innerHTML = html;
    }

    // Cargar los horarios desde la API de backend
    async function cargarHorarios(pagina = 1) {
        paginaActual = pagina;
        const idLinea = document.getElementById('filter-linea').value;
        if (!idLinea) return;

        const contenedor = document.getElementById('horarios-container');
        const controlesPaginacion = document.getElementById('pagination-controls');
        
        contenedor.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                <svg class="animate-spin h-8 w-8 mx-auto text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-sm">Cargando la matriz de horarios...</p>
            </div>`;
        controlesPaginacion.classList.add('hidden');

        const filtroDia = document.getElementById('filter-dia').value;
        const filtroParada = document.getElementById('filter-parada').value;

        // Construir la URL con parámetros normales
        let url = `${API_BASE}/api/horarios?linea_id=${idLinea}&sentido=ida`;
        if (filtroDia) url += `&dia_tipo=${filtroDia}`;
        if (filtroParada) url += `&parada=${encodeURIComponent(filtroParada)}`;

        try {
            const res = await fetch(url);
            const respuesta = await res.json();
            const registros = respuesta.items || respuesta;

            if (respuesta.total_paginas && respuesta.total_paginas > 1) {
                controlesPaginacion.classList.remove('hidden');
                document.getElementById('current-page').textContent = respuesta.pagina;
                document.getElementById('total-pages').textContent = respuesta.total_paginas;
                document.getElementById('btn-prev-page').disabled = respuesta.pagina <= 1;
                document.getElementById('btn-next-page').disabled = !respuesta.hay_mas;

                document.getElementById('btn-prev-page').onclick = () => cargarHorarios(respuesta.pagina - 1);
                document.getElementById('btn-next-page').onclick = () => cargarHorarios(respuesta.pagina + 1);
            }

            pintarTablaHorarios(registros);
        } catch (err) {
            console.error(err);
            contenedor.innerHTML = `
                <div class="p-8 text-center text-red-500">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">No se pudo conectar con el servicio de horarios.</p>
                </div>`;
        }
    }

    // Evento al cambiar la línea en el selector
    async function cambioDeLinea() {
        const idLinea = document.getElementById('filter-linea').value;
        const contenedor = document.getElementById('horarios-container');
        
        if (!idLinea) {
            contenedor.innerHTML = `
                <div class="p-8 text-center text-gray-300">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
                    </svg>
                    <p class="text-lg font-medium">Selecciona una línea para ver sus horarios</p>
                </div>`;
            return;
        }

        const lineaSeleccionada = listaLineas.find(l => l.id == idLinea);
        colorLineaActiva = lineaSeleccionada ? lineaSeleccionada.color : '#3B82F6';

        // Actualizar selectores secundarios de días y paradas
        const selectDia = document.getElementById('filter-dia');
        selectDia.innerHTML = '<option value="">Todos los días</option>';
        if (lineaSeleccionada && lineaSeleccionada.dias) {
            lineaSeleccionada.dias.forEach(d => {
                selectDia.innerHTML += `<option value="${d}">${ETIQUETAS_DIAS[d] || d}</option>`;
            });
        }

        try {
            const resParadas = await fetch(`${API_BASE}/api/horarios/paradas?linea_id=${idLinea}&sentido=ida`);
            const paradas = await resParadas.json();
            const selectParada = document.getElementById('filter-parada');
            selectParada.innerHTML = '<option value="">Todas las paradas</option>';
            paradas.forEach(p => {
                selectParada.innerHTML += `<option value="${p.parada}">${p.parada}</option>`;
            });
        } catch (e) {
            console.warn(e);
        }

        cargarHorarios();
    }

    // Evento al hacer click sobre una tarjeta
    function seleccionarTarjeta(id) {
        document.getElementById('filter-linea').value = id;
        document.querySelectorAll('#lineas-cards-grid > div').forEach(card => {
            card.classList.toggle('border-blue-500', card.dataset.id == id);
            card.classList.toggle('bg-blue-50/10', card.dataset.id == id);
        });
        cambioDeLinea();
        document.getElementById('filter-linea').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Inicialización al cargar la página
    async function inicializar() {
        // Listeners de los selectores normales
        document.getElementById('filter-linea').addEventListener('change', cambioDeLinea);
        document.getElementById('filter-dia').addEventListener('change', () => cargarHorarios());
        document.getElementById('filter-parada').addEventListener('change', () => cargarHorarios());

        // Evento para capturar el click en las tarjetas del grid
        document.getElementById('lineas-cards-grid').addEventListener('click', (e) => {
            const tarjeta = e.target.closest('[data-id]');
            if (tarjeta) {
                seleccionarTarjeta(tarjeta.dataset.id);
            }
        });

        try {
            const res = await fetch(`${API_BASE}/api/horarios/lineas`);
            listaLineas = await res.json();
            
            const selectLinea = document.getElementById('filter-linea');
            selectLinea.innerHTML = '<option value="">Selecciona una línea</option>';
            listaLineas.forEach(l => {
                selectLinea.innerHTML += `<option value="${l.id}">${l.codigo} – ${l.nombre}</option>`;
            });
            
            pintarTarjetas();
        } catch (e) {
            console.error(e);
        }
    }

    document.addEventListener('DOMContentLoaded', inicializar);
</script>