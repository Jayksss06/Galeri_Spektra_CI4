<?php
$oldJenis    = (string) old('jenis_karya');
$oldKategori = (string) old('tipe_karya');
?>

<div class="mb-12 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="0">
    <h1 class="text-4xl font-extrabold text-indigo-950 tracking-tight leading-none mb-2">Ajukan Karya Baru</h1>
    <p class="text-xs text-gray-500 max-w-2xl">Publikasikan karya terbaikmu di Galeri Spektra Polimedia dan jadilah bagian dari kurasi digital maupun pameran ruang fisik terpilih.</p>
</div>

<form action="<?= base_url('dashboard/simpan-karya') ?>" method="POST" enctype="multipart/form-data" id="form-pengajuan" class="grid grid-cols-1 md:grid-cols-3 gap-8 opacity-0 translate-y-4 transition-all duration-700 ease-out" data-anim data-delay="150">
    <?= csrf_field() ?>

    <div class="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col justify-between">
        <div class="space-y-6">

            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Judul Karya</label>
                <input type="text" name="judul_karya" value="<?= esc(old('judul_karya')) ?>" minlength="3" maxlength="255" placeholder="Masukkan judul project Anda..." required
                    class="w-full px-4 py-3.5 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all text-gray-800 placeholder-gray-400">
            </div>

            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Deskripsi Konsep & Teknis</label>
                <textarea name="deskripsi" rows="5" minlength="15" maxlength="5000" placeholder="Ceritakan konsep, pesan artistik, dan proses teknis di balik karya Anda (min. 15 karakter)..." required
                    class="w-full px-4 py-3.5 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all text-gray-800 placeholder-gray-400 resize-none"><?= esc(old('deskripsi')) ?></textarea>
                <span class="block text-[9px] text-gray-400 mt-1.5 font-medium">Pastikan deskripsi mencakup aspek teknis dan filosofis karya.</span>
            </div>

            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Jenis Karya</label>
                <div class="flex flex-wrap gap-6 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="jenis_karya" value="DIGITAL" <?= $oldJenis === 'DIGITAL' ? 'checked' : '' ?> onchange="aktifkanFormSpesifik(this.value)" required class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer">
                        <span class="ml-2 text-xs font-bold text-gray-700">Digital (Desain, UI/UX, Video, Game, dll)</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="jenis_karya" value="FISIK" <?= $oldJenis === 'FISIK' ? 'checked' : '' ?> onchange="aktifkanFormSpesifik(this.value)" required class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer">
                        <span class="ml-2 text-xs font-bold text-gray-700">Fisik (Instalasi, Maket, Kanvas, Kriya, dll)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Kategori Spesifik</label>
                <div class="relative">
                    <select name="tipe_karya" id="kategori_dinamis" required disabled class="appearance-none w-full px-4 py-3.5 text-xs bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-300 transition-all text-gray-800 cursor-pointer font-medium disabled:opacity-60 disabled:cursor-not-allowed">
                        <option value="" disabled selected hidden>Pilih Jenis Karya terlebih dahulu...</option>
                    </select>
                    <span class="absolute bottom-3.5 right-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div id="form-tautan-digital" class="hidden space-y-4 bg-blue-50/50 p-6 rounded-2xl border border-blue-100 transition-all duration-300 mt-4">
                <h4 class="text-[11px] font-extrabold text-blue-950 uppercase tracking-widest border-b border-blue-200 pb-2">Akses Berkas Karya Digital</h4>
                <p class="text-xs text-gray-500 font-medium leading-relaxed">Untuk karya digital (Video, Animasi, UI/UX, Game, atau Desain Resolusi Penuh), unggah berkas utama ke platform eksternal (YouTube, Google Drive, Itch.io, Figma) dan masukkan tautannya di bawah.<br><br><strong>Catatan:</strong> Kotak unggah berkas di sisi kanan tetap wajib diisi sebagai Poster / Cuplikan Layar (Thumbnail) galeri.</p>

                <div class="mt-4">
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Tautan Eksternal (URL https://)</label>
                    <input type="url" name="tautan_karya" value="<?= esc(old('tautan_karya')) ?>" placeholder="Contoh: https://www.figma.com/file/..." class="w-full px-4 py-3 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-blue-300 transition-all text-gray-800 font-medium placeholder-gray-300">
                </div>
            </div>

            <div id="form-proposal-fisik" class="hidden space-y-5 bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100 transition-all duration-300 mt-4">
                <h4 class="text-[11px] font-extrabold text-indigo-950 uppercase tracking-widest border-b border-indigo-200 pb-2">Spesifikasi Proposal Logistik Karya Fisik</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Dimensi (P x L x T cm)</label>
                        <input type="text" name="dimensi_karya" value="<?= esc(old('dimensi_karya')) ?>" placeholder="Contoh: 120 x 80 x 50 cm" class="w-full px-4 py-3 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Material / Media</label>
                        <input type="text" name="material_media" value="<?= esc(old('material_media')) ?>" placeholder="Contoh: Kayu Jati, Cat Akrilik" class="w-full px-4 py-3 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Kebutuhan Display Ruangan</label>
                    <textarea name="kebutuhan_display" rows="3" placeholder="Contoh: Butuh pedestal 1x1 meter dan sumber listrik 220V..." class="w-full px-4 py-3 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-300 transition-all text-gray-800 font-medium leading-relaxed resize-none"><?= esc(old('kebutuhan_display')) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-indigo-100">
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Estimasi Total Anggaran (RAB)</label>
                        <input type="text" name="estimasi_biaya" value="<?= esc(old('estimasi_biaya')) ?>" placeholder="Contoh: Rp 2.500.000" class="w-full px-4 py-3 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-300 transition-all text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-extrabold text-gray-700 tracking-wider uppercase mb-2">Unggah Berkas RAB (PDF/Excel, Maks 10MB)</label>
                        <input type="file" name="file_rab" accept=".pdf,.xls,.xlsx" class="w-full px-4 py-2 text-xs bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-300 transition-all text-gray-800 font-medium file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">

                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-[9px] text-gray-400 font-medium">Bingung formatnya?</span>
                            <a href="<?= base_url('assets/docs/Template_RAB_Spektra.xlsx') ?>" download class="text-[9px] font-bold text-orange-500 hover:text-orange-600 underline underline-offset-2 transition-colors">
                                Unduh Templat Acuan RAB
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 space-y-4">
                <label class="block text-[10px] font-extrabold text-indigo-950 uppercase tracking-wider mb-1">Persetujuan & Legalitas Pameran</label>

                <label class="flex items-start cursor-pointer group">
                    <input type="checkbox" name="pakta_integritas" value="1" required class="mt-0.5 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                    <span class="ml-3 text-xs text-gray-600 font-medium leading-relaxed group-hover:text-gray-900 transition-colors">
                        <strong class="text-indigo-950 font-bold">Pakta Integritas:</strong> Saya menyatakan bahwa karya ini merupakan karya asli ciptaan saya sendiri, tidak mengandung unsur plagiarisme, dan tidak melanggar Hak Kekayaan Intelektual (HKI) pihak mana pun.
                    </span>
                </label>

                <label class="flex items-start cursor-pointer group">
                    <input type="checkbox" name="izin_publikasi" value="1" required class="mt-0.5 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                    <span class="ml-3 text-xs text-gray-600 font-medium leading-relaxed group-hover:text-gray-900 transition-colors">
                        <strong class="text-indigo-950 font-bold">Izin Publikasi Dokumentasi:</strong> Saya memberikan izin non-komersial kepada pengelola Galeri Spektra Polimedia untuk mendokumentasikan, mereproduksi visual, dan mempublikasikan karya ini dalam katalog pameran fisik maupun arsip digital institusi.
                    </span>
                </label>
            </div>

        </div>

        <button type="submit" class="w-full mt-8 py-4 text-xs font-bold text-white bg-indigo-950 hover:bg-indigo-900 rounded-2xl tracking-tight transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer hover:-translate-y-1">
            Kirim Pengajuan Ke Kurator
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
            </svg>
        </button>
    </div>

    <div class="space-y-8">

        <div id="dropzone" class="border-2 border-dashed border-gray-300 bg-white hover:bg-gray-50 hover:border-indigo-400 rounded-3xl p-8 flex flex-col items-center justify-center h-[280px] text-center transition-all cursor-pointer group">
            <div id="dropzone-icon" class="p-4 bg-orange-50 rounded-2xl mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
            </div>
            <p id="dropzone-text" class="text-xs font-bold text-gray-900 mb-1.5">Seret & Lepas Poster / Cuplikan Karya</p>
            <p class="text-[10px] text-gray-400 max-w-xs leading-relaxed mb-6 px-4">Maksimum ukuran 5 MB. Format wajib: JPG, JPEG, atau PNG.</p>

            <input type="file" name="file_karya" id="file-input" class="hidden" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            <button type="button" onclick="document.getElementById('file-input').click()" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded-xl tracking-tight transition shadow-sm cursor-pointer">
                Pilih File Manual
            </button>
        </div>

        <div class="bg-indigo-950 border border-indigo-950 rounded-3xl p-8 text-white shadow-sm flex flex-col justify-center min-h-[200px] relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2 bg-indigo-900/50 border border-indigo-800/50 rounded-xl text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2 2 2 0 01-2-2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </span>
                    <h2 class="text-xs font-extrabold tracking-tight">Tips Lolos Kurasi</h2>
                </div>
                <p class="text-[11px] text-indigo-200 leading-relaxed">Gunakan poster rasio lanskap/persegi beresolusi tajam (min. lebar 1200px) dan jelaskan latar belakang riset kreatif Anda secara ringkas namun padat.</p>
            </div>
        </div>

    </div>
</form>

<script>
    const dataKategori = {
        DIGITAL: <?= json_encode($kategori_digital ?? [], JSON_UNESCAPED_UNICODE) ?>,
        FISIK: <?= json_encode($kategori_fisik ?? [], JSON_UNESCAPED_UNICODE) ?>
    };

    const initialJenis = '<?= esc($oldJenis, 'js') ?>';
    const initialKategori = '<?= esc($oldKategori, 'js') ?>';

    function aktifkanFormSpesifik(jenis, preselectedKategori = '') {
        const selectKategori = document.getElementById('kategori_dinamis');
        const formFisik = document.getElementById('form-proposal-fisik');
        const formDigital = document.getElementById('form-tautan-digital');

        if (!dataKategori[jenis]) return;

        selectKategori.removeAttribute('disabled');
        selectKategori.innerHTML = '<option value="" disabled selected hidden>Pilih Kategori Spesifik...</option>';

        dataKategori[jenis].forEach(kategori => {
            const option = document.createElement('option');
            option.value = kategori;
            option.textContent = kategori;
            if (preselectedKategori && preselectedKategori === kategori) {
                option.selected = true;
            }
            selectKategori.appendChild(option);
        });

        if (jenis === 'FISIK') {
            formDigital.classList.add('hidden');
            formDigital.querySelectorAll('input').forEach(i => i.removeAttribute('required'));

            formFisik.classList.remove('hidden');
            formFisik.querySelectorAll('input, textarea').forEach(input => {
                if (input.name !== 'estimasi_biaya' && input.name !== 'file_rab') {
                    input.setAttribute('required', 'required');
                }
            });
        } else if (jenis === 'DIGITAL') {
            formFisik.classList.add('hidden');
            formFisik.querySelectorAll('input, textarea').forEach(i => i.removeAttribute('required'));

            formDigital.classList.remove('hidden');
            formDigital.querySelectorAll('input').forEach(i => i.setAttribute('required', 'required'));
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        if (initialJenis === 'DIGITAL' || initialJenis === 'FISIK') {
            aktifkanFormSpesifik(initialJenis, initialKategori);
        }

        setTimeout(() => {
            document.querySelectorAll('[data-anim]').forEach(el => {
                setTimeout(() => {
                    el.classList.remove('opacity-0', 'translate-y-4');
                    el.classList.add('opacity-100', 'translate-y-0');
                }, parseInt(el.getAttribute('data-delay')) || 0);
            });
        }, 100);

        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file-input');
        const dropzoneText = document.getElementById('dropzone-text');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('border-indigo-500', 'bg-indigo-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                updateDropzoneText(files[0]);
            }
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                updateDropzoneText(this.files[0]);
            }
        });

        function updateDropzoneText(file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file poster melebihi batas maksimum 5 MB!');
                fileInput.value = '';
                dropzoneText.textContent = 'Seret & Lepas Poster / Cuplikan Karya';
                dropzoneText.classList.remove('text-indigo-600');
                return;
            }
            dropzoneText.textContent = 'File Terpilih: ' + file.name;
            dropzoneText.classList.add('text-indigo-600');
        }

        document.getElementById('form-pengajuan').addEventListener('submit', function(e) {
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Mohon unggah file Poster / Cuplikan Karya Anda terlebih dahulu pada area yang disediakan!');
                dropzone.classList.add('border-red-400', 'bg-red-50');
                setTimeout(() => dropzone.classList.remove('border-red-400', 'bg-red-50'), 2000);
            }
        });
    });
</script>
