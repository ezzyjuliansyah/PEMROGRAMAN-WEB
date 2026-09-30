<?php
// Memulai session. Selalu di-include dengan require_once.
//
// Lokal (default)     : session disimpan di file PHP biasa, seperti sebelumnya.
// Vercel (SESSION_DRIVER=db): kontainer Vercel tidak punya penyimpanan permanen dan
// bisa berganti instance tiap request, jadi session disimpan di tabel `sessions`
// di database (Supabase). Tanpa ini, login akan "hilang" di request berikutnya.

require_once __DIR__ . '/db.php';

class DbSessionHandler implements SessionHandlerInterface
{
    private PDO $db;

    public function open(string $path, string $name): bool
    {
        try {
            $this->db = buatKoneksi();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        $stmt = $this->db->prepare('SELECT data FROM sessions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetchColumn();

        return $data === false ? '' : (string) base64_decode($data);
    }

    public function write(string $id, string $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO sessions (id, data, updated_at)
             VALUES (:id, :data, NOW())
             ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, updated_at = NOW()'
        );

        return $stmt->execute(['id' => $id, 'data' => base64_encode($data)]);
    }

    public function destroy(string $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM sessions WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function gc(int $max_lifetime): int|false
    {
        $stmt = $this->db->prepare(
            "DELETE FROM sessions WHERE updated_at < NOW() - (CAST(:detik AS integer) * INTERVAL '1 second')"
        );
        $stmt->execute(['detik' => $max_lifetime]);

        return $stmt->rowCount();
    }
}

if (session_status() === PHP_SESSION_NONE) {
    if (getenv('SESSION_DRIVER') === 'db') {
        session_set_save_handler(new DbSessionHandler(), true);
    }

    ini_set('session.gc_maxlifetime', '7200');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        // Di Vercel isi SESSION_COOKIE_SECURE=1 (situs diakses lewat HTTPS)
        'secure' => getenv('SESSION_COOKIE_SECURE') === '1',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}
