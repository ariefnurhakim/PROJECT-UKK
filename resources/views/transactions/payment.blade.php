@extends('layouts.app')
@section('title','Pembayaran')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-primary">Pembayaran</h3>

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

                <!-- HIDDEN INPUT untuk dikirim ke controller -->
                <input type="hidden" name="kembalian" id="kembalian_hidden">

                <!-- Metode Pembayaran -->
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">💵 Cash</option>
                        <option value="transfer">🏦 Transfer Bank</option>
                        <option value="qris">📱 QRIS</option>
                        <option value="ewallet">💳 E-Wallet (Dana, OVO, Gopay, dll)</option>
                    </select>
                </div>

                <!-- Input Transfer -->
                <div class="mb-3 d-none" id="transfer-info">
                    <label class="form-label">Nama Bank / No. Rekening</label>
                    <input type="text" name="bank" class="form-control" placeholder="Contoh: BCA - 1234567890 a.n. Arief">
                </div>

                <!-- QRIS -->
                <div class="mb-3 d-none" id="qris-info">
                    <label class="form-label">Scan QRIS</label>
                    <div class="text-center">
                        <img src="/img/qris.png" alt="QRIS" class="img-fluid" style="max-width:250px;">
                    </div>
                </div>

                <!-- E-Wallet -->
                <div class="mb-3 d-none" id="ewallet-info">
                    <label class="form-label">Pilih E-Wallet</label>
                    <select name="ewallet_type" class="form-select">
                        <option value="Dana">Dana</option>
                        <option value="OVO">OVO</option>
                        <option value="Gopay">Gopay</option>
                        <option value="ShopeePay">ShopeePay</option>
                    </select>

                    <label class="form-label mt-2">Nomor / Nama Akun</label>
                    <input type="text" name="ewallet_account" class="form-control" placeholder="Contoh: 0812xxxxxx a.n Arief">
                </div>

                <button class="btn btn-success w-100 mt-3">Proses Pembayaran</button>
            </form>
        </div>
    </div>
</div>

<script>
    const total = {{ $total }};
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
        kembalianHidden.value = kembali; // simpan untuk dikirim ke backend
    }

    function cekPembayaran() {
        let dibayar = parseInt(document.getElementById("dibayar").value);

        if (dibayar < total) {
            notifKurang.classList.remove("d-none");
            return false;
        }
        return true;
    }

    const metodeSelect = document.getElementById('metode_pembayaran');
    const transferInfo = document.getElementById('transfer-info');
    const qrisInfo = document.getElementById('qris-info');
    const ewalletInfo = document.getElementById('ewallet-info');

    metodeSelect.addEventListener('change', function() {
        transferInfo.classList.add('d-none');
        qrisInfo.classList.add('d-none');
        ewalletInfo.classList.add('d-none');

        if (this.value === 'transfer') transferInfo.classList.remove('d-none');
        if (this.value === 'qris') qrisInfo.classList.remove('d-none');
        if (this.value === 'ewallet') ewalletInfo.classList.remove('d-none');
    });
</script>

@endsection
