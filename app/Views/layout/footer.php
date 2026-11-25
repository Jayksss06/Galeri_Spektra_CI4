        </main>

        <footer class="py-8 text-center text-[11px] font-medium text-gray-400 border-t border-gray-100 bg-white w-full mt-auto">
            &copy; <?= date('Y') ?> Galeri Spektra Polimedia. Seluruh Hak Cipta Dilindungi.
        </footer>
    </div>

    <!-- Modal Pemilihan Role Login -->
    <div id="loginSelectionModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 text-center">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" onclick="closeAllModals()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-xl font-bold text-indigo-950 mb-2">Masuk ke Sistem</h2>
            <p class="text-xs text-gray-500 mb-6">Pilih portal akses sesuai peran Anda di Galeri Spektra.</p>

            <?php if (session()->has('error') && session('modal_open') === 'loginSelectionModal'): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-5 text-xs text-center border border-red-100 font-medium">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-2 gap-4">
                <button type="button" class="p-6 border border-gray-200 rounded-2xl hover:border-indigo-500 hover:bg-indigo-50 transition cursor-pointer flex flex-col items-center" onclick="switchModal('loginMahasiswaModal')">
                    <span class="text-3xl mb-2">🎓</span>
                    <span class="text-sm font-bold text-indigo-950">Mahasiswa</span>
                    <span class="text-[10px] text-gray-400 mt-1">Kreator Karya</span>
                </button>
                <button type="button" class="p-6 border border-gray-200 rounded-2xl hover:border-orange-500 hover:bg-orange-50 transition cursor-pointer flex flex-col items-center" onclick="switchModal('loginAdminModal')">
                    <span class="text-3xl mb-2">🛡️</span>
                    <span class="text-sm font-bold text-indigo-950">Kurator</span>
                    <span class="text-[10px] text-gray-400 mt-1">Dosen Pengelola</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Login Mahasiswa -->
    <div id="loginMahasiswaModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 border-t-4 border-indigo-500">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" onclick="closeAllModals()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-950">Login Mahasiswa</h2>
                <p class="text-xs text-gray-500 mt-1">Digital Curator Student Access</p>
            </div>

            <?php if (session()->has('pesan_sukses') && session('modal_open') === 'loginMahasiswaModal'): ?>
                <div class="bg-green-50 text-green-600 p-3 rounded-xl mb-4 text-xs text-center border border-green-100 font-medium">
                    <?= esc(session('pesan_sukses')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error') && session('modal_open') === 'loginMahasiswaModal'): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs text-center border border-red-100 font-medium">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST" class="flex flex-col gap-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Institusi</label>
                    <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@polimedia.ac.id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2 cursor-pointer">Masuk</button>
            </form>
            <div class="mt-4 text-center text-xs text-gray-600">
                Belum memiliki akses? <button type="button" onclick="switchModal('registerMahasiswaModal')" class="text-indigo-600 font-bold hover:underline cursor-pointer">Daftar Akun Baru</button>
            </div>
        </div>
    </div>

    <!-- Modal Login Kurator / Admin (Tanpa Registrasi Publik) -->
    <div id="loginAdminModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative p-8 border-t-4 border-orange-500">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" onclick="closeAllModals()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-950">Login Kurator</h2>
                <p class="text-xs text-gray-500 mt-1">Portal Evaluasi & Kurasi Dosen Pengelola</p>
            </div>

            <?php if (session()->has('pesan_sukses') && session('modal_open') === 'loginAdminModal'): ?>
                <div class="bg-green-50 text-green-600 p-3 rounded-xl mb-4 text-xs text-center border border-green-100 font-medium">
                    <?= esc(session('pesan_sukses')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error') && session('modal_open') === 'loginAdminModal'): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs text-center border border-red-100 font-medium">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login-admin') ?>" method="POST" class="flex flex-col gap-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Kurator</label>
                    <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="kurator@polimedia.ac.id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500">
                </div>
                <button type="submit" class="w-full py-3.5 bg-orange-600 text-white rounded-xl text-sm font-bold hover:bg-orange-700 transition-colors mt-2 cursor-pointer">Masuk sebagai Kurator</button>
            </form>
            <div class="mt-5 pt-4 border-t border-gray-100 text-center text-[11px] text-gray-400 leading-relaxed">
                Akun Kurator dikelola secara internal oleh pengelola Galeri Spektra Polimedia.
            </div>
        </div>
    </div>

    <!-- Modal Registrasi Mahasiswa -->
    <div id="registerMahasiswaModal" class="auth-modal fixed inset-0 z-[9999] items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">
        <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl relative p-8 border-t-4 border-indigo-500">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" onclick="closeAllModals()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-600">Registrasi Mahasiswa</h2>
                <p class="text-xs text-gray-500 mt-1">Buat akun kreator menggunakan identitas akademik Polimedia</p>
            </div>

            <?php if (session()->has('errors') && session('modal_open') === 'registerMahasiswaModal'): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-xs border border-red-100">
                    <ul class="list-disc pl-5 m-0 space-y-1">
                        <?php foreach (session('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST" class="flex flex-col gap-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required minlength="3" maxlength="150" value="<?= esc(old('nama_lengkap')) ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">NIM</label>
                    <input type="text" name="identitas" required minlength="5" maxlength="20" value="<?= esc(old('identitas')) ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Program Studi</label>
                    <select name="id_prodi" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 cursor-pointer">
                        <option value="" disabled <?= empty(old('id_prodi')) ? 'selected' : '' ?>>Pilih Program Studi</option>
                        <?php if (! empty($daftar_prodi)): ?>
                            <?php foreach ($daftar_prodi as $prodi): ?>
                                <option value="<?= esc((string) $prodi['id_prodi']) ?>" <?= (string) old('id_prodi') === (string) $prodi['id_prodi'] ? 'selected' : '' ?>>
                                    <?= esc($prodi['nama_prodi']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Institusi</label>
                    <input type="email" name="email" required maxlength="150" value="<?= esc(old('email')) ?>" placeholder="nama@polimedia.ac.id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi <span class="font-normal text-gray-400">(Min. 8 karakter)</span></label>
                    <input type="password" name="password" required minlength="8" maxlength="72" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2 cursor-pointer">Daftar Sekarang</button>
            </form>
            <div class="mt-4 text-center text-xs text-gray-600">
                Sudah punya akun? <button type="button" onclick="switchModal('loginMahasiswaModal')" class="text-indigo-600 font-bold hover:underline cursor-pointer">Masuk</button>
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
                    if (!document.getElementById('mobile-sidebar-overlay')) {
                        const overlay = document.createElement('div');
                        overlay.id = 'mobile-sidebar-overlay';
                        overlay.className = 'fixed inset-0 top-20 bg-gray-900/40 z-30 lg:hidden backdrop-blur-[2px] transition-all cursor-pointer';
                        overlay.onclick = toggleGlobalSidebar;
                        document.body.appendChild(overlay);
                    }
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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllModals();
            }
        });

        function catatKunjunganKarya(idKarya, elemenCounterId) {
            if (!idKarya) return;
            const csrfHeaderMeta = document.querySelector('meta[name="csrf-header"]');
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const headers = { 'X-Requested-With': 'XMLHttpRequest' };
            if (csrfHeaderMeta && csrfTokenMeta) {
                headers[csrfHeaderMeta.content] = csrfTokenMeta.content;
            }

            fetch('<?= base_url('galeri/lihat') ?>/' + encodeURIComponent(idKarya), {
                method: 'POST',
                headers: headers
            })
            .then(res => res.ok ? res.json() : null)
            .then(json => {
                if (json && json.success && typeof json.views === 'number') {
                    if (elemenCounterId) {
                        const targetEl = document.getElementById(elemenCounterId);
                        if (targetEl) targetEl.textContent = json.views + ' dilihat';
                    }
                    const cardBadge = document.getElementById('card-views-' + idKarya);
                    if (cardBadge) cardBadge.textContent = json.views;
                }
            })
            .catch(() => {});
        }

        <?php if (session()->has('modal_open')): ?>
            document.addEventListener("DOMContentLoaded", function() {
                switchModal('<?= esc(session('modal_open'), 'js') ?>');
            });
        <?php endif; ?>
    </script>
</body>

</html>
