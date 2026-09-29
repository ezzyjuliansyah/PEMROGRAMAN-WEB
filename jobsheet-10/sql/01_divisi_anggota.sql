-- Jobsheet 8: skema PostgreSQL untuk E-Sport Championship
-- Buat database terlebih dahulu, misalnya: esport_championship

CREATE TABLE IF NOT EXISTS divisi (
    id SERIAL PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama_game VARCHAR(100) NOT NULL,
    platform VARCHAR(50) NOT NULL,
    roster INTEGER NOT NULL CHECK (roster >= 1)
);

CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    no_anggota VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL,
    no_hp VARCHAR(20) NOT NULL
);
