<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: monospace; padding: 20px; }
        .center { text-align: center; }
        table { width: 100%; margin-top: 10px; }
        td { padding: 4px 0; }
        hr { border: 1px dashed #000; }
    </style>
</head>
<body onload="window.print()">

    <div class="center">
        <h3><strong>QASHIER STORE</strong></h3>
        <small>Jl. Contoh No. 123</small><br>
        <small>Telp: 0812-3456-7890</small>
    </div>

    <hr>

    <table>
        <tr>
            <td>Total</td>
            <td>: Rp {{ number_format($transaksi->total,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td>: Rp {{ number_format($transaksi->bayar,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td>: Rp {{ number_format($transaksi->kembalian,0,',','.') }}</td>
        </tr>
    </table>

    <hr>

    <p class="center">Terima kasih telah berbelanja 🙏</p>

</body>
</html>
