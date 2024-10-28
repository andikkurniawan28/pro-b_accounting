<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function journal_entry(){
        return $this->hasMany(JournalEntry::class);
    }

    public static function generateCode()
    {
        // Prefix untuk kode jurnal
        $prefix = 'JRN';
        // Tanggal saat ini dalam format Ymd
        $date = date('Ymd');
        // Mengambil jurnal terakhir yang dibuat pada tanggal hari ini
        $lastJournal = self::whereDate('date', today())->latest('created_at')->first();

        // Mendapatkan urutan berdasarkan ID terakhir atau mulai dari 1
        $sequence = $lastJournal ? intval(substr($lastJournal->code, -4)) + 1 : 1;

        // Mengisi nol di depan hingga 4 digit
        $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Mengembalikan kode yang diformat
        return "{$prefix}-{$date}-{$sequence}";
    }

}
