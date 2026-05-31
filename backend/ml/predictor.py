import pandas as pd
# pyrefly: ignore [missing-import]
import joblib
import os
from datetime import datetime

class TravelTimePredictor:
    def __init__(self, db_config):
        self.db_config = db_config
        self.ruta_modelo = os.path.join(os.path.dirname(__file__), 'eta_model.pkl')
        self.modelo = None
        self.columnas_modelo = []
        self.cargar_modelo()

    def cargar_modelo(self):
        if os.path.exists(self.ruta_modelo):
            datos = joblib.load(self.ruta_modelo)
            self.modelo = datos['model']
            self.columnas_modelo = datos['columns']

    def predict_eta(self, route_id, timestamp=None):
        if self.modelo is None:
            return None 
        
        if timestamp is None:
            timestamp = datetime.now()

        hora = timestamp.hour
        dia_semana = timestamp.strftime('%w')
        
        datos_entrada = {}
        for col in self.columnas_modelo:
            datos_entrada[col] = [0]
        
        if 'hour' in datos_entrada: 
            datos_entrada['hour'] = [hora]
        if 'day_of_week' in datos_entrada: 
            datos_entrada['day_of_week'] = [int(dia_semana)]
            
        columna_ruta = f"route_id_{route_id}"
        if columna_ruta in datos_entrada:
            datos_entrada[columna_ruta] = [1]
            
        df_pred = pd.DataFrame(datos_entrada)
        df_pred = df_pred[self.columnas_modelo]

        prediccion = self.modelo.predict(df_pred)[0]
        return int(prediccion)