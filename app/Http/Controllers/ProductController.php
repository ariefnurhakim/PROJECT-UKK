<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Daftar produk
    public function index(Request $request)
    {
        $query = Product::with('kategori');
    
        // Search nama produk atau nama kategori
        if ($request->search) {
            $query->where('nama_produk', 'like', '%'.$request->search.'%')
                  ->orWhereHas('kategori', function($q) use ($request) {
                      $q->where('nama_kategori', 'like', '%'.$request->search.'%');
                  });
        }
    
        // Filter dropdown kategori
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }
    
        $produks = $query->orderBy('id_produk', 'DESC')->paginate(10)->withQueryString();
    
        return view('products.index', compact('produks'));
    }
    
    

    // Form tambah produk
    public function create()
    {
        $kategoris = Category::all();
        return view('products.create', compact('kategoris'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori', // ✅ diperbaiki
            'stok' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        Product::create($request->only(['nama_produk', 'id_kategori', 'stok', 'harga']));

        return redirect()->route('products.index')->with('success','Produk berhasil ditambahkan!');
    }

    // Form edit
    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        $kategoris = Category::all();
        return view('products.edit', compact('produk','kategoris'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori', // ✅ diperbaiki
            'stok' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        $produk = Product::findOrFail($id);
        $produk->update($request->only(['nama_produk','id_kategori','stok','harga']));

        return redirect()->route('products.index')->with('success','Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);
        $produk->delete();

        return redirect()->route('products.index')->with('success','Produk berhasil dihapus!');
    }
}
