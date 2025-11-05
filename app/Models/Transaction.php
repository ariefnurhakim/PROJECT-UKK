<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    // Relasi ke item transaksi
    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'id_transaksi');
    }
}
