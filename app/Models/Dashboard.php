<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\TransactionItem;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalTransaksi = TransactionItem::count();

        return view('dashboard', compact('totalProduk', 'totalKategori', 'totalTransaksi'));
    }
}
