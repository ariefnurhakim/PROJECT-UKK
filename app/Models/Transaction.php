<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    // Relasi ke TransactionItem



    public function items()
    {
        // Tambahkan foreign key sesuai nama kolom di DB
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}
