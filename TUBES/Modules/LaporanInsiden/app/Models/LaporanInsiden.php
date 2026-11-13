<?php

namespace Modules\LaporanInsiden\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\LaporanInsiden\Database\Factories\LaporanInsidenFactory;

class LaporanInsiden extends Model
{
    /** @use HasFactory<LaporanInsidenFactory> */
    use HasFactory;

    protected $table = 'laporan_insidens';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_pelapor',
        'lokasi_jalan',
        'kategori_insiden',
        'tingkat_keparahan',
        'keterangan',
        'kontak_pelapor',
        'berkas',
        'nama_berkas',
    ];

    /**
     * The accessors to append to the model's array and JSON form.
     *
     * @var list<string>
     */
    protected $appends = [
        'berkas_url',
    ];

    /**
     * Public URL of the uploaded file, or null when there is no file.
     */
    protected function berkasUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->berkas ? asset('storage/'.$this->berkas) : null);
    }

    protected static function newFactory(): LaporanInsidenFactory
    {
        return LaporanInsidenFactory::new();
    }
}
