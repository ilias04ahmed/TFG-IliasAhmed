<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Mis Rutas
            </h1>
            <p class="text-gray-500 mt-1">Guarda tus trayectos habituales y accede rápidamente</p>
        </div>
        <button onclick="openModal()" id="btn-nueva-ruta"
            class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-teal-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Ruta
        </button>
    </div>

    <div id="alertas-banner" class="hidden mb-6 animate-fadeIn">
        <div class="bg-gradient-to-r from-red-50 to-amber-50 border border-red-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600 animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="flex-grow">
                    <h3 class="font-bold text-red-800 text-sm">Avisos que afectan a tus rutas</h3>
                    <p class="text-xs text-red-600 mt-0.5" id="alertas-summary"></p>
                    <div id="alertas-detail-list" class="mt-3 space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="favoritos-list" class="space-y-4">
        <div class="text-center py-16">
            <div class="animate-spin inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full">
            </div>
            <p class="text-gray-400 mt-3">Cargando tus rutas...</p>
        </div>
    </div>

    <div id="empty-state" class="hidden text-center py-20">
        <div class="w-24 h-24 mx-auto mb-4 text-blue-400 animate-fav-float opacity-50">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-1.447-.894L15 7m0 13V7"></path>
                <circle cx="12" cy="11" r="1.5" fill="currentColor" class="text-blue-600 opacity-100"></circle>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-700">No tienes rutas guardadas</h3>
        <p class="text-gray-400 mt-2 max-w-md mx-auto">
            Guarda tus trayectos habituales como "Trabajo", "Casa" o "Universidad" para acceder rápidamente a ellos.
        </p>
        <button onclick="openModal()"
            class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear mi primera ruta
        </button>
    </div>
</div>

<div id="modal-overlay"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4"
    onclick="closeModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0"
        id="modal-content" onclick="event.stopPropagation()">

        <div
            class="sticky top-0 bg-white rounded-t-2xl border-b border-gray-100 px-6 py-4 flex justify-between items-center z-10">
            <h2 class="text-xl font-bold text-gray-800" id="modal-title">Nueva Ruta Favorita</h2>
            <button onclick="closeModal()"
                class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 space-y-5">

            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Icono</label>
                    <div class="relative">
                        <button type="button" id="emoji-btn" data-icon="location"
                            class="w-14 h-14 bg-gray-50 border-2 border-gray-200 rounded-xl flex items-center justify-center hover:border-blue-400 transition focus:ring-2 focus:ring-blue-200 text-blue-600"
                            onclick="toggleEmojiPicker()">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                        
                        <div id="emoji-picker" class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-xl p-2 shadow-xl z-20 flex gap-1">
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEmoji('home')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEmoji('work')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745V20a2 2 0 002 2h14a2 2 0 002-2v-6.745zM16 8V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v3m4 7h4v-2H8v2h4zm0 0V9"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEmoji('school')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEmoji('location')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEmoji('heart')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-grow">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nombre de la ruta</label>
                    <input id="input-nombre" type="text" placeholder="Ej: Trabajo, Casa, Universidad..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition text-gray-800 font-medium"
                        maxlength="50">
                </div>
            </div>

            <div>
                <div class="flex border-b border-gray-200 mb-4">
                    <button type="button" id="tab-planificador" onclick="conmutarModoRuta('planificador')" class="py-2 px-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600 focus:outline-none">Planificador</button>
                    <button type="button" id="tab-manual" onclick="conmutarModoRuta('manual')" class="py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none">Modo Manual</button>
                </div>

                <div id="seccion-planificador" class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Parada Origen</label>
                            <select id="planificar_origen" class="w-full px-3 py-2.5 bg-white border-2 border-gray-200 rounded-lg outline-none text-sm"></select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Parada Destino</label>
                            <select id="planificar_destino" class="w-full px-3 py-2.5 bg-white border-2 border-gray-200 rounded-lg outline-none text-sm"></select>
                        </div>
                    </div>
                    <button type="button" onclick="ejecutarPlanificacion()" class="w-full py-2.5 bg-blue-600 text-white font-medium rounded-xl text-sm hover:bg-blue-700 transition">Calcular Itinerario</button>
                    <div id="contenedor-itinerario" class="hidden p-4 bg-gray-50 rounded-xl border border-gray-200 text-sm space-y-2"></div>
                </div>

                <div id="seccion-manual" class="hidden space-y-3">
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-sm font-medium text-gray-600">Segmentos del trayecto</label>
                        <span class="text-xs text-gray-400" id="seg-count">0 segmentos</span>
                    </div>

                    <div id="segmentos-container" class="space-y-3"></div>

                    <button onclick="addSegmentForm()" id="btn-add-segment" type="button"
                        class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-dashed border-gray-300 text-gray-500 font-medium rounded-xl hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50/50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Añadir segmento
                    </button>

                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Añade varios segmentos si tu trayecto incluye transbordo entre lineas
                    </p>
                </div>
            </div>

        <div class="sticky bottom-0 bg-gray-50 rounded-b-2xl border-t border-gray-100 px-6 py-4 flex justify-end gap-3">
            <button onclick="closeModal()"
                class="px-5 py-2.5 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition">
                Cancelar
            </button>
            <button onclick="saveFavorito()" id="btn-save"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-teal-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                Guardar Ruta
            </button>
        </div>
    </div>
</div>

<div id="edit-modal-overlay"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4"
    onclick="closeEditModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0"
        id="edit-modal-content" onclick="event.stopPropagation()">
        <div class="px-6 py-5">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Editar Ruta</h2>
            <input type="hidden" id="edit-fav-id">
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Icono</label>
                    <div class="relative">
                        <button type="button" id="edit-emoji-btn" data-icon="location"
                            class="w-14 h-14 bg-gray-50 border-2 border-gray-200 rounded-xl flex items-center justify-center hover:border-blue-400 transition text-blue-600"
                            onclick="toggleEditEmojiPicker()">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                        
                        <div id="edit-emoji-picker" class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-xl p-2 shadow-xl z-20 flex gap-1">
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEditEmoji('home')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEditEmoji('work')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745V20a2 2 0 002 2h14a2 2 0 002-2v-6.745zM16 8V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v3m4 7h4v-2H8v2h4zm0 0V9"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEditEmoji('school')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEditEmoji('location')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                            <button type="button" class="emoji-opt p-2 rounded-lg hover:bg-blue-50 transition flex items-center justify-center text-blue-600" onclick="selectEditEmoji('heart')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-grow">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nombre</label>
                    <input id="edit-input-nombre" type="text"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition text-gray-800 font-medium"
                        maxlength="50">
                </div>
            </div>
        </div>
        <div class="bg-gray-50 rounded-b-2xl border-t border-gray-100 px-6 py-4 flex justify-end gap-3">
            <button onclick="closeEditModal()"
                class="px-5 py-2.5 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition">Cancelar</button>
            <button onclick="updateFavorito()"
                class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-700 transition">Guardar</button>
        </div>
    </div>
</div>

<div id="confirm-modal-overlay"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4"
    onclick="cerrarConfirmModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0"
        id="confirm-modal-content" onclick="event.stopPropagation()">
        <div class="px-6 py-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">¿Eliminar ruta?</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Se eliminará "<span id="confirm-modal-nombre" class="font-medium text-gray-700"></span>"</p>
                </div>
            </div>
            <p class="text-xs text-gray-400">Esta acción no se puede deshacer.</p>
        </div>
        <div class="bg-gray-50 rounded-b-2xl border-t border-gray-100 px-6 py-4 flex justify-end gap-3">
            <button onclick="cerrarConfirmModal()"
                class="px-5 py-2.5 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition">Cancelar</button>
            <button onclick="confirmarEliminar()"
                class="px-5 py-2.5 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition">Eliminar</button>
        </div>
    </div>
</div>

<script>
    // API_BASE viene del header (global)
    const USER_ID = <?php echo json_encode($_SESSION['user_id']); ?>;
    let routesData = null;
    let segmentCount = 0;
    let editingId = null;
    let alertasData = [];
    let alertasByFavId = {};
    let pendingDeleteId = null;
    let currentMode = 'planificador';
    let segmentosPlanificados = [];

    let globalStops = [];
    async function loadRoutesData() {
        try {
            const [resRoutes, resStops] = await Promise.all([
                fetch(`${API_BASE}/api/routes`),
                fetch(`${API_BASE}/api/stops`)
            ]);
            
            const dataRoutes = await resRoutes.json();
            // Soporta si la API devuelve directamente la lista o el objeto estructurado
            routesData = dataRoutes.routes || (Array.isArray(dataRoutes) ? dataRoutes : []);
            
            if (resStops.ok) {
                const dataStops = await resStops.json();
                // Soporta si la API devuelve directamente la lista de paradas u objeto estructurado
                globalStops = dataStops.stops || (Array.isArray(dataStops) ? dataStops : []);
            }
        } catch (e) {
            console.error('Error cargando rutas o paradas:', e);
            if (!routesData) routesData = [];
            if (!globalStops) globalStops = [];
        }
    }

    async function loadFavoritos() {
        try {
            const res = await fetch(`${API_BASE}/api/favoritos/${USER_ID}`);
            const favoritos = await res.json();
            renderFavoritos(favoritos);
        } catch (e) {
            console.error('Error cargando favoritos:', e);
            document.getElementById('favoritos-list').innerHTML =
                '<p class="text-center text-red-400 py-8">Error al cargar tus rutas. ¿Está el servidor activo?</p>';
        }
    }

    function renderFavoritos(favoritos) {
        const list = document.getElementById('favoritos-list');
        const empty = document.getElementById('empty-state');

        if (!favoritos || favoritos.length === 0) {
            list.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        list.innerHTML = favoritos.map(fav => {
            const favAlertas = alertasByFavId[fav.id] || [];
            const hasAlerts = favAlertas.length > 0;
            const borderClass = hasAlerts ? 'border-red-200 ring-1 ring-red-100' : 'border-gray-100';

            const segResumen = fav.segmentos.map((s, i) => {
                const arrow = `<span class="text-gray-300 mx-1">→</span>`;
                const lineaBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold text-white" 
                    style="background-color: ${getLineColor(s.linea_id)}">${s.linea_id}</span>`;
                return `
                    <div class="flex items-center gap-2 text-sm ${i > 0 ? 'mt-2 pt-2 border-t border-gray-100' : ''}">
                        ${lineaBadge}
                        <span class="text-gray-600">${escapeHtml(s.parada_origen_nombre || s.parada_origen_id)}</span>
                        ${arrow}
                        <span class="text-gray-600">${escapeHtml(s.parada_destino_nombre || s.parada_destino_id)}</span>
                    </div>`;
            }).join('');

            const transbordoBadge = fav.segmentos.length > 1
                ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 gap-1">
                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                     ${fav.segmentos.length - 1} transbordo${fav.segmentos.length > 2 ? 's' : ''}
                   </span>`
                : '';

            // Alerta inline para esta ruta
            const alertaInline = hasAlerts ? favAlertas.map(al => {
                const iconHtml = { 
                    info: '<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 
                    averia: '<svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>', 
                    retraso: '<svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 
                    cambio_ruta: '<svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>'
                };
                const tipoBg = { info: 'bg-blue-50 border-blue-200', averia: 'bg-red-50 border-red-200', retraso: 'bg-yellow-50 border-yellow-200', cambio_ruta: 'bg-purple-50 border-purple-200' };
                const icon = iconHtml[al.tipo] || iconHtml.info;
                const bg = tipoBg[al.tipo] || 'bg-gray-50 border-gray-200';
                const lineaTag = al.linea_codigo ? `<span class="text-xs font-bold text-gray-500">Línea ${al.linea_codigo}</span>` : `<span class="text-xs font-bold text-gray-500">Todas las líneas</span>`;
                return `
                <div class="${bg} border rounded-lg p-3 mt-2 flex items-start gap-2">
                    <span class="text-base flex-shrink-0">${icon}</span>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-800">${escapeHtml(al.titulo)}</span>
                            ${lineaTag}
                        </div>
                        <p class="text-xs text-gray-600 mt-0.5 line-clamp-2">${escapeHtml(al.mensaje)}</p>
                    </div>
                </div>`;
            }).join('') : '';

            return `
            <div class="group bg-white rounded-2xl border ${borderClass} shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden" data-id="${fav.id}">
                ${hasAlerts ? `<div class="bg-red-50 px-5 py-1.5 border-b border-red-100 flex items-center gap-2">
                    <svg class="w-3 h-3 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="text-xs font-bold text-red-600">${favAlertas.length} aviso${favAlertas.length > 1 ? 's' : ''} activo${favAlertas.length > 1 ? 's' : ''}</span>
                </div>` : ''}
                <div class="p-5 flex items-start gap-4">
                    <!-- Icono -->
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl ${hasAlerts ? 'bg-gradient-to-br from-red-50 to-amber-50 border-red-200' : 'bg-gradient-to-br from-blue-50 to-teal-50 border-blue-100'} flex items-center justify-center text-blue-600 border group-hover:scale-110 transition-transform duration-300">
                        ${hasAlerts ? '<svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>' : getIconSvg(fav.icono)}
                    </div>

                    <!-- Contenido -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-gray-900 text-lg truncate">${escapeHtml(fav.nombre)}</h3>
                            ${transbordoBadge}
                        </div>
                        <div class="mt-2">
                            ${segResumen}
                        </div>
                        ${alertaInline}
                        <p class="text-xs text-gray-300 mt-3">${formatDate(fav.creada_en)}</p>
                    </div>

                    <!-- Acciones -->
                    <div class="flex-shrink-0 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <button onclick="openEditModal(${fav.id}, '${escapeAttr(fav.nombre)}', '${fav.icono || 'location'}')" title="Editar"
                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button onclick="deleteFavorito(${fav.id}, '${escapeAttr(fav.nombre)}')" title="Eliminar"
                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    // Modal: Crear
    function openModal() {
        segmentCount = 0;
        document.getElementById('segmentos-container').innerHTML = '';
        document.getElementById('input-nombre').value = '';
        document.getElementById('emoji-btn').setAttribute('data-icon', 'location');
        document.getElementById('emoji-btn').innerHTML = getIconSvg('location');
        document.getElementById('modal-title').textContent = 'Nueva Ruta Favorita';
        updateSegCount();

        const planOrigen = document.getElementById('planificar_origen');
        const planDestino = document.getElementById('planificar_destino');

        if (planOrigen && planDestino) {
            let paradasParaPlanificar = [];

            if (typeof globalStops !== 'undefined' && Array.isArray(globalStops) && globalStops.length > 0) {
                paradasParaPlanificar = globalStops;
            } else if (typeof routesData !== 'undefined' && Array.isArray(routesData) && routesData.length > 0) {
                const paradasMapa = new Map();
                routesData.forEach(route => {
                    if (route.stops && Array.isArray(route.stops)) {
                        route.stops.forEach(s => {
                            if (s.id || s.name) {
                                paradasMapa.set(s.id || s.name, s);
                            }
                        });
                    }
                });
                paradasParaPlanificar = Array.from(paradasMapa.values());
            }

            if (paradasParaPlanificar.length > 0) {
                const optionsHtml = '<option value="">Selecciona parada</option>' + 
                    paradasParaPlanificar.map(s => `<option value="${s.id || s.name}">${s.name}</option>`).join('');
                
                planOrigen.innerHTML = optionsHtml;
                planDestino.innerHTML = optionsHtml;
            } else {
                planOrigen.innerHTML = '<option value="">Cargando paradas...</option>';
                planDestino.innerHTML = '<option value="">Cargando paradas...</option>';
            }
        }

        const overlay = document.getElementById('modal-overlay');
        const content = document.getElementById('modal-content');
        overlay.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        addSegmentForm();
        document.getElementById('input-nombre').focus();
    }

   // Algoritmo local blindado contra inconsistencias de tipos (String vs Integer)
function ejecutarPlanificacion() {
    console.log("-> Botón pulsado: Iniciando planificación...");

    const origenSelect = document.getElementById('planificar_origen');
    const destinoSelect = document.getElementById('planificar_destino');
    const contenedor = document.getElementById('contenedor-itinerario');

    if (!origenSelect || !destinoSelect || !contenedor) {
        console.error("❌ Error: No se encuentran los elementos HTML en la página.");
        return;
    }

    const normalizar = (texto) => {
        if (!texto) return '';
        return texto.trim().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    };

    const origenName = normalizar(origenSelect.options[origenSelect.selectedIndex]?.text);
    const destinoName = normalizar(destinoSelect.options[destinoSelect.selectedIndex]?.text);

    console.log("Origen seleccionado:", origenName);
    console.log("Destino seleccionado:", destinoName);

    if (!origenSelect.value || !destinoSelect.value) {
        contenedor.innerHTML = '<p class="text-center text-red-500 py-2 text-xs">Por favor, selecciona origen y destino.</p>';
        contenedor.classList.remove('hidden');
        return;
    }

    if (origenName === destinoName) {
        contenedor.innerHTML = '<div class="text-amber-600 font-medium text-xs p-2 text-center bg-amber-50 rounded-lg">El origen y el destino son la misma parada.</div>';
        contenedor.classList.remove('hidden');
        return;
    }

    // Verificar si los datos de las rutas existen en el mapa
    let lineasDisponibles = [];
    if (typeof routesData !== 'undefined') {
        if (Array.isArray(routesData)) lineasDisponibles = routesData;
        else if (routesData && Array.isArray(routesData.routes)) lineasDisponibles = routesData.routes;
    }

    console.log("Líneas cargadas en memoria del navegador:", lineasDisponibles.length);

    if (lineasDisponibles.length === 0) {
        contenedor.innerHTML = '<div class="text-red-600 text-xs p-2 text-center">Error: No hay datos de líneas cargados en el mapa aún.</div>';
        contenedor.classList.remove('hidden');
        return;
    }

    let segmentoEncontrado = null;

    for (const ruta of lineasDisponibles) {
        const paradasRuta = ruta.stops || ruta.paradas || [];
        const idxOrigen = paradasRuta.findIndex(s => normalizar(s.name || s.nombre) === origenName);
        const idxDestino = paradasRuta.findIndex(s => normalizar(s.name || s.nombre) === destinoName);

        if (idxOrigen !== -1 && idxDestino !== -1) {
            segmentoEncontrado = {
                linea_id: ruta.id,
                linea_codigo: ruta.name || ("Línea " + ruta.id),
                origen_id: origenSelect.value,
                destino_id: destinoSelect.value,
                origen_nombre: paradasRuta[idxOrigen].name || paradasRuta[idxOrigen].nombre,
                destino_nombre: paradasRuta[idxDestino].name || paradasRuta[idxDestino].nombre
            };
            break;
        }
    }

    contenedor.innerHTML = '';
    contenedor.classList.remove('hidden');

    if (segmentoEncontrado) {
        console.log("¡Línea directa encontrada!", segmentoEncontrado);
        if (typeof segmentosPlanificados === 'undefined') window.segmentosPlanificados = [];
        window.segmentosPlanificados = [segmentoEncontrado];

        contenedor.innerHTML = `
            <div class="p-3 bg-green-50 rounded-xl border border-green-100 flex flex-col gap-1 text-left">
                <p class="font-bold text-sm text-green-800 flex items-center gap-1.5">¡Línea directa encontrada!</p>
                <p class="text-xs text-gray-700 mt-1">Puedes realizar este trayecto completo a bordo de la <strong class="text-blue-600">${segmentoEncontrado.linea_codigo}</strong>.</p>
            </div>`;
    } else {
        console.log("Trayecto directo no disponible.");
        if (typeof segmentosPlanificados === 'undefined') window.segmentosPlanificados = [];
        window.segmentosPlanificados = [];
        contenedor.innerHTML = `
            <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 text-center">
                <p class="font-semibold text-sm text-amber-800">Sin coincidencia directa</p>
                <p class="text-xs text-gray-600 mt-1">No existe una línea única directa en este sentido. Cambia a la pestaña de <strong class="underline cursor-pointer font-bold text-blue-600" onclick="conmutarModoRuta('manual')">Modo Manual</strong> para configurar tramos con transbordo.</p>
            </div>`;
    }
}
    function openModal() {
        segmentCount = 0;
        document.getElementById('segmentos-container').innerHTML = '';
        document.getElementById('input-nombre').value = '';
        document.getElementById('emoji-btn').setAttribute('data-icon', 'location');
        document.getElementById('emoji-btn').innerHTML = getIconSvg('location');
        document.getElementById('modal-title').textContent = 'Nueva Ruta Favorita';
        updateSegCount();

        const planOrigen = document.getElementById('planificar_origen');
        const planDestino = document.getElementById('planificar_destino');

        if (planOrigen && planDestino && typeof globalStops !== 'undefined' && globalStops.length > 0) {
            const optionsHtml = '<option value="">Selecciona parada</option>' + 
                globalStops.map(s => `<option value="${s.id || s.name}">${s.name}</option>`).join('');
            
            planOrigen.innerHTML = optionsHtml;
            planDestino.innerHTML = optionsHtml;
        }

        const overlay = document.getElementById('modal-overlay');
        const content = document.getElementById('modal-content');
        overlay.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        addSegmentForm();
        document.getElementById('input-nombre').focus();
    }

    function closeModal(e) {
        if (e && e.target !== e.currentTarget) return;
        const overlay = document.getElementById('modal-overlay');
        const content = document.getElementById('modal-content');
        if(content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            if(overlay) overlay.classList.add('hidden');
        }, 200);
    }

    function closeEditModal(e) {
        if (e && e.target !== e.currentTarget) return;
        const overlay = document.getElementById('edit-modal-overlay');
        const content = document.getElementById('edit-modal-content');
        if(content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            if(overlay) overlay.classList.add('hidden');
        }, 200);
    }

    function conmutarModoRuta(modo) {
        const tabPlanificador = document.getElementById('tab-planificador');
        const tabManual = document.getElementById('tab-manual');
        const seccionPlanificador = document.getElementById('seccion-planificador');
        const seccionManual = document.getElementById('seccion-manual');

        if (modo === 'planificador') {
            tabPlanificador.classList.add('border-blue-500', 'text-blue-600');
            tabPlanificador.classList.remove('border-transparent', 'text-gray-500');
            tabManual.classList.remove('border-blue-500', 'text-blue-600');
            tabManual.classList.add('border-transparent', 'text-gray-500');
            
            seccionPlanificador.classList.remove('hidden');
            seccionManual.classList.add('hidden');
        } else {
            tabManual.classList.add('border-blue-500', 'text-blue-600');
            tabManual.classList.remove('border-transparent', 'text-gray-500');
            tabPlanificador.classList.remove('border-blue-500', 'text-blue-600');
            tabPlanificador.classList.add('border-transparent', 'text-gray-500');
            
            seccionManual.classList.remove('hidden');
            seccionPlanificador.classList.add('hidden');
        }
    }

    // Segmentos dinámicos
    function addSegmentForm() {
    segmentCount++;
    updateSegCount();

    const container = document.getElementById('segmentos-container');
    const div = document.createElement('div');
    div.className = 'segment-item bg-gray-50 rounded-xl p-4 border border-gray-200 relative animate-fadeIn';
    div.setAttribute('data-seg-index', segmentCount);

    const routeOptions = routesData
        ? routesData.map(r => `<option value="${r.id}">${r.name || r.id}</option>`).join('')
        : '<option value="">Cargando...</option>';

    div.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">Segmento ${segmentCount}</span>
            ${segmentCount > 1 ? `
            <button onclick="removeSegment(this)" class="text-gray-300 hover:text-red-500 transition p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            ` : ''}
        </div>

        <div class="mb-3">
            <label class="block text-xs font-medium text-gray-500 mb-1">Línea</label>
            <select class="seg-linea w-full px-3 py-2.5 bg-white border-2 border-gray-200 rounded-lg focus:border-blue-400 outline-none transition text-sm font-medium" onchange="onLineaChange(this)">
                <option value="">Selecciona línea</option>
                ${routeOptions}
            </select>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Parada origen
                </label>
                <select class="seg-origen w-full px-3 py-2.5 bg-white border-2 border-gray-200 rounded-lg focus:border-blue-400 outline-none transition text-sm" disabled>
                    <option value="">Selecciona línea primero</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    Parada destino
                </label>
                <select class="seg-destino w-full px-3 py-2.5 bg-white border-2 border-gray-200 rounded-lg focus:border-blue-400 outline-none transition text-sm" disabled>
                    <option value="">Selecciona línea primero</option>
                </select>
            </div>
        </div>
    `;

    container.appendChild(div);
}

    function removeSegment(btn) {
        const segDiv = btn.closest('.segment-item');
        segDiv.remove();
        segmentCount--;
        updateSegCount();
        // Re-number remaining segments
        document.querySelectorAll('.segment-item').forEach((s, i) => {
            s.querySelector('.text-blue-600').textContent = `Segmento ${i + 1}`;
        });
    }

    function updateSegCount() {
        const el = document.getElementById('seg-count');
        if (el) el.textContent = `${segmentCount} segmento${segmentCount !== 1 ? 's' : ''}`;
    }

    // Al cambiar línea, poblar paradas
    function onLineaChange(select) {
        const segDiv = select.closest('.segment-item');
        const lineaId = select.value;
        const origenSelect = segDiv.querySelector('.seg-origen');
        const destinoSelect = segDiv.querySelector('.seg-destino');

        if (!lineaId || !routesData) {
            origenSelect.innerHTML = '<option value="">Selecciona línea primero</option>';
            destinoSelect.innerHTML = '<option value="">Selecciona línea primero</option>';
            origenSelect.disabled = true;
            destinoSelect.disabled = true;
            return;
        }

        const route = routesData.find(r => r.id === lineaId);
        if (!route) {
            origenSelect.innerHTML = '<option value="">Sin paradas</option>';
            destinoSelect.innerHTML = '<option value="">Sin paradas</option>';
            return;
        }

        // Si la ruta dinámica trae sus propias paradas, usar esas, si no usar el catálogo global
        const paradasParaMostrar = (route.stops && route.stops.length > 0) ? route.stops : globalStops;

        if (!paradasParaMostrar || paradasParaMostrar.length === 0) {
            origenSelect.innerHTML = '<option value="">Sin paradas disponibles</option>';
            destinoSelect.innerHTML = '<option value="">Sin paradas disponibles</option>';
            return;
        }

        const options = paradasParaMostrar.map(s =>
            `<option value="${s.id || s.name}" data-name="${escapeAttr(s.name)}">${s.name}</option>`
        ).join('');

        origenSelect.innerHTML = '<option value="">Selecciona parada</option>' + options;
        destinoSelect.innerHTML = '<option value="">Selecciona parada</option>' + options;
        origenSelect.disabled = false;
        destinoSelect.disabled = false;
    }

    // Guardar
    async function saveFavorito() {
        const nombre = document.getElementById('input-nombre').value.trim();
        const icono = document.getElementById('emoji-btn').getAttribute('data-icon') || 'location';

        if (!nombre) {
            showToast('Escribe un nombre para tu ruta', 'error');
            document.getElementById('input-nombre').focus();
            return;
        }

        let segmentos = [];

        if (currentMode === 'planificador') {
            if (segmentosPlanificados.length === 0) {
                showToast('Calcula una ruta antes de guardar', 'error');
                return;
            }
            segmentos = segmentosPlanificados;
        } else {
            const segElements = document.querySelectorAll('.segment-item');
            if (segElements.length === 0) {
                showToast('Añade al menos un segmento', 'error');
                return;
            }

            let valid = true;
            segElements.forEach((seg, i) => {
                const linea = seg.querySelector('.seg-linea').value;
                const origenSelect = seg.querySelector('.seg-origen');
                const destinoSelect = seg.querySelector('.seg-destino');
                const origen = origenSelect.value;
                const destino = destinoSelect.value;

                if (!linea || !origen || !destino) {
                    valid = false;
                    return;
                }

                if (origen === destino) {
                    valid = false;
                    showToast(`Segmento ${i + 1}: origen y destino no pueden ser iguales`, 'error');
                    return;
                }

                segmentos.push({
                    orden: i + 1,
                    linea_id: linea,
                    parada_origen_id: origen,
                    parada_destino_id: destino,
                    parada_origen_nombre: origenSelect.options[origenSelect.selectedIndex].text,
                    parada_destino_nombre: destinoSelect.options[destinoSelect.selectedIndex].text
                });
            });

            if (!valid || segmentos.length === 0) {
                showToast('Completa todos los campos de cada segmento', 'error');
                return;
            }
        }

        const btn = document.getElementById('btn-save');
        btn.disabled = true;
        btn.textContent = 'Guardando...';

        try {
            const res = await fetch(`${API_BASE}/api/favoritos`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    user_id: USER_ID,
                    nombre: nombre,
                    icono: icono,
                    segmentos: segmentos
                })
            });

            const data = await res.json();
            if (res.ok) {
                showToast('Ruta guardada correctamente', 'success');
                closeModal();
                loadFavoritos();
            } else {
                showToast(data.error || 'Error al guardar', 'error');
            }
        } catch (e) {
            showToast('Error de conexion con el servidor', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Guardar Ruta';
        }
    }

    // Editar
    function openEditModal(id, nombre, icono) {
        document.getElementById('edit-fav-id').value = id;
        document.getElementById('edit-input-nombre').value = nombre;
        document.getElementById('edit-emoji-btn').setAttribute('data-icon', icono);
        document.getElementById('edit-emoji-btn').innerHTML = getIconSvg(icono);

        const overlay = document.getElementById('edit-modal-overlay');
        const content = document.getElementById('edit-modal-content');
        overlay.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeEditModal(e) {
        if (e && e.target !== e.currentTarget) return;
        const overlay = document.getElementById('edit-modal-overlay');
        const content = document.getElementById('edit-modal-content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 200);
    }

    async function updateFavorito() {
        const id = document.getElementById('edit-fav-id').value;
        const nombre = document.getElementById('edit-input-nombre').value.trim();
        const icono = document.getElementById('edit-emoji-btn').getAttribute('data-icon') || 'location';

        if (!nombre) {
            showToast('El nombre es obligatorio', 'error');
            return;
        }

        try {
            const res = await fetch(`${API_BASE}/api/favoritos/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, icono })
            });
            if (res.ok) {
                showToast('Ruta actualizada', 'success');
                closeEditModal();
                loadFavoritos();
            } else {
                const data = await res.json();
                showToast(data.error || 'Error al actualizar', 'error');
            }
        } catch (e) {
            showToast('Error de conexión', 'error');
        }
    }

    // Abrir modal de confirmacion antes de eliminar
    function deleteFavorito(id, nombre) {
        pendingDeleteId = id;
        document.getElementById('confirm-modal-nombre').textContent = nombre;
        const overlay = document.getElementById('confirm-modal-overlay');
        const content = document.getElementById('confirm-modal-content');
        overlay.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function cerrarConfirmModal(e) {
        if (e && e.target !== e.currentTarget) return;
        pendingDeleteId = null;
        const overlay = document.getElementById('confirm-modal-overlay');
        const content = document.getElementById('confirm-modal-content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 200);
    }

    async function confirmarEliminar() {
        if (!pendingDeleteId) return;
        const id = pendingDeleteId;
        cerrarConfirmModal();
        try {
            const res = await fetch(`${API_BASE}/api/favoritos/${id}`, { method: 'DELETE' });
            if (res.ok) {
                showToast('Ruta eliminada', 'success');
                loadFavoritos();
            } else {
                showToast('Error al eliminar', 'error');
            }
        } catch (e) {
            showToast('Error de conexión', 'error');
        }
    }

    // Emoji Pickers
    function toggleEmojiPicker() {
        document.getElementById('emoji-picker').classList.toggle('hidden');
    }
    function selectEmoji(iconName) {
        const btn = document.getElementById('emoji-btn');
        if (btn) {
            btn.setAttribute('data-icon', iconName);
            btn.innerHTML = getIconSvg(iconName);
        }
        
        const picker = document.getElementById('emoji-picker');
        if (picker) {
            picker.classList.add('hidden');
        }
    }

    function selectEditEmoji(iconName) {
        const btn = document.getElementById('edit-emoji-btn');
        if (btn) {
            btn.setAttribute('data-icon', iconName);
            btn.innerHTML = getIconSvg(iconName);
        }
        
        const picker = document.getElementById('edit-emoji-picker');
        if (picker) {
            picker.classList.add('hidden');
        }
    }
    function toggleEditEmojiPicker() {
        document.getElementById('edit-emoji-picker').classList.toggle('hidden');
    }

    // Iconos SVG para los pickers - se usan en el HTML y cuando se carga un favorito existente
    function getIconSvg(name) {
        const icons = {
            home: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
            work: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745V20a2 2 0 002 2h14a2 2 0 002-2v-6.745zM16 8V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v3m4 7h4v-2H8v2h4zm0 0V9"></path></svg>',
            school: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>',
            location: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
            heart: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>'
        };
        // Por si falla lo otro
        if (name === '🏠') return icons.home;
        if (name === '💼') return icons.work;
        if (name === '🏫') return icons.school;
        if (name === '📍') return icons.location;
        if (name === '❤️') return icons.heart;
        
        return icons[name] || icons.location;
    }

    function getLineColor(lineaId) {
        const colors = {
            'L1': '#3B82F6', 'L2': '#EF4444', 'L3': '#10B981', 'L4': '#F59E0B',
            'L5': '#8B5CF6', 'L6': '#EC4899', 'L7': '#06B6D4', 'L8': '#F97316'
        };
        return colors[lineaId] || '#6B7280';
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function escapeAttr(text) {
        if (!text) return '';
        return text.replace(/'/g, "\\'").replace(/"/g, '&quot;');
    }

    function formatDate(dateStr) {
        try {
            const d = new Date(dateStr);
            return d.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
        } catch (e) {
            return dateStr;
        }
    }

    // Mostrar notificacion
    function showToast(msg, type) {
        if (!type) type = 'info';
        var icons = {
            success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
            error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
            info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };

        var toast = document.createElement('div');
        toast.className = 'toast-notif toast-notif--' + type;
        toast.innerHTML = '<span class="flex-shrink-0">' + icons[type] + '</span> ' + escapeHtml(msg);
        document.body.appendChild(toast);

        setTimeout(function() {
            toast.classList.add('show');
        }, 10);

        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    }

    // Cargar alertas
    async function loadAlertas() {
        try {
            var res = await fetch(API_BASE + '/api/favoritos/' + USER_ID + '/alertas');
            var data = await res.json();
            alertasData = data.alertas || [];

            alertasByFavId = {};
            for (var i = 0; i < alertasData.length; i++) {
                var a = alertasData[i];
                if (!alertasByFavId[a.favorito_id]) {
                    alertasByFavId[a.favorito_id] = [];
                }
                
                var duplicado = false;
                for (var j = 0; j < alertasByFavId[a.favorito_id].length; j++) {
                    if (alertasByFavId[a.favorito_id][j].aviso_id === a.aviso_id) duplicado = true;
                }
                
                if (!duplicado) {
                    alertasByFavId[a.favorito_id].push(a);
                }
            }

            var banner = document.getElementById('alertas-banner');
            if (alertasData.length > 0) {
                var favAfectados = data.favoritos_afectados || 0;
                var pluralAviso = alertasData.length > 1 ? 's' : '';
                var pluralAfecta = alertasData.length > 1 ? 'n' : '';
                document.getElementById('alertas-summary').textContent =
                    alertasData.length + " aviso" + pluralAviso + " afecta" + pluralAfecta + " a " + favAfectados + " de tus rutas guardadas";

                var uniqueAvisos = [];
                var seenIds = new Set();
                for (var k = 0; k < alertasData.length; k++) {
                    var aviso = alertasData[k];
                    if (!seenIds.has(aviso.aviso_id)) {
                        seenIds.add(aviso.aviso_id);
                        uniqueAvisos.push(aviso);
                    }
                }

                var tipoIcons = { 
                    info: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 
                    averia: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>', 
                    retraso: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 
                    cambio_ruta: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>' 
                };
                
                var htmlList = "";
                for (var m = 0; m < uniqueAvisos.length; m++) {
                    var uv = uniqueAvisos[m];
                    var icon = tipoIcons[uv.tipo] || tipoIcons.info;
                    var lineaTag = uv.linea_codigo
                        ? '<span class="text-xs bg-white px-1.5 py-0.5 rounded font-bold text-gray-600">' + uv.linea_codigo + '</span>'
                        : '<span class="text-xs bg-white px-1.5 py-0.5 rounded font-bold text-gray-600">General</span>';
                    
                    htmlList += '<div class="flex items-center gap-2 text-xs text-red-700">' +
                        '<span>' + icon + '</span>' +
                        '<span class="font-semibold">' + escapeHtml(uv.titulo) + '</span>' +
                        lineaTag +
                    '</div>';
                }
                document.getElementById('alertas-detail-list').innerHTML = htmlList;

                banner.classList.remove('hidden');
            } else {
                banner.classList.add('hidden');
            }
        } catch (e) {
            console.log('Error alertas: ' + e);
            alertasData = [];
            alertasByFavId = {};
        }
    }

    // Arrancar
    (async function init() {
        await loadRoutesData();
        await loadAlertas();
        loadFavoritos();
    })();
</script>
