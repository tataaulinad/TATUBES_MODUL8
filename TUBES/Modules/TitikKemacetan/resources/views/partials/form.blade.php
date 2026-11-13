<div class="space-y-5">
    <div>
        <label for="nama_jalan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
            Nama Jalan / Ruas Jalan <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-road text-sm"></i>
            </div>
            <input type="text" id="nama_jalan" name="nama_jalan" value="{{ old('nama_jalan', $titik?->nama_jalan) }}" placeholder="Contoh: Jl. Dr. Djunjunan (Gerbang Tol Pasteur)" required autofocus
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('nama_jalan') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
        </div>
        @error('nama_jalan')
            <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="wilayah" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Wilayah / Kawasan / Kecamatan <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-map-marker-alt text-sm"></i>
                </div>
                <input type="text" id="wilayah" name="wilayah" value="{{ old('wilayah', $titik?->wilayah) }}" placeholder="Contoh: Cicendo / Coblong" required
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('wilayah') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
            </div>
            @error('wilayah')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kondisi_lalin" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Kondisi Lalu Lintas <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select id="kondisi_lalin" name="kondisi_lalin" required
                    class="w-full px-4 py-2.5 bg-gray-50 border @error('kondisi_lalin') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
                    <option value="">-- Pilih Kondisi Lalu Lintas --</option>
                    @foreach ($daftarKondisi as $kondisi)
                        <option value="{{ $kondisi }}" @selected(old('kondisi_lalin', $titik?->kondisi_lalin) === $kondisi)>{{ $kondisi }}</option>
                    @endforeach
                </select>
            </div>
            @error('kondisi_lalin')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="kecepatan_rata_rata" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Kecepatan Rata-Rata (km/jam) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-gauge-high text-sm"></i>
                </div>
                <input type="number" min="0" max="150" id="kecepatan_rata_rata" name="kecepatan_rata_rata" value="{{ old('kecepatan_rata_rata', $titik?->kecepatan_rata_rata) }}" placeholder="Contoh: 15" required
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('kecepatan_rata_rata') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
            </div>
            @error('kecepatan_rata_rata')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="panjang_antrian" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Panjang Antrian Kendaraan (meter) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-arrows-left-right text-sm"></i>
                </div>
                <input type="number" min="0" max="20000" id="panjang_antrian" name="panjang_antrian" value="{{ old('panjang_antrian', $titik?->panjang_antrian) }}" placeholder="Contoh: 850" required
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border @error('panjang_antrian') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">
            </div>
            @error('panjang_antrian')
                <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="penyebab" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
            Penyebab Kemacetan / Keterangan <span class="text-red-500">*</span>
        </label>
        <textarea id="penyebab" name="penyebab" rows="3" placeholder="Contoh: Volume kendaraan jam sibuk sore hari dan penyempitan lajur di persimpangan lampu merah" required
            class="w-full px-4 py-2.5 bg-gray-50 border @error('penyebab') border-red-300 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-xl text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition">{{ old('penyebab', $titik?->penyebab) }}</textarea>
        @error('penyebab')
            <p class="text-xs text-red-600 mt-1.5 font-medium flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
        @enderror
    </div>
</div>
