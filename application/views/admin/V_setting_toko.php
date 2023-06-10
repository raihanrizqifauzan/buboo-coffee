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
                    <h4 class="card-title">Profil Toko</h4>
                    <div class="row p-3 align-items-center">
                        <div class="col-lg-2 col-sm-12">
                            <div class="" style="border-radius:50%;background:#ddd;">
                                <img src="http://localhost/buboo-coffee/assets/public/img/logo2.png" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-10 col-sm-12">
                            <table class="table ml-3" id="tbKategori">
                                <tr>
                                    <td style="width:20%;font-weight:bold">Nama Toko</td>
                                    <td>Buboo Coffee <span class="iconify" data-icon="akar-icons:edit"></span></td>
                                </tr>
                                <tr>
                                    <td style="width:20%;font-weight:bold">No. HP</td>
                                    <td>+6281802136200 <span class="iconify" data-icon="akar-icons:edit"></span></td>
                                </tr>
                                <tr>
                                    <td style="width:20%;font-weight:bold">Alamat</td>
                                    <td>Jl. dr. Sudarsono, Kota Banjar <span class="iconify" data-icon="akar-icons:edit"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="row h-100">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Hari Operasional</h4>
                    <div class="row p-3">
                        <?php
                        $list_hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
                        foreach ($list_hari as $key => $hari) { ?>
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" checked class="status_aktif" data-id="" data-status="">
                                            <span class="slider round"></span>
                                        </label> 
                                        <?= $hari ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div><input type="time" class="form-control" value="09:00"></div>
                                        <div class="mx-2">s.d</div>
                                        <div><input type="time" class="form-control" value="23:59"></div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <div class="d-flex justify-content-end w-100 mt-4">
                            <div>
                                <button class="btn btn-sm btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jadwal Libur</h4>
                    <div class="row p-3 align-items-center">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Dari Tanggal</label>
                                <input type="date" class="form-control" value="2023-12-25">
                            </div>
                            <div class="form-group">
                                <label for="">Sampai Tanggal</label>
                                <input type="date" class="form-control" value="2023-12-31">
                            </div>
                            <div class="form-group">
                                <label for="">Alasan Libur</label>
                                <textarea name="" id="" class="form-control">Libur Taun Baru</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end w-100 mt-4">
                            <div>
                                <button class="btn btn-sm btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>