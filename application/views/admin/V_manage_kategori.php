<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manage Kategori</h4>
        </div>
        <div class="col-12 col-md-6 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Manage Kategori</li>
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h4 class="card-title">Kategori</h4>
                            <h6 class="card-subtitle">Manage Kategori menu makanan dan minuman</h6>
                        </div>
                        <div>
                            <button type="button" id="btnAdd" class="btn btn-primary" data-toggle="modal" data-target="#modalKategori">
                                Tambah Kategori
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" width="100%" id="tbKategori">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Icon Kategori</th>
                                    <th>Action</th>
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
                    <div class="form-group">
                        <label for="">Icon Kategori</label>
                        <select name="icon_kategori" class="form-control">
                            <option value="">- Pilih Icon -</option>
                            <?php 
                            foreach ($list_icon as $key => $icon) {
                                echo '<option value="'.$icon.'">'.$icon.'</option>';
                            }
                            ?>
                        </select>
                    </div>
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
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('admin/kategori/ajax_get_kategori')?>",
            type: "POST",
        },
    });

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
</script>