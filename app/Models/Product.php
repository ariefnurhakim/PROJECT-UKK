<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama_produk', 'id_kategori', 'stok', 'harga'];
    public $timestamps = false;

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}
