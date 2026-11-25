<?php
$isLoggedIn  = (bool) session()->get('logged_in');
$namaLengkap = $isLoggedIn ? (session('nama_lengkap') ?? 'User') : '';
$roleUser    = $isLoggedIn ? (session('role') === 'admin' ? 'Administrator / Kurator' : 'Mahasiswa') : '';
$inisialAkun = 'US';

if ($isLoggedIn) {
    $inisialAkun = strtoupper(substr(str_replace(' ', '', (string) $namaLengkap), 0, 2));
    if (strlen($inisialAkun) < 2) {
        $inisialAkun = 'US';
    }
}

$linkDasbor = $isLoggedIn
    ? (session('role') === 'admin' ? base_url('dashboard/admin') : base_url('dashboard'))
    : '';

$currentUri     = trim(uri_string(), '/');
$sidebarContext = 'publik';
if (strpos($currentUri, 'dashboard/admin') === 0) {
    $sidebarContext = 'admin';
} elseif (strpos($currentUri, 'dashboard') === 0) {
    $sidebarContext = 'mahasiswa';
}

$hasModalTarget = session()->has('modal_open');
$flashSukses    = session()->getFlashdata('pesan');
$flashError     = ! $hasModalTarget ? session()->getFlashdata('error') : null;
$flashErrors    = ! $hasModalTarget ? session()->getFlashdata('errors') : null;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-header" content="<?= esc(csrf_header()) ?>">
    <meta name="csrf-token" content="<?= esc(csrf_hash()) ?>">
    <title><?= esc($title ?? 'Galeri Spektra Polimedia') ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        input:focus,
        button:focus,
        select:focus,
        textarea:focus {
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen flex text-gray-900 overflow-x-hidden pt-20">

    <header class="fixed top-0 left-0 w-full h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-8 shadow-sm z-50">

        <div class="flex items-center gap-4 lg:gap-6">
            <button type="button" onclick="toggleGlobalSidebar()" aria-label="Buka Navigasi" class="p-2 bg-gray-50 text-indigo-950 rounded-xl hover:bg-gray-100 transition border border-gray-100 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <a href="<?= base_url('/') ?>" class="flex items-center gap-3 cursor-pointer">
                <img src="<?= base_url('assets/img/logo-spektra.png') ?>" alt="Logo Spektra" class="h-10 w-auto object-contain">
            </a>
        </div>

        <div class="flex items-center justify-end min-w-[150px]">
            <?php if ($isLoggedIn): ?>
                <div class="relative">
                    <button type="button" onclick="toggleGlobalProfil()" class="h-9 w-9 rounded-full bg-indigo-50 border border-indigo-200 flex items-center justify-center text-xs font-bold text-indigo-700 uppercase hover:bg-indigo-100 transition cursor-pointer">
                        <?= esc($inisialAkun) ?>
                    </button>
                    <div id="global-profil-dropdown" class="hidden absolute right-0 mt-3 w-52 bg-white border border-gray-100 rounded-xl shadow-xl z-30 p-2 text-xs">
                        <div class="px-4 py-2 border-b border-gray-50 mb-1">
                            <p class="font-bold text-gray-800 truncate"><?= esc($namaLengkap) ?></p>
                            <p class="text-[10px] text-gray-400 mt-0.5"><?= esc($roleUser) ?></p>
                        </div>
                        <a href="<?= $linkDasbor ?>" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Dasbor Saya</a>
                        <a href="<?= base_url('dashboard/profil') ?>" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Profil Akun</a>
                        <form action="<?= base_url('logout') ?>" method="POST" class="mt-1 pt-1 border-t border-gray-50">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-lg transition font-bold cursor-pointer">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <button type="button" onclick="openLoginModal()" class="px-5 py-2.5 bg-indigo-950 text-white text-xs font-bold tracking-wider rounded-xl hover:bg-indigo-900 transition shadow-sm border border-transparent cursor-pointer">
                    LOG IN
                </button>
            <?php endif; ?>
        </div>
    </header>

    <aside id="global-sidebar" class="w-72 bg-[#1C0A35] text-white flex flex-col shadow-2xl z-40 fixed top-20 left-0 h-[calc(100vh-5rem)] transition-transform duration-300 ease-in-out -translate-x-full">

        <?php if ($sidebarContext === 'mahasiswa'): ?>
            <div class="px-8 pt-8 pb-2">
                <h2 class="text-lg font-bold text-white leading-tight">Kurator Digital</h2>
                <p class="text-[10px] text-[#A78BFA] uppercase tracking-wider font-semibold mt-0.5">PANEL MAHASISWA</p>
            </div>
            <nav class="flex-grow px-4 py-4 space-y-1.5 overflow-y-auto">
                <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'dashboard' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                    </svg>
                    Dasbor
                </a>
                <a href="<?= base_url('dashboard/ajukan-karya') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'dashboard/ajukan-karya' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Ajukan Karya
                </a>
                <a href="<?= base_url('dashboard/profil') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'dashboard/profil' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Akun
                </a>

                <div class="my-4 border-t border-[#3E1B73]/40 w-full"></div>
                <a href="<?= base_url('galeri') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-gray-300 hover:text-white hover:bg-white/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Eksplorasi Galeri
                </a>
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </nav>

        <?php elseif ($sidebarContext === 'admin'): ?>
            <div class="px-8 pt-8 pb-2">
                <h2 class="text-lg font-bold text-white leading-tight">Panel Kurator</h2>
                <p class="text-[10px] text-[#A78BFA] uppercase tracking-wider font-semibold mt-0.5">KURATOR DIGITAL</p>
            </div>
            <nav class="flex-grow px-4 py-4 space-y-1.5 overflow-y-auto">
                <a href="<?= base_url('dashboard/admin') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'dashboard/admin' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Tinjau Karya
                </a>

                <a href="<?= base_url('dashboard/profil') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'dashboard/profil' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Akun
                </a>

                <div class="my-4 border-t border-[#3E1B73]/40 w-full"></div>
                <a href="<?= base_url('galeri') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-gray-300 hover:text-white hover:bg-white/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Lihat Galeri Publik
                </a>
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </nav>

        <?php else: ?>
            <div class="px-8 pt-8 pb-2">
                <h2 class="text-lg font-bold text-white leading-tight">Galeri Spektra</h2>
                <p class="text-[10px] text-[#A78BFA] uppercase tracking-wider font-semibold mt-0.5">NAVIGASI PUBLIK</p>
            </div>
            <nav class="flex-grow px-4 py-4 space-y-1.5 overflow-y-auto">
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === '' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <a href="<?= base_url('galeri') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all <?= $currentUri === 'galeri' ? 'bg-[#3E1B73]/60 text-white border border-[#5D24B5]/30' : 'text-[#D8B4FE] hover:bg-[#3E1B73]/40' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A78BFA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Eksplorasi Karya
                </a>

                <?php if ($isLoggedIn): ?>
                    <div class="my-4 border-t border-[#3E1B73]/40 w-full"></div>
                    <a href="<?= $linkDasbor ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-indigo-300 bg-indigo-900/40 hover:bg-indigo-900/60 transition-all border border-indigo-700/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Menuju Dasbor
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

        <div class="p-6 border-t border-[#3E1B73]/40">
            <?php if (! $isLoggedIn): ?>
                <button type="button" onclick="openLoginModal()" class="flex items-center justify-center gap-3 w-full px-4 py-2.5 rounded-xl text-[10px] font-bold text-orange-400 bg-orange-950/30 hover:bg-orange-950/50 transition-all border border-orange-500/15 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Masuk / Daftar
                </button>
            <?php else: ?>
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-9 w-9 rounded-full bg-[#3E1B73] border border-[#5D24B5] flex items-center justify-center text-xs font-bold text-white shadow-md">
                        <?= esc($inisialAkun) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate max-w-[140px]"><?= esc($namaLengkap) ?></p>
                        <p class="text-[10px] text-[#A78BFA] font-medium mt-0.5 tracking-tight truncate max-w-[140px]"><?= esc($roleUser) ?></p>
                    </div>
                </div>
                <form action="<?= base_url('logout') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="flex items-center justify-center gap-3 w-full px-4 py-2.5 rounded-xl text-[10px] font-bold text-orange-400 bg-orange-950/30 hover:bg-orange-950/50 transition-all border border-orange-500/15 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log Out Akun
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </aside>

    <div id="main-wrapper" class="flex-grow flex flex-col min-h-[calc(100vh-5rem)] w-full transition-all duration-300 ml-0">
        <main class="p-6 lg:p-12 max-w-7xl mx-auto w-full flex-grow">

            <?php if (! empty($flashSukses)): ?>
                <div id="global-flash-success" class="mb-8 flex items-center justify-between gap-4 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?= esc($flashSukses) ?></span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (! empty($flashError)): ?>
                <div id="global-flash-error" class="mb-8 flex items-center justify-between gap-4 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span><?= esc($flashError) ?></span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 cursor-pointer">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (! empty($flashErrors) && is_array($flashErrors)): ?>
                <div id="global-flash-errors" class="mb-8 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <strong class="font-extrabold uppercase tracking-wider text-[10px]">Periksa Kembali Masukan Anda:</strong>
                        <button type="button" onclick="this.closest('#global-flash-errors').remove()" class="text-red-500 hover:text-red-700 font-bold cursor-pointer">&times;</button>
                    </div>
                    <ul class="list-disc pl-5 space-y-1 font-medium">
                        <?php foreach ($flashErrors as $errItem): ?>
                            <li><?= esc($errItem) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
