<?php

namespace Modules\TitikKemacetan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTitikKemacetanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'nama_jalan' => ['required', 'string', 'max:255'],
            'wilayah' => ['required', 'string', 'max:100'],
            'kondisi_lalin' => ['required', 'string', 'in:Lancar,Ramai Lancar,Padat Merayap,Macet Total'],
            'kecepatan_rata_rata' => ['required', 'integer', 'min:0', 'max:150'],
            'panjang_antrian' => ['required', 'integer', 'min:0', 'max:20000'],
            'penyebab' => ['required', 'string', 'max:255'],
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
            'nama_jalan.required' => 'Nama jalan / ruas wajib diisi.',
            'wilayah.required' => 'Wilayah / kecamatan wajib diisi.',
            'kondisi_lalin.required' => 'Kondisi lalu lintas wajib dipilih.',
            'kondisi_lalin.in' => 'Kondisi lalu lintas yang dipilih tidak valid.',
            'kecepatan_rata_rata.required' => 'Kecepatan rata-rata wajib diisi.',
            'kecepatan_rata_rata.integer' => 'Kecepatan rata-rata harus berupa angka (km/jam).',
            'panjang_antrian.required' => 'Panjang antrian kendaraan wajib diisi.',
            'panjang_antrian.integer' => 'Panjang antrian harus berupa angka (meter).',
            'penyebab.required' => 'Penyebab kemacetan wajib diisi.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }
}
