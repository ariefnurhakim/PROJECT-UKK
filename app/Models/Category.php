<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'kategori'; // atau 'kategori' jika itu nama tabelmu
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    public function produk()
    {
        return $this->hasMany(Product::class, 'id_kategori', 'id_kategori');
    }
}
