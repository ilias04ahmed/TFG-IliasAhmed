import psycopg2
from psycopg2.extensions import ISOLATION_LEVEL_AUTOCOMMIT
import os

try:
    print("Connecting to postgres database to create gpsdb...")
    conn = psycopg2.connect(
        host='localhost',
        database='postgres',
        user='postgres',
        password='password'
    )
    conn.set_isolation_level(ISOLATION_LEVEL_AUTOCOMMIT)
    cursor = conn.cursor()
    cursor.execute("CREATE DATABASE gpsdb;")
    cursor.close()
    conn.close()
    print("Database gpsdb created!")
except psycopg2.errors.DuplicateDatabase:
    print("Database gpsdb already exists.")
except Exception as e:
    print(f"Error creating db: {repr(e)}")

print("Running init.sql...")
try:
    conn = psycopg2.connect(
        host='localhost',
        database='gpsdb',
        user='postgres',
        password='password'
    )
    cursor = conn.cursor()
    init_sql_path = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), 'database', 'init.sql')
    with open(init_sql_path, 'r', encoding='utf-8') as f:
        sql = f.read()
    cursor.execute(sql)
    conn.commit()
    cursor.close()
    conn.close()
    print("init.sql executed successfully.")
except Exception as e:
    print(f"Error running init.sql: {repr(e)}")
