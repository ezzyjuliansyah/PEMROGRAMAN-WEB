<?php
// Fungsi bantu umum (Jobsheet 11).
// e() = escape output untuk mencegah XSS. WAJIB membungkus setiap data dari
// database / $_GET / $_POST yang dicetak ke HTML.
// ENT_QUOTES  : tanda ' dan " ikut di-escape (aman dipakai di dalam atribut value="...")
// ENT_SUBSTITUTE : byte UTF-8 rusak diganti, bukan menghasilkan string kosong

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
