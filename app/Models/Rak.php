<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Rak extends Model
{
    protected $table = 'rak';
    protected $fillable = ['nama_rak'];


    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
}
