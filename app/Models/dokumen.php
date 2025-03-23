<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'dokumen';

    protected $fillable = [
        'user_id',
        'laporan_polisi',
        'tanggal_laporan',
        'file',
        'size',
        'kategori',
        'rak_penyimpanan',
        'jenis_surat',
        'tanggal_ungkap'
    ];

    /**
     * Relasi dengan User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
