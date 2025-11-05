<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transaction_item'; // jika nama tabelnya berbeda sesuaikan
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaksi');
    }
}
