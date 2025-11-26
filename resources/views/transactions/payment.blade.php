@extends('layouts.app')
@section('title','Pembayaran')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-primary">Pembayaran (Cash)</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('transactions.process') }}" method="POST" onsubmit="return cekPembayaran()">
                @csrf

                <!-- Total -->
                <div class="mb-3">
                    <label class="form-label">Total Pembayaran</label>
                    <input type="text" class="form-control" 
                           value="Rp{{ number_format($total,0,',','.') }}" readonly>
                </div>

                <!-- Uang diterima -->
                <div class="mb-3">
                    <label class="form-label">Uang Diterima</label>
                    <input type="number" name="dibayar" id="dibayar" class="form-control" 
                           placeholder="Masukkan jumlah uang" required oninput="hitungKembalian()">
                </div>

                <!-- Notif uang kurang -->
                <div class="alert alert-danger d-none" id="notifKurang">
                    ❌ Uangnya kurang bro!
                </div>

                <!-- Kembalian -->
                <div class="mb-3">
                    <label class="form-label">Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" readonly>
                </div>

                <!-- Diset otomatis bahwa metode pembayaran = cash -->
                <input type="hidden" name="metode_pembayaran" value="cash">

                <!-- HIDDEN INPUT untuk dikirim ke controller -->
                <input type="hidden" name="kembalian" id="kembalian_hidden">

                <button class="btn btn-success w-100 mt-3">Proses Pembayaran</button>
            </form>
        </div>
    </div>
</div>

<script>
    const total = { $total };
    const notifKurang = document.getElementById("notifKurang");
    const kembalianInput = document.getElementById("kembalian");
    const kembalianHidden = document.getElementById("kembalian_hidden");

    function hitungKembalian() {
        let dibayar = parseInt(document.getElementById("dibayar").value);

        if (!dibayar || dibayar < total) {
            notifKurang.classList.remove("d-none");
            kembalianInput.value = "";
            kembalianHidden.value = "";
            return;
        }

        notifKurang.classList.add("d-none");

        let kembali = dibayar - total;

        kembalianInput.value = "Rp " + kembali.toLocaleString("id-ID");
        kembalianHidden.value = kembali;
    }

    function cekPembayaran() {
        let dibayar = parseInt(document.getElementById("dibayar").value);

        if (dibayar < total) {
            notifKurang.classList.remove("d-none");
            return false;
        }
        return true;
    }
</script>

@endsection
