<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // =========================
    // LAPORAN TRANSAKSI + FILTER
    // =========================
    public function transactions(Request $request)
    {
        $query = Transaction::with('items.product')
            ->where('status', 'selesai');

        // FILTER: Cari invoice atau nama produk
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice', 'like', "%{$request->search}%")
                  ->orWhereHas('items.product', function ($p) use ($request) {
                      $p->where('nama_produk', 'like', "%{$request->search}%");
                  });
            });
        }

        // FILTER: Tanggal mulai
        if ($request->start) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        // FILTER: Tanggal akhir
        if ($request->end) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        // FILTER: Metode pembayaran
        if ($request->metode) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // HASIL FILTER
        $transactions = $query->orderBy('id', 'DESC')->get();

        // TOTAL berdasarkan hasil filter
        $totalFiltered = $transactions->sum('total');

        // TOTAL semua transaksi
        $totalAll = Transaction::where('status', 'selesai')->sum('total');

        return view('reports.transactions', compact(
            'transactions',
            'totalFiltered',
            'totalAll'
        ));
    }

    // =========================
    // CETAK LAPORAN (SEMUA TRANSAKSI)
    // =========================
    public function print()
    {
        $transactions = Transaction::with('items.product')
            ->where('status', 'selesai')
            ->orderBy('id', 'DESC')
            ->get();

        $totalAll = $transactions->sum('total');

        return view('reports.print-transactions', compact('transactions', 'totalAll'));
    }

    // =========================
    // CETAK LAPORAN (MENGIKUTI FILTER)
    // =========================
    public function printFiltered(Request $request)
    {
        $query = Transaction::with('items.product')
            ->where('status', 'selesai');

        // Copy semua filter dari halaman laporan
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice', 'like', "%{$request->search}%")
                  ->orWhereHas('items.product', function ($p) use ($request) {
                      $p->where('nama_produk', 'like', "%{$request->search}%");
                  });
            });
        }

        if ($request->start) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        if ($request->end) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        if ($request->metode) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $transactions = $query->orderBy('id', 'DESC')->get();
        $totalFiltered = $transactions->sum('total');

        return view('reports.print-transactions', compact('transactions', 'totalFiltered'));
    }

    // =========================
    // LAPORAN PRODUK
    // =========================
    public function products()
    {
        $products = Product::orderBy('nama_produk')->get();
        return view('reports.products', compact('products'));
    }
}
