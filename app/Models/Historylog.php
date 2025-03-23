<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historylog extends Model
{
    use HasFactory;
    protected $table = 'history_logs';
    protected $fillable = ['user_id', 'file_id', 'action'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model File
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'file_id', 'id')->withTrashed();
    }
}
