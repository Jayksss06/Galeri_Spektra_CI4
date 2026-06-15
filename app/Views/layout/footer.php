</main>

<footer class="py-8 text-center text-[11px] font-medium text-gray-400 border-t border-gray-100 bg-white w-full mt-auto">
    &copy; <?= date('Y') ?> Galeri Spektra Polimedia. Seluruh Hak Cipta Dilindungi.
</footer>
</div>
<div id="loginSelectionModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 text-center">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" onclick="closeAllModals()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="text-xl font-bold text-indigo-950 mb-6">Masuk ke Sistem</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-6 border border-gray-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition cursor-pointer flex flex-col items-center" onclick="switchModal('loginMahasiswaModal')">
                <div class="text-3xl mb-2">🎓</div>
                <h3 class="text-sm font-bold text-indigo-950">Mahasiswa</h3>
            </div>
            <div class="p-6 border border-gray-200 rounded-2xl hover:border-orange-500 hover:bg-orange-50 transition cursor-pointer flex flex-col items-center" onclick="switchModal('loginAdminModal')">
                <div class="text-3xl mb-2">🛡️</div>
                <h3 class="text-sm font-bold text-indigo-950">Kurator</h3>
            </div>
        </div>
    </div>
</div>

<div id="loginMahasiswaModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 border-t-4 border-indigo-500">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" onclick="closeAllModals()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-950">Login Mahasiswa</h2>
            <p class="text-xs text-gray-500 mt-1">Digital Curator Student Access</p>
        </div>

        <?php if (session()->has('pesan_sukses') && session('modal_open') == 'loginMahasiswaModal'): ?>
            <div class="bg-green-50 text-green-600 p-3 rounded-xl mb-4 text-xs text-center border border-green-100 font-medium">
                <?= esc(session('pesan_sukses')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error') && session('modal_open') == 'loginMahasiswaModal'): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs text-center border border-red-100 font-medium">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="POST" class="flex flex-col gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email Institusi</label>
                <input type="email" name="email" placeholder="NIM@polimedia.ac.id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2">Masuk</button>
        </form>
        <div class="mt-4 text-center text-xs text-gray-600">
            Belum memiliki akses? <a href="javascript:void(0)" onclick="switchModal('registerMahasiswaModal')" class="text-indigo-600 font-bold hover:underline">Daftar Akun Baru</a>
        </div>
    </div>
</div>

<div id="loginAdminModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 border-t-4 border-orange-500">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" onclick="closeAllModals()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-950">Login Admin</h2>
            <p class="text-xs text-gray-500 mt-1">Digital Curator Admin Access</p>
        </div>

        <?php if (session()->has('pesan_sukses') && session('modal_open') == 'loginAdminModal'): ?>
            <div class="bg-green-50 text-green-600 p-3 rounded-xl mb-4 text-xs text-center border border-green-100 font-medium">
                <?= esc(session('pesan_sukses')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error') && session('modal_open') == 'loginAdminModal'): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs text-center border border-red-100 font-medium">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login-admin') ?>" method="POST" class="flex flex-col gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email Admin</label>
                <input type="email" name="email" placeholder="admin@polimedia.ac.id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <button type="submit" class="w-full py-3.5 bg-orange-600 text-white rounded-xl text-sm font-bold hover:bg-orange-700 transition-colors mt-2">Masuk</button>
        </form>
        <div class="mt-4 text-center text-xs text-gray-600">
            Belum memiliki akses admin? <a href="javascript:void(0)" onclick="switchModal('registerAdminModal')" class="text-orange-600 font-bold hover:underline">Daftar Akun Baru</a>
        </div>
    </div>
</div>

<div id="registerMahasiswaModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl relative p-8 border-t-4 border-indigo-500">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" onclick="closeAllModals()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-600">Registrasi Mahasiswa</h2>
        </div>

        <?php if (session()->has('errors') && session('modal_open') == 'registerMahasiswaModal'): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-xs border border-red-100">
                <ul class="list-disc pl-5 m-0">
                    <?php foreach (session('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="POST" class="flex flex-col gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required value="<?= old('nama_lengkap') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">NIM</label>
                <input type="text" name="identitas" required value="<?= old('identitas') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Program Studi</label>
                <select name="id_prodi" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 cursor-pointer">
                    <option value="" disabled <?= empty(old('id_prodi')) ? 'selected' : '' ?>>Pilih Program Studi</option>
                    <option value="1" <?= old('id_prodi') == '1' ? 'selected' : '' ?>>Teknologi Rekayasa Multimedia</option>
                    <option value="2" <?= old('id_prodi') == '2' ? 'selected' : '' ?>>Desain Grafis</option>
                    <option value="3" <?= old('id_prodi') == '3' ? 'selected' : '' ?>>Fotografi</option>
                    <option value="4" <?= old('id_prodi') == '4' ? 'selected' : '' ?>>Animasi</option>
                    <option value="5" <?= old('id_prodi') == '5' ? 'selected' : '' ?>>Penerbitan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email Institusi</label>
                <input type="email" name="email" required value="<?= old('email') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2">Daftar Sekarang</button>
        </form>
        <div class="mt-4 text-center text-xs text-gray-600">
            Sudah punya akun? <a href="javascript:void(0)" onclick="switchModal('loginMahasiswaModal')" class="text-indigo-600 font-bold hover:underline">Masuk</a>
        </div>
    </div>
</div>

<div id="registerAdminModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
    <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl relative p-8 border-t-4 border-orange-500">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" onclick="closeAllModals()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-orange-600">Registrasi Pengelola</h2>
        </div>

        <?php if (session()->has('errors') && session('modal_open') == 'registerAdminModal'): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-xs border border-red-100">
                <ul class="list-disc pl-5 m-0">
                    <?php foreach (session('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register-admin') ?>" method="POST" class="flex flex-col gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required value="<?= old('nama_lengkap') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">NIP / ID Pengelola</label>
                <input type="text" name="identitas" required value="<?= old('identitas') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email Institusi</label>
                <input type="email" name="email" required value="<?= old('email') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
            </div>
            <button type="submit" class="w-full py-3.5 bg-orange-600 text-white rounded-xl text-sm font-bold hover:bg-orange-700 transition-colors mt-2">Daftar Pengelola</button>
        </form>
        <div class="mt-4 text-center text-xs text-gray-600">
            Sudah punya akun? <a href="javascript:void(0)" onclick="switchModal('loginAdminModal')" class="text-orange-600 font-bold hover:underline">Masuk</a>
        </div>
    </div>
</div>

<script>
    function toggleGlobalSidebar() {
        const sidebar = document.getElementById('global-sidebar');
        const mainWrapper = document.getElementById('main-wrapper');
        sidebar.classList.toggle('-translate-x-full');

        if (window.innerWidth >= 1024) {
            mainWrapper.classList.toggle('lg:ml-72');
        } else {
            if (!sidebar.classList.contains('-translate-x-full')) {
                let overlay = document.createElement('div');
                overlay.id = 'mobile-sidebar-overlay';
                overlay.className = 'fixed inset-0 top-20 bg-gray-900/40 z-30 lg:hidden backdrop-blur-[2px] transition-all cursor-pointer';
                overlay.onclick = toggleGlobalSidebar;
                document.body.appendChild(overlay);
            } else {
                const overlay = document.getElementById('mobile-sidebar-overlay');
                if (overlay) overlay.remove();
            }
        }
    }

    function toggleGlobalProfil() {
        const dropdown = document.getElementById('global-profil-dropdown');
        if (dropdown) dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('global-profil-dropdown');
        const button = document.querySelector('[onclick="toggleGlobalProfil()"]');
        if (dropdown && button && !button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function closeAllModals() {
        document.querySelectorAll('.auth-modal').forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        document.body.style.overflow = 'auto'; 
    }

    function openLoginModal() {
        closeAllModals();
        const target = document.getElementById('loginSelectionModal');
        if (target) {
            target.classList.remove('hidden');
            target.classList.add('flex');
            document.body.style.overflow = 'hidden'; 
        }
    }

    function switchModal(targetModalId) {
        closeAllModals();
        const target = document.getElementById(targetModalId);
        if (target) {
            target.classList.remove('hidden');
            target.classList.add('flex');
            document.body.style.overflow = 'hidden'; 
        }
    }

    
    document.querySelectorAll('.auth-modal').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeAllModals();
        });
    });

    <?php if (session()->has('modal_open')): ?>
        document.addEventListener("DOMContentLoaded", function() {
            switchModal('<?= esc(session('modal_open'), 'js') ?>');
        });
    <?php endif; ?>
</script>
</body>

</html>