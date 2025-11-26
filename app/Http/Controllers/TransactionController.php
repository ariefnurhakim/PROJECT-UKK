<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::firstOrCreate(
            ['status' => 'pending'],
            ['total' => 0, 'invoice' => 'INV' . time()]
        );

        $items = TransactionItem::with('product')
            ->where('transaction_id', $transaction->id)
            ->get();

        $total = $items->sum('subtotal');
        $transaction->update(['total' => $total]);

        $products = Product::all();

        return view('transactions.index', compact('transaction', 'items', 'total', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'produk_id' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        $product = Product::where('id_produk', $request->produk_id)->firstOrFail();

        if ($product->stok <= 0) {
            return back()->with('error', 'Stok produk sedang habis!');
        }

        if ($request->jumlah > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        // CEK ITEM YANG SUDAH ADA
        $existingItem = TransactionItem::where('transaction_id', $transaction->id)
            ->where('product_id', $product->id_produk)
            ->first();

        if ($existingItem) {

            $newJumlah = $existingItem->qty + $request->jumlah;

            if ($newJumlah > $product->stok) {
                return back()->with('error', 'Jumlah melebihi stok tersedia!');
            }

            $existingItem->update([
                'qty' => $newJumlah,
                'subtotal' => $newJumlah * $product->harga,
            ]);

        } else {
            // TAMBAH ITEM BARU
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id_produk,
                'qty' => $request->jumlah,
                'product_name' => $product->nama_produk,
                'product_price' => $product->harga,
                'subtotal' => $product->harga * $request->jumlah,
            ]);
            
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke transaksi!');
    }

    public function destroy($id)
    {
        TransactionItem::findOrFail($id)->delete();

        return back()->with('success', 'Item berhasil dihapus!');
    }

    public function payment()
    {
        $transaction = Transaction::where('status', 'pending')->firstOrFail();
        $items = $transaction->items()->with('product')->get();
        $total = $items->sum('subtotal');

        return view('transactions.payment', compact('transaction', 'total'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
        ]);

        $transaction = Transaction::where('status', 'pending')->firstOrFail();
        $items = $transaction->items()->with('product')->get();
        $total = $items->sum('subtotal');
        $dibayar = $request->dibayar;

        if ($dibayar < $total) {
            return back()->with('error', 'Uangnya kurang bro!')->withInput();
        }

        $transaction->update([
            'status' => 'selesai',
            'total' => $total,
            'dibayar' => $dibayar,
            'kembalian' => $dibayar - $total,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        foreach ($transaction->items as $item) {
            $product = Product::where('id_produk', $item->product_id)->first();

            if ($product) {
                $qty = $item->qty ?? $item->quantity ?? 0;
                $product->stok = max(0, $product->stok - $qty);
                $product->save();
            }
        }

        return redirect()->route('transactions.print', $transaction->id);
    }

    public function print($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);

        return view('transactions.print', compact('transaction'))
            ->with('autoRedirect', true);
    }

    public function reset()
    {
        Transaction::where('status', 'pending')->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi baru siap.');
    }

    public function laporan(Request $request)
    {
        $query = Transaction::with('items.product')
            ->where('status', 'selesai');

        if ($request->search) {
            $query->where('invoice', 'like', "%{$request->search}%")
                  ->orWhereHas('items.product', function($q) use ($request) {
                      $q->where('nama_produk', 'like', "%{$request->search}%");
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

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return view('reports.index', compact('transactions'));
    }
}
