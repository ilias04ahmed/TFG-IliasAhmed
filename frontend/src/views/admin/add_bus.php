<div class="container mx-auto py-8">
    <div class="bg-white border rounded-lg max-w-xl mx-auto shadow-sm">
        
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Añadir Nuevo Autobús</h3>
            <p class="text-xs text-gray-500">Introduce los datos para dar de alta el vehículo en el sistema.</p>
        </div>

        <form action="/admin/bus/store" method="POST" class="p-6">
            
            <div class="mb-4">
                <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                <input type="text" name="matricula" id="matricula"
                    class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 shadow-sm"
                    placeholder="Ej: 1234-KLS" required>
            </div>

            <div class="mb-4">
                <label for="linea" class="block text-sm font-medium text-gray-700 mb-1">Línea Asignada</label>
                <select id="linea" name="linea"
                    class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 bg-white shadow-sm">
                    <option value="1">L1 - P. Constitución / Campus / San Amaro</option>
                    <option value="2">L7 - Frontera del Tarajal / Hospital</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado Inicial</label>
                <select id="estado" name="estado"
                    class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 bg-white shadow-sm">
                    <option value="1">Activo / En Servicio</option>
                    <option value="0">Inactivo / Fuera de Servicio</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 border-t pt-4">
                <a href="/admin" 
                   class="px-4 py-2 text-sm border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-sm">
                    Guardar Autobús
                </button>
            </div>

        </form>
    </div>
</div>