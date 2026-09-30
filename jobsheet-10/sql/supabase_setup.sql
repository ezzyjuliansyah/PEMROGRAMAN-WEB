-- Setup database untuk Supabase (jalankan SEKALI di SQL Editor Supabase)
-- Isinya: 01_divisi_anggota.sql + 02_users.sql + tabel sessions + pengaman RLS

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

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas' CHECK (role IN ('admin', 'petugas'))
);

-- Tempat menyimpan session login (kontainer Vercel tidak punya penyimpanan permanen)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT NOT NULL,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_sessions_updated_at ON sessions (updated_at);

-- Tabel di schema public Supabase bisa dibuka lewat API publik Supabase.
-- Aktifkan RLS (tanpa policy) supaya data, termasuk hash password di tabel users,
-- tidak bisa dibaca lewat API tersebut. Aplikasi PHP tetap bisa akses karena
-- konek langsung sebagai role postgres (mengabaikan RLS).
ALTER TABLE divisi   ENABLE ROW LEVEL SECURITY;
ALTER TABLE anggota  ENABLE ROW LEVEL SECURITY;
ALTER TABLE users    ENABLE ROW LEVEL SECURITY;
ALTER TABLE sessions ENABLE ROW LEVEL SECURITY;
