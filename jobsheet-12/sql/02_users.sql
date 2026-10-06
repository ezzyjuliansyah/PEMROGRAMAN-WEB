-- Jobsheet 10: tabel users untuk autentikasi (register & login)
-- Jalankan di database yang sama dengan Jobsheet 8/9 (esport_championship)

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas' CHECK (role IN ('admin', 'petugas'))
);
