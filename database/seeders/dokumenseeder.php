<?php

namespace Database\Seeders;

use App\Models\dokumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class dokumenseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dokumen::insert([
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/1/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 1,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/2/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 2,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/3/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 3,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/4/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 4,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/5/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 5,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/6/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 6,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/7/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 7,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/8/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 8,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/9/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 9,
                'tanggal_laporan' => '2023-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/10/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 10,
                'tanggal_laporan' => '2025-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAS',
                'rak_id' => 1,
                'jenis_surat' => "Tahap 2"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/11/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 11,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURAT',
                'rak_id' => 1,
                'jenis_surat' => "SP3"
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/A/12/IV/2025/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU',
                'lp' => 12,
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'CURANMOR',
                'rak_id' => 1,
                'jenis_surat' => "RJ"
            ],
        ]);
    }
}
