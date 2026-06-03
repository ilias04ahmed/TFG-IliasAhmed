<div class="container mx-auto py-8">
  <div class="bg-white border rounded-lg max-w-xl mx-auto shadow-sm">
    
    <div class="p-4 border-b">
      <h3 class="text-lg font-semibold text-gray-800">Añadir Nuevo Autobús</h3>
      <p class="text-xs text-gray-500">Introduce los datos para dar de alta el vehículo en el sistema.</p>
    </div>

    <form id="form-bus" class="p-6">
      
      <div class="mb-4">
        <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código del Autobús</label>
        <input type="text" id="codigo" class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 shadow-sm" placeholder="Ej: BUS_03" required>
      </div>

      <div class="mb-4">
        <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
        <input type="text" id="matricula" class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 shadow-sm" placeholder="Ej: 1234-KLS" required>
      </div>

      <div class="mb-4">
        <label for="linea" class="block text-sm font-medium text-gray-700 mb-1">Línea Asignada</label>
        <select id="linea" class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 bg-white shadow-sm" required>
          <option value="">Cargando líneas disponibles...</option>
        </select>
      </div>

      <div class="mb-6">
        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado Inicial</label>
        <select id="estado" class="w-full text-sm border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 bg-white shadow-sm">
          <option value="1">Activo / En Servicio</option>
          <option value="0">Inactivo / Fuera de Servicio</option>
        </select>
      </div>

      <div class="flex justify-end space-x-2 border-t pt-4">
        <a href="/admin" class="px-4 py-2 text-sm border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Cancelar</a>
        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-sm">Guardar Autobús</button>
      </div>

    </form>
  </div>
</div>

<script>
    if (typeof window.API_BASE === 'undefined') {
        window.API_BASE = 'https://tfg-backend-api.onrender.com';
    }

    async function cargarLineas() {
        const selectLinea = document.getElementById('linea');
        try {
            const res = await fetch(`${window.API_BASE}/api/routes?_t=${Date.now()}`);
            const data = await res.json();
            const rutas = data.routes || [];
            
            if (rutas.length === 0) {
                selectLinea.innerHTML = '<option value="">No hay líneas disponibles</option>';
                return;
            }

            selectLinea.innerHTML = '<option value="">-- Selecciona una línea --</option>';
            rutas.forEach(r => {
                const idRuta = r.route_id || r.id;
                const nombreRuta = r.name || r.route_long_name || idRuta;
                
                const option = document.createElement('option');
                option.value = idRuta;
                option.textContent = `${idRuta} - ${nombreRuta}`;
                selectLinea.appendChild(option);
            });
        } catch (e) {
            console.error(e);
            selectLinea.innerHTML = '<option value="">Error al cargar las líneas</option>';
        }
    }

    document.getElementById('form-bus').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const codigo = document.getElementById('codigo').value.trim();
        const matricula = document.getElementById('matricula').value.trim();
        const route_id = document.getElementById('linea').value;
        
        try {
            const res = await fetch(`${window.API_BASE}/api/buses`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ codigo, matricula, route_id })
            });
            
            if (res.ok) {
                window.location.href = '/admin';
            } else {
                const errData = await res.json();
                alert('Error: ' + (errData.error || 'No se pudo guardar'));
            }
        } catch (e) {
            console.error(e);
            alert('Error de conexión con la API.');
        }
    });

    document.addEventListener('DOMContentLoaded', cargarLineas);
</script>