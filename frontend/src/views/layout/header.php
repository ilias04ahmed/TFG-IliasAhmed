<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if (!defined('BACKEND_URL')) define('BACKEND_URL', 'https://tfg-backend-api.onrender.com');
    ?>
    <script>const API_BASE = '<?php echo BACKEND_URL; ?>';</script>
    <title>
        <?php echo $title ?? 'Ceuta Bus - Seguimiento en tiempo real'; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/map.css">
    <link rel="stylesheet" href="/css/horarios.css">
    <link rel="stylesheet" href="/css/favoritos.css">
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <nav class="fixed w-full z-50 glass top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-teal-500">
                        CeutaBus
                    </span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="/"
                            class="hover:bg-blue-50 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition">Inicio</a>
                        <a href="/map"
                            class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium shadow-lg transition">Ver
                            Mapa en Vivo</a>
                        <a href="/horarios"
                            class="hover:bg-teal-50 text-gray-700 px-3 py-2 rounded-md text-sm font-medium transition">Horarios</a>

                        <!-- Separador visual -->
                        <div class="h-6 w-px bg-gray-300 mx-2"></div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="flex items-center gap-3">
                                <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                                    <!-- Centro de Notificaciones -->
                                    <div class="relative">
                                        <button id="btn-notificaciones" onclick="toggleNotifDropdown()" class="relative px-2 py-1.5 rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center text-gray-600 focus:outline-none" title="Centro de Notificaciones">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                            <span id="notif-badge" class="hidden absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                                0
                                            </span>
                                        </button>

                                        <!-- Menú desplegable (oculto por defecto) -->
                                        <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden z-50">
                                            <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                                <h3 class="text-sm font-semibold text-gray-800">Avisos</h3>
                                                <button onclick="marcarTodasLeidas()" class="text-[11px] text-blue-600 hover:text-blue-800 font-medium bg-transparent focus:outline-none transition">
                                                    Marcar todas como leídas
                                                </button>
                                            </div>
                                            <div id="notif-list" class="max-h-80 overflow-y-auto w-full">
                                                <div class="p-4 text-center text-sm text-gray-500">Cargando...</div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="/mis-rutas" id="nav-mis-rutas"
                                        class="text-teal-600 hover:text-teal-800 font-medium text-sm transition flex items-center gap-1 relative">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                        Mis Rutas
                                        <span id="nav-alertas-badge" class="hidden absolute -top-1 -right-3 flex h-4 w-4">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex items-center justify-center rounded-full h-4 w-4 bg-red-500 text-white text-[9px] font-bold"
                                                id="nav-alertas-count"></span>
                                        </span>
                                    </a>

                                    <a href="/reportes"
                                        class="text-teal-600 hover:text-teal-800 font-medium text-sm transition flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Soporte
                                    </a>
                                    <script>
                                        (function () {
                                            const uid = <?php echo json_encode($_SESSION['user_id']); ?>;
                                            fetch(API_BASE + '/api/favoritos/' + uid + '/alertas')
                                                .then(r => r.json())
                                                .then(data => {
                                                    if (data.count && data.count > 0) {
                                                        const badge = document.getElementById('nav-alertas-badge');
                                                        const count = document.getElementById('nav-alertas-count');
                                                        if (badge && count) {
                                                            count.textContent = data.count > 9 ? '9+' : data.count;
                                                            badge.classList.remove('hidden');
                                                        }
                                                    }
                                                })
                                                .catch(() => { });
                                        })();
                                    </script>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <a href="/admin"
                                        class="text-amber-600 hover:text-amber-800 font-medium text-sm transition">Panel
                                        Admin</a>
                                <?php endif; ?>
                                <span class="text-sm text-gray-600">Hola, <span
                                        class="font-bold text-gray-900"><?php echo htmlspecialchars($_SESSION['username']); ?></span></span>
                                <a href="/logout" class="text-sm text-red-600 hover:text-red-800 transition">Salir</a>
                            </div>
                        <?php else: ?>
                            <a href="/login"
                                class="text-gray-700 hover:text-blue-600 text-sm font-medium transition">Iniciar Sesión</a>
                            <a href="/register"
                                class="bg-teal-500 text-white hover:bg-teal-600 px-4 py-2 rounded-md text-sm font-medium shadow transition">Registro</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="md:hidden">
                <button onclick="toggleMenuMovil()" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition" id="btn-hamburguesa">
                    <svg id="icon-menu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="menu-movil" class="hidden md:hidden pb-3 pt-2 border-t border-gray-100">
            <div class="flex flex-col space-y-1 px-2">
                <a href="/" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-blue-50 transition">Inicio</a>
                <a href="/map" class="block px-3 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">Ver Mapa en Vivo</a>
                <a href="/horarios" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-teal-50 transition">Horarios</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                        <a href="/mis-rutas" class="block px-3 py-2 rounded-md text-sm font-medium text-teal-600 hover:bg-teal-50 transition">Mis Rutas</a>
                        <a href="/reportes" class="block px-3 py-2 rounded-md text-sm font-medium text-teal-600 hover:bg-teal-50 transition">Soporte</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/admin" class="block px-3 py-2 rounded-md text-sm font-medium text-amber-600 hover:bg-amber-50 transition">Panel Admin</a>
                    <?php endif; ?>
                    <div class="px-3 py-2 border-t border-gray-100 mt-1 pt-3 flex justify-between items-center">
                        <span class="text-sm text-gray-600">Hola, <span class="font-bold text-gray-900"><?php echo htmlspecialchars($_SESSION['username']); ?></span></span>
                        <a href="/logout" class="text-sm text-red-600 hover:text-red-800 transition">Salir</a>
                    </div>
                <?php else: ?>
                    <a href="/login" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Iniciar Sesión</a>
                    <a href="/register" class="block px-3 py-2 rounded-md text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 transition">Registro</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </nav>
    <div class="h-16"></div>

    <div id="notif-toast" class="fixed top-20 right-4 z-[100] transform translate-x-full opacity-0 transition-all duration-500 pointer-events-none">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 p-4 max-w-sm pointer-events-auto">
            <div class="flex items-start gap-3">
                                <svg id="notif-toast-icon-svg" class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <div class="min-w-0">
                    <h4 id="notif-toast-titulo" class="font-bold text-gray-900 text-sm truncate"></h4>
                    <p id="notif-toast-mensaje" class="text-xs text-gray-500 mt-0.5 line-clamp-2"></p>
                </div>
                <button onclick="cerrarToastNotif()" class="text-gray-400 hover:text-gray-600 flex-shrink-0">✕</button>
            </div>
        </div>
    </div>

    <script>
    // =====================
    // Centro de Notificaciones
    // =====================
    var notifIntervalo = null;
    var allAvisos = [];

    // Iconos por tipo de aviso (scope global para que estén disponibles en todas las funciones)
    var iconosAviso = {
        info: '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        averia: '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        retraso: '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        cambio_ruta: '<svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>'
    };

    function getAvisosLeidos() {
        var leidos = localStorage.getItem('notif_leidas');
        return leidos ? JSON.parse(leidos) : [];
    }

    // Agregar ID a leídos
    function marcarAvisoLeido(id) {
        var leidos = getAvisosLeidos();
        id = parseInt(id);
        if (!leidos.includes(id)) {
            leidos.push(id);
            localStorage.setItem('notif_leidas', JSON.stringify(leidos));
            renderNotificaciones(allAvisos);
        }
    }

    function marcarTodasLeidas() {
        var leidos = getAvisosLeidos();
        for (var i = 0; i < allAvisos.length; i++) {
            var id = parseInt(allAvisos[i].id);
            if (!leidos.includes(id)) {
                leidos.push(id);
            }
        }
        localStorage.setItem('notif_leidas', JSON.stringify(leidos));
        renderNotificaciones(allAvisos);
    }

    // Alternar visibilidad del menú desplegable
    function toggleNotifDropdown() {
        var dropdown = document.getElementById('notif-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Cerrar menú si se hace clic fuera
    document.addEventListener('click', function(event) {
        var btn = document.getElementById('btn-notificaciones');
        var dropdown = document.getElementById('notif-dropdown');
        if (btn && dropdown) {
            if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Iniciar el polling
    function iniciarPollingAvisos() {
        if (!notifIntervalo) {
            // Pedir notificación nativa si no tiene
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
            obtenerAvisos(true); // Carga inicial
            notifIntervalo = setInterval(function() { obtenerAvisos(false); }, 30000); // 30s
        }
    }

    // Realizar la consulta a la API
    function obtenerAvisos(isInitialLoad) {
        fetch(API_BASE + '/api/avisos')
            .then(function(res) { return res.json(); })
            .then(function(avisos) {
                if (!avisos) return;
                allAvisos = avisos;
                renderNotificaciones(avisos);
                comprobarNuevosParaToast(avisos, isInitialLoad);
            })
            .catch(function(e) {
                console.error("Error obteniendo avisos:", e);
            });
    }

    function renderNotificaciones(avisos) {
        var listContainer = document.getElementById('notif-list');
        var badge = document.getElementById('notif-badge');
        if (!listContainer || !badge) return;

        var leidos = getAvisosLeidos();
        var unreadCount = 0;
        
        listContainer.innerHTML = '';

        if (avisos.length === 0) {
            listContainer.innerHTML = '<div class="p-6 text-center text-sm text-gray-400">No hay avisos recientes</div>';
            badge.classList.add('hidden');
            return;
        }

        var iconos = iconosAviso;

        for (var i = 0; i < avisos.length; i++) {
            var aviso = avisos[i];
            var id = parseInt(aviso.id);
            var esLeido = leidos.includes(id);
            if (!esLeido) unreadCount++;

            var iconItem = iconos[aviso.tipo] || '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>';
            var bgClass = esLeido ? 'bg-white opacity-70' : 'bg-blue-50 hover:bg-blue-100 cursor-pointer';
            var lineasInfo = aviso.linea_codigo ? '<span class="px-1.5 py-0.5 rounded text-[10px] bg-gray-200 text-gray-700 font-bold ml-2">L' + aviso.linea_codigo + '</span>' : '';
            var dotVisual = esLeido ? '' : '<div class="absolute right-3 top-3 w-2 h-2 rounded-full bg-blue-500"></div>';

            var onclickHandler = esLeido ? '' : 'onclick="marcarAvisoLeido(' + id + ')"';

            var html = `
            <div class="relative p-4 border-b border-gray-100 transition-colors ${bgClass}" ${onclickHandler}>
                ${dotVisual}
                <div class="flex items-start gap-3">
                    <span class="text-xl flex-shrink-0">${iconItem}</span>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-gray-900 pr-4">${aviso.titulo} ${lineasInfo}</h4>
                        <p class="text-xs text-gray-600 mt-1 line-clamp-2">${aviso.mensaje}</p>
                        <span class="text-[10px] text-gray-400 mt-2 block">${new Date(aviso.creado_en).toLocaleString()}</span>
                    </div>
                </div>
            </div>`;
            listContainer.insertAdjacentHTML('beforeend', html);
        }

        // Setup badge
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 9 ? '+9' : unreadCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    // Comprobar si debemos soltar un Toast/Notificación OS
    function comprobarNuevosParaToast(avisos, isInitialLoad) {
        var ultimoIdToast = parseInt(localStorage.getItem('notif_ultimo_id_toast')) || 0;
        
        if (ultimoIdToast === 0 && isInitialLoad) {
            // Primera carga en la historia de este navegador, no hacer spam
            var maxActual = Math.max.apply(Math, avisos.map(function(o) { return parseInt(o.id) || 0; }));
            localStorage.setItem('notif_ultimo_id_toast', maxActual);
            return;
        }

        var nuevos = [];
        var nuevoMax = ultimoIdToast;

        for (var i = 0; i < avisos.length; i++) {
            var id = parseInt(avisos[i].id);
            if (!isNaN(id) && id > ultimoIdToast) {
                nuevos.push(avisos[i]);
                if (id > nuevoMax) nuevoMax = id;
            }
        }

        if (nuevos.length > 0) {
            for (var j = 0; j < nuevos.length; j++) {
                enviarNotificacionEmergente(nuevos[j]);
            }
        }

        if (nuevoMax > ultimoIdToast) {
            localStorage.setItem('notif_ultimo_id_toast', nuevoMax);
        }
    }

    function enviarNotificacionEmergente(aviso) {
        var iconoHtml = iconosAviso[aviso.tipo] || iconosAviso.info;
        var linea = aviso.linea_codigo ? ' (Línea ' + aviso.linea_codigo + ')' : '';

        // Notificacion nativa del navegador
        if ('Notification' in window && Notification.permission === 'granted') {
            var notif = new Notification('CeutaBus: ' + aviso.titulo, {
                body: aviso.mensaje + linea,
                icon: '/images/bus-icon.png',
                tag: 'aviso-' + aviso.id
            });
            notif.onclick = function() {
                window.focus();
                notif.close();
                toggleNotifDropdown(); // abrir centro de notis
            };
        }

        // Tambien mostrar toast dentro de la web
        mostrarToastNotif(iconoHtml, aviso.titulo, aviso.mensaje);
    }

    // Toast visual dentro de la pagina
    function mostrarToastNotif(icono, titulo, mensaje) {
        var toast = document.getElementById('notif-toast');
        var iconEl = document.getElementById('notif-toast-icon');
        var tituloEl = document.getElementById('notif-toast-titulo');
        var mensajeEl = document.getElementById('notif-toast-mensaje');

        if (!toast) return;

        iconEl.innerHTML = icono;
        tituloEl.textContent = titulo;
        mensajeEl.textContent = mensaje;
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');

        setTimeout(cerrarToastNotif, 5000);
    }

    function cerrarToastNotif() {
        var toast = document.getElementById('notif-toast');
        if (!toast) return;
        toast.classList.add('translate-x-full', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');
    }

    function toggleMenuMovil() {
        var menu = document.getElementById('menu-movil');
        var iconoMenu = document.getElementById('icon-menu');
        var iconoCierre = document.getElementById('icon-close');
        menu.classList.toggle('hidden');
        iconoMenu.classList.toggle('hidden');
        iconoCierre.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('btn-notificaciones')) {
            iniciarPollingAvisos();
        }
    });
    </script>

    <main class="flex-grow">