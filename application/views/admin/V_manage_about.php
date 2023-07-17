<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Informasi Kontak</h4>
        </div>
        <div class="col-12 col-md-6 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Informasi Website</li>
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
                    <h4 class="card-title">About</h4>
                    <h6 class="card-subtitle">Atur konten di halaman about</h6>
                    <div class="views-about">
                        <div class="mb-2 text-right">
                            <button class="btn btn-secondary btn-sm" id="btnEdit"><i class="fa fa-edit"></i> Edit</button>
                        </div>
                        <div class="text-justify">
                            <?= $data->content_about ?>
                        </div>
                    </div>
                    <div class="edit-about" style="display:none">
                        <div class="mb-2 text-right">
                            <button class="btn btn-secondary btn-sm" id="btnBack"><i class="fa fa-chevron-left"></i> Kembali</button>
                        </div>
                        <form class="mt-4" action="<?= base_url('admin/informasi-website/edit-about') ?>" method="post">
                            <div class="form-group">
                                <label for="">Konten Halaman About</label>
                                <textarea required class="form-control" id="editor1" name="content_about"><?= $data->content_about ?></textarea>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-success" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#btnEdit").click(function () {
        $(".edit-about").show();
        $(".views-about").hide();
    })

    $("#btnBack").click(function () {
        $(".edit-about").hide();
        $(".views-about").show();
    })

    CKEDITOR.replace( 'editor1' );
</script>