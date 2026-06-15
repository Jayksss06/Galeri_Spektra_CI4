<div id="register-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">

    <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl relative p-8">

        <button onclick="document.getElementById('register-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-indigo-950"><?= esc($header) ?></h1>
            <p class="text-xs text-gray-500 mt-2"><?= esc($subtitle) ?></p>
        </div>

        <?php if (session()->has('errors')): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-xs border border-red-100">
                <strong class="font-bold block mb-1">Registrasi Gagal:</strong>
                <ul class="list-disc pl-5">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="flex flex-col gap-4">

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required value="<?= old('nama_lengkap') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2"><?= esc($label_id) ?></label>
                <input type="text" name="identitas" placeholder="<?= esc($place_id) ?>" required value="<?= old('identitas') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <?php if ($tipe == 'mahasiswa'): ?>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Program Studi</label>
                    <div class="relative">
                        <select name="id_prodi" required class="appearance-none w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                            <option value="" disabled <?= empty(old('id_prodi')) ? 'selected' : '' ?>>Pilih Program Studi</option>
                            <option value="1" <?= old('id_prodi') == '1' ? 'selected' : '' ?>>Teknologi Rekayasa Multimedia</option>
                            <option value="2" <?= old('id_prodi') == '2' ? 'selected' : '' ?>>Desain Grafis</option>
                            <option value="3" <?= old('id_prodi') == '3' ? 'selected' : '' ?>>Fotografi</option>
                            <option value="4" <?= old('id_prodi') == '4' ? 'selected' : '' ?>>Animasi</option>
                            <option value="5" <?= old('id_prodi') == '5' ? 'selected' : '' ?>>Penerbitan</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Email Institusi</label>
                <input type="email" name="email" placeholder="<?= esc($place_email) ?>" required value="<?= old('email') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2">Daftar Sekarang</button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Sudah punya akun? <a href="<?= esc($link_login) ?>" class="text-indigo-600 font-bold hover:underline">Masuk</a>
        </div>
    </div>
</div>