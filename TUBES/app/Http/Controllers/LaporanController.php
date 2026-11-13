<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar seluruh laporan.
     */
    public function index(Request $request)
    {
        $query = Laporan::orderByDesc('waktu_laporan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('lokasi', 'like', "%{$q}%")
                   ->orWhere('deskripsi', 'like', "%{$q}%")
                   ->orWhere('nama_pelapor', 'like', "%{$q}%");
            });
        }

        $laporans = $query->paginate(12)->withQueryString();

        return view('laporan.index', compact('laporans'));
    }

    /**
     * Tampilkan form pembuatan laporan baru.
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'tingkat_kemacetan' => ['nullable', 'integer', 'min:0', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ], [
            'lokasi.required' => 'Lokasi kejadian wajib diisi.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter agar informasi jelas.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 4MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        Laporan::create([
            'nama_pelapor' => Auth::user()->name,
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'tingkat_kemacetan' => $validated['tingkat_kemacetan'] ?? 30,
            'foto' => $fotoPath,
            'status_verifikasi' => 'verified',
            'waktu_laporan' => now(),
        ]);

        return redirect()->route('beranda')->with('success', 'Laporan insiden berhasil dikirimkan dan dipublikasikan!');
    }

    /**
     * Tampilkan rincian detail laporan.
     */
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }
}
