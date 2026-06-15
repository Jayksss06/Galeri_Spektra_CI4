<div class="mb-12 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="0">
    <?php 
        $namaLengkap = session('nama_lengkap') ?? 'Mahasiswa';
        $namaDepan = explode(' ', trim($namaLengkap))[0];
    ?>
    <p class="text-xs font-semibold tracking-widest text-indigo-950 uppercase mb-2">Selamat Datang Kembali, <?= esc($namaDepan) ?></p>
    <h1 class="text-4xl lg:text-5xl font-extrabold text-indigo-950 tracking-tight leading-none mb-1">Kelola pameran digitalmu,</h1>
    <h1 class="text-4xl lg:text-5xl font-extrabold text-orange-500 tracking-tight">tunjukkan prestasimu.</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="150">
    <div class="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col justify-between min-h-[230px] hover:shadow-md transition duration-300">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-sm font-bold text-indigo-950">Status Pengajuan</h2>
                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-xl tracking-tight">Update Hari Ini</span>
            </div>
            <p class="text-xs text-gray-500 leading-relaxed mb-6"><?= esc($statistik['review'] ?? 0) ?> Karya sedang dalam proses kurasi</p>
        </div>
        <div class="flex items-center justify-between border-t border-gray-50 pt-5">
            <div>
                <p class="text-4xl font-extrabold text-orange-500"><?= str_pad($statistik['total'] ?? 0, 2, '0', STR_PAD_LEFT) ?></p>
                <p class="text-[10px] font-bold tracking-wider text-gray-400 uppercase mt-1">Total Karya</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-indigo-950"><?= str_pad($statistik['disetujui'] ?? 0, 2, '0', STR_PAD_LEFT) ?></p>
                <p class="text-[10px] font-bold tracking-wider text-gray-400 uppercase mt-1">Disetujui</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-indigo-950"><?= str_pad($statistik['review'] ?? 0, 2, '0', STR_PAD_LEFT) ?></p>
                <p class="text-[10px] font-bold tracking-wider text-gray-400 uppercase mt-1">Review</p>
            </div>
        </div>
    </div>

    <div class="bg-indigo-950 border border-indigo-950 rounded-3xl p-8 shadow-sm flex flex-col justify-between min-h-[230px] text-white hover:shadow-lg transition duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <h2 class="text-sm font-bold mb-2">Butuh Bantuan?</h2>
            <p class="text-xs text-indigo-200 leading-relaxed max-w-[200px]">Panduan pengajuan karya telah diperbarui untuk standar 2026.</p>
        </div>
        <a href="#" class="relative z-10 inline-flex items-center justify-between gap-2 text-xs font-bold text-white bg-indigo-900/50 hover:bg-indigo-900/80 rounded-xl px-4 py-3 w-full transition border border-indigo-800/50">
            Baca Panduan
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>
</div>

<div class="opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="300">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <h2 class="text-lg font-extrabold text-indigo-950">Riwayat Pengajuan</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if (!empty($riwayat)): ?>
            <?php foreach ($riwayat as $item): ?>
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow duration-300 group">
                    <div class="relative overflow-hidden rounded-t-[2rem]">
                        <img src="<?= esc($item['file_path']) ?>" alt="<?= esc($item['judul_karya']) ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <?php 
                            $bg_status = 'bg-orange-500'; 
                            if ($item['status_kurasi'] === 'ACCEPTED') $bg_status = 'bg-green-500';
                            if ($item['status_kurasi'] === 'REJECTED') $bg_status = 'bg-red-500';
                        ?>
                        <span class="absolute top-4 left-4 px-3 py-1 <?= $bg_status ?> text-white text-[9px] font-bold tracking-wider rounded-lg uppercase shadow-sm backdrop-blur-md">
                            <?= esc($item['status_kurasi']) ?>
                        </span>
                    </div>
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            <span class="text-[9px] font-bold tracking-widest uppercase text-gray-400"><?= esc($item['tipe_karya']) ?></span>
                            <h3 class="text-lg font-extrabold text-indigo-950 mt-2 leading-snug"><?= esc($item['judul_karya']) ?></h3>
                        </div>
                        <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-50 relative">
                            <span class="text-[10px] text-gray-400 font-medium">Diajukan: <?= date('d M Y', strtotime($item['tanggal_pengajuan'])) ?></span>
                            
                            <div class="relative">
                                <button onclick="toggleDropdown('menu-<?= $item['id_karya'] ?>')" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-950 hover:bg-gray-200 transition-colors duration-300 cursor-pointer focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                </button>
                                
                                <div id="menu-<?= $item['id_karya'] ?>" class="hidden absolute bottom-full right-0 mb-2 w-36 bg-white border border-gray-100 rounded-xl shadow-xl z-20 overflow-hidden">
                                    <button onclick="bukaModalDetail({
                                        judul: '<?= esc($item['judul_karya'], 'js') ?>',
                                        tipe: '<?= esc($item['tipe_karya'], 'js') ?>',
                                        deskripsi: '<?= esc($item['deskripsi'], 'js') ?>',
                                        gambar: '<?= esc($item['file_path'], 'js') ?>',
                                        status: '<?= esc($item['status_kurasi'], 'js') ?>'
                                    })" class="w-full text-left px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition cursor-pointer">
                                        Lihat Detail
                                    </button>
                                    
                                    <?php if ($item['status_kurasi'] === 'PENDING'): ?>
                                        <form action="<?= base_url('dashboard/hapus-karya') ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?');">
                                            <input type="hidden" name="id_karya" value="<?= $item['id_karya'] ?>">
                                            <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition cursor-pointer border-t border-gray-50">
                                                Batalkan / Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-1 md:col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                <p class="text-gray-400 font-medium">Anda belum memiliki riwayat pengajuan karya.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="modal-detail" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden transition-opacity duration-300">
    <div class="bg-white w-full max-w-4xl h-[85vh] lg:h-[500px] rounded-[2rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row relative">
        <button onclick="tutupModalDetail()" class="absolute top-4 right-4 z-20 p-2.5 bg-gray-100/50 text-gray-800 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="w-full lg:w-1/2 bg-gray-100 flex items-center justify-center h-1/2 lg:h-full p-4">
            <img id="mdl-gambar" src="" class="max-w-full max-h-full object-contain drop-shadow-xl">
        </div>
        <div class="w-full lg:w-1/2 p-6 lg:p-10 flex flex-col overflow-y-auto">
            <span id="mdl-tipe" class="w-fit px-3 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 text-[9px] font-bold rounded-lg uppercase tracking-widest mb-4">Tipe</span>
            <h2 id="mdl-judul" class="text-2xl font-extrabold text-indigo-950 leading-tight mb-2">Judul</h2>
            <p id="mdl-status" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Status</p>
            <div class="border-t border-gray-100 pt-6 mt-2 flex-grow">
                <h4 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider mb-2">Deskripsi Karya</h4>
                <p id="mdl-deskripsi" class="text-xs text-gray-500 leading-relaxed text-justify"></p>
            </div>
        </div>
    </div>
</div>

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

    function toggleDropdown(id) {
        document.querySelectorAll('[id^="menu-"]').forEach(menu => {
            if (menu.id !== id) menu.classList.add('hidden');
        });
        document.getElementById(id).classList.toggle('hidden');
    }
    
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative')) {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => menu.classList.add('hidden'));
        }
    });

    function bukaModalDetail(data) {
        document.getElementById('mdl-judul').textContent = data.judul;
        document.getElementById('mdl-tipe').textContent = data.tipe;
        document.getElementById('mdl-deskripsi').textContent = data.deskripsi;
        document.getElementById('mdl-gambar').src = data.gambar;
        document.getElementById('mdl-status').textContent = 'Status Saat Ini: ' + data.status;
        
        document.getElementById('modal-detail').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }

    function tutupModalDetail() {
        document.getElementById('modal-detail').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }
</script>