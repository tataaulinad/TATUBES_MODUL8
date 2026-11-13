@extends('layouts.app')

@section('title', 'Tambah Titik Kemacetan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <div class="mb-6">
        <a href="{{ route('titikkemacetan.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-500 hover:text-orange-600 transition mb-3">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Titik Kemacetan
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Titik Kemacetan</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Masukkan data titik rawan kemacetan baru untuk dipantau secara berkala.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('titikkemacetan.store') }}" method="POST">
            @csrf
            @include('titikkemacetan::partials.form', ['titik' => null])

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('titikkemacetan.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition inline-flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Titik Kemacetan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
