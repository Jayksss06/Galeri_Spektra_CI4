<div id="login-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-indigo-950/80 backdrop-blur-sm p-4 hidden">

    <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl relative p-8">

        <button onclick="document.getElementById('login-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="text-center mb-8">
            <img src="<?= base_url('assets/img/logo-spektra.png') ?>" alt="Galeri Spektra" class="h-12 mx-auto mb-4">
            <h1 class="text-2xl font-extrabold text-indigo-950">Galeri Spektra Polimedia</h1>
            <p class="text-xs text-gray-500 mt-2"><?= esc($subtitle) ?></p>
        </div>

        <?php if (session()->has('pesan')): ?>
            <div class="bg-green-50 text-green-600 p-3 rounded-xl mb-6 text-xs text-center border border-green-100 font-medium">
                <?= esc(session('pesan')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-6 text-xs text-center border border-red-100 font-medium">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login/process') ?>" method="POST" class="flex flex-col gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2"><?= esc($label_email) ?></label>
                <input type="email" name="email" placeholder="<?= esc($placeholder_email) ?>" required value="<?= old('email') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-bold text-gray-700">Password</label>
                    <a href="#" class="text-[10px] text-indigo-600 font-bold hover:underline">Lupa Sandi?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <button type="submit" class="w-full py-3.5 bg-indigo-950 text-white rounded-xl text-sm font-bold hover:bg-indigo-900 transition-colors mt-2">Masuk &rarr;</button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            <?= str_replace('Daftar Akun Baru', '<a href="' . esc($link_register) . '" class="text-indigo-600 font-bold hover:underline">Daftar Akun Baru</a>', esc($teks_daftar)) ?>
        </div>
    </div>
</div>