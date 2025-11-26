<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'subtotal',
        'nama_produk',
        'harga',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_produk')->withTrashed();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
