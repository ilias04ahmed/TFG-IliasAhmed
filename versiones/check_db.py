import psycopg2
import os

try:
    conn = psycopg2.connect(
        host=os.getenv("DATABASE_HOST", "localhost"),
        database=os.getenv("DATABASE_NAME", "gpsdb"),
        user=os.getenv("DATABASE_USER", "postgres"),
        password=os.getenv("DATABASE_PASSWORD", "postgres")
    )
    cursor = conn.cursor()
    
    cursor.execute("SELECT count(*) FROM trip_history;")
    trips = cursor.fetchone()[0]
    print(f"Total trips recorded: {trips}")
    
    if trips > 0:
        cursor.execute("SELECT * FROM trip_history LIMIT 5;")
        rows = cursor.fetchall()
        for r in rows:
            print(r)
            
    cursor.execute("SELECT count(*) FROM gps_data;")
    gps = cursor.fetchone()[0]
    print(f"Total GPS points: {gps}")
    
    conn.close()
except Exception as e:
    print(f"DB Error: {e}")
