<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TitikKemacetan\Database\Seeders\TitikKemacetanDatabaseSeeder;
use Modules\LaporanInsiden\Database\Seeders\LaporanInsidenDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LaporanSeeder::class,
            TitikKemacetanDatabaseSeeder::class,
            LaporanInsidenDatabaseSeeder::class,
        ]);
    }
}
