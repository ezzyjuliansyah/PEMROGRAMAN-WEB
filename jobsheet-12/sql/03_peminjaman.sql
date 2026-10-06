-- Jobsheet 12: tabel peminjaman (relasi ke divisi dan anggota)
-- Jalankan di database yang sama dengan Jobsheet 8-10 (esport_championship):
--   psql -p 5433 -U postgres -d esport_championship -f sql/03_peminjaman.sql
--
-- Konsep di project E-Sport: "peminjaman" = player (anggota) dipinjam masuk ke sebuah
-- divisi game. Kolom divisi.roster dipakai sebagai stok slot: bertambah/berkurang
-- tiap peminjaman/pengembalian (setara kolom stok pada buku).

-- Roster boleh 0 (semua slot terpakai). Sebelumnya CHECK (roster >= 1) akan menolak
-- pengurangan terakhir, jadi batasnya diturunkan ke >= 0.
ALTER TABLE divisi DROP CONSTRAINT IF EXISTS divisi_roster_check;
ALTER TABLE divisi ADD CONSTRAINT divisi_roster_check CHECK (roster >= 0);

CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    anggota_id INTEGER NOT NULL REFERENCES anggota(id) ON DELETE RESTRICT,
    divisi_id INTEGER NOT NULL REFERENCES divisi(id) ON DELETE RESTRICT,
    tgl_pinjam TIMESTAMP NOT NULL DEFAULT NOW(),
    tgl_kembali TIMESTAMP,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam' CHECK (status IN ('dipinjam', 'selesai'))
);

CREATE INDEX IF NOT EXISTS idx_peminjaman_status ON peminjaman (status);
CREATE INDEX IF NOT EXISTS idx_peminjaman_anggota ON peminjaman (anggota_id);
