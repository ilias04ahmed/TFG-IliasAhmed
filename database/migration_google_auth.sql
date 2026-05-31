-- Migración para añadir soporte para login con Google

-- Hacer que el atributo password_hash sea opcional (los usuarios de Google no tienen contraseña)
ALTER TABLE usuarios ALTER COLUMN password_hash DROP NOT NULL;

-- Añadir columna para el email
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS email VARCHAR(100) UNIQUE;

-- Añadir columna para el ID de Google
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS google_id VARCHAR(100) UNIQUE;
