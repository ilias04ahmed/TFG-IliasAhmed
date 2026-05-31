<div class="flex h-[calc(100vh-64px)]">
    <aside
        class="w-80 md:w-96 lg:w-[26rem] bg-gradient-to-b from-white to-gray-50 shadow-2xl z-20 flex flex-col transition-all duration-300 transform border-r border-gray-100"
        id="sidebar">
        <div class="p-5 border-b border-gray-100 bg-white">
            <div class="flex items-center gap-3 mb-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-teal-400 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 7m0 13V7">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Rutas Activas</h2>
                    <p class="text-xs text-gray-400">Mapa interactivo en tiempo real</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-400 flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Actualizando en vivo
                </span>
                <button onclick="toggleAllRoutes()"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1.5 rounded-lg transition font-medium">
                    Mostrar/Ocultar Todo
                </button>
            </div>
        </div>

        <div class="flex-grow overflow-y-auto p-4 space-y-2" id="routes-list-container">
            <div class="text-gray-300 py-8">
                <svg class="w-12 h-12 mx-auto mb-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2zM8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M9 12h6M9 16h6"></path>
                </svg>
                <p class="text-sm">Cargando rutas...</p>
            </div>
        </div>

        <div class="p-4 border-t border-gray-100 bg-white">
            <div id="selected-bus-info" class="hidden">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></span>
                    <h3 class="font-bold text-gray-700 text-sm">Próxima Llegada Estimada</h3>
                </div>
                <div class="text-xs text-gray-400 mb-2">
                    Línea <span id="eta-linea" class="font-bold text-gray-600">--</span>
                    &middot; Autobús <span id="eta-bus" class="font-bold text-gray-600">--</span>
                </div>
                <div
                    class="p-4 bg-gradient-to-br from-teal-50 to-blue-50 rounded-xl text-center border border-teal-100">
                    <span
                        class="block text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-600 to-blue-600"
                        id="eta-time">-- min</span>
                    <span class="text-xs text-gray-400 mt-1 block">a tu parada más cercana</span>
                </div>
            </div>
            <div id="no-selection" class="text-center py-3">
                <p class="text-sm text-gray-400">
                    <svg class="w-6 h-6 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                    </svg>
                    Toca un autobús en el mapa para ver su ETA
                </p>
            </div>
        </div>
    </aside>

    <div class="flex-grow relative z-10">
        <div id="map" class="h-full w-full"></div>

        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
            class="absolute top-4 left-4 z-[500] bg-white/90 backdrop-blur-sm p-2.5 rounded-xl shadow-lg md:hidden border border-gray-100 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <div
            class="absolute bottom-6 right-6 z-[500] bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 px-4 py-3">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Leyenda</div>
            <div class="flex flex-col gap-1.5 text-xs text-gray-600">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm"></span>
                    Autobús en ruta
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full border-2 border-gray-400 bg-white"></span>
                    Parada de autobús
                </div>
            </div>
        </div>

        <div id="aviso-sin-buses" class="hidden absolute top-4 left-1/2 -translate-x-1/2 z-[500] bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border border-gray-200 px-4 py-2.5 flex items-center gap-2 text-sm text-gray-600">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            No hay autobuses activos en este momento
        </div>
    </div>
</div>

<script>
    const map = L.map('map', {
        zoomControl: false 
    }).setView([35.8883, -5.3162], 14);

    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    function createBusIcon(color) {
        return L.divIcon({
            className: 'custom-bus-icon',
            html: `<div class="bus-marker-icon" style="
                background: linear-gradient(135deg, ${color}, ${color}dd);
                box-shadow: 0 4px 12px -2px ${color}66, 0 2px 6px rgba(0,0,0,0.15);
            " onmouseover="this.style.boxShadow='0 8px 20px -4px ${color}88'"
               onmouseout="this.style.boxShadow='0 4px 12px -2px ${color}66'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 6v6m7-6v6M2 12h19.6M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H6C4.9 6 3.9 6.8 3.6 7.8l-1.4 5c-.1.4-.2.8-.2 1.2 0 .4.1.8.2 1.2.3 1.1.8 2.8.8 2.8h3m2 0h6"></path>
                    <circle cx="7" cy="18" r="2"></circle>
                    <circle cx="17" cy="18" r="2"></circle>
                </svg>
            </div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -22]
        });
    }

    const globalStopIcon = L.divIcon({
        className: 'global-stop-icon',
        html: `<div class="stop-marker-icon-global"></div>`,
        iconSize: [12, 12],
        iconAnchor: [6, 6]
    });

    var mapLayer = {};
    var routesInfo = {};
    var activeRoutes = new Set();
    var allRoutes = [];

    function getRouteColor(route) {
        if (route.color) return route.color;
        
        const colors = [
            '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', 
            '#EC4899', '#06B6D4', '#F97316', '#6366F1', '#14B8A6'
        ];
        
        // Cifrado simple para color de ruta
        let hash = 0;
        const str = String(route.id);
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        return colors[Math.abs(hash) % colors.length];
    }

    function renderRoutesSidebar(routes) {
        var container = document.getElementById('routes-list-container');
        container.innerHTML = '';

        routes.forEach(function(route) {
            var isVisible = activeRoutes.has(route.id);
            var div = document.createElement('div');
            div.className = `group p-3.5 rounded-xl transition-all duration-300 flex items-center justify-between cursor-pointer border-2 ${isVisible
                ? 'bg-white shadow-sm border-gray-100 hover:shadow-md'
                : 'bg-gray-50 border-transparent opacity-60 hover:opacity-80'}`;

            div.onclick = function() { toggleSingleRoute(route.id); };
            div.onmouseenter = function() { window.highlightRoute(route.id); };
            div.onmouseleave = function() { window.unhighlightRoute(route.id); };

            var displayName = route.name || route.id;
            div.innerHTML = `
                <div class="flex items-center gap-3 flex-grow min-w-0 pr-2">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm flex-shrink-0 transition-transform group-hover:scale-110"
                         style="background: ${route.color}">
                        ${route.id}
                    </div>
                    <div class="min-w-0 py-1">
                        <div class="font-bold text-gray-900 text-sm">Línea ${route.id}</div>
                        <div class="font-medium text-gray-500 text-xs leading-tight mt-0.5">${displayName}</div>
                        <div class="text-[10px] uppercase font-bold tracking-wide mt-1 ${isVisible ? 'text-green-500' : 'text-gray-400'}">${isVisible ? '🟢 EN EL MAPA' : '⚫ OCULTA'}</div>
                    </div>
                </div>
                <div class="flex-shrink-0 ml-2">
                    <div class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition ${isVisible
                    ? 'bg-blue-500 border-blue-500'
                    : 'border-gray-300 bg-white'}">
                        ${isVisible ? '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    }

    function toggleSingleRoute(routeId) {
        if (activeRoutes.has(routeId)) {
            activeRoutes.delete(routeId);
        } else {
            activeRoutes.add(routeId);
        }
        updateMapVisibility();
        renderRoutesSidebar(Object.values(routesInfo));
    }

    function toggleAllRoutes() {
        var hayVisibles = false;
        activeRoutes.forEach(function(id) {
            if (routesInfo[id]) hayVisibles = true;
        });
        
        if (hayVisibles) {
            activeRoutes.clear();
        } else {
            for (var i = 0; i < allRoutes.length; i++) {
                activeRoutes.add(allRoutes[i]);
            }
        }
        updateMapVisibility();
        renderRoutesSidebar(Object.values(routesInfo));
    }

    function updateMapVisibility() {
        for (var rutaId in routesInfo) {
            var isVisible = activeRoutes.has(rutaId);
            var capaRuta = mapLayer['route_' + rutaId];
            var capaParadas = mapLayer['stops_' + rutaId];

            if (capaRuta) {
                if (isVisible && !map.hasLayer(capaRuta)) map.addLayer(capaRuta);
                else if (!isVisible && map.hasLayer(capaRuta)) map.removeLayer(capaRuta);
            }
            if (capaParadas) {
                if (isVisible && !map.hasLayer(capaParadas)) map.addLayer(capaParadas);
                else if (!isVisible && map.hasLayer(capaParadas)) map.removeLayer(capaParadas);
            }
        }

        for (var key in mapLayer) {
            if (key.indexOf('BUS_') === 0) {
                var marker = mapLayer[key];
                var rId = marker.options.routeId;
                
                var existeRuta = rId && routesInfo[rId];
                if (existeRuta && !activeRoutes.has(rId)) {
                    if (map.hasLayer(marker)) map.removeLayer(marker);
                } else {
                    if (!map.hasLayer(marker)) map.addLayer(marker);
                }
            }
        }
    }

    window.highlightRoute = function(routeId) {
        if (!activeRoutes.has(routeId)) return;
        var layer = mapLayer['route_' + routeId];
        if (layer) {
            layer.eachLayer(function(line) {
                line.setStyle({ weight: 8, opacity: 1 });
                line.bringToFront();
            });
        }
        var stopsLayer = mapLayer['stops_' + routeId];
        if (stopsLayer) {
            stopsLayer.eachLayer(function(marker) {
                if(marker._icon) marker._icon.style.transform = 'scale(1.5)';
            });
        }
    };

    window.unhighlightRoute = function(routeId) {
        if (!activeRoutes.has(routeId)) return;
        var layer = mapLayer['route_' + routeId];
        if (layer) {
            layer.eachLayer(function(line) {
                line.setStyle({ weight: 5, opacity: 0.65 });
            });
        }
        var stopsLayer = mapLayer['stops_' + routeId];
        if (stopsLayer) {
            stopsLayer.eachLayer(function(marker) {
                if(marker._icon) marker._icon.style.transform = 'scale(1)';
            });
        }
    };

    async function loadRoutes() {
        try {
            var response = await fetch(API_BASE + '/api/routes');
            if (!response.ok) return;

            var data = await response.json();

            for (var key in mapLayer) {
                if (key.indexOf('route_') === 0 || key.indexOf('stops_') === 0) {
                    map.removeLayer(mapLayer[key]);
                    delete mapLayer[key];
                }
            }
            routesInfo = {};
            
            if (data.routes) {
                for (var i = 0; i < data.routes.length; i++) {
                    var route = data.routes[i];
                    var rColor = getRouteColor(route);
                    route.color = rColor;
                    
                    routesInfo[route.id] = route;
                    allRoutes.push(route.id);
                    activeRoutes.add(route.id);

                    if (route.path && route.path.length > 0) {
                        var segments = Array.isArray(route.path[0]) ? route.path : [route.path];
                        
                        var polylineGroup = L.featureGroup();
                        for (var s = 0; s < segments.length; s++) {
                            var segment = segments[s];
                            var pathCoords = [];
                            for (var p = 0; p < segment.length; p++) {
                                pathCoords.push([segment[p].lat, segment[p].lon]);
                            }
                            L.polyline(pathCoords, {
                                color: rColor,
                                weight: 5,
                                opacity: 0.65,
                                lineCap: 'round',
                                lineJoin: 'round'
                            }).addTo(polylineGroup);
                        }
                        
                        if (activeRoutes.has(route.id)) polylineGroup.addTo(map);
                        mapLayer['route_' + route.id] = polylineGroup;
                    }

                    if (route.stops) {
                        var stopMarkers = [];
                        for (var st = 0; st < route.stops.length; st++) {
                            var stop = route.stops[st];
                            var stopIcon = L.divIcon({
                                className: 'custom-stop-icon',
                                html: `<div class="stop-marker-icon-route" style="border-color: ${route.color}"></div>`,
                                iconSize: [14, 14],
                                iconAnchor: [7, 7]
                            });

                            var stopMarker = L.marker([stop.lat, stop.lon], { icon: stopIcon, zIndexOffset: 1000 });
                            stopMarker.bindPopup(`
                                <div class="stop-popup">
                                    <div class="stop-popup__name">${stop.name}</div>
                                    <div class="stop-popup__badge" style="background: ${route.color}15;">
                                        <span class="stop-popup__badge-dot" style="background: ${route.color}"></span>
                                        <span class="stop-popup__badge-text" style="color: ${route.color}">${route.id}</span>
                                    </div>
                                </div>
                            `);
                            stopMarker.bindTooltip(stop.name, { direction: 'top', offset: [0, -10], className: 'custom-tooltip' });
                            stopMarkers.push(stopMarker);
                        }
                        var stopsGroup = L.layerGroup(stopMarkers);
                        if (activeRoutes.has(route.id)) stopsGroup.addTo(map);
                        mapLayer['stops_' + route.id] = stopsGroup;
                    }
                }

                allRoutes = Object.keys(routesInfo);
                renderRoutesSidebar(Object.values(routesInfo));
            }
        } catch (error) {
            console.log("Error routes: " + error);
        }
    }

    async function loadAllStops() {
        try {
            var response = await fetch(API_BASE + '/api/stops');
            if (!response.ok) return;

            var stops = await response.json();

            var stopMarkers = [];
            for (var i = 0; i < stops.length; i++) {
                var stop = stops[i];
                var marker = L.marker([stop.lat, stop.lon], { icon: globalStopIcon, zIndexOffset: 0 });
                marker.bindPopup(`
                    <div class="global-stop-popup">
                        <div class="global-stop-popup__name">${stop.name}</div>
                        <div class="global-stop-popup__sub">Parada de Autobús</div>
                    </div>
                `);
                marker.bindTooltip(stop.name, { direction: 'top', offset: [0, -8], className: 'custom-tooltip' });
                stopMarkers.push(marker);
            }

            var globalStopsGroup = L.layerGroup(stopMarkers).addTo(map);
            mapLayer['global_stops'] = globalStopsGroup;
        } catch (error) {
            console.log("Error al cargar paradas: " + error);
        }
    }

    function animarMarcador(marker, destLat, destLon, duracion) {
        var origen = marker.getLatLng();
        var inicioLat = origen.lat;
        var inicioLon = origen.lng;

        var dist = Math.abs(destLat - inicioLat) + Math.abs(destLon - inicioLon);
        if (dist < 0.000001) return;

        var tiempoInicio = performance.now();

        function paso(tiempoActual) {
            var progreso = (tiempoActual - tiempoInicio) / duracion;

            if (progreso >= 1) {
                marker.setLatLng([destLat, destLon]);
                return;
            }

            var lat = inicioLat + (destLat - inicioLat) * progreso;
            var lon = inicioLon + (destLon - inicioLon) * progreso;
            marker.setLatLng([lat, lon]);

            requestAnimationFrame(paso);
        }

        requestAnimationFrame(paso);
    }

    async function updateBuses() {
        try {
            const response = await fetch(`${API_BASE}/api/buses?_nocache=${new Date().getTime()}`);
            if (!response.ok) throw new Error("HTTP " + response.status);
            const buses = await response.json();

            buses.forEach(bus => {
                const routeC = routesInfo[bus.route_id] ? routesInfo[bus.route_id].color : '#6366F1';
                const isVisible = activeRoutes.has(bus.route_id);

                const busKey = 'BUS_' + bus.id;

                if (!mapLayer[busKey]) {
                    const marker = L.marker([bus.lat, bus.lon], {
                        icon: createBusIcon(routeC),
                        routeId: bus.route_id
                    });

                    marker.addTo(map);

                    marker.bindPopup(`
                        <div class="bus-popup">
                            <div class="bus-popup__title" style="color: ${routeC};">Línea ${bus.route_id}</div>
                            <div class="bus-popup__sub">Vehículo: ${bus.id}</div>
                        </div>
                    `);

                    marker.on('click', async () => {
                        document.getElementById('no-selection').classList.add('hidden');
                        document.getElementById('selected-bus-info').classList.remove('hidden');
                        document.getElementById('eta-time').innerText = "Calculando...";
                        document.getElementById('eta-linea').innerText = bus.route_id || '--';
                        document.getElementById('eta-bus').innerText = bus.id;

                        try {
                            const etaRes = await fetch(`${API_BASE}/api/eta/${bus.route_id}`);
                            const etaData = await etaRes.json();

                            if (etaData.eta_seconds !== null) {
                                const totalSeconds = etaData.eta_seconds;
                                const minutes = Math.floor(totalSeconds / 60);
                                const seconds = Math.floor(totalSeconds % 60);

                                let timeStr = "";
                                if (minutes > 0) timeStr += minutes + " min ";
                                if (seconds > 0 || minutes === 0) timeStr += seconds + " seg";

                                document.getElementById('eta-time').innerText = timeStr.trim();
                            } else {
                                document.getElementById('eta-time').innerText = "Aprendiendo...";
                            }
                        } catch (e) {
                            document.getElementById('eta-time').innerText = "--";
                        }
                    });

                    mapLayer[busKey] = marker;
                } else {
                    const marker = mapLayer[busKey];

                    animarMarcador(marker, bus.lat, bus.lon, 900);

                    const routeExisteEnSistema = routesInfo.hasOwnProperty(bus.route_id);
                    if (routeExisteEnSistema && !isVisible) {
                        if (map.hasLayer(marker)) map.removeLayer(marker);
                    } else {
                        if (!map.hasLayer(marker)) map.addLayer(marker);
                    }
                }
            });
            var aviso = document.getElementById('aviso-sin-buses');
            if (aviso) {
                if (buses.length === 0) {
                    aviso.classList.remove('hidden');
                } else {
                    aviso.classList.add('hidden');
                }
            }
        } catch (error) {
            console.error("Error buses:", error.message);
        }
    }

    loadAllStops().then(() => {
        loadRoutes(); // Routes will handle their own initial updateBuses
        setInterval(updateBuses, 1000);
    });
</script>

