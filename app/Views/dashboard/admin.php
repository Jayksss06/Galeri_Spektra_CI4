<div class="mb-8 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="0">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-950 tracking-tight leading-none mb-2">Dasbor Kurator</h1>
    <p class="text-xs text-gray-500">Tinjau, kelola, dan publikasikan karya visual mahasiswa Galeri Spektra.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="100">
    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col justify-center">
        <h3 class="text-[11px] font-extrabold text-indigo-950 uppercase tracking-widest mb-2">Peninjauan Tertunda</h3>
        <p class="text-5xl font-extrabold text-orange-500"><?= esc($total_pending ?? 0) ?></p>
    </div>
    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col justify-center">
        <h3 class="text-[11px] font-extrabold text-indigo-950 uppercase tracking-widest mb-2">Karya Yang Dipublikasi</h3>
        <p class="text-5xl font-extrabold text-orange-500"><?= esc($total_published ?? 0) ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="200">

    <div class="lg:col-span-2 bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-extrabold text-indigo-950">Pengiriman Terbaru</h2>

            <a href="<?= base_url('dashboard/export-csv') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 border border-emerald-200 text-[10px] font-extrabold uppercase tracking-wider rounded-lg transition-colors cursor-pointer shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export CSV
            </a>
        </div>

        <div class="overflow-x-auto hide-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] text-gray-400 uppercase tracking-widest">
                        <th class="pb-3 font-bold font-semibold">Judul Karya</th>
                        <th class="pb-3 font-bold font-semibold">Kreator</th>
                        <th class="pb-3 font-bold font-semibold">Prodi</th>
                        <th class="pb-3 font-bold font-semibold">Tanggal</th>
                        <th class="pb-3 font-bold font-semibold">Status</th>
                        <th class="pb-3 font-bold font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-700">

                    <?php if (!empty($daftar_karya)): ?>
                        <?php foreach ($daftar_karya as $karya): ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="py-4 flex items-center gap-3">
                                    <img src="<?= esc($karya['file_path']) ?>" alt="<?= esc($karya['judul_karya']) ?>" class="w-10 h-10 rounded-lg object-cover">
                                    <span class="font-extrabold text-indigo-950 truncate max-w-[120px]"><?= esc($karya['judul_karya']) ?></span>
                                </td>
                                <td class="py-4 font-medium"><?= esc($karya['kreator']) ?></td>
                                <td class="py-4 text-gray-500"><?= esc($karya['prodi'] ?? 'Polimedia') ?></td>
                                <td class="py-4 text-gray-500"><?= date('d M Y', strtotime($karya['tanggal_pengajuan'])) ?></td>
                                <td class="py-4">
                                    <?php
                                    if ($karya['status_kurasi'] === 'ACCEPTED') {
                                        $badge = 'bg-green-50 text-green-600';
                                    } elseif ($karya['status_kurasi'] === 'REJECTED') {
                                        $badge = 'bg-red-50 text-red-600';
                                    } else {
                                        $badge = 'bg-orange-50 text-orange-500';
                                    }
                                    ?>
                                    <span class="px-3 py-1 <?= $badge ?> font-bold text-[9px] uppercase tracking-wide rounded-md">
                                        <?= esc($karya['status_kurasi']) ?>
                                    </span>
                                </td>
                                <td class="py-4 text-center">
                                    <?php if ($karya['status_kurasi'] === 'PENDING'): ?>
                                        <button onclick="tinjauKarya({
                                            id: '<?= $karya['id_karya'] ?>',
                                            judul: '<?= esc($karya['judul_karya'], 'js') ?>',
                                            kreator: '<?= esc($karya['kreator'], 'js') ?>',
                                            prodi: '<?= esc($karya['prodi'] ?? 'Polimedia', 'js') ?>',
                                            tipe: '<?= esc($karya['tipe_karya'], 'js') ?>',
                                            jenis: '<?= esc($karya['jenis_karya'], 'js') ?>',
                                            dimensi: '<?= esc($karya['dimensi_karya'] ?? '-', 'js') ?>',
                                            material: '<?= esc($karya['material_media'] ?? '-', 'js') ?>',
                                            display: '<?= esc($karya['kebutuhan_display'] ?? '-', 'js') ?>',
                                            biaya: '<?= esc($karya['estimasi_biaya'] ?? '-', 'js') ?>',
                                            file_rab: '<?= esc($karya['file_rab'] ?? '', 'js') ?>',
                                            tautan: '<?= esc($karya['tautan_karya'] ?? '', 'js') ?>',
                                            deskripsi: '<?= esc($karya['deskripsi'], 'js') ?>',
                                            gambar: '<?= esc($karya['file_path'], 'js') ?>'
                                        })" class="px-4 py-2 bg-indigo-950 hover:bg-indigo-800 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm cursor-pointer">
                                            Tinjau
                                        </button>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400 font-medium">Belum ada karya yang diajukan oleh mahasiswa.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col">
        <h2 class="text-xl font-extrabold text-indigo-950 mb-8">Distribusi Program Studi</h2>

        <div class="relative w-40 h-40 mx-auto mb-8 flex items-center justify-center">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <path class="text-gray-100" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" stroke="currentColor" stroke-width="4" fill="none" />
                <path class="text-indigo-950" stroke-dasharray="45, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" stroke="currentColor" stroke-width="4" fill="none" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                <span class="text-2xl font-extrabold text-indigo-950">45%</span>
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Desain</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between text-xs font-medium">
                <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-indigo-950"></span><span class="text-gray-600">Desain Grafis</span></div>
                <span class="font-extrabold text-indigo-950">45%</span>
            </div>
            <div class="flex items-center justify-between text-xs font-medium">
                <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span><span class="text-gray-600">Fotografi</span></div>
                <span class="font-extrabold text-indigo-950">30%</span>
            </div>
            <div class="flex items-center justify-between text-xs font-medium">
                <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-200"></span><span class="text-gray-600">Lainnya</span></div>
                <span class="font-extrabold text-indigo-950">25%</span>
            </div>
        </div>
    </div>
</div>

<div id="modal-tinjau" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-5xl h-[90vh] lg:h-[600px] rounded-[2rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row relative">
        <button onclick="tutupModalTinjau()" class="absolute top-4 right-4 z-20 p-2.5 bg-gray-100/50 text-gray-800 hover:bg-red-500 hover:text-white rounded-xl transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full lg:w-1/2 bg-gray-900 flex items-center justify-center h-2/5 lg:h-full relative p-4">
            <img id="krt-gambar" src="" class="max-w-full max-h-full object-contain drop-shadow-2xl">
        </div>

        <div class="w-full lg:w-1/2 p-6 lg:p-8 flex flex-col h-3/5 lg:h-full">
            <div class="overflow-y-auto flex-grow pr-2">
                <div class="flex gap-2 mb-2">
                    <span id="krt-tipe" class="px-2.5 py-1 bg-orange-50 text-orange-600 border border-orange-100 text-[9px] font-bold rounded-md uppercase tracking-wider">Tipe</span>
                    <span id="krt-jenis" class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-[9px] font-bold rounded-md uppercase tracking-wider">Jenis</span>
                </div>
                <h2 id="krt-judul" class="text-2xl font-extrabold text-indigo-950 leading-tight mb-1">Judul</h2>
                <p id="krt-kreator" class="text-xs font-bold text-gray-700"></p>
                <p id="krt-prodi" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Prodi</p>

                <div id="krt-block-fisik" class="hidden bg-gray-50 border border-gray-100 rounded-2xl p-4 mb-4 space-y-2.5">
                    <p class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-wider border-b border-gray-200 pb-1">Spesifikasi Proposal Fisik</p>
                    <p class="text-xs text-gray-600"><strong class="text-indigo-950">Dimensi:</strong> <span id="krt-dimensi"></span></p>
                    <p class="text-xs text-gray-600"><strong class="text-indigo-950">Material:</strong> <span id="krt-material"></span></p>
                    <p class="text-xs text-gray-600 leading-relaxed"><strong class="text-indigo-950">Display Space:</strong> <span id="krt-display"></span></p>

                    <div class="pt-2 border-t border-gray-200 mt-2">
                        <p class="text-xs text-gray-600"><strong class="text-indigo-950">Estimasi RAB:</strong> <span id="krt-biaya" class="font-bold text-orange-600"></span></p>
                        <div id="krt-rab-container" class="mt-2 hidden">
                            <a href="#" id="krt-rab-link" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-green-200 hover:bg-green-100 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Unduh / Lihat Dokumen RAB
                            </a>
                        </div>
                    </div>
                </div>

                <div id="krt-block-digital" class="hidden bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-4">
                    <p class="text-[10px] font-extrabold text-blue-950 uppercase tracking-wider mb-2">Tautan Berkas Digital / Video</p>
                    <a href="#" id="krt-tautan-link" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 underline underline-offset-4 break-all">
                        Menuju Tautan Karya Terlampir
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider mb-1">Catatan Kreator</h4>
                    <p id="krt-deskripsi" class="text-xs text-gray-500 leading-relaxed text-justify mb-4"></p>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-4">
                    <label class="block text-[10px] font-extrabold text-red-600 uppercase tracking-wider mb-2">Feedback / Catatan Penolakan (Wajib jika ditolak)</label>
                    <textarea id="krt-feedback" name="catatan_kurator" rows="2" placeholder="Tuliskan evaluasi kritismu atau alasan penolakan di sini agar terbaca oleh mahasiswa..." class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-red-300 transition-all text-gray-800 font-medium leading-relaxed"></textarea>
                </div>
            </div>

            <form id="form-keputusan" action="<?= base_url('dashboard/update-status-karya') ?>" method="POST" onsubmit="return validasiKeputusan(this);" class="pt-4 border-t border-gray-100 flex gap-4 mt-auto">
                <input type="hidden" name="id_karya" id="krt-id">
                <input type="hidden" name="status_kurasi" id="krt-status-action">
                <input type="hidden" name="catatan_kurator" id="krt-catatan-hidden">

                <button type="submit" onclick="setDecision('REJECTED')" class="flex-1 py-3 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold rounded-xl tracking-tight transition cursor-pointer">
                    Tolak Karya
                </button>
                <button type="submit" onclick="setDecision('ACCEPTED')" class="flex-1 py-3 bg-indigo-950 hover:bg-indigo-900 text-white text-xs font-bold rounded-xl tracking-tight transition shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                    Setujui & Publikasikan
                </button>
            </form>
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
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            document.querySelectorAll('[data-anim]').forEach(el => {
                setTimeout(() => {
                    el.classList.remove('opacity-0', 'translate-y-4');
                    el.classList.add('opacity-100', 'translate-y-0');
                }, parseInt(el.getAttribute('data-delay')) || 0);
            });
        }, 100);
    });

    function tinjauKarya(data) {
        document.getElementById('krt-id').value = data.id;
        document.getElementById('krt-judul').textContent = data.judul;
        document.getElementById('krt-kreator').textContent = data.kreator;
        document.getElementById('krt-prodi').textContent = data.prodi;
        document.getElementById('krt-tipe').textContent = data.tipe;
        document.getElementById('krt-jenis').textContent = data.jenis;
        document.getElementById('krt-deskripsi').textContent = data.deskripsi;
        document.getElementById('krt-gambar').src = data.gambar;
        document.getElementById('krt-feedback').value = '';

        const blockFisik = document.getElementById('krt-block-fisik');
        const blockDigital = document.getElementById('krt-block-digital');
        const tautanLink = document.getElementById('krt-tautan-link');

        if (data.jenis === 'FISIK') {
            blockDigital.classList.add('hidden'); 
            blockFisik.classList.remove('hidden'); 

            document.getElementById('krt-dimensi').textContent = data.dimensi;
            document.getElementById('krt-material').textContent = data.material;
            document.getElementById('krt-display').textContent = data.display;
            document.getElementById('krt-biaya').textContent = data.biaya;

            const rabContainer = document.getElementById('krt-rab-container');
            const rabLink = document.getElementById('krt-rab-link');

            if (data.file_rab && data.file_rab !== '') {
                rabLink.href = data.file_rab;
                rabContainer.classList.remove('hidden');
            } else {
                rabContainer.classList.add('hidden');
            }
        } else {
            blockFisik.classList.add('hidden'); 

            if (data.tautan && data.tautan.trim() !== '') {
                blockDigital.classList.remove('hidden');
                tautanLink.href = data.tautan;
            } else {
                blockDigital.classList.add('hidden');
            }
        }

        document.getElementById('modal-tinjau').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalTinjau() {
        document.getElementById('modal-tinjau').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function setDecision(status) {
        document.getElementById('krt-status-action').value = status;
    }

    function validasiKeputusan(form) {
        const feedbackVal = document.getElementById('krt-feedback').value.trim();
        const statusAction = document.getElementById('krt-status-action').value;

        if (statusAction === 'REJECTED' && feedbackVal === '') {
            alert('Gagal memproses penolakan. Anda wajib menyertakan alasan penolakan/feedback pada kolom yang tersedia!');
            return false;
        }

        document.getElementById('krt-catatan-hidden').value = feedbackVal;
        return true;
    }
</script>