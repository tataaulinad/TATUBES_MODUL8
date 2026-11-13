<?php

namespace Modules\LaporanInsiden\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\LaporanInsiden\Http\Requests\LaporanInsidenRequest;
use Modules\LaporanInsiden\Models\LaporanInsiden;

class LaporanInsidenController extends Controller
{
    /**
     * Display the page. Data is loaded via AJAX.
     */
    public function index(): View
    {
        return view('laporaninsiden::index');
    }

    /**
     * Return all reports as JSON.
     */
    public function getData(): JsonResponse
    {
        return response()->json(LaporanInsiden::latest()->get());
    }

    /**
     * Store a newly created report together with its uploaded file.
     */
    public function store(LaporanInsidenRequest $request): JsonResponse
    {
        $data = $request->safe()->except('berkas');
        $file = $request->file('berkas');
        $data['berkas'] = $file->store('berkas_insiden', 'public');
        $data['nama_berkas'] = $file->getClientOriginalName();

        LaporanInsiden::create($data);

        return response()->json(['success' => 'Laporan insiden berhasil disimpan via AJAX.']);
    }

    /**
     * Return a single report for the edit modal form.
     */
    public function edit(LaporanInsiden $laporaninsiden): JsonResponse
    {
        return response()->json($laporaninsiden);
    }

    /**
     * Update the specified report. The old file is replaced only when a new one is uploaded.
     */
    public function update(LaporanInsidenRequest $request, LaporanInsiden $laporaninsiden): JsonResponse
    {
        $data = $request->safe()->except('berkas');

        if ($request->hasFile('berkas')) {
            if ($laporaninsiden->berkas) {
                Storage::disk('public')->delete($laporaninsiden->berkas);
            }
            $file = $request->file('berkas');
            $data['berkas'] = $file->store('berkas_insiden', 'public');
            $data['nama_berkas'] = $file->getClientOriginalName();
        }

        $laporaninsiden->update($data);

        return response()->json(['success' => 'Laporan insiden berhasil diperbarui via AJAX.']);
    }

    /**
     * Remove the specified report and its uploaded file.
     */
    public function destroy(LaporanInsiden $laporaninsiden): JsonResponse
    {
        if ($laporaninsiden->berkas) {
            Storage::disk('public')->delete($laporaninsiden->berkas);
        }

        $laporaninsiden->delete();

        return response()->json(['success' => 'Laporan insiden berhasil dihapus via AJAX.']);
    }
}
