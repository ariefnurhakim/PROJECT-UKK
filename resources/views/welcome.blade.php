<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalDelete" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- UBAH bg-danger → bg-secondary (abu) -->
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Yakin ingin menghapus produk <b id="nama-produk"></b> ?
      </div>

      <div class="modal-footer">
        <form id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>

            <!-- Tombol hapus tetap merah biar jelas -->
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalDelete = new bootstrap.Modal(document.getElementById('modalDelete'));

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {

            let id = this.dataset.id;
            let nama = this.dataset.nama;

            document.getElementById('nama-produk').textContent = nama;
            document.getElementById('formDelete').action = "/products/" + id;

            modalDelete.show();
        });
    });
});
</script>
