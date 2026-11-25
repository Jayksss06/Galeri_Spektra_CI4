<?php
$distItems  = $distribusi_prodi['items'] ?? [];
$totalKarya = (int) ($distribusi_prodi['total_karya'] ?? 0);
$topProdi   = ! empty($distItems) && $totalKarya > 0 ? $distItems[0] : null;
$palette    = [
    ['stroke' => '#1e1b4b', 'dot' => 'bg-indigo-950'],
    ['stroke' => '#f97316', 'dot' => 'bg-orange-500'],
    ['stroke' => '#8b5cf6', 'dot' => 'bg-violet-500'],
    ['stroke' => '#10b981', 'dot' => 'bg-emerald-500'],
    ['stroke' => '#94a3b8', 'dot' => 'bg-slate-400'],
];
?>

<div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="0">
    <div>
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-950 tracking-tight leading-none mb-2">Dasbor Kurator</h1>
        <p class="text-xs text-gray-500">Tinjau kelayakan karya, proposal ruang pamer fisik, dan kelola publikasi Galeri Spektra.</p>
    </div>
    <button type="button" onclick="document.getElementById('modal-tambah-kurator').classList.remove('hidden')" class="px-4 py-2.5 bg-indigo-950 hover:bg-indigo-900 text-white text-xs font-bold rounded-xl transition shadow-sm cursor-pointer w-fit">
        + Tambah Kurator
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="100">
    <div class="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm flex flex-col justify-center">
        <h3 class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-widest mb-2">Peninjauan Tertunda</h3>
        <p class="text-4xl lg:text-5xl font-extrabold text-orange-500"><?= esc((string) ($total_pending ?? 0)) ?></p>
    </div>
    <div class="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm flex flex-col justify-center">
        <h3 class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-widest mb-2">Karya Dipublikasikan</h3>
        <p class="text-4xl lg:text-5xl font-extrabold text-emerald-600"><?= esc((string) ($total_published ?? 0)) ?></p>
    </div>
    <div class="bg-white border border-gray-100 rounded-3xl p-7 shadow-sm flex flex-col justify-center">
        <h3 class="text-[10px] font-extrabold text-indigo-950 uppercase tracking-widest mb-2">Karya Ditolak</h3>
        <p class="text-4xl lg:text-5xl font-extrabold text-red-500"><?= esc((string) ($total_rejected ?? 0)) ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="200">

    <div class="lg:col-span-2 bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-extrabold text-indigo-950">Antrean & Riwayat Pengajuan</h2>

            <a href="<?= base_url('dashboard/export-csv') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 border border-emerald-200 text-[10px] font-extrabold uppercase tracking-wider rounded-lg transition-colors cursor-pointer shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export CSV
            </a>
        </div>

        <div class="overflow-x-auto hide-scrollbar">
            <table class="w-full text-left border-collapse min-w-[620px]">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] text-gray-400 uppercase tracking-widest">
                        <th class="pb-3 font-bold">Judul Karya</th>
                        <th class="pb-3 font-bold">Kreator</th>
                        <th class="pb-3 font-bold">Prodi</th>
                        <th class="pb-3 font-bold">Tanggal</th>
                        <th class="pb-3 font-bold">Status</th>
                        <th class="pb-3 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-700">

                    <?php if (! empty($daftar_karya)): ?>
                        <?php foreach ($daftar_karya as $karya): ?>
                            <?php
                            if ($karya['status_kurasi'] === 'ACCEPTED') {
                                $badge = 'bg-green-50 text-green-600';
                            } elseif ($karya['status_kurasi'] === 'REJECTED') {
                                $badge = 'bg-red-50 text-red-600';
                            } else {
                                $badge = 'bg-orange-50 text-orange-500';
                            }
                            $imgUrl = media_url($karya['file_path']);
                            $rabUrl = media_url($karya['file_rab'] ?? null);
                            ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="py-4 flex items-center gap-3">
                                    <img src="<?= esc($imgUrl) ?>" alt="<?= esc($karya['judul_karya']) ?>" loading="lazy" class="w-10 h-10 rounded-lg object-cover bg-gray-100 shrink-0">
                                    <div>
                                        <span class="block font-extrabold text-indigo-950 truncate max-w-[140px]"><?= esc($karya['judul_karya']) ?></span>
                                        <span class="block text-[10px] text-gray-400 truncate max-w-[140px]"><?= esc($karya['tipe_karya'] ?: '-') ?></span>
                                    </div>
                                </td>
                                <td class="py-4 font-medium"><?= esc($karya['kreator']) ?></td>
                                <td class="py-4 text-gray-500"><?= esc($karya['prodi'] ?? 'Polimedia') ?></td>
                                <td class="py-4 text-gray-500"><?= date('d M Y', strtotime($karya['tanggal_pengajuan'])) ?></td>
                                <td class="py-4">
                                    <span class="px-3 py-1 <?= $badge ?> font-bold text-[9px] uppercase tracking-wide rounded-md">
                                        <?= esc($karya['status_kurasi']) ?>
                                    </span>
                                </td>
                                <td class="py-4 text-center">
                                    <button type="button" onclick="tinjauKarya({
                                        id: '<?= (int) $karya['id_karya'] ?>',
                                        judul: '<?= esc($karya['judul_karya'], 'js') ?>',
                                        kreator: '<?= esc($karya['kreator'], 'js') ?>',
                                        prodi: '<?= esc($karya['prodi'] ?? 'Polimedia', 'js') ?>',
                                        tipe: '<?= esc($karya['tipe_karya'] ?: 'Karya Kreatif', 'js') ?>',
                                        jenis: '<?= esc($karya['jenis_karya'] ?? 'DIGITAL', 'js') ?>',
                                        dimensi: '<?= esc($karya['dimensi_karya'] ?? '-', 'js') ?>',
                                        material: '<?= esc($karya['material_media'] ?? '-', 'js') ?>',
                                        display: '<?= esc($karya['kebutuhan_display'] ?? '-', 'js') ?>',
                                        biaya: '<?= esc($karya['estimasi_biaya'] ?? '-', 'js') ?>',
                                        file_rab: '<?= esc($rabUrl, 'js') ?>',
                                        tautan: '<?= esc($karya['tautan_karya'] ?? '', 'js') ?>',
                                        deskripsi: '<?= esc($karya['deskripsi'], 'js') ?>',
                                        gambar: '<?= esc($imgUrl, 'js') ?>',
                                        status: '<?= esc($karya['status_kurasi'], 'js') ?>',
                                        catatan: '<?= esc($karya['catatan_kurator'] ?? '', 'js') ?>',
                                        nama_kurator: '<?= esc($karya['nama_kurator'] ?? '-', 'js') ?>'
                                    })" class="px-4 py-2 <?= $karya['status_kurasi'] === 'PENDING' ? 'bg-indigo-950 hover:bg-indigo-800 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' ?> text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm cursor-pointer">
                                        <?= $karya['status_kurasi'] === 'PENDING' ? 'Tinjau' : 'Detail' ?>
                                    </button>
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

    <!-- Grafik Dinamis Distribusi Program Studi -->
    <div class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col">
        <h2 class="text-xl font-extrabold text-indigo-950 mb-2">Distribusi Program Studi</h2>
        <p class="text-[11px] text-gray-400 mb-6">Proporsi total <?= $totalKarya ?> pengajuan karya berdasarkan prodi.</p>

        <div class="relative w-40 h-40 mx-auto mb-8 flex items-center justify-center">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#f1f5f9" stroke-width="4"></circle>
                <?php
                $cumulativeOffset = 0.0;
                foreach ($distItems as $idx => $item):
                    $pct = (float) $item['persentase'];
                    if ($pct <= 0) {
                        continue;
                    }
                    $color = $palette[$idx % count($palette)]['stroke'];
                ?>
                    <circle cx="18" cy="18" r="15.9155" fill="none"
                        stroke="<?= $color ?>"
                        stroke-width="4"
                        stroke-dasharray="<?= $pct ?> <?= 100 - $pct ?>"
                        stroke-dashoffset="<?= -$cumulativeOffset ?>"></circle>
                <?php
                    $cumulativeOffset += $pct;
                endforeach;
                ?>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3">
                <?php if ($topProdi): ?>
                    <span class="text-2xl font-extrabold text-indigo-950"><?= esc((string) $topProdi['persentase']) ?>%</span>
                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-wider mt-1 line-clamp-2"><?= esc($topProdi['nama_prodi']) ?></span>
                <?php else: ?>
                    <span class="text-xl font-extrabold text-gray-400">0%</span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase mt-1">Belum Ada</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="space-y-3.5 mt-auto">
            <?php foreach ($distItems as $idx => $item): ?>
                <?php $dotClass = $palette[$idx % count($palette)]['dot']; ?>
                <div class="flex items-center justify-between text-xs font-medium gap-2">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 <?= $dotClass ?>"></span>
                        <span class="text-gray-600 truncate"><?= esc($item['nama_prodi']) ?></span>
                    </div>
                    <span class="font-extrabold text-indigo-950 shrink-0"><?= (int) $item['jumlah'] ?> (<?= esc((string) $item['persentase']) ?>%)</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal Tinjau / Detail Karya -->
<div id="modal-tinjau" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-5xl h-[90vh] lg:h-[620px] rounded-[2rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row relative">
        <button type="button" onclick="tutupModalTinjau()" class="absolute top-4 right-4 z-20 p-2.5 bg-gray-100/80 text-gray-800 hover:bg-red-500 hover:text-white rounded-xl transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="w-full lg:w-1/2 bg-gray-900 flex items-center justify-center h-2/5 lg:h-full relative p-4">
            <img id="krt-gambar" src="" alt="Karya Mahasiswa" class="max-w-full max-h-full object-contain drop-shadow-2xl">
        </div>

        <div class="w-full lg:w-1/2 p-6 lg:p-8 flex flex-col h-3/5 lg:h-full">
            <div class="overflow-y-auto flex-grow pr-2">
                <div class="flex flex-wrap gap-2 mb-2 pr-8">
                    <span id="krt-tipe" class="px-2.5 py-1 bg-orange-50 text-orange-600 border border-orange-100 text-[9px] font-bold rounded-md uppercase tracking-wider">Tipe</span>
                    <span id="krt-jenis" class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-[9px] font-bold rounded-md uppercase tracking-wider">Jenis</span>
                    <span id="krt-status-badge" class="px-2.5 py-1 bg-gray-100 text-gray-700 text-[9px] font-bold rounded-md uppercase tracking-wider">Status</span>
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
                            <a href="#" id="krt-rab-link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-green-200 hover:bg-green-100 transition shadow-sm">
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
                    <a href="#" id="krt-tautan-link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 underline underline-offset-4 break-all">
                        Menuju Tautan Karya Terlampir
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider mb-1">Deskripsi Konsep Kreator</h4>
                    <p id="krt-deskripsi" class="text-xs text-gray-500 leading-relaxed text-justify mb-4"></p>
                </div>

                <div id="krt-input-feedback-wrapper" class="border-t border-gray-100 pt-4 mb-4">
                    <label class="block text-[10px] font-extrabold text-indigo-950 uppercase tracking-wider mb-2">Evaluasi Kurator / Alasan Penolakan <span class="text-red-500">(Wajib jika ditolak)</span></label>
                    <textarea id="krt-feedback" rows="2" placeholder="Tuliskan apresiasi kuratorial atau catatan evaluasi (minimal 5 karakter jika ditolak)..." class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium leading-relaxed"></textarea>
                </div>

                <div id="krt-readonly-feedback" class="hidden border-t border-gray-100 pt-4 mb-4">
                    <p class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider mb-1">Riwayat Keputusan Kurator (<span id="krt-peninjau"></span>)</p>
                    <p id="krt-catatan-teks" class="text-xs text-gray-600 bg-gray-50 p-3.5 rounded-xl border border-gray-100"></p>
                </div>
            </div>

            <form id="form-keputusan" action="<?= base_url('dashboard/update-status-karya') ?>" method="POST" onsubmit="return validasiKeputusan();" class="pt-4 border-t border-gray-100 flex gap-4 mt-auto">
                <?= csrf_field() ?>
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

<!-- Modal Tambah Kurator (Terproteksi Hanya untuk Admin Login) -->
<div id="modal-tambah-kurator" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 border-t-4 border-orange-500">
        <button type="button" onclick="document.getElementById('modal-tambah-kurator').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 cursor-pointer text-xl font-bold">&times;</button>
        <h3 class="text-xl font-extrabold text-indigo-950 mb-1">Daftarkan Kurator Baru</h3>
        <p class="text-xs text-gray-500 mb-6">Tambahkan dosen pengelola resmi ke sistem kurasi.</p>

        <form action="<?= base_url('dashboard/tambah-kurator') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar</label>
                <input type="text" name="nama_lengkap" required minlength="3" maxlength="150" class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:border-orange-500">
            </div>
            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 uppercase tracking-wider mb-1">NIP / ID Dosen</label>
                <input type="text" name="nip_dosen" required minlength="5" maxlength="20" class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:border-orange-500">
            </div>
            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 uppercase tracking-wider mb-1">Departemen / Unit</label>
                <input type="text" name="departemen" value="Kurasi Seni & Multimedia" required maxlength="150" class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:border-orange-500">
            </div>
            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 uppercase tracking-wider mb-1">Email Institusi</label>
                <input type="email" name="email_institusi" required maxlength="150" placeholder="dosen@polimedia.ac.id" class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:border-orange-500">
            </div>
            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 uppercase tracking-wider mb-1">Kata Sandi Awal (Min. 8 karakter)</label>
                <input type="password" name="password" required minlength="8" maxlength="72" class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:border-orange-500">
            </div>
            <button type="submit" class="w-full py-3 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl transition cursor-pointer mt-2">
                Simpan Akun Kurator
            </button>
        </form>
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
        document.getElementById('krt-status-badge').textContent = data.status;
        document.getElementById('krt-deskripsi').textContent = data.deskripsi;
        document.getElementById('krt-gambar').src = data.gambar;
        document.getElementById('krt-feedback').value = data.catatan || '';

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
            if (data.tautan && /^https?:\/\//i.test(data.tautan.trim())) {
                blockDigital.classList.remove('hidden');
                tautanLink.href = data.tautan.trim();
            } else {
                blockDigital.classList.add('hidden');
            }
        }

        const formKeputusan = document.getElementById('form-keputusan');
        const inputFeedbackWrapper = document.getElementById('krt-input-feedback-wrapper');
        const readonlyFeedback = document.getElementById('krt-readonly-feedback');

        if (data.status === 'PENDING') {
            formKeputusan.classList.remove('hidden');
            inputFeedbackWrapper.classList.remove('hidden');
            readonlyFeedback.classList.add('hidden');
        } else {
            formKeputusan.classList.add('hidden');
            inputFeedbackWrapper.classList.add('hidden');
            readonlyFeedback.classList.remove('hidden');
            document.getElementById('krt-peninjau').textContent = data.nama_kurator || 'Kurator';
            document.getElementById('krt-catatan-teks').textContent = data.catatan || 'Tidak ada catatan tambahan.';
        }

        document.getElementById('modal-tinjau').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalTinjau() {
        document.getElementById('modal-tinjau').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('modal-tinjau').addEventListener('click', function(e) {
        if (e.target === this) tutupModalTinjau();
    });

    function setDecision(status) {
        document.getElementById('krt-status-action').value = status;
    }

    function validasiKeputusan() {
        const feedbackVal = document.getElementById('krt-feedback').value.trim();
        const statusAction = document.getElementById('krt-status-action').value;

        if (statusAction === 'REJECTED' && feedbackVal.length < 5) {
            alert('Gagal memproses penolakan. Anda wajib menyertakan alasan penolakan minimal 5 karakter pada kolom yang tersedia!');
            return false;
        }

        document.getElementById('krt-catatan-hidden').value = feedbackVal;
        return true;
    }
</script>
