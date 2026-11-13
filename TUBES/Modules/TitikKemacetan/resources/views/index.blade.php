@extends('layouts.app')

@section('title', 'Titik Kemacetan (CRUD Sync)')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-bold mb-2">
                <i class="fas fa-layer-group text-orange-600"></i> Modul HMVC 1 &bull; Synchronous CRUD
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Titik Kemacetan Lalu Lintas</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Pengelolaan dan pemantauan titik rawan macet Kota Bandung berbasis <strong>CRUD Synchronous</strong> (6 Item Data).
            </p>
        </div>
        <div class="flex items-center gap-3">
            @if (auth()->user()->isAdmin())
                <a href="{{ route('titikkemacetan.create') }}" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition inline-flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Titik Kemacetan
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-600 rounded-xl text-xs font-semibold">
                    <i class="fas fa-lock text-gray-400"></i> Mode Baca (Hak Akses User)
                </span>
            @endif
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-6">
        <form method="GET" action="{{ route('titikkemacetan.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="search" name="search" value="{{ $search }}" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition" placeholder="Cari nama jalan, wilayah, atau penyebab...">
            </div>

            <div class="w-full md:w-56">
                <select name="kondisi" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
                    <option value="">Semua Kondisi Lalu Lintas</option>
                    @foreach ($daftarKondisi as $k)
                        <option value="{{ $k }}" @selected($selectedKondisi === $k)>{{ $k }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if ($search !== '' || $selectedKondisi)
                    <a href="{{ route('titikkemacetan.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Ruas / Nama Jalan</th>
                        <th class="py-3.5 px-4">Wilayah</th>
                        <th class="py-3.5 px-4">Kondisi Lalu Lintas</th>
                        <th class="py-3.5 px-4">Kecepatan Rata-rata</th>
                        <th class="py-3.5 px-4">Panjang Antrian</th>
                        <th class="py-3.5 px-4">Penyebab Kemacetan</th>
                        @if (auth()->user()->isAdmin())
                            <th class="py-3.5 px-4 text-right">Aksi Admin</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                    @forelse ($titiks as $titik)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="py-3.5 px-4 text-center font-semibold text-gray-400">
                                {{ $titiks->firstItem() + $loop->index }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                    <span>{{ $titik->nama_jalan }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">
                                    <i class="fas fa-location-dot text-orange-500 text-[10px]"></i> {{ $titik->wilayah }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badge = match ($titik->kondisi_lalin) {
                                        'Lancar' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Ramai Lancar' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Padat Merayap' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Macet Total' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-50 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badge }}">
                                    {{ $titik->kondisi_lalin }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-gray-700">
                                {{ $titik->kecepatan_rata_rata }} <span class="text-xs text-gray-400 font-normal">km/jam</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-gray-700">
                                {{ number_format($titik->panjang_antrian, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">meter</span>
                            </td>
                            <td class="py-3.5 px-4 text-gray-600 max-w-xs truncate" title="{{ $titik->penyebab }}">
                                {{ $titik->penyebab }}
                            </td>
                            @if (auth()->user()->isAdmin())
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('titikkemacetan.edit', $titik) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg border border-blue-200 transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('titikkemacetan.destroy', $titik) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data titik kemacetan di {{ addslashes($titik->nama_jalan) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg border border-red-200 transition">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '8' : '7' }}" class="py-12 text-center text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-orange-50 text-orange-500 mx-auto flex items-center justify-center text-2xl mb-3">
                                    <i class="fas fa-road-circle-exclamation"></i>
                                </div>
                                <h4 class="font-bold text-gray-700 text-base">Belum Ada Data Titik Kemacetan</h4>
                                <p class="text-xs text-gray-400 mt-1">Tidak ada data yang cocok dengan kriteria pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($titiks->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $titiks->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
