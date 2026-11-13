@extends('layouts.app')

@section('title', 'Laporan Insiden (CRUD AJAX)')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold mb-2">
                <i class="fas fa-bolt text-blue-600"></i> Modul HMVC 2 &bull; Asynchronous (AJAX) CRUD &bull; File Upload
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Laporan Insiden Lalu Lintas</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Pengelolaan pelaporan insiden darurat dan kerusakan jalan via <strong>AJAX tanpa reload</strong> dengan upload berkas yang dapat dibuka kembali.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" id="openAddModalBtn" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Laporan (AJAX)
            </button>
        </div>
    </div>

    <!-- Alert / Toast Container -->
    <div id="alertContainer" class="hidden mb-6"></div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="text-xs sm:text-sm font-extrabold text-gray-700 uppercase tracking-wider">
                Total Laporan:
            </span>
            <span id="totalBadge" class="px-2.5 py-0.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                0
            </span>
        </div>

        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-search text-sm"></i>
            </div>
            <input type="search" id="liveSearchInput" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition" placeholder="Cari pelapor, jalan, kategori...">
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporanTable">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Pelapor & Kontak</th>
                        <th class="py-3.5 px-4">Lokasi Kejadian</th>
                        <th class="py-3.5 px-4">Kategori & Tingkat</th>
                        <th class="py-3.5 px-4">Bukti Berkas</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4 text-right">Aksi AJAX</th>
                    </tr>
                </thead>
                <tbody id="laporanTableBody" class="divide-y divide-gray-100 text-xs sm:text-sm">
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <div class="inline-flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-spinner fa-spin text-orange-600"></i> Memuat data via AJAX...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Form (Tambah & Edit AJAX) -->
<div id="laporanModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all p-6 sm:p-8 relative">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600" id="modalSubtitle">Form Pengelolaan AJAX</span>
                <h3 class="text-xl font-extrabold text-gray-900 tracking-tight" id="modalTitle">Tambah Laporan Insiden</h3>
            </div>
            <button type="button" id="closeModalBtn" class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="laporanForm" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="id" id="laporanId">
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pelapor" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Pelapor <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <input type="text" id="nama_pelapor" name="nama_pelapor" placeholder="Contoh: Budi Santoso"
                                class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
                        </div>
                        <p class="text-xs text-red-600 mt-1 hidden" id="error_nama_pelapor"></p>
                    </div>

                    <div>
                        <label for="kontak_pelapor" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            No. HP / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-phone text-xs"></i>
                            </div>
                            <input type="tel" id="kontak_pelapor" name="kontak_pelapor" placeholder="Contoh: 081234567890"
                                class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
                        </div>
                        <p class="text-xs text-red-600 mt-1 hidden" id="error_kontak_pelapor"></p>
                    </div>
                </div>

                <div>
                    <label for="lokasi_jalan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Lokasi / Ruas Jalan Kejadian <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-map-pin text-xs"></i>
                        </div>
                        <input type="text" id="lokasi_jalan" name="lokasi_jalan" placeholder="Contoh: Jl. Dr. Djunjunan Depan BTC Mall"
                            class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
                    </div>
                    <p class="text-xs text-red-600 mt-1 hidden" id="error_lokasi_jalan"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori_insiden" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kategori Insiden <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori_insiden" name="kategori_insiden"
                            class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kemacetan Parah">Kemacetan Parah</option>
                            <option value="Kecelakaan Lalu Lintas">Kecelakaan Lalu Lintas</option>
                            <option value="Pohon Tumbang">Pohon Tumbang</option>
                            <option value="Jalan Berlubang / Rusak">Jalan Berlubang / Rusak</option>
                            <option value="Lampu Merah Mati">Lampu Merah Mati</option>
                            <option value="Banjir / Genangan Air">Banjir / Genangan Air</option>
                        </select>
                        <p class="text-xs text-red-600 mt-1 hidden" id="error_kategori_insiden"></p>
                    </div>

                    <div>
                        <label for="tingkat_keparahan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Tingkat Keparahan <span class="text-red-500">*</span>
                        </label>
                        <select id="tingkat_keparahan" name="tingkat_keparahan"
                            class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
                            <option value="">-- Pilih Keparahan --</option>
                            <option value="Rendah">Rendah (Lancar Terkendali)</option>
                            <option value="Sedang">Sedang (Perlambatan Jalur)</option>
                            <option value="Tinggi">Tinggi (Macet Panjang)</option>
                            <option value="Kritis">Kritis (Jalan Tertutup / Darurat)</option>
                        </select>
                        <p class="text-xs text-red-600 mt-1 hidden" id="error_tingkat_keparahan"></p>
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Keterangan Insiden / Kronologi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Jelaskan kondisi detail kejadian di lapangan..."
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition"></textarea>
                    <p class="text-xs text-red-600 mt-1 hidden" id="error_keterangan"></p>
                </div>

                <!-- Input Upload Berkas Bukti (Dapat dibuka kembali) -->
                <div>
                    <label for="berkasInput" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Upload Bukti Berkas / Foto / Dokumen <span class="text-red-500" id="berkasRequiredStar">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 hover:border-orange-300 rounded-2xl p-4 bg-gray-50/50 text-center transition">
                        <i class="fas fa-cloud-arrow-up text-2xl text-orange-500 mb-2"></i>
                        <input type="file" id="berkasInput" name="berkas" accept="image/jpeg,image/png,image/jpg,application/pdf"
                            class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 cursor-pointer">
                        <p class="text-[11px] text-gray-400 mt-2">Mendukung file JPG, PNG, atau PDF (Maksimal 2 MB).</p>
                    </div>
                    <div id="currentFileContainer" class="hidden mt-2 p-3 bg-orange-50 border border-orange-200 rounded-xl text-xs flex items-center justify-between">
                        <div class="flex items-center gap-2 truncate">
                            <i class="fas fa-file-lines text-orange-600"></i>
                            <span class="text-gray-700 truncate" id="currentFileName">file.jpg</span>
                        </div>
                        <a href="#" id="currentFileLink" target="_blank" class="px-2.5 py-1 bg-white hover:bg-orange-600 hover:text-white text-orange-700 border border-orange-200 rounded-lg font-bold text-[11px] transition shadow-sm flex-shrink-0">
                            <i class="fas fa-arrow-up-right-from-square"></i> Buka Berkas
                        </a>
                    </div>
                    <p class="text-xs text-red-600 mt-1 hidden" id="error_berkas"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                <button type="button" id="cancelModalBtn" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition">
                    Batal
                </button>
                <button type="submit" id="saveSubmitBtn" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition inline-flex items-center gap-2">
                    <span id="btnSpinner" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
                    <span id="btnText">Simpan Laporan (AJAX)</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('laporanTableBody');
    const totalBadge = document.getElementById('totalBadge');
    const liveSearchInput = document.getElementById('liveSearchInput');
    const alertContainer = document.getElementById('alertContainer');
    
    const modal = document.getElementById('laporanModal');
    const openAddModalBtn = document.getElementById('openAddModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const form = document.getElementById('laporanForm');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const formMethod = document.getElementById('formMethod');
    const laporanId = document.getElementById('laporanId');
    const berkasRequiredStar = document.getElementById('berkasRequiredStar');
    const currentFileContainer = document.getElementById('currentFileContainer');
    const currentFileName = document.getElementById('currentFileName');
    const currentFileLink = document.getElementById('currentFileLink');
    const saveSubmitBtn = document.getElementById('saveSubmitBtn');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    let allReports = [];

    // Helper: Tampilkan Notifikasi Toast
    function showAlert(type, message) {
        const isSuccess = type === 'success';
        alertContainer.className = `mb-6 p-4 rounded-2xl border flex items-center justify-between text-xs sm:text-sm shadow-sm transition ${
            isSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800'
        }`;
        alertContainer.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="fas ${isSuccess ? 'fa-check-circle text-emerald-600' : 'fa-triangle-exclamation text-red-600'} text-base"></i>
                <span class="font-semibold">${message}</span>
            </div>
            <button type="button" onclick="this.parentElement.classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-sm font-bold">&times;</button>
        `;
        alertContainer.classList.remove('hidden');
        setTimeout(() => alertContainer.classList.add('hidden'), 5000);
    }

    // Reset Form Error Fields
    function clearFormErrors() {
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });
        document.querySelectorAll('#laporanForm input, #laporanForm select, #laporanForm textarea').forEach(el => {
            el.classList.remove('border-red-400', 'ring-2', 'ring-red-100');
        });
    }

    // Buka Modal
    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    // Tutup Modal
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        form.reset();
        clearFormErrors();
        laporanId.value = '';
        currentFileContainer.classList.add('hidden');
    }

    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // Buka Modal Tambah
    openAddModalBtn.addEventListener('click', function () {
        form.reset();
        clearFormErrors();
        laporanId.value = '';
        formMethod.value = 'POST';
        modalTitle.textContent = 'Tambah Laporan Insiden Baru';
        modalSubtitle.textContent = 'Simpan Laporan Real-Time via AJAX';
        berkasRequiredStar.classList.remove('hidden');
        currentFileContainer.classList.add('hidden');
        btnText.textContent = 'Simpan Laporan (AJAX)';
        openModal();
    });

    // Muat Seluruh Data Laporan via AJAX (GET)
    async function loadReports() {
        try {
            const res = await fetch("{{ route('laporaninsiden.data') }}", {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('Gagal memuat data.');
            allReports = await res.json();
            renderTable(allReports);
        } catch (error) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-10 text-center text-red-500 font-semibold">
                        <i class="fas fa-triangle-exclamation mr-1"></i> Terjadi kesalahan saat memuat data via AJAX.
                    </td>
                </tr>
            `;
        }
    }

    // Render Baris Tabel
    function renderTable(data) {
        totalBadge.textContent = data.length;
        if (!data || data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-400">
                        <div class="w-16 h-16 rounded-full bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-2xl mb-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h4 class="font-bold text-gray-700 text-base">Tidak Ada Laporan Insiden</h4>
                        <p class="text-xs text-gray-400 mt-1">Belum ada laporan atau pencarian tidak cocok.</p>
                    </td>
                </tr>
            `;
            return;
        }

        tableBody.innerHTML = data.map((item, index) => {
            const keparahanBadges = {
                'Kritis': 'bg-red-50 text-red-700 border-red-200',
                'Tinggi': 'bg-orange-50 text-orange-700 border-orange-200',
                'Sedang': 'bg-amber-50 text-amber-700 border-amber-200',
                'Rendah': 'bg-emerald-50 text-emerald-700 border-emerald-200'
            };
            const badgeClass = keparahanBadges[item.tingkat_keparahan] || 'bg-gray-50 text-gray-700 border-gray-200';

            const fileButton = item.berkas
                ? `<a href="/storage/${item.berkas}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 rounded-lg text-xs font-bold transition shadow-sm" title="Buka berkas ${item.nama_berkas || ''}">
                    <i class="fas fa-file-arrow-up text-orange-500"></i> Buka Berkas
                   </a>`
                : `<span class="text-xs text-gray-400 italic">Tidak ada berkas</span>`;

            return `
                <tr class="hover:bg-blue-50/30 transition" id="row-${item.id}">
                    <td class="py-3.5 px-4 text-center font-semibold text-gray-400">${index + 1}</td>
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-gray-900">${escapeHtml(item.nama_pelapor)}</div>
                        <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                            <i class="fas fa-phone text-gray-400 text-[10px]"></i> ${escapeHtml(item.kontak_pelapor)}
                        </div>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center gap-1.5 font-medium text-gray-800">
                            <i class="fas fa-location-dot text-orange-500 text-xs"></i> ${escapeHtml(item.lokasi_jalan)}
                        </span>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="font-semibold text-gray-800 text-xs mb-1">${escapeHtml(item.kategori_insiden)}</div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold border ${badgeClass}">
                            ${escapeHtml(item.tingkat_keparahan)}
                        </span>
                    </td>
                    <td class="py-3.5 px-4">
                        ${fileButton}
                    </td>
                    <td class="py-3.5 px-4 text-gray-600 max-w-xs truncate" title="${escapeHtml(item.keterangan)}">
                        ${escapeHtml(item.keterangan)}
                    </td>
                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-1.5">
                            <button type="button" class="edit-btn inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg border border-blue-200 transition" data-id="${item.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="delete-btn inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg border border-red-200 transition" data-id="${item.id}" data-nama="${escapeHtml(item.nama_pelapor)}">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        // Attach Edit & Delete Listeners
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => handleEdit(btn.dataset.id));
        });
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => handleDelete(btn.dataset.id, btn.dataset.nama));
        });
    }

    // Escape HTML to prevent XSS
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Live Client-Side Search
    liveSearchInput.addEventListener('input', function (e) {
        const keyword = e.target.value.toLowerCase().trim();
        if (!keyword) {
            renderTable(allReports);
            return;
        }
        const filtered = allReports.filter(item => 
            (item.nama_pelapor && item.nama_pelapor.toLowerCase().includes(keyword)) ||
            (item.lokasi_jalan && item.lokasi_jalan.toLowerCase().includes(keyword)) ||
            (item.kategori_insiden && item.kategori_insiden.toLowerCase().includes(keyword)) ||
            (item.tingkat_keparahan && item.tingkat_keparahan.toLowerCase().includes(keyword)) ||
            (item.keterangan && item.keterangan.toLowerCase().includes(keyword))
        );
        renderTable(filtered);
    });

    // Form Submit (Tambah / Edit via AJAX)
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearFormErrors();

        const id = laporanId.value;
        const isEdit = Boolean(id);
        const url = isEdit ? `/laporaninsiden/${id}` : "{{ route('laporaninsiden.store') }}";

        const formData = new FormData(form);
        if (isEdit) {
            formData.set('_method', 'PUT');
        }

        // Tampilkan State Loading
        btnSpinner.classList.remove('hidden');
        btnText.textContent = isEdit ? 'Menyimpan Perubahan...' : 'Menyimpan Laporan...';
        saveSubmitBtn.disabled = true;

        try {
            const res = await fetch(url, {
                method: 'POST', // Menggunakan POST dengan _method=PUT jika update (standar multipart FormData di Laravel)
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await res.json();

            if (res.status === 422) {
                // Tampilkan pesan validasi
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const errorEl = document.getElementById(`error_${field}`);
                        const inputEl = document.getElementById(field) || document.getElementById('berkasInput');
                        if (errorEl) {
                            errorEl.textContent = messages[0];
                            errorEl.classList.remove('hidden');
                        }
                        if (inputEl) {
                            inputEl.classList.add('border-red-400', 'ring-2', 'ring-red-100');
                        }
                    }
                }
                return;
            }

            if (!res.ok) {
                throw new Error(data.message || 'Terjadi kesalahan sistem.');
            }

            // Berhasil
            closeModal();
            showAlert('success', data.success || 'Laporan insiden berhasil disimpan via AJAX.');
            await loadReports();
        } catch (error) {
            showAlert('error', error.message || 'Gagal menyimpan laporan insiden via AJAX.');
        } finally {
            btnSpinner.classList.add('hidden');
            btnText.textContent = isEdit ? 'Simpan Perubahan' : 'Simpan Laporan (AJAX)';
            saveSubmitBtn.disabled = false;
        }
    });

    // Handle Edit via AJAX (GET Single Data)
    async function handleEdit(id) {
        try {
            const res = await fetch(`/laporaninsiden/${id}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('Gagal mengambil data laporan.');
            const data = await res.json();

            clearFormErrors();
            laporanId.value = data.id;
            formMethod.value = 'PUT';
            document.getElementById('nama_pelapor').value = data.nama_pelapor || '';
            document.getElementById('kontak_pelapor').value = data.kontak_pelapor || '';
            document.getElementById('lokasi_jalan').value = data.lokasi_jalan || '';
            document.getElementById('kategori_insiden').value = data.kategori_insiden || '';
            document.getElementById('tingkat_keparahan').value = data.tingkat_keparahan || '';
            document.getElementById('keterangan').value = data.keterangan || '';
            document.getElementById('berkasInput').value = '';

            modalTitle.textContent = 'Edit Laporan Insiden (AJAX)';
            modalSubtitle.textContent = 'Perbarui Data Laporan & Berkas';
            berkasRequiredStar.classList.add('hidden');

            if (data.berkas) {
                currentFileName.textContent = data.nama_berkas || 'Berkas Bukti Terunggah';
                currentFileLink.href = `/storage/${data.berkas}`;
                currentFileContainer.classList.remove('hidden');
            } else {
                currentFileContainer.classList.add('hidden');
            }

            btnText.textContent = 'Simpan Perubahan (AJAX)';
            openModal();
        } catch (error) {
            showAlert('error', error.message || 'Gagal mengambil data untuk diedit.');
        }
    }

    // Handle Delete via AJAX (DELETE)
    async function handleDelete(id, nama) {
        if (!confirm(`Apakah Anda yakin ingin menghapus laporan dari "${nama}" via AJAX?`)) {
            return;
        }

        try {
            const res = await fetch(`/laporaninsiden/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Gagal menghapus laporan.');

            // Animasi hapus baris tabel secara live
            const row = document.getElementById(`row-${id}`);
            if (row) {
                row.classList.add('opacity-0', 'scale-95', 'transition', 'duration-300');
                setTimeout(() => {
                    allReports = allReports.filter(item => item.id != id);
                    renderTable(allReports);
                }, 300);
            } else {
                await loadReports();
            }

            showAlert('success', data.success || 'Laporan insiden berhasil dihapus via AJAX.');
        } catch (error) {
            showAlert('error', error.message || 'Gagal menghapus data laporan.');
        }
    }

    // Inisialisasi: Muat Laporan Pertama Kali
    loadReports();
});
</script>
@endpush
