<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total produk, kategori, transaksi
        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalTransaksi = Transaction::count();

        // Total pendapatan dari transaksi selesai
        $totalPendapatan = Transaction::where('status', 'selesai')->sum('total');

        // 5 transaksi terbaru
        $latestTransactions = Transaction::with('items.product')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        // Data chart bulanan (jumlah transaksi per bulan tahun ini)
        $months = [];
        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create(null, $m, 1)->format('M');
            $data[] = Transaction::whereMonth('created_at', $m)
                        ->whereYear('created_at', date('Y'))
                        ->sum('total');
        }

        $chartLabels = $months;
        $chartData = $data;

        return view('dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalTransaksi',
            'totalPendapatan',
            'latestTransactions',
            'chartLabels',
            'chartData'
        ));
    }
}
