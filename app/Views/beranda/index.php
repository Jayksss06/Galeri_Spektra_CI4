<section class="pt-10 pb-20 lg:pt-20 lg:pb-32 overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16 lg:gap-20 w-full px-4 sm:px-6 lg:px-8">

        <div class="lg:w-1/2 pr-0 lg:pr-4 reveal fade-right">
            <p class="text-xs font-extrabold text-[#f97316] uppercase tracking-[0.25em] mb-6">The Digital Curator</p>
            <h1 class="text-6xl lg:text-[5.5rem] font-extrabold text-[#1e1b4b] tracking-tight leading-[1.05] mb-2">
                Wadah Eksplorasi
            </h1>
            <h1 class="text-6xl lg:text-[5.5rem] font-extrabold text-[#c084fc] tracking-tight leading-[1.05] italic mb-2">
                Kreativitas
            </h1>
            <h1 class="text-6xl lg:text-[5.5rem] font-extrabold text-[#1e1b4b] tracking-tight leading-[1.05] mb-8">
                Mahasiswa
            </h1>
            <p class="text-gray-500 text-base lg:text-lg leading-relaxed mb-12 max-w-lg font-medium">
                Menampilkan karya terbaik dari Polimedia. Dari desain grafis yang memikat hingga narasi visual yang mendalam.
            </p>

            <div class="flex flex-wrap items-center gap-5">
                <?php if (!session()->get('logged_in')): ?>
                    <button onclick="switchModal('registerMahasiswaModal')" class="px-10 py-4 bg-[#f97316] text-white text-base font-bold rounded-xl hover:bg-orange-600 transition shadow-xl shadow-orange-500/20 cursor-pointer hover:-translate-y-1">
                        Ajukan Karya
                    </button>
                <?php else: ?>
                    <a href="<?= session('role') === 'admin' ? base_url('dashboard/admin') : base_url('dashboard') ?>" class="px-10 py-4 bg-[#f97316] text-white text-base font-bold rounded-xl hover:bg-orange-600 transition shadow-xl shadow-orange-500/20 hover:-translate-y-1 inline-block">
                        Ke Dasbor Saya
                    </a>
                <?php endif; ?>
                <a href="#tentang" class="px-10 py-4 bg-[#23103A] text-white text-base font-bold rounded-xl hover:bg-indigo-950 transition shadow-xl shadow-indigo-900/20 hover:-translate-y-1 inline-block">
                    Tentang Galeri
                </a>
            </div>
        </div>

        <div class="lg:w-1/2 flex gap-5 h-[500px] lg:h-[650px] w-full reveal fade-left delay-200">
            <div class="w-5/12 flex flex-col gap-5 h-full">
                <div class="flex-[5] w-full rounded-[2rem] overflow-hidden shadow-sm hover:scale-[1.03] transition-transform duration-500">
                    <img src="<?= base_url('assets/img/1.jpg') ?>" alt="Abstract Blob" class="w-full h-full object-cover">
                </div>
                <div class="flex-[3] w-full rounded-[2rem] overflow-hidden shadow-sm hover:scale-[1.03] transition-transform duration-500 bg-gray-100">
                    <img src="<?= base_url('assets/img/2.jpg') ?>" alt="Spheres" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-7/12 flex flex-col gap-5 h-full">
                <div class="flex-[3] w-full rounded-[2rem] overflow-hidden shadow-sm hover:scale-[1.03] transition-transform duration-500 bg-gray-100">
                    <img src="<?= base_url('assets/img/3.jpg') ?>" alt="Lines" class="w-full h-full object-cover">
                </div>
                <div class="flex-[4] w-full rounded-[2rem] overflow-hidden shadow-sm hover:scale-[1.03] transition-transform duration-500 bg-gray-100">
                    <img src="<?= base_url('assets/img/4.jpg') ?>" alt="Architecture" class="w-full h-full object-cover">
                </div>
                <div class="flex-[3] w-full rounded-[2rem] overflow-hidden shadow-sm hover:scale-[1.03] transition-transform duration-500 bg-gray-100">
                    <img src="<?= base_url('assets/img/5.jpg') ?>" alt="Gallery Room" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

    </div>
</section>

<section id="tentang" class="min-h-[calc(100vh-5rem)] flex items-center py-20 lg:py-32 border-t border-gray-200/50 overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pr-0 lg:pr-10 reveal fade-right">
            <h2 class="text-5xl lg:text-6xl font-extrabold text-indigo-950 mb-8 leading-tight">
                Galeri Spektra<br>Polimedia
            </h2>
            <div class="space-y-6 text-gray-500 text-base lg:text-lg leading-relaxed">
                <p>Merupakan ruang pamer karya mahasiswa Politeknik Negeri Media Kreatif yang berlokasi di Gedung A Jakarta dan terbuka untuk umum.</p>
                <p>Galeri ini menjadi wadah bagi mahasiswa untuk menampilkan berbagai karya kreatif, seperti desain grafis, fotografi, video, dan karya multimedia lainnya.</p>
                <p>Melalui platform ini, mahasiswa dapat mengajukan karya secara digital untuk ditinjau oleh pengelola sebelum dipamerkan di Galeri Spektra.</p>
            </div>
        </div>
        <div class="h-[400px] lg:h-[550px] w-full reveal fade-left delay-200">
            <img src="<?= base_url('assets/img/campus.jpg') ?>" alt="Kampus Polimedia" class="rounded-[2.5rem] w-full h-full object-cover shadow-lg hover:shadow-2xl transition-shadow duration-500">
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 reveal fade-up">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-8">
        <div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-[#1a103c] mb-4 tracking-tight">Karya Terkini</h2>
            <p class="text-base text-gray-500 font-medium">Kurasi karya terbaru bulan ini dari berbagai Program Studi Polimedia.</p>
        </div>

        <div class="hidden md:flex items-center gap-4">
            <button onclick="scrollKarya('left')" class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-[#1a103c] hover:border-gray-300 transition-colors cursor-pointer bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button onclick="scrollKarya('right')" class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-[#1a103c] hover:border-gray-300 transition-colors cursor-pointer bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

    <div id="korsel-karya" class="flex overflow-x-auto gap-6 pb-10 snap-x snap-mandatory hide-scrollbar scroll-smooth">
        <?php if (!empty($karya_terbaik)): ?>
            <?php foreach ($karya_terbaik as $karya): ?>
                <?php
                $inisial = strtoupper(substr(str_replace(' ', '', $karya['kreator']), 0, 2));
                if (strlen($inisial) < 2) $inisial = 'US';

                $kategori = strtoupper($karya['tipe_karya']);
                $warnaBg = 'bg-gray-100';
                $warnaTeks = 'text-gray-600';

                if (strpos($kategori, 'DESAIN') !== false || strpos($kategori, 'ARTWORK') !== false) {
                    $warnaBg = 'bg-purple-100';
                    $warnaTeks = 'text-purple-600';
                } elseif (strpos($kategori, 'FOTO') !== false) {
                    $warnaBg = 'bg-orange-100';
                    $warnaTeks = 'text-orange-500';
                } elseif (strpos($kategori, 'TEKNO') !== false || strpos($kategori, 'GAME') !== false) {
                    $warnaBg = 'bg-blue-100';
                    $warnaTeks = 'text-blue-500';
                } elseif (strpos($kategori, 'UI') !== false || strpos($kategori, 'UX') !== false) {
                    $warnaBg = 'bg-indigo-100';
                    $warnaTeks = 'text-indigo-500';
                } else {
                    $warnaBg = 'bg-emerald-100';
                    $warnaTeks = 'text-emerald-500';
                }
                ?>

                <div class="flex-none w-[320px] bg-white rounded-[2rem] p-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-50 flex flex-col snap-start hover:-translate-y-1 hover:shadow-xl transition-all duration-300 cursor-pointer"
                    onclick="tampilkanDetailKarya({
                         judul: '<?= esc($karya['judul_karya'], 'js') ?>',
                         kategori: '<?= esc($karya['tipe_karya'], 'js') ?>',
                         kreator: '<?= esc($karya['kreator'], 'js') ?>',
                         prodi: '<?= esc($karya['prodi'] ?? 'Polimedia', 'js') ?>',
                         deskripsi: '<?= esc($karya['deskripsi'], 'js') ?>',
                         gambar: '<?= esc($karya['file_path'], 'js') ?>',
                         inisial: '<?= esc($inisial, 'js') ?>'
                     })">

                    <div class="w-full h-48 rounded-2xl overflow-hidden mb-5">
                        <img src="<?= esc($karya['file_path']) ?>" alt="<?= esc($karya['judul_karya']) ?>" class="w-full h-full object-cover">
                    </div>

                    <div class="flex justify-between items-center mb-4 px-1">
                        <span class="text-[9px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-lg <?= $warnaBg ?> <?= $warnaTeks ?>">
                            <?= esc($karya['tipe_karya']) ?>
                        </span>
                        <span class="text-[10px] font-medium text-gray-400">
                            <?= date('d F Y', strtotime($karya['tanggal_tinjauan'])) ?>
                        </span>
                    </div>

                    <div class="px-1 flex flex-col flex-grow">
                        <h3 class="text-xl font-extrabold text-[#1a103c] mb-2 leading-tight line-clamp-2">
                            <?= esc($karya['judul_karya']) ?>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 mb-6 flex-grow text-justify">
                            <?= esc($karya['deskripsi']) ?>
                        </p>
                    </div>

                    <div class="flex items-center gap-3 px-1 pt-1">
                        <div class="w-9 h-9 rounded-full <?= $warnaBg ?> <?= $warnaTeks ?> flex items-center justify-center text-[11px] font-extrabold">
                            <?= esc($inisial) ?>
                        </div>
                        <span class="text-[11px] font-extrabold text-[#1a103c]">
                            <?= esc($karya['kreator']) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="w-full text-center py-24 bg-gray-50 rounded-[2rem] border border-dashed border-gray-200">
                <p class="text-gray-500 font-medium text-lg">Belum ada karya pilihan minggu ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-12 flex justify-center">
        <a href="<?= base_url('galeri') ?>" class="px-10 py-4 bg-white border border-gray-200 text-[#1a103c] font-extrabold text-sm uppercase tracking-wider rounded-2xl shadow-sm hover:bg-gray-50 hover:border-gray-300 transition-all cursor-pointer">
            Eksplorasi Seluruh Karya
        </a>
    </div>

</section>

<section class="pt-24 pb-32 text-center px-4 border-t border-gray-200/50">
    <div class="max-w-5xl mx-auto reveal fade-up">
        <h2 class="text-4xl lg:text-5xl font-extrabold text-[#1e1b4b] leading-tight mb-8">
            "Karya bukan hanya tentang visual, tapi tentang bagaimana kita menceritakan dunia."
        </h2>
        <p class="text-base font-medium text-gray-500 mb-12 uppercase tracking-widest">
            — Kurator Spektra Polimedia
        </p>

        <div class="w-px h-20 bg-gradient-to-b from-orange-400 to-transparent mx-auto mb-12 opacity-70"></div>

        <?php if (!session()->get('logged_in')): ?>
            <button onclick="switchModal('registerMahasiswaModal')" class="px-12 py-5 bg-[#f97316] text-white text-base font-bold rounded-2xl hover:bg-orange-600 hover:-translate-y-1 transition-all shadow-xl shadow-orange-500/30 cursor-pointer">
                Daftarkan Karyamu Sekarang
            </button>
        <?php else: ?>
            <a href="<?= session('role') === 'admin' ? base_url('dashboard/admin') : base_url('dashboard') ?>" class="inline-block px-12 py-5 bg-[#f97316] text-white text-base font-bold rounded-2xl hover:bg-orange-600 hover:-translate-y-1 transition-all shadow-xl shadow-orange-500/30 cursor-pointer">
                Akses Dasbor Kurasi
            </a>
        <?php endif; ?>
    </div>
</section>

<div id="modal-galeri" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/90 backdrop-blur-sm p-4 hidden transition-opacity duration-300">
    <div class="bg-white w-full max-w-5xl h-[90vh] lg:h-[600px] rounded-[2rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row relative">
        <button onclick="tutupDetailKarya()" class="absolute top-4 right-4 z-20 p-2.5 bg-gray-100/50 text-gray-800 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full lg:w-3/5 bg-gray-900 flex items-center justify-center h-1/2 lg:h-full p-4 relative">
            <img id="pub-gambar" src="" class="max-w-full max-h-full object-contain drop-shadow-2xl">
        </div>

        <div class="w-full lg:w-2/5 p-8 lg:p-10 flex flex-col overflow-y-auto bg-white">
            <span id="pub-kategori" class="w-fit px-3 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 text-[9px] font-bold rounded-lg uppercase tracking-widest mb-4">Kategori</span>
            <h2 id="pub-judul" class="text-3xl font-extrabold text-indigo-950 leading-tight mb-6">Judul Karya</h2>

            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div id="pub-inisial" class="h-12 w-12 rounded-full bg-indigo-950 flex items-center justify-center text-sm font-bold text-white shadow-md">US</div>
                <div>
                    <p id="pub-kreator" class="text-sm font-extrabold text-gray-900">Nama Kreator</p>
                    <p id="pub-prodi" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Program Studi</p>
                </div>
            </div>

            <div class="flex-grow">
                <h4 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider mb-2">Tentang Karya</h4>
                <p id="pub-deskripsi" class="text-xs text-gray-500 leading-relaxed text-justify"></p>
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

    .reveal {
        opacity: 0;
        transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
    }

    .reveal.active {
        opacity: 1;
        transform: translate(0, 0);
    }

    .fade-up {
        transform: translateY(50px);
    }

    .fade-left {
        transform: translateX(50px);
    }

    .fade-right {
        transform: translateX(-50px);
    }

    .delay-100 {
        transition-delay: 100ms;
    }

    .delay-200 {
        transition-delay: 200ms;
    }

    .delay-300 {
        transition-delay: 300ms;
    }
</style>

<script>
    window.onbeforeunload = function() {
        window.scrollTo(0, 0);
    };

    document.addEventListener("DOMContentLoaded", () => {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });

    function scrollKarya(direction) {
        const container = document.getElementById('korsel-karya');
        if (!container) return;

        const scrollAmount = 344; 
        if (direction === 'left') {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    function tampilkanDetailKarya(data) {
        document.getElementById('pub-judul').textContent = data.judul;
        document.getElementById('pub-kategori').textContent = data.kategori;
        document.getElementById('pub-kreator').textContent = data.kreator;
        document.getElementById('pub-prodi').textContent = data.prodi;
        document.getElementById('pub-deskripsi').textContent = data.deskripsi;
        document.getElementById('pub-gambar').src = data.gambar;
        document.getElementById('pub-inisial').textContent = data.inisial;

        document.getElementById('modal-galeri').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupDetailKarya() {
        document.getElementById('modal-galeri').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>