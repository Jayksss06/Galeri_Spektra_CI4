<?php
$activeSearch   = $filter_search ?? '';
$activeKategori = $filter_kategori ?? '';
$activeSort     = $filter_sort ?? 'terbaru';
$hasActiveFilter = ($activeSearch !== '' || $activeKategori !== '' || $activeSort !== 'terbaru');
?>

<div class="text-center max-w-2xl mx-auto mb-12">
    <p class="text-[11px] font-extrabold text-orange-500 uppercase tracking-widest mb-3">Arsip Digital & Pameran</p>
    <h1 class="text-4xl lg:text-5xl font-extrabold text-indigo-950 tracking-tight leading-tight">Eksplorasi Karya</h1>
    <p class="text-sm text-gray-500 mt-4 leading-relaxed">
        Temukan ragam karya visual dan instalasi terbaik dari mahasiswa Polimedia. Dari desain grafis hingga pameran ruang fisik, setiap karya adalah cerminan inovasi dan kreativitas.
    </p>
</div>

<form action="<?= base_url('galeri') ?>" method="GET" class="bg-white border border-gray-100 rounded-[1.5rem] p-4 lg:p-5 mb-12 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center w-full">

    <div class="relative w-full md:w-1/2 lg:w-5/12">
        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
            </svg>
        </span>
        <input type="text" name="search" value="<?= esc($activeSearch) ?>" placeholder="Cari judul karya, deskripsi, atau kreator..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:bg-white focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all">
    </div>

    <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
        <div class="relative min-w-[180px]">
            <select name="kategori" class="appearance-none w-full bg-gray-50 border border-gray-100 text-gray-600 text-xs font-bold py-3 pl-4 pr-9 rounded-xl focus:outline-none focus:border-indigo-300 transition-all cursor-pointer">
                <option value="">Semua Kategori</option>
                <?php if (! empty($kategori_digital)): ?>
                    <optgroup label="Karya Digital">
                        <?php foreach ($kategori_digital as $kat): ?>
                            <option value="<?= esc($kat) ?>" <?= $activeKategori === $kat ? 'selected' : '' ?>><?= esc($kat) ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endif; ?>
                <?php if (! empty($kategori_fisik)): ?>
                    <optgroup label="Karya Fisik">
                        <?php foreach ($kategori_fisik as $kat): ?>
                            <option value="<?= esc($kat) ?>" <?= $activeKategori === $kat ? 'selected' : '' ?>><?= esc($kat) ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endif; ?>
            </select>
            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <div class="relative min-w-[140px]">
            <select name="sort" class="appearance-none w-full bg-gray-50 border border-gray-100 text-gray-600 text-xs font-bold py-3 pl-4 pr-9 rounded-xl focus:outline-none focus:border-indigo-300 transition-all cursor-pointer">
                <option value="terbaru" <?= $activeSort === 'terbaru' ? 'selected' : '' ?>>Paling Baru</option>
                <option value="terlama" <?= $activeSort === 'terlama' ? 'selected' : '' ?>>Paling Lama</option>
                <option value="populer" <?= $activeSort === 'populer' ? 'selected' : '' ?>>Terpopuler</option>
            </select>
            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <button type="submit" title="Terapkan Filter" class="px-5 py-3 bg-indigo-950 text-white text-xs font-bold rounded-xl hover:bg-indigo-900 transition shadow-sm cursor-pointer shrink-0 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3 6h1.5M3 12h1.5M3 18h1.5" />
            </svg>
            Filter
        </button>

        <?php if ($hasActiveFilter): ?>
            <a href="<?= base_url('galeri') ?>" class="px-4 py-3 bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-bold rounded-xl transition shrink-0">
                Reset
            </a>
        <?php endif; ?>
    </div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if (! empty($daftar_karya)): ?>
        <?php foreach ($daftar_karya as $karya): ?>
            <?php
            $inisial = strtoupper(substr(str_replace(' ', '', (string) $karya['kreator']), 0, 2));
            if (strlen($inisial) < 2) {
                $inisial = 'US';
            }
            $imgUrl    = media_url($karya['file_path']);
            $tglTinjau = ! empty($karya['tanggal_tinjauan']) ? date('d M Y', strtotime($karya['tanggal_tinjauan'])) : date('d M Y', strtotime($karya['tanggal_pengajuan']));
            ?>
            <div class="bg-white p-4 rounded-[1.5rem] border border-gray-100 shadow-sm flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300 cursor-pointer"
                onclick="tampilkanDetailKarya({
                    id: <?= (int) $karya['id_karya'] ?>,
                    judul: '<?= esc($karya['judul_karya'], 'js') ?>',
                    kategori: '<?= esc($karya['tipe_karya'] ?: 'Karya Kreatif', 'js') ?>',
                    jenis: '<?= esc($karya['jenis_karya'] ?? 'DIGITAL', 'js') ?>',
                    kreator: '<?= esc($karya['kreator'], 'js') ?>',
                    prodi: '<?= esc($karya['prodi'] ?? 'Polimedia', 'js') ?>',
                    deskripsi: '<?= esc($karya['deskripsi'], 'js') ?>',
                    gambar: '<?= esc($imgUrl, 'js') ?>',
                    inisial: '<?= esc($inisial, 'js') ?>',
                    dimensi: '<?= esc($karya['dimensi_karya'] ?? '', 'js') ?>',
                    material: '<?= esc($karya['material_media'] ?? '', 'js') ?>',
                    tautan: '<?= esc($karya['tautan_karya'] ?? '', 'js') ?>',
                    views: <?= (int) ($karya['jumlah_dilihat'] ?? 0) ?>
                })">

                <div class="w-full h-52 rounded-2xl mb-4 overflow-hidden relative bg-gray-100">
                    <img src="<?= esc($imgUrl) ?>" alt="<?= esc($karya['judul_karya']) ?>" loading="lazy" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                        <span class="px-4 py-2 bg-white/90 backdrop-blur-sm text-indigo-950 text-[10px] font-bold rounded-lg uppercase tracking-wide">Lihat Detail</span>
                    </div>
                </div>

                <div class="flex flex-col flex-grow px-2 pb-2">
                    <div class="flex justify-between items-center gap-2 mb-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 text-[9px] font-bold rounded-full tracking-wide uppercase truncate max-w-[180px]">
                            <?= esc($karya['tipe_karya'] ?: 'Karya Kreatif') ?>
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium shrink-0">
                            <?= esc($tglTinjau) ?>
                        </span>
                    </div>

                    <h3 class="text-lg font-extrabold text-indigo-950 mt-1 leading-snug">
                        <?= esc($karya['judul_karya']) ?>
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed flex-grow line-clamp-2">
                        <?= esc($karya['deskripsi']) ?>
                    </p>

                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-50">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600 shrink-0">
                                <?= esc($inisial) ?>
                            </div>
                            <span class="text-xs font-bold text-gray-800 truncate"><?= esc($karya['kreator']) ?></span>
                        </div>
                        <span class="text-[10px] text-gray-400 font-semibold flex items-center gap-1 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="card-views-<?= (int) $karya['id_karya'] ?>"><?= (int) ($karya['jumlah_dilihat'] ?? 0) ?></span>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-gray-500 font-semibold mb-2">Tidak ada karya yang sesuai dengan kriteria pencarian.</p>
            <?php if ($hasActiveFilter): ?>
                <a href="<?= base_url('galeri') ?>" class="inline-block mt-2 text-xs font-bold text-indigo-600 hover:underline">Tampilkan seluruh karya</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Paginasi Dinamis CodeIgniter 4 -->
<?php if (isset($pager) && $pager->getPageCount('galeri') > 1): ?>
    <?php
    $currentPage = $pager->getCurrentPage('galeri');
    $totalPages  = $pager->getPageCount('galeri');
    $buildUrl    = static function (int $page) use ($activeSearch, $activeKategori, $activeSort): string {
        $params = array_filter([
            'search'      => $activeSearch !== '' ? $activeSearch : null,
            'kategori'    => $activeKategori !== '' ? $activeKategori : null,
            'sort'        => $activeSort !== 'terbaru' ? $activeSort : null,
            'page_galeri' => $page > 1 ? $page : null,
        ]);

        return base_url('galeri') . (! empty($params) ? '?' . http_build_query($params) : '');
    };
    ?>
    <nav aria-label="Navigasi Halaman Galeri" class="flex items-center justify-center gap-2 mt-12 mb-8">
        <?php if ($currentPage > 1): ?>
            <a href="<?= esc($buildUrl($currentPage - 1)) ?>" class="px-4 py-2.5 bg-white text-indigo-950 border border-gray-200 rounded-xl text-xs font-bold hover:bg-gray-50 transition shadow-sm">
                &larr; Sebelumnya
            </a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <a href="<?= esc($buildUrl($p)) ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-extrabold transition shadow-sm <?= $p === $currentPage ? 'bg-indigo-950 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' ?>">
                <?= $p ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= esc($buildUrl($currentPage + 1)) ?>" class="px-4 py-2.5 bg-white text-indigo-950 border border-gray-200 rounded-xl text-xs font-bold hover:bg-gray-50 transition shadow-sm">
                Berikutnya &rarr;
            </a>
        <?php endif; ?>
    </nav>
<?php endif; ?>

<!-- Modal Detail Karya Galeri -->
<div id="karya-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 lg:p-8 hidden transition-opacity duration-300">
    <div class="bg-white w-full max-w-5xl h-[90vh] md:h-[600px] rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative">

        <button type="button" onclick="tutupDetailKarya()" class="absolute top-4 right-4 md:top-6 md:right-6 z-20 p-2 md:p-3 bg-gray-100 hover:bg-red-500 text-gray-800 hover:text-white rounded-xl md:rounded-2xl transition-all shadow-sm cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full md:w-1/2 h-2/5 md:h-full bg-gray-900 flex items-center justify-center relative overflow-hidden p-4">
            <img id="modal-gambar" src="" alt="Detail Karya" class="max-w-full max-h-full object-contain drop-shadow-2xl">
        </div>

        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col bg-white overflow-y-auto">
            <div class="mt-2 md:mt-0 flex-grow">
                <div class="flex flex-wrap items-center gap-2 mb-4 pr-10">
                    <span id="modal-kategori" class="px-3 py-1 bg-purple-50 border border-purple-100 text-purple-600 text-[10px] font-bold rounded-full tracking-wide uppercase">
                        Kategori
                    </span>
                    <span id="modal-jenis" class="px-3 py-1 bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold rounded-full tracking-wide uppercase">
                        Jenis
                    </span>
                    <span id="modal-views" class="text-[10px] font-semibold text-gray-400 ml-auto">0 dilihat</span>
                </div>

                <h2 id="modal-judul" class="text-2xl md:text-3xl font-extrabold text-indigo-950 mt-2 leading-tight">
                    Judul Karya
                </h2>

                <div class="flex items-center gap-4 mt-6 pt-5 border-t border-gray-100">
                    <div id="modal-inisial-kreator" class="h-10 w-10 md:h-12 md:w-12 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xs md:text-sm font-bold text-indigo-600 shadow-sm shrink-0">
                        ID
                    </div>
                    <div>
                        <p id="modal-nama-kreator" class="text-sm md:text-base font-bold text-indigo-950">Nama Kreator</p>
                        <p id="modal-prodi" class="text-[10px] md:text-[11px] text-gray-500 font-medium mt-0.5 uppercase tracking-wider">Program Studi</p>
                    </div>
                </div>

                <p id="modal-deskripsi" class="text-xs md:text-sm text-gray-600 mt-6 leading-relaxed text-justify pr-2"></p>

                <div id="modal-blok-fisik" class="hidden mt-6 bg-gray-50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-widest border-b border-gray-200 pb-2 mb-3">Spesifikasi Karya Fisik</h4>
                    <p class="text-xs text-gray-600 mb-1.5"><strong class="text-indigo-950">Dimensi:</strong> <span id="modal-dimensi"></span></p>
                    <p class="text-xs text-gray-600"><strong class="text-indigo-950">Material/Media:</strong> <span id="modal-material"></span></p>
                </div>
            </div>

            <div id="modal-blok-digital" class="hidden mt-8 pt-4 border-t border-gray-100">
                <a href="#" id="modal-tautan-link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full px-6 py-4 bg-indigo-950 text-white text-xs font-bold rounded-xl hover:bg-indigo-900 transition shadow-sm cursor-pointer">
                    Akses / Kunjungi Berkas Digital
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none !important;
    }

    .hide-scrollbar {
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    function tampilkanDetailKarya(data) {
        document.getElementById('modal-judul').textContent = data.judul;
        document.getElementById('modal-nama-kreator').textContent = data.kreator;
        document.getElementById('modal-prodi').textContent = data.prodi;
        document.getElementById('modal-deskripsi').textContent = data.deskripsi;
        document.getElementById('modal-gambar').src = data.gambar;
        document.getElementById('modal-kategori').textContent = data.kategori;
        document.getElementById('modal-jenis').textContent = data.jenis;
        document.getElementById('modal-inisial-kreator').textContent = data.inisial;
        document.getElementById('modal-views').textContent = (data.views || 0) + ' dilihat';

        const blokFisik = document.getElementById('modal-blok-fisik');
        const blokDigital = document.getElementById('modal-blok-digital');
        const tautanLink = document.getElementById('modal-tautan-link');

        if (data.jenis === 'FISIK') {
            blokDigital.classList.add('hidden');
            blokFisik.classList.remove('hidden');
            document.getElementById('modal-dimensi').textContent = data.dimensi || '-';
            document.getElementById('modal-material').textContent = data.material || '-';
        } else {
            blokFisik.classList.add('hidden');
            if (data.tautan && /^https?:\/\//i.test(data.tautan.trim())) {
                blokDigital.classList.remove('hidden');
                tautanLink.href = data.tautan.trim();
            } else {
                blokDigital.classList.add('hidden');
            }
        }

        document.getElementById('karya-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        if (typeof catatKunjunganKarya === 'function') {
            catatKunjunganKarya(data.id, 'modal-views');
        }
    }

    function tutupDetailKarya() {
        document.getElementById('karya-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('karya-modal').addEventListener('click', function(e) {
        if (e.target === this) tutupDetailKarya();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupDetailKarya();
    });
</script>
