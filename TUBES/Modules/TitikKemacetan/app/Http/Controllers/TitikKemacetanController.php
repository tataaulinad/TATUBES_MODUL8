<?php

namespace Modules\TitikKemacetan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\TitikKemacetan\Http\Requests\StoreTitikKemacetanRequest;
use Modules\TitikKemacetan\Http\Requests\UpdateTitikKemacetanRequest;
use Modules\TitikKemacetan\Models\TitikKemacetan;

class TitikKemacetanController extends Controller
{
    /**
     * Display a listing of traffic points.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $kondisi = $request->string('kondisi')->trim()->toString();

        $titiks = TitikKemacetan::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('nama_jalan', 'like', "%{$search}%")
                        ->orWhere('wilayah', 'like', "%{$search}%")
                        ->orWhere('penyebab', 'like', "%{$search}%");
                });
            })
            ->when($kondisi !== '', fn (Builder $query) => $query->where('kondisi_lalin', $kondisi))
            ->orderBy('nama_jalan')
            ->paginate(10)
            ->withQueryString();

        $daftarKondisi = ['Lancar', 'Ramai Lancar', 'Padat Merayap', 'Macet Total'];

        return view('titikkemacetan::index', [
            'titiks' => $titiks,
            'search' => $search,
            'selectedKondisi' => $kondisi,
            'daftarKondisi' => $daftarKondisi,
        ]);
    }

    /**
     * Show the form for creating a new traffic point.
     */
    public function create(): View
    {
        $this->ensureAdmin();

        return view('titikkemacetan::create', [
            'daftarKondisi' => ['Lancar', 'Ramai Lancar', 'Padat Merayap', 'Macet Total'],
        ]);
    }

    /**
     * Store a newly created traffic point.
     */
    public function store(StoreTitikKemacetanRequest $request): RedirectResponse
    {
        TitikKemacetan::create($request->validated());

        return redirect()->route('titikkemacetan.index')->with('success', 'Titik kemacetan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified traffic point.
     */
    public function edit(TitikKemacetan $titik): View
    {
        $this->ensureAdmin();

        return view('titikkemacetan::edit', [
            'titik' => $titik,
            'daftarKondisi' => ['Lancar', 'Ramai Lancar', 'Padat Merayap', 'Macet Total'],
        ]);
    }

    /**
     * Update the specified traffic point.
     */
    public function update(UpdateTitikKemacetanRequest $request, TitikKemacetan $titik): RedirectResponse
    {
        $titik->update($request->validated());

        return redirect()->route('titikkemacetan.index')->with('success', 'Titik kemacetan berhasil diperbarui.');
    }

    /**
     * Remove the specified traffic point.
     */
    public function destroy(Request $request, TitikKemacetan $titik): RedirectResponse
    {
        $this->ensureAdmin();

        $titik->delete();

        return redirect()->route('titikkemacetan.index')->with('success', 'Titik kemacetan berhasil dihapus.');
    }

    /**
     * Ensure the current user has the admin role.
     */
    protected function ensureAdmin(): void
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
    }
}
