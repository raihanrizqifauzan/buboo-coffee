<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">QR Code Meja</h4>
        </div>
        <div class="col-12 col-md-6 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">QR Code Meja</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <button class="btn btn-sm btn-secondary" id="editMeja"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCetak"><i class="fa fa-download"></i> Cetak</button>
            </div>
            <div class="card mt-2">
                <div class="card-body text-center">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="iconify fa-2x" data-icon="material-symbols:table-bar-outline"></span>
                            <div class="mt-1">Jumlah Meja</div>
                        </div>
                        <div class="col-6">
                            <p style="font-size:60px;"><?= $jumlah_meja ?></p>
                        </div>
                    </div>
                </div>
                <!-- <div class="card-body">
                    <div class="form-group">
                        <label for="">Masukkan berapa Banyak No. yang akan di Cetak</label>
                        <input type="text" class="form-control" id="jumlah" placeholder="Jumlah Meja">
                    </div>
                    <div class="form-group text-right">
                        <a href="javascript:void(0)" class="btn btn-primary" id="submitMeja">Submit</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalMeja">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Edit Meja</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="">Jumlah Meja sekarang</label>
            <input type="number" id="jumlah_meja" class="form-control" value="<?= $jumlah_meja ?>">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCloseStok" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCetak">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Cetak Meja</h5>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Opsi Cetak</label>
                <select class="form-control" id="opsi_cetak">
                    <option value="semua">Cetak Semua Nomor Meja</option>
                    <option value="custom">Cetak Custom</option>
                </select>
            </div>
            <div class="form-group" id="row_cetak_custom" style="display:none">
                <label for="">Meja yang akan dicetak</label>
                <input type="text" class="form-control" id="meja_cetak">
                <small>dapat dipisahkan dengan tanda koma</small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnCloseStok" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btnCetak">Cetak</button>
        </div>
      </div>
    </div>
</div>

<script>
    $("#editMeja").click(function () {
        $("#modalMeja").modal("show");    
    })

    $("#submitMeja").click(function () {
        var jumlah_meja = $("#jumlah").val();
        if (jumlah_meja != "") {
            window.location.href="<?= base_url('admin/meja/generate_qr?jumlah=') ?>" + jumlah_meja;
        }
    })

    $("#btnSave").click(function () {
        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/meja/update_meja') ?>`,
            dataType: "JSON",
            data: {
                jumlah_meja: $("#jumlah_meja").val(),
            },
            success: function(res) {
                if (res.status) {
                    location.reload();
                } else {
                    swal("Oops...", res.message, "error");
                }
            }
        });
    })

    $("#opsi_cetak").change(function () {
        var opsi_cetak = $(this).val();
        if (opsi_cetak == "semua") {
            $("#meja_cetak").val("");
            $("#row_cetak_custom").hide();
        } else {
            $("#row_cetak_custom").show();
        }
    })

    $("#btnCetak").click(function () {
        var opsi_cetak = $("#opsi_cetak").val();
        if (opsi_cetak == "semua") {
            window.location.href="<?= base_url('admin/meja/generate_qr?meja=all') ?>";
        } else {
            var meja_cetak = $("#meja_cetak").val();
            window.location.href="<?= base_url('admin/meja/generate_qr?meja=') ?>" + meja_cetak;
        }
    })
</script>