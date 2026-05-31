import time
import requests
import json
import os
import random
from datetime import datetime

BACKEND = "http://localhost:5000/api/gps"
RECORD_TRIP_URL = "http://localhost:5000/api/record_trip"

def load_routes():
    try:
        base_dir = os.path.dirname(os.path.abspath(__file__))
        path = os.path.join(base_dir, "routes_data.json")
        with open(path, "r", encoding="utf-8") as f:
            data = json.load(f)
            return data["routes"]
    except Exception as e:
        print(f"Error loading routes from {path}: {e}")
        return []

routes = load_routes()
print(f"Loaded {len(routes)} routes.")

buses = []
for r in routes:
    buses.append({
        "id": f"BUS_{r['id']}",
        "route_id": r['id'],
        "path": r['path'],
        "index": 0,
        "direction": 1,
        "start_time": datetime.now(),
        "trip_active": True
    })

if not buses:
    buses.append({
        "id": "BUS_TEST",
        "route_id": "L1",
        "path": [[35.8889, -5.3213], [35.8900, -5.3185]],
        "index": 0,
        "direction": 1,
        "start_time": datetime.now(),
        "trip_active": True
    })

print("Starting simulation with data generation...")

traffic_factor = 1.0 

while True:
    if random.random() < 0.05:
        traffic_factor = random.uniform(0.8, 1.5)

    for bus in buses:
        path = bus["path"]
        idx = bus["index"]
        current_pos = path[idx]

        data = {
            "id": bus["id"],
            "lat": current_pos[0],
            "lon": current_pos[1],
            "route_id": bus["route_id"]
        }

        try:
            requests.post(BACKEND, json=data)
        except Exception as e:
            pass

        next_idx = idx + bus["direction"]
        
        if next_idx >= len(path) or next_idx < 0:
            end_time = datetime.now()
            start_time = bus["start_time"]
            duration = (end_time - start_time).total_seconds()
            
            if duration > 5:
                try:
                    trip_data = {
                        "route_id": bus["route_id"],
                        "start_time": start_time.strftime('%Y-%m-%d %H:%M:%S'),
                        "end_time": end_time.strftime('%Y-%m-%d %H:%M:%S'),
                        "duration": int(duration)
                    }
                    requests.post(RECORD_TRIP_URL, json=trip_data)
                    print(f"Trip recorded: {bus['id']} Duration: {int(duration)}s (Route: {bus['route_id']})")
                except Exception as e:
                    print(f"Failed to record trip: {e}")
            
            if next_idx >= len(path):
                bus["direction"] = -1
                next_idx = len(path) - 2
            else:
                bus["direction"] = 1
                next_idx = 1
            
            bus["start_time"] = datetime.now()

        bus["index"] = next_idx

    sleep_time = 1.0 * traffic_factor
    time.sleep(sleep_time)
