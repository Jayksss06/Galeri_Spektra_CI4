<div class="text-center max-w-2xl mx-auto mb-12">
    <p class="text-[11px] font-extrabold text-orange-500 uppercase tracking-widest mb-3">Arsip Digital</p>
    <h1 class="text-4xl lg:text-5xl font-extrabold text-indigo-950 tracking-tight leading-tight">Eksplorasi Karya</h1>
    <p class="text-sm text-gray-500 mt-4 leading-relaxed">
        Temukan ragam karya visual terbaik dari mahasiswa Polimedia. Dari desain grafis hingga fotografi, setiap karya adalah cerminan inovasi dan kreativitas.
    </p>
</div>

<form action="<?= base_url('galeri') ?>" method="GET" class="bg-white border border-gray-100 rounded-[1.5rem] p-4 lg:p-5 mb-12 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center w-full">

    <div class="relative w-full md:w-1/2 lg:w-5/12">
        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
            </svg>
        </span>
        <input type="text" name="search" placeholder="Cari judul karya atau kreator..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 font-medium focus:outline-none focus:bg-white focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all">
    </div>

    <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
        <div class="relative min-w-[140px]">
            <select name="kategori" class="appearance-none w-full bg-gray-50 border border-gray-100 text-gray-600 text-xs font-bold py-3 pl-5 pr-10 rounded-xl focus:outline-none focus:border-indigo-300 transition-all cursor-pointer">
                <option value="">Semua Kategori</option>
                <option value="Desain Grafis">Desain Grafis</option>
                <option value="Fotografi">Fotografi</option>
                <option value="Animasi">Animasi</option>
            </select>
            <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <div class="relative min-w-[140px]">
            <select name="sort" class="appearance-none w-full bg-gray-50 border border-gray-100 text-gray-600 text-xs font-bold py-3 pl-5 pr-10 rounded-xl focus:outline-none focus:border-indigo-300 transition-all cursor-pointer">
                <option value="terbaru">Paling Baru</option>
                <option value="terlama">Paling Lama</option>
                <option value="populer">Terpopuler</option>
            </select>
            <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <button type="submit" class="p-3 bg-indigo-950 text-white rounded-xl hover:bg-indigo-900 transition shadow-sm cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3 6h1.5M3 12h1.5M3 18h1.5" />
            </svg>
        </button>
    </div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if (!empty($daftar_karya)): ?>
        <?php foreach ($daftar_karya as $karya): ?>
            <?php
            $inisial = strtoupper(substr(str_replace(' ', '', $karya['kreator']), 0, 2));
            if (strlen($inisial) < 2) $inisial = 'US';
            ?>
            <div class="bg-white p-4 rounded-[1.5rem] border border-gray-100 shadow-sm flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300 cursor-pointer"
                onclick="tampilkanDetailKarya({
                     judul: '<?= esc($karya['judul_karya'], 'js') ?>',
                     kategori: '<?= esc($karya['tipe_karya'], 'js') ?>',
                     jenis: '<?= esc($karya['jenis_karya'] ?? 'DIGITAL', 'js') ?>',
                     kreator: '<?= esc($karya['kreator'], 'js') ?>',
                     prodi: '<?= esc($karya['prodi'] ?? 'Polimedia', 'js') ?>',
                     deskripsi: '<?= esc($karya['deskripsi'], 'js') ?>',
                     gambar: '<?= esc($karya['file_path'], 'js') ?>',
                     inisial: '<?= esc($inisial, 'js') ?>',
                     dimensi: '<?= esc($karya['dimensi_karya'] ?? '', 'js') ?>',
                     material: '<?= esc($karya['material_media'] ?? '', 'js') ?>',
                     tautan: '<?= esc($karya['tautan_karya'] ?? '', 'js') ?>'
                 })">

                <div class="w-full h-52 rounded-2xl mb-4 overflow-hidden relative">
                    <img src="<?= esc($karya['file_path']) ?>" alt="<?= esc($karya['judul_karya']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                        <span class="px-4 py-2 bg-white/90 backdrop-blur-sm text-indigo-950 text-[10px] font-bold rounded-lg uppercase tracking-wide">Lihat Detail</span>
                    </div>
                </div>

                <div class="flex flex-col flex-grow px-2 pb-2">
                    <div class="flex justify-between items-center mb-3">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 text-[9px] font-bold rounded-full tracking-wide uppercase">
                            <?= esc($karya['tipe_karya']) ?>
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium">
                            <?= date('d M Y', strtotime($karya['tanggal_tinjauan'])) ?>
                        </span>
                    </div>

                    <h3 class="text-lg font-extrabold text-indigo-950 mt-1 leading-snug">
                        <?= esc($karya['judul_karya']) ?>
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed flex-grow line-clamp-2">
                        <?= esc(substr($karya['deskripsi'], 0, 100)) ?>...
                    </p>

                    <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-50">
                        <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                            <?= esc($inisial) ?>
                        </div>
                        <span class="text-xs font-bold text-gray-800"><?= esc($karya['kreator']) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="col-span-1 md:col-span-3 text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-gray-400 font-medium">Belum ada karya yang dipublikasikan.</p>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($daftar_karya)): ?>
    <div class="flex justify-center mt-12 mb-8">
        <button onclick="alert('Fungsi paginasi siap disambungkan ke Controller.')" class="px-8 py-3.5 bg-white text-indigo-950 border border-gray-200 rounded-xl text-xs font-bold tracking-tight hover:bg-gray-50 hover:border-gray-300 transition shadow-sm cursor-pointer flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Muat Lebih Banyak
        </button>
    </div>
<?php endif; ?>

<div id="karya-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 lg:p-8 hidden transition-opacity duration-300">
    <div class="bg-white w-full max-w-5xl h-[90vh] md:h-[600px] rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative animate-fade-in">

        <button onclick="tutupDetailKarya()" class="absolute top-4 right-4 md:top-6 md:right-6 z-20 p-2 md:p-3 bg-gray-100 hover:bg-red-500 text-gray-800 hover:text-white rounded-xl md:rounded-2xl transition-all shadow-sm cursor-pointer focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full md:w-1/2 h-2/5 md:h-full bg-gray-900 flex items-center justify-center relative overflow-hidden p-4">
            <img id="modal-gambar" src="" alt="Detail Karya" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent md:hidden pointer-events-none"></div>
        </div>

        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col bg-white overflow-y-auto">
            <div class="mt-2 md:mt-0 flex-grow">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span id="modal-kategori" class="px-3 py-1 bg-purple-50 border border-purple-100 text-purple-600 text-[10px] font-bold rounded-full tracking-wide uppercase">
                        Kategori
                    </span>
                    <span id="modal-jenis" class="px-3 py-1 bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold rounded-full tracking-wide uppercase">
                        Jenis
                    </span>
                </div>

                <h2 id="modal-judul" class="text-2xl md:text-4xl font-extrabold text-indigo-950 mt-2 leading-tight">
                    Judul Karya
                </h2>

                <div class="flex items-center gap-4 mt-6 pt-5 border-t border-gray-100">
                    <div id="modal-inisial-kreator" class="h-10 w-10 md:h-12 md:w-12 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xs md:text-sm font-bold text-indigo-600 shadow-sm">
                        ID
                    </div>
                    <div>
                        <p id="modal-nama-kreator" class="text-sm md:text-base font-bold text-indigo-950">Nama Kreator</p>
                        <p id="modal-prodi" class="text-[10px] md:text-[11px] text-gray-500 font-medium mt-0.5 uppercase tracking-wider">Program Studi</p>
                    </div>
                </div>

                <p id="modal-deskripsi" class="text-xs md:text-sm text-gray-600 mt-6 leading-relaxed text-justify pr-2">
                    Deskripsi lengkap karya akan ditampilkan di sini.
                </p>

                <div id="modal-blok-fisik" class="hidden mt-6 bg-gray-50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-widest border-b border-gray-200 pb-2 mb-3">Spesifikasi Karya Fisik</h4>
                    <p class="text-xs text-gray-600 mb-1.5"><strong class="text-indigo-950">Dimensi:</strong> <span id="modal-dimensi"></span></p>
                    <p class="text-xs text-gray-600"><strong class="text-indigo-950">Material/Media:</strong> <span id="modal-material"></span></p>
                </div>
            </div>

            <div id="modal-blok-digital" class="hidden mt-8 pt-4 border-t border-gray-100">
                <a href="#" id="modal-tautan-link" target="_blank" class="inline-flex items-center justify-center gap-2 w-full px-6 py-4 bg-indigo-950 text-white text-xs font-bold rounded-xl hover:bg-indigo-900 transition shadow-sm cursor-pointer hover:-translate-y-1">
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

            if (data.tautan && data.tautan.trim() !== '') {
                blokDigital.classList.remove('hidden');
                tautanLink.href = data.tautan;
            } else {
                blokDigital.classList.add('hidden');
            }
        }

        document.getElementById('karya-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }

    function tutupDetailKarya() {
        document.getElementById('karya-modal').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }

    document.getElementById('karya-modal').addEventListener('click', function(e) {
        if (e.target === this) tutupDetailKarya();
    });
</script>