@extends('layouts.app')

@section('title', 'Kelola Pengguna (Admin)')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold mb-2">
                <i class="fas fa-shield-halved text-purple-600"></i> Modul Admin &bull; Multi-Role Authorization Middleware
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Pengguna & Hak Akses</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Manajemen akun pengguna sistem Smart Traffic Finder dan penugasan role (Admin / User).
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-orange-500/20 transition inline-flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="search" name="search" value="{{ $search }}" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition" placeholder="Cari nama atau email pengguna...">
            </div>

            <div class="w-full md:w-56">
                <select name="role" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition text-gray-700">
                    <option value="">Semua Role Pengguna</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->value }}" @selected($selectedRole === $role)>{{ $role->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if ($search !== '' || $selectedRole)
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition">
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
                        <th class="py-3.5 px-4">Nama Pengguna</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">No. Telepon & Lokasi</th>
                        <th class="py-3.5 px-4">Role Akses</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                    @forelse ($users as $u)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="py-3.5 px-4 text-center font-semibold text-gray-400">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                                        {{ $u->inisial }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 block">{{ $u->name }}</span>
                                        @if ($u->is(auth()->user()))
                                            <span class="text-[10px] text-orange-600 font-bold bg-orange-50 px-1.5 py-0.2 rounded border border-orange-200">Akun Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-gray-600 font-medium">
                                {{ $u->email }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-500 text-xs">
                                <div><i class="fas fa-phone text-gray-400 mr-1"></i> {{ $u->telepon ?? '-' }}</div>
                                <div class="mt-0.5"><i class="fas fa-location-dot text-gray-400 mr-1"></i> {{ $u->lokasi ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($u->isAdmin())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                        <i class="fas fa-shield text-[10px]"></i> Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                        <i class="fas fa-user text-[10px]"></i> Pengguna Biasa
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.users.edit', $u) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg border border-blue-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @unless ($u->is(auth()->user()))
                                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun &quot;{{ addslashes($u->name) }}&quot;?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg border border-red-200 transition">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-purple-50 text-purple-500 mx-auto flex items-center justify-center text-2xl mb-3">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h4 class="font-bold text-gray-700 text-base">Tidak Ada Pengguna Ditemukan</h4>
                                <p class="text-xs text-gray-400 mt-1">Gunakan kata kunci pencarian yang lain.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
