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
                    <h4 class="card-title">Kontak</h4>
                    <h6 class="card-subtitle">Atur alamat, no. HP, dan jam operasional</h6>
                    <div class="views-kontak">
                        <div class="mb-2 text-right">
                            <button class="btn btn-secondary btn-sm" id="btnEdit"><i class="fa fa-edit"></i> Edit</button>
                        </div>
                        <iframe id="maps_viewer" src="https://maps.google.com/maps?q=<?= $data->latitude_longitude ?>&z=15&output=embed" width="100%" height="270" frameborder="0" style="border:0"></iframe>
                        <div class="form-group">
                            <label for="">Alamat Lengkap</label>
                            <div id="">
                                <?= $data->alamat_lengkap ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <div id="">
                                <?= $data->no_telp ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Hari Operasional</label>
                            <div id="">
                                <?= $data->hari_operasional ?>
                            </div>
                        </div>
                    </div>
                    <div class="edit-kontak" style="display:none">
                        <div class="mb-2 text-right">
                            <button class="btn btn-secondary btn-sm" id="btnBack"><i class="fa fa-chevron-left"></i> Kembali</button>
                        </div>
                        <form class="mt-4" action="<?= base_url('admin/informasi-website/edit-contact') ?>" method="post">
                            <div class="form-group">
                                <label for="">Latitude Longitude (Maps)</label>
                                <input value="<?= $data->latitude_longitude ?>" required type="text" class="form-control" name="latitude_longitude" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat Lengkap</label>
                                <textarea required name="alamat_lengkap" class="form-control" autocomplete="off"><?= $data->alamat_lengkap ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">No. Telp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1">+62</span>
                                    </div>
                                    <input value="<?= substr($data->no_telp, 3) ?>" required type="text" class="form-control" name="no_telp" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Hari Operasional</label>
                                <input value="<?= $data->hari_operasional ?>" required type="text" class="form-control" name="hari_operasional" autocomplete="off">
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
        $(".edit-kontak").show();
        $(".views-kontak").hide();
    })

    $("#btnBack").click(function () {
        $(".edit-kontak").hide();
        $(".views-kontak").show();
    })
</script>