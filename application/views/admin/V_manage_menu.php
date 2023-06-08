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

    #tbMenu_filter label {
        width:100%!important;
    }
    [type=search] {
        margin-left:0px!important;
        width:100%!important;
    }

    .filter-status {
        cursor:pointer;
    }
    .filter-status.active {
        background: #5f76e8;
    }

    .filter-status.active a{
        color:#FFF!important;
    }

    .title-product {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }

    .title-product {
        -webkit-line-clamp: 2;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Menu</h4>
            <h6 class="card-subtitle">Kelola Menu yang tersedia</h6>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center mb-4">
                        <div>
                            <a type="button" href="<?= base_url('admin/menu/add/') ?>" class="btn btn-primary">
                                Tambah Menu
                            </a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between w-100 text-center">
                        <div class="w-100 nav-item filter-status active p-2" data-filter="">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="">
                                <i class="mdi mdi-home-variant mr-1"></i>
                                <span class="">Semua</span>
                            </a>
                        </div>
                        <div class="w-100 nav-item filter-status p-2" data-filter="aktif">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="">
                                <i class="mdi mdi-home-variant mr-1"></i>
                                <span class="">Dijual</span>
                            </a>
                        </div>
                        <div class="w-100 nav-item filter-status p-2" data-filter="nonaktif">
                            <a href="#profile" data-toggle="tab" aria-expanded="true" class="">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span class="">Nonaktif</span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="">
                        <div class="table-responsive">
                            <table class="table" id="tbMenu" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditStok">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditStok">Edit Stok</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-menu" class="form-control">
        <input type="number" id="edit-stok" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCloseStok" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSaveStok">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
    $("[name='icon_kategori']").select2({
        width: "100%"
    });

    var filter_status = "";
    var tbMenu = $('#tbMenu').DataTable({
        language: {
            "lengthMenu": "_MENU_",
            "search": ""
        },
        bDestroy: true,
        bLengthChange: false,
        order: [[ 0, "desc" ]],
        bInfo: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('admin/menu/ajax_get_menu')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = filter_status
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari Disini")
        }
    });

    $(".filter-status").click(function () {
        $(".filter-status").removeClass("active");
        $(this).addClass("active");
        filter_status = $(this).data("filter");
        tbMenu.ajax.reload();
    })

    $("#btnAdd").click(function () {
        $("#formKategori").attr("action", "<?= base_url('admin/kategori/create') ?>");
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

    $("#tbMenu").on("click", ".status_aktif", function (e) {
        e.stopImmediatePropagation();
        var id_menu = $(this).data("id");
        var status = $(this).data("status");

        if ($(this).is(":checked")) {
            $(this).prop("checked", false);
            var message = "Menu yang di aktifkan dapat dilihat dan diorder oleh customer";
        } else {
            $(this).prop("checked", true);
            var message = "Menu yang di nonaktifkan tidak dapat dilihat dan diorder oleh customer";
        }

        swal({
            title: "",
            text: "Update Status Menu ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: `<?= base_url('admin/menu/update_status_menu') ?>?id=${id_menu}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            swal("Sukses", res.message, "success").then(function () {
                                tbMenu.ajax.reload();
                            });
                        } else {
                            swal("Oops...", res.message, "error").then(function () {
                                tbMenu.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })

    $(document).on("click", ".editStok", function () {
        var stok = $(this).data("stok");
        var id_menu = $(this).data("id");
        $("#id-menu").val(id_menu)
        $("#edit-stok").val(stok)
        $("#modalEditStok").modal("show")
    })

    $("#btnCloseStok").click(function () {
        $("#id-menu").val("")
        $("#edit-stok").val("")
        $("#modalEditStok").modal("hide")
    })

    $("#btnSaveStok").click(function () {
        var id_menu = $("#id-menu").val();
        var stok = $("#edit-stok").val();
        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/menu/update_stok') ?>`,
            data: {id_menu: id_menu, stok: stok},
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        $("#modalEditStok").modal("hide")
                        tbMenu.ajax.reload();
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbMenu.ajax.reload();
                    });
                }
            }
        });
    })
</script>