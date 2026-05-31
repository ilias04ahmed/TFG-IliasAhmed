<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel de Control</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center">
            <div class="bg-blue-500 rounded-md p-3 text-white mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Autobuses Activos</p>
                <p class="text-3xl font-semibold text-gray-900">5</p>
            </div>
        </div>

        <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center">
            <div class="bg-green-500 rounded-md p-3 text-white mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-1.447-.894L15 7m0 13V7"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Rutas Totales</p>
                <p class="text-3xl font-semibold text-gray-900">2</p>
            </div>
        </div>
        
    </div>

    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="text-lg font-semibold text-gray-800">Gestión de Flota</h3>
            
            <div class="flex flex-wrap gap-2">
                <a href="/admin/horarios" class="bg-white text-gray-700 px-3 py-2 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50 transition flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Gestionar Horarios
                </a>
                <a href="/admin/avisos" class="bg-white text-gray-700 px-3 py-2 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50 transition flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    Gestionar Avisos
                </a>
                <a href="/admin/reportes" class="bg-white text-gray-700 px-3 py-2 border border-gray-300 rounded text-sm font-medium hover:bg-gray-50 transition flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Gestionar Reportes
                </a>
                <a href="/admin/bus/add" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                    Añadir Autobús
                </a>
            </div>
        </div>

        <div class="border-t border-gray-100">
            <ul class="divide-y divide-gray-100">
                
                <li class="px-6 py-4 hover:bg-gray-50 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-600">BUS_01</p>
                        <p class="text-xs text-gray-500 mt-1">Matrícula: 8899-KLS</p>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            En Ruta
                        </span>
                    </div>
                </li>

                <li class="px-6 py-4 hover:bg-gray-50 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-600">BUS_02</p>
                        <p class="text-xs text-gray-500 mt-1">Matrícula: 4321-BBB</p>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            En Ruta
                        </span>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>