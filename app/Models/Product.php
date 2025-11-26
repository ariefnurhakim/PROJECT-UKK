<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'stok',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}
