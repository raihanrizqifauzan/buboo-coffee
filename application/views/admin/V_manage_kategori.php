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
                            <h4 class="card-title">Kategori</h4>
                            <h6 class="card-subtitle">Kelola kategori Menu di Tokomu</h6>
                        </div>
                        <div class="mx-2">
                            <button type="button" id="btnAdd" class="btn btn-primary" data-toggle="modal" data-target="#modalKategori">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" width="100%" id="tbKategori">
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
            <form id="formKategori" action="<?= base_url('admin/kategori/create') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_kategori">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" autocomplete="off">
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Icon Kategori</label>
                        <select name="icon_kategori" class="form-control">
                            <option value="">- Pilih Icon -</option>
                            <?php 
                            foreach ($list_icon as $key => $icon) {
                                echo '<option value="'.$icon.'">'.$icon.'</option>';
                            }
                            ?>
                        </select>
                        <small>Referensi Icon : <a href="https://openmoji.org/library/#group=food-drink%2Fdrink" target="_blank">Klik Disini</a></small>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("[name='icon_kategori']").select2({
        width: "100%"
    });

    var tbKategori = $('#tbKategori').DataTable({
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
            url: "<?php echo site_url('admin/kategori/ajax_get_kategori')?>",
            type: "POST",
        },
    });

    $("#btnAdd").click(function () {
        $("#formKategori").attr("action", "<?= base_url('admin/kategori/create') ?>");
        $(".modal-title").html("Tambah Kategori");
    })

    $(document).on("click", ".editKategori", function (e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        $.ajax({
            url: "<?= base_url('admin/kategori/detail/') ?>" + id,
            beforeSend: function () {
                showLoading()
            },
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    swal.close();
                    var data = res.data;
                    $("[name='id_kategori']").val(data.id_kategori);
                    $("[name='nama_kategori']").val(data.nama_kategori);
                    $("[name='icon_kategori']").val(data.icon_kategori).trigger("change");
                    $("#modalKategori").modal("show");
                    $("#formKategori").attr("action", "<?= base_url('admin/kategori/update') ?>");
                    $(".modal-title").html("Edit Kategori");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        $("#modalKategori").modal("hide");
                    });
                }
            }
        });
    })

    $(document).on('click', '.deleteKategori', function(e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        swal({
            title: 'Konfirmasi',
            html: "Kategori akan dihapus ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                let link = "<?= base_url('admin/kategori/delete/') ?>" + id;
                location.assign(link);
            }
        })
    });
</script>