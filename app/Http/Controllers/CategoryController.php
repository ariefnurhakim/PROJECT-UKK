<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori + search + pagination
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%'.$request->search.'%');
        }

        $kategoris = $query->paginate(10);
        $kategoris->appends($request->all());

        return view('categories.index', compact('kategoris'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Category::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Form edit kategori
    public function edit($id_kategori)
    {
        $category = Category::findOrFail($id_kategori);
        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Category::where('id_kategori', $id_kategori)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy($id_kategori)
    {
        Category::where('id_kategori', $id_kategori)->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
