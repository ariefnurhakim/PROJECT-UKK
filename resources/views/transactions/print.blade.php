<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* WRAPPER AGAR STRUK DI TENGAH */
        .wrapper {
            width: 260px; /* sedikit lebih besar dari 58mm supaya proporsional */
            background: white;
            margin-top: 20px;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 0 5px #bbb;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .left { text-align: left; }
        .small { font-size: 11px; }

        hr {
            border: 0;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }

        /* Sembunyikan tombol saat print */
        @media print {
            body { background: white; }
            .wrapper { box-shadow: none; margin-top: 0; }
            #btnArea { display: none; }
        }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- HEADER TOKO -->
    <div class="center" style="margin-bottom:5px;">
        <strong>TSIQOH SECOND STORE</strong><br>
        Barang Thrift Berkualitas<br>
        Jl. Kebersamaan No.10
    </div>
    <hr>

    <!-- DETAIL TRANSAKSI -->
    <table class="small">
        <tr><td>ID Struk</td><td>: {{ $transaction->id }}</td></tr>
        <tr><td>Invoice</td><td>: {{ $transaction->invoice }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ $transaction->created_at->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Kasir</td><td>: {{ auth()->user()->name ?? 'Admin' }}</td></tr>
        <tr><td>Metode</td><td>: {{ ucfirst($transaction->metode_pembayaran) }}</td></tr>

        @if (!empty($transaction->catatan))
        <tr><td>Catatan</td><td>: {{ $transaction->catatan }}</td></tr>
        @endif
    </table>
    <hr>

    <!-- PRODUK -->
    <table>
        <tr>
            <td><strong>Nama</strong></td>
            <td><strong>Kat</strong></td>
            <td class="center"><strong>Qty</strong></td>
            <td class="right"><strong>Total</strong></td>
        </tr>

        @foreach ($transaction->items as $item)
        <tr>
            <td>{{ $item->product->nama_produk }}</td>
            <td>{{ $item->product->kategori->nama_kategori ?? '-' }}</td>
            <td class="center">{{ $item->quantity }}</td>
            <td class="right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    <hr>

    <!-- TOTAL -->
    <table>
        <tr>
            <td><strong>TOTAL</strong></td>
            <td class="right"><strong>{{ number_format($transaction->total, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>DIBAYAR</td>
            <td class="right">{{ number_format($transaction->dibayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALIAN</td>
            <td class="right">{{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>
    <hr>

    <!-- FOOTER -->
    <div class="center small" style="margin-top:5px;">
        TERIMA KASIH SUDAH BELANJA ♻️<br>
        Barang thrift — Harga hemat, gaya tetap lekat!<br>
        <strong>TSIQOH SECOND STORE</strong>
    </div>

    <hr>

    <!-- BUTTON ARAH -->
    <div id="btnArea" class="center" style="margin-top:12px;">
        <button onclick="window.print()" 
                style="background:#28a745; color:white; padding:7px 0; width:100%;
                border:none; border-radius:5px; margin-bottom:8px; cursor:pointer;">
            🖨️ Cetak Struk
        </button>

        <a href="{{ route('transactions.index') }}" 
           style="display:block; background:#007bff; color:white; padding:7px 0;
           text-decoration:none; border-radius:5px;">
            ⬅️ Kembali ke Kasir
        </a>
    </div>

</div>

</body>
</html>
