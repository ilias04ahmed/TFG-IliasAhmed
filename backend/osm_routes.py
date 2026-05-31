import requests
import json
import psycopg2
import os

def limpiar_nombre_ruta(nombre):
    prefijos = [
        "Plaza de la Constitución - ",
        "Plaza Constitución - ",
        "Plaza de la Constitucion - ",
        "Plaza de la Constitucion-",
        "Pza. Constitución - ",
        "Pza Constitución - ",
    ]
    for prefijo in prefijos:
        if nombre.startswith(prefijo):
            return nombre[len(prefijo):]
            
    sufijos = [
        " - Plaza de la Constitución",
        "- Plaza de la Constitución",
        " - Plaza de la Constitucion",
        "- Plaza de la Constitucion",
    ]
    for sufijo in sufijos:
        if nombre.endswith(sufijo):
            return nombre[:len(nombre) - len(sufijo)]
    return nombre

def fetch_routes():
    overpass_urls = [
        "https://overpass-api.de/api/interpreter",
        "https://overpass.kumi.systems/api/interpreter",
        "https://lz4.overpass-api.de/api/interpreter",
        "https://overpass.osm.ch/api/interpreter"
    ]
    
    overpass_query = """
    [out:json][timeout:25];
    relation["route"="bus"](35.86,-5.40,35.91,-5.28);
    out geom;
    """
    
    headers = {
        'User-Agent': 'CeutaBusTracker/1.0'
    }
    
    data = None
    
    for url in overpass_urls:
        print("Intentando conectar con servidor OSM (Rutas): " + url)
        try:
            response = requests.post(url, data={'data': overpass_query}, headers=headers, timeout=15)
            if response.status_code == 200:
                data = response.json()
                print("Rutas obtenidas correctamente de " + url)
                try:
                    with open('routes_data.json', 'w', encoding='utf-8') as f:
                        json.dump(data, f, ensure_ascii=False, indent=4)
                    print("Backup local 'routes_data.json' actualizado.")
                except Exception as save_err:
                    print("No se pudo actualizar el backup local: " + str(save_err))
                break
        except Exception as e:
            print("Error en este servidor, probando el siguiente... Motivo: " + str(e))
            
    if data is None:
        print("Todos los servidores de rutas han fallado. Buscando backup local...")
        if os.path.exists('routes_data.json'):
            try:
                with open('routes_data.json', 'r', encoding='utf-8') as f:
                    data = json.load(f)
                print("Cargado archivo de respaldo local de rutas correctamente.")
            except Exception as json_err:
                print("Error al leer el archivo local de rutas: " + str(json_err))
                return []
        else:
            print("No existe el archivo routes_data.json.")
            return []

    routes = []
    elements = data.get('elements', [])
    for element in elements:
        if element.get('type') == 'relation':
            tags = element.get('tags', {})
            name = tags.get('name', tags.get('description', 'Ruta sin nombre'))
            name = limpiar_nombre_ruta(name)
            ref = tags.get('ref', '??')
            color = tags.get('color', None)
            
            segments = []
            members = element.get('members', [])
            for member in members:
                if member.get('type') == 'way' and 'geometry' in member:
                    segment = []
                    for pt in member['geometry']:
                        segment.append({'lat': pt['lat'], 'lon': pt['lon']})
                    if len(segment) > 0:
                        segments.append(segment)
            
            if len(segments) > 0:
                route_info = {
                    'osm_id': element.get('id'),
                    'name': name,
                    'ref': ref,
                    'color': color,
                    'geometry': segments
                }
                routes.append(route_info)
            
    print("Total de lineas procesadas: " + str(len(routes)))
    return routes

def insert_into_db(routes):
    conn = None
    cursor = None
    try:
        conn = psycopg2.connect(
            host=os.getenv("DATABASE_HOST", "localhost"),
            database=os.getenv("DATABASE_NAME", "gpsdb"),
            user=os.getenv("DATABASE_USER", "postgres"),
            password=os.getenv("DATABASE_PASSWORD", "postgres"),
            client_encoding='UTF8'
        )
        cursor = conn.cursor()
        
        print("Conectado a la BD. Sincronizando rutas...")
        
        cursor.execute("""
            CREATE TABLE IF NOT EXISTS rutas_estaticas (
                id SERIAL PRIMARY KEY,
                osm_id BIGINT UNIQUE,
                nombre VARCHAR(100),
                ref VARCHAR(10),
                color VARCHAR(7),
                geometria JSONB
            );
        """)

        cursor.execute("TRUNCATE TABLE rutas_estaticas RESTART IDENTITY;")
        
        inserted = 0
        for route in routes:
            try:
                cursor.execute(
                    """INSERT INTO rutas_estaticas (osm_id, nombre, ref, color, geometria) 
                       VALUES (%s, %s, %s, %s, %s)""",
                    (route['osm_id'], route['name'], route['ref'], route['color'], json.dumps(route['geometry']))
                )
                inserted += 1
            except Exception as e:
                print("Error insertando la ruta " + str(route['ref']) + ": " + str(e))
            
        conn.commit()
        print("Se han insertado " + str(inserted) + " rutas correctamente.")
        
    except Exception as e:
        print("Error de base de datos: " + str(e))
        if conn:
            conn.rollback()
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == "__main__":
    routes = fetch_routes()
    if len(routes) > 0:
        insert_into_db(routes)
    else:
        print("No se encontraron rutas para insertar.")