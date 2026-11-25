<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('media_url')) {
    /**
     * Menghasilkan URL lengkap untuk berkas media (mendukung path relatif maupun URL eksternal).
     */
    function media_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        $trimmed = trim($path);
        if (preg_match('#^https?://#i', $trimmed)) {
            return $trimmed;
        }

        return base_url(ltrim($trimmed, '/'));
    }
}

if (! function_exists('safe_external_url')) {
    /**
     * Memastikan tautan eksternal hanya menggunakan skema http:// atau https:// (mencegah javascript: XSS).
     */
    function safe_external_url(?string $url): string
    {
        if (empty($url)) {
            return '';
        }

        $trimmed = trim($url);
        if (preg_match('#^https?://#i', $trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL)) {
            return $trimmed;
        }

        return '';
    }
}

if (! function_exists('sanitize_csv_cell')) {
    /**
     * Mencegah serangan CSV / Formula Injection saat diekspor ke spreadsheet (Excel).
     */
    function sanitize_csv_cell(?string $value): string
    {
        $str = (string) ($value ?? '');
        if ($str !== '' && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $str;
        }

        return $str;
    }
}

if (! function_exists('daftar_prodi_publik')) {
    /**
     * Mengambil daftar program studi dari database dengan cache per-request.
     *
     * @return list<array{id_prodi: int|string, nama_prodi: string}>
     */
    function daftar_prodi_publik(): array
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }

        try {
            $db     = \Config\Database::connect();
            $cached = $db->table('program_studi')
                ->orderBy('id_prodi', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            $cached = [
                ['id_prodi' => 1, 'nama_prodi' => 'Teknologi Rekayasa Multimedia'],
                ['id_prodi' => 2, 'nama_prodi' => 'Desain Grafis'],
                ['id_prodi' => 3, 'nama_prodi' => 'Fotografi'],
                ['id_prodi' => 4, 'nama_prodi' => 'Animasi'],
                ['id_prodi' => 5, 'nama_prodi' => 'Penerbitan'],
            ];
        }

        return $cached;
    }
}
