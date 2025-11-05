<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(12);
        $total_semua = Transaction::sum('total');
    
        return view('transactions.index', compact('transactions','total_semua'));
    }


    public function search(Request $request)
    {
        $keyword = $request->keyword;
    
        $transactions = Transaction::with('produk')
            ->whereHas('produk', function($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%');
            })
            ->orWhere('invoice', 'like', '%' . $keyword . '%')
            ->orWhereHas('user', function($q) use ($keyword){
                $q->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(12);
    
        $total_semua = Transaction::sum('total');
    
        return view('transactions.index', compact('transactions', 'total_semua'));
    }


    public function create()
    {
        $products = Product::where('stock','>',0)->get();
        return view('transactions.create', compact('products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id'=>'required|array',
            'qty'=>'required|array',
        ]);

        $productIds = $request->input('product_id');
        $qtys = $request->input('qty');

        DB::beginTransaction();
        try {
            $invoice = 'INV-'.Str::upper(Str::random(6));
            $total = 0;

            $transaction = Transaction::create([
                'invoice'=>$invoice,
                'user_id'=>auth()->id(),
                'total'=>0,
                'paid'=>0,
                'status' => 'unpaid'
            ]);

            foreach($productIds as $i => $pid){
                $p = Product::findOrFail($pid);
                $q = (int)($qtys[$i] ?? 1);
                $subtotal = $p->price * $q;

                TransactionItem::create([
                    'transaction_id'=>$transaction->id,
                    'product_id'=>$p->id,
                    'quantity'=>$q,
                    'price'=>$p->price,
                    'subtotal'=>$subtotal,
                ]);

                $p->decrement('stock',$q);
                $total += $subtotal;
            }

            $transaction->update(['total'=>$total]);

            DB::commit();
            return redirect()->route('transactions.index')->with('success','Transaksi berhasil: '.$invoice);
        } catch(\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }


    public function destroy(Transaction $transaction)
    {
        foreach($transaction->items as $item){
            $item->product->increment('stock', $item->quantity);
        }
        
        $transaction->delete();
        return back()->with('success','Transaksi dihapus');
    }


    // ✅ SUMBUKAN METHOD PAY DI SINI (INSIDE THE CLASS!)
    public function pay(Request $request, $id)
    {
        $request->validate([
            'paid' => 'required|numeric|min:0'
        ]);

        $transaction = Transaction::findOrFail($id);

        $paid = $request->paid;

        if ($paid < $transaction->total) {
            return back()->with('error', 'Uang yang dibayar kurang dari total!');
        }

        $kembalian = $paid - $transaction->total;

        $transaction->update([
            'paid' => $paid,
            'change' => $kembalian,
            'status' => 'paid',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Pembayaran berhasil! Kembalian: Rp '.number_format($kembalian));
    }
}
