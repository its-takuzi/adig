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
                'laporan_polisi' => 'LP/45/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-17',
                'file' => 'files/Doc1.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/48/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-10',
                'file' => 'files/Doc2.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/50/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-01',
                'file' => 'files/Doc3.pdf',
                'size' => 512000,
                'kategori' => 'curanmor',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/55/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-08',
                'file' => 'files/Doc4.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/60/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-20',
                'file' => 'files/Doc5.pdf',
                'size' => 512000,
                'kategori' => 'curanmor',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/65/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-25',
                'file' => 'files/Doc6.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/70/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-15',
                'file' => 'files/Doc7.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/75/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-12',
                'file' => 'files/Doc8.pdf',
                'size' => 512000,
                'kategori' => 'curanmor',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/80/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-18',
                'file' => 'files/Doc9.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/85/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-22',
                'file' => 'files/Doc10.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/90/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-07',
                'file' => 'files/Doc11.pdf',
                'size' => 512000,
                'kategori' => 'curanmor',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/95/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-30',
                'file' => 'files/Doc12.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/100/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-28',
                'file' => 'files/Doc13.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/105/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-05',
                'file' => 'files/Doc14.pdf',
                'size' => 512000,
                'kategori' => 'curanmor',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/110/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-27',
                'file' => 'files/Doc15.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/115/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-14',
                'file' => 'files/Doc16.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/120/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-21',
                'file' => 'files/Doc17.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 2,
                'laporan_polisi' => 'LP/125/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-11',
                'file' => 'files/Doc18.pdf',
                'size' => 512000,
                'kategori' => 'curat',
            ],
            [
                'user_id' => 3,
                'laporan_polisi' => 'LP/130/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-26',
                'file' => 'files/Doc19.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
            [
                'user_id' => 1,
                'laporan_polisi' => 'LP/135/VI/2023/SPKT/POLSEK DUKU',
                'tanggal_laporan' => '2024-06-16',
                'file' => 'files/Doc20.pdf',
                'size' => 512000,
                'kategori' => 'curas',
            ],
        ]);
    }
}
