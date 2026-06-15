<?php
    $namaLengkap = session('nama_lengkap') ?? 'Pengguna Spektra';
    $role        = session('role') === 'admin' ? 'Administrator / Kurator' : 'Mahasiswa';
    $email       = session('email') ?? 'email@polimedia.ac.id';
    
    $inisial = strtoupper(substr(str_replace(' ', '', $namaLengkap), 0, 2));
    if(strlen($inisial) < 2) $inisial = 'US';
?>

<div class="mb-10 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="0">
    <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-950 tracking-tight leading-none mb-2">Profil Akun</h1>
    <p class="text-xs text-gray-500">Kelola informasi pribadi, detail akademik, dan pengaturan keamanan Anda.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="150">
    
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-100 rounded-[2rem] p-8 shadow-sm flex flex-col items-center text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-indigo-50 to-white"></div>
            
            <div class="relative z-10 w-24 h-24 rounded-full bg-indigo-950 border-4 border-white shadow-md flex items-center justify-center text-2xl font-extrabold text-white tracking-widest mb-4">
                <?= esc($inisial) ?>
            </div>
            
            <h2 class="text-xl font-extrabold text-indigo-950 leading-tight"><?= esc($namaLengkap) ?></h2>
            <p class="text-xs font-bold text-orange-500 uppercase tracking-widest mt-1 mb-6"><?= esc($role) ?></p>

            <div class="w-full border-t border-gray-100 pt-6 mt-2">
                <div class="flex justify-between items-center text-xs mb-3">
                    <span class="text-gray-400 font-medium">Status Akun</span>
                    <span class="px-2.5 py-1 bg-green-50 text-green-600 font-bold rounded-lg uppercase tracking-wide text-[9px]">Aktif</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-400 font-medium">Bergabung sejak</span>
                    <span class="text-indigo-950 font-bold">Okt 2023</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <form action="<?= base_url('dashboard/update-profil') ?>" method="POST" class="bg-white border border-gray-100 rounded-[2rem] p-8 shadow-sm">
            
            <h3 class="text-sm font-extrabold text-indigo-950 uppercase tracking-widest mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Informasi Dasar
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= esc($namaLengkap) ?>" required class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Alamat Email</label>
                    <input type="email" name="email" value="<?= esc($email) ?>" required class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium">
                </div>
            </div>

            <div class="border-t border-gray-100 mb-8"></div>

            <h3 class="text-sm font-extrabold text-indigo-950 uppercase tracking-widest mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                <?= session('role') === 'admin' ? 'Detail Instansi' : 'Detail Akademik' ?>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <?php if (session('role') !== 'admin'): ?>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" name="identitas" value="2300012345" class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Program Studi</label>
                        <select name="prodi" class="appearance-none w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium cursor-pointer">
                            <option value="Teknologi Rekayasa Multimedia" selected>Teknologi Rekayasa Multimedia</option>
                            <option value="Desain Grafis">Desain Grafis</option>
                            </select>
                    </div>
                <?php else: ?>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">NIP / ID Kurator</label>
                        <input type="text" name="identitas" value="KRT-2026-001" class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Departemen</label>
                        <input type="text" name="prodi" value="Kurasi Eksekutif Seni Digital" class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                <?php endif; ?>
            </div>

            <div class="border-t border-gray-100 mb-8"></div>

            <h3 class="text-sm font-extrabold text-indigo-950 uppercase tracking-widest mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Keamanan Kata Sandi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password_baru" placeholder="Kosongkan jika tidak ingin diubah" class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 placeholder-gray-400">
                </div>
                <div>
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="konfirmasi_password" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-3 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 placeholder-gray-400">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-3.5 text-xs font-bold text-white bg-indigo-950 hover:bg-indigo-900 rounded-xl tracking-tight transition-all shadow-sm flex items-center gap-2 cursor-pointer hover:-translate-y-1">
                    Simpan Perubahan
                </button>
            </div>

        </form>
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
</script>