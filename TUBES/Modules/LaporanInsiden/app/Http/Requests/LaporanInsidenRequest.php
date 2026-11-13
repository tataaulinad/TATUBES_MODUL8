<?php

namespace Modules\LaporanInsiden\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanInsidenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * The file is required when creating, and optional when updating (keep the old file).
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $insiden = $this->route('laporaninsiden');

        return [
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'lokasi_jalan' => ['required', 'string', 'max:255'],
            'kategori_insiden' => ['required', 'string', 'max:100'],
            'tingkat_keparahan' => ['required', 'string', 'in:Rendah,Sedang,Tinggi,Kritis'],
            'keterangan' => ['required', 'string', 'max:1000'],
            'kontak_pelapor' => ['required', 'string', 'regex:/^[0-9+]{8,20}$/'],
            'berkas' => [$insiden ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'lokasi_jalan.required' => 'Lokasi jalan insiden wajib diisi.',
            'kategori_insiden.required' => 'Kategori insiden wajib dipilih.',
            'tingkat_keparahan.required' => 'Tingkat keparahan insiden wajib dipilih.',
            'tingkat_keparahan.in' => 'Pilihan tingkat keparahan tidak valid.',
            'keterangan.required' => 'Keterangan insiden wajib diisi.',
            'kontak_pelapor.required' => 'Kontak pelapor wajib diisi.',
            'kontak_pelapor.regex' => 'Kontak pelapor hanya boleh berisi angka (8-20 digit).',
            'berkas.required' => 'Berkas bukti insiden wajib diunggah.',
            'berkas.mimes' => 'Berkas harus berformat jpg, jpeg, png, atau pdf.',
            'berkas.max' => 'Ukuran berkas maksimal 2 MB.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
