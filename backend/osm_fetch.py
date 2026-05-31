import requests
import json
import psycopg2
import os

def fetch_stops():
    overpass_urls = [
        "https://overpass-api.de/api/interpreter",
        "https://overpass.kumi.systems/api/interpreter",
        "https://lz4.overpass-api.de/api/interpreter",
        "https://overpass.osm.ch/api/interpreter"
    ]
    
    overpass_query = """
    [out:json][timeout:25];
    node["highway"="bus_stop"](35.86,-5.40,35.91,-5.28);
    out body;
    """
    
    headers = {
        'User-Agent': 'CeutaBusTracker/1.0'
    }
    
    data = None
    
    for url in overpass_urls:
        print("Intentando conectar con servidor OSM: " + url)
        try:
            response = requests.post(url, data={'data': overpass_query}, headers=headers, timeout=15)
            if response.status_code == 200:
                data = response.json()
                print("Datos obtenidos correctamente de " + url)
                
                try:
                    with open('osm_stops.json', 'w', encoding='utf-8') as f:
                        json.dump(data, f, ensure_ascii=False, indent=4)
                    print("Backup local 'osm_stops.json' actualizado.")
                except Exception as save_err:
                    print("No se pudo actualizar el backup local: " + str(save_err))
                
                break
        except Exception as e:
            print("Error en este servidor, probando el siguiente... Motivo: " + str(e))
            
    if data is None:
        print("Todos los servidores Overpass han fallado. Buscando backup local...")
        if os.path.exists('stops_fallback.json'):
            try:
                with open('stops_fallback.json', 'r', encoding='utf-8') as f:
                    data = json.load(f)
                print("Cargado archivo de respaldo local correctamente.")
            except Exception as json_err:
                print("Error al leer el archivo local: " + str(json_err))
                return []
        else:
            print("No existe el archivo de respaldo local.")
            return []

    stops = []
    elements = data.get('elements', [])
    for element in elements:
        if element.get('type') == 'node':
            tags = element.get('tags', {})
            name = tags.get('name', 'Parada sin nombre')
            
            stop_info = {
                'id': element.get('id'),
                'lat': element.get('lat'),
                'lon': element.get('lon'),
                'name': name
            }
            stops.append(stop_info)
            
    print("Total de paradas procesadas: " + str(len(stops)))
    return stops

def insert_into_db(stops):
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
        
        print("Conectado a la base de datos. Limpiando paradas antiguas...")
        cursor.execute("TRUNCATE TABLE paradas RESTART IDENTITY CASCADE;")
        
        inserted = 0
        for stop in stops:
            try:
                name = stop['name']
                name = name.encode('utf-8', 'ignore').decode('utf-8')
                
                cursor.execute(
                    "INSERT INTO paradas (nombre, lat, lon) VALUES (%s, %s, %s)",
                    (name, stop['lat'], stop['lon'])
                )
                inserted += 1
            except Exception:
                pass
            
        conn.commit()
        print("Se han insertado " + str(inserted) + " paradas correctamente.")
        
    except Exception as e:
        print("Error al insertar los datos en la base de datos: " + str(e))
        if conn:
            conn.rollback()
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == "__main__":
    stops = fetch_stops()
    if len(stops) > 0:
        insert_into_db(stops)
    else:
        print("No se encontraron paradas para insertar.")