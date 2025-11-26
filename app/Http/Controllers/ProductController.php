<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // ✅ Tampilkan semua produk
    public function index(Request $request)
    {
        $query = Product::with('kategori');

        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        $produks = $query->orderBy('id_produk', 'DESC')->paginate(10)->withQueryString();
        $kategoris = Category::all();

        return view('products.index', compact('produks', 'kategoris'));
    }

    // ✅ Form tambah produk
    public function create()
    {
        $kategoris = Category::all();
        return view('products.create', compact('kategoris'));
    }

    // ✅ Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori', // ✅ pakai tabel kategori
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        Product::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // ✅ Edit produk
    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        $kategoris = Category::all();
        return view('products.edit', compact('produk', 'kategoris'));
    }

    // ✅ Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori', // ✅ ubah dari categories ke kategori
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $produk = Product::findOrFail($id);
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // ✅ Hapus produk
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);
        $produk->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
