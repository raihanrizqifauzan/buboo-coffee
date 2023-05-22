<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Menu</h4>
            <h6 class="card-subtitle">Kelola Menu yang tersedia</h6>
        </div>
        <div class="col-12 col-md-6 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Manage Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center mb-2">
                        <div>
                            <a type="button" href="<?= base_url('admin/menu/add/') ?>" class="btn btn-primary">
                                Tambah Menu
                            </a>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-bordered mb-2">
                        <li class="nav-item filter-status" data-filter="">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Semua</span>
                            </a>
                        </li>
                        <li class="nav-item filter-status" data-filter="aktif">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Dijual</span>
                            </a>
                        </li>
                        <li class="nav-item filter-status" data-filter="nonaktif">
                            <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Tidak Dijual</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table class="table" width="100%" id="tbMenu">
                                <thead>
                                    <tr>
                                        <th class="text-center">Thumbnail</th>
                                        <th>Nama Menu</th>
                                        <th>Harga</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
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
    });

    $(".filter-status").click(function () {
        filter_status = $(this).data("filter");
        tbMenu.ajax.reload();
    })

    function showLoading() {
        return Swal.fire({
            title: 'Loading...',
            width: 600,
            padding: '3em',
            allowOutsideClick: false,
            timer: 500,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

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
                    Swal.close();
                    var data = res.data;
                    $("[name='id_kategori']").val(data.id_kategori);
                    $("[name='nama_kategori']").val(data.nama_kategori);
                    $("[name='icon_kategori']").val(data.icon_kategori).trigger("change");
                    $("#modalKategori").modal("show");
                    $("#formKategori").attr("action", "<?= base_url('admin/kategori/update') ?>");
                } else {
                    Swal.fire("Oops...", res.message, "error").then(function () {
                        $("#modalKategori").modal("hide");
                    });
                }
            }
        });
    })

    $(document).on('click', '.deleteKategori', function(e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        Swal.fire({
            title: 'Konfirmasi',
            html: "Kategori akan dihapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
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

        Swal.fire({
            title: "",
            text: "Update Status Menu ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: `<?= base_url('admin/menu/update_status_menu') ?>?id=${id_menu}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            Swal.fire("Sukses", res.message, "success").then(function () {
                                tbMenu.ajax.reload();
                            });
                        } else {
                            Swal.fire("Oops...", res.message, "error").then(function () {
                                tbMenu.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })
</script>