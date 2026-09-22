# 4. Koneksi PDO

File `includes/koneksi.php` membuat objek PDO dengan driver PostgreSQL.

```php
$pdo = new PDO(
    "pgsql:host=$host;port=$port;dbname=$db",
    $user,
    $pass
);
```

Mode error diatur menjadi exception:

```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

Dengan demikian kegagalan koneksi dapat diketahui saat aplikasi dijalankan.
