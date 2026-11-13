<?php

namespace Modules\TitikKemacetan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\TitikKemacetan\Database\Factories\TitikKemacetanFactory;

class TitikKemacetan extends Model
{
    /** @use HasFactory<TitikKemacetanFactory> */
    use HasFactory;

    protected $table = 'titik_kemacetans';

    protected $fillable = [
        'nama_jalan',
        'wilayah',
        'kondisi_lalin',
        'kecepatan_rata_rata',
        'panjang_antrian',
        'penyebab',
    ];

    protected static function newFactory(): TitikKemacetanFactory
    {
        return TitikKemacetanFactory::new();
    }
}
