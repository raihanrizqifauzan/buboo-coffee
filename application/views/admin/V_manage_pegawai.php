<style>
    .col-sm-12, .col-12 {
        padding-left: 0px;
        padding-right: 0px;
    }

    .container-fluid {
        padding: 30px;
    }

    .card-body {
        padding: 10px;
    }

    th {
        display:none;
        border:none;
    }

    td {
        padding: 10px 3px !important;
    }
    
    #tbKategori_filter label {
        width:100%!important;
    }

    [type=search] {
        margin-left:0px!important;
        width:100%!important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="w-100">
                            <h4 class="card-title">Pegawai</h4>
                            <h6 class="card-subtitle">Kelola data Pegawai di Tokomu</h6>
                        </div>
                        <div class="mx-2">
                            <button type="button" id="btnAdd" class="btn btn-primary" data-toggle="modal" data-target="#modalKategori">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" width="100%" id="tb_admin">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAdmin" action="<?= base_url('admin/pegawai/create') ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_admin">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">No. HP</label>
                            <input type="number" name="no_hp" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" autocomplete="off" minlength="6">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">- Pilih Role -</option>
                                <option value="owner">Owner</option>
                                <option value="kasir">Kasir</option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("[name='icon_kategori']").select2({
        width: "100%"
    });

    var tb_admin = $('#tb_admin').DataTable({
        language: {
            "lengthMenu": "_MENU_",
            "search": ""
        },
        bDestroy: true,
        order: [[ 0, "desc" ]],
        bInfo: false,
        bLengthChange: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('admin/pegawai/ajax_get_admin')?>",
            type: "POST",
        },
    });

    $("#btnAdd").click(function () {
        $("#formAdmin").attr("action", "<?= base_url('admin/pegawai/create') ?>");
        $(".modal-title").html("Tambah Kategori");
        $("[name='password']").val("").attr("placeholder", "");
    })

    $(document).on("click", ".btnEdit", function (e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        $(this).closest(".dropdown-menu").removeClass("show");
        $.ajax({
            url: "<?= base_url('admin/pegawai/detail/') ?>" + id,
            beforeSend: function () {
                showLoading()
            },
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    swal.close();
                    var data = res.data;
                    $("[name='id_admin']").val(data.id);
                    $("[name='nama_lengkap']").val(data.nama_lengkap);
                    $("[name='no_hp']").val(data.no_hp);
                    $("[name='username']").val(data.username);
                    $("[name='role']").val(data.role).trigger("change");
                    $("[name='password']").val("").attr("placeholder", "Kosongkan jika tidak ingin mengubah password");
                    $("#modalKategori").modal("show");
                    $("#formAdmin").attr("action", "<?= base_url('admin/pegawai/update') ?>");
                    $(".modal-title").html("Edit Pegawai");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        $("#modalKategori").modal("hide");
                    });
                }
            }
        });
    })

    $(document).on('click', '.btnDelete', function(e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        $(this).closest(".dropdown-menu").removeClass("show");
        swal({
            title: 'Konfirmasi',
            html: "Pegawai akan dihapus ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                let link = "<?= base_url('admin/pegawai/delete/') ?>" + id;
                location.assign(link);
            }
        })
    });
</script>