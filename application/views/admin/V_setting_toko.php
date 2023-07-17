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
                        <!-- <div class="col-lg-2 col-sm-12">
                            <div class="" style="border-radius:50%;background:#ddd;">
                                <img src="http://localhost/buboo-coffee/assets/public/img/logo2.png" alt="" class="img-fluid">
                            </div>
                        </div> -->
                        <div class="col-lg-10 col-sm-12">
                            <button class="btn btn-primary float-right mb-2" data-toggle="modal" data-target="#modalDataToko"><span class="iconify" data-icon="akar-icons:edit"></span></button>
                            <table class="table ml-3" id="tbKategori">
                                <?php 
                                $data_toko = getDataToko();
                                ?>
                                <tr>
                                    <td style="width:20%;font-weight:bold">Nama Toko</td>
                                    <td><?= $data_toko->nama_toko ?></td>
                                </tr>
                                <tr>
                                    <td style="width:20%;font-weight:bold">No. HP</td>
                                    <td><?= $data_toko->no_telp ?></td>
                                </tr>
                                <tr>
                                    <td style="width:20%;font-weight:bold">Alamat</td>
                                    <td><?= $data_toko->alamat_lengkap ?></td>
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
                        $list_hari = [
                            'mon' => 'Senin',
                            'tue' => 'Selasa',
                            'wed' => 'Rabu',
                            'thu' => 'Kamis',
                            'fri' => 'Jumat',
                            'sat' => 'Sabtu',
                            'sun' => 'Minggu',
                        ];
                        $hari_operasional = json_decode($data_toko->hari_operasional, TRUE);
                        foreach ($list_hari as $key => $hari) { 
                            $status = $hari_operasional[$key]['status'] == "on" ? "checked" : "";
                            ?>
                            <div class="col-sm-12 container-harim mt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" <?= $status ?> class="status" data-hari="<?= $key ?>" data-status="<?= $status == 'checked' ? 'aktif' : 'nonaktif' ?>">
                                            <span class="slider round"></span>
                                        </label> 
                                        <?= $hari ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div><input type="time" class="form-control start_date" value="<?= $hari_operasional[$key]['start_time'] ?>"></div>
                                        <div class="mx-2">s.d</div>
                                        <div><input type="time" class="form-control end_date" value="<?= $hari_operasional[$key]['end_time'] ?>"></div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <div class="d-flex justify-content-end w-100 mt-4">
                            <div>
                                <button class="btn btn-sm btn-success" id="saveHariOperasional">Simpan</button>
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
                    <?php 
                    $jadwal_libur = empty($data_toko->jadwal_libur) ? "" : json_decode($data_toko->jadwal_libur, TRUE);
                    $from = "";
                    $to = "";
                    $keterangan = "";
                    if (is_array($jadwal_libur)) {
                        $from = $jadwal_libur['datetime_start'];
                        $to = $jadwal_libur['datetime_end'];
                        $keterangan = $jadwal_libur['keterangan'];
                    }
                    ?>
                    <div class="row p-3 align-items-center">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Dari Tanggal</label>
                                <input type="datetime-local" id="datetime_start_libur" class="form-control" value="<?= $from ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sampai Tanggal</label>
                                <input type="datetime-local" id="datetime_end_libur" class="form-control" value="<?= $to ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Alasan Libur</label>
                                <textarea id="keterangan_libur" class="form-control"><?= $keterangan ?></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end w-100 mt-4">
                            <div>
                                <button class="btn btn-sm btn-success" id="saveJadwalLibur">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDataToko" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Toko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Toko</label>
                    <input type="text" id="nama_toko" value="<?= $data_toko->nama_toko ?>" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">No. HP</label>
                    <input type="text" id="no_telp" value="<?= $data_toko->no_telp ?>" class="form-control" autocomplete="off" placeholder="Harus Diawali dengan +62">
                </div>
                <div class="form-group">
                    <label for="">Alamat Lengkap</label>
                    <input type="text" id="alamat_lengkap" value="<?= $data_toko->alamat_lengkap ?>" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnUpdateToko">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#btnUpdateToko").click(function () {
        $.ajax({
            url: "<?= base_url('admin/setting/update_data_toko/') ?>",
            beforeSend: function () {
                showLoading()
            },
            type: "POST",
            data: {
                nama_toko: $("#nama_toko").val(),
                no_telp: $("#no_telp").val(),
                alamat_lengkap: $("#alamat_lengkap").val(),
            },
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        window.location.href = "<?= base_url('/admin/setting/') ?>"
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                    });
                }
            }
        });
    })

    $("#saveJadwalLibur").click(function () {
        $.ajax({
            url: "<?= base_url('admin/setting/update_jadwal_libur/') ?>",
            beforeSend: function () {
                showLoading()
            },
            type: "POST",
            data: {
                datetime_start: $("#datetime_start_libur").val(),
                datetime_end: $("#datetime_end_libur").val(),
                keterangan: $("#keterangan_libur").val(),
            },
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                    });
                }
            }
        });
    })

    $(".status").change(function () {
        if ($(this).is(":checked")) {
            var start_time = $(this).closest(".container-hari").find(".start_date").val();
            var end_time = $(this).closest(".container-hari").find(".end_date").val();

            if (start_time == "" || end_time == "") {
                $(this).prop("checked", false)
            }
        } else {
            // $(this).prop("checked", true)
            $(this).closest(".container-hari").find(".start_date").val("");
            $(this).closest(".container-hari").find(".end_date").val("");
        }
    })

    $("#saveHariOperasional").click(function () {
        var start_time = [], end_time = [], status = [];
        $(".start_date").each(function (i, obj) {
            start_time.push($(obj).val());
        })

        $(".end_date").each(function (i, obj) {
            end_time.push($(obj).val());
        })

        $(".status").each(function (i, obj) {
            if ($(obj).is(":checked")) {
                status.push("on");
            } else {
                status.push("off");
            }
        })

        var obj = {
            start_time: start_time,
            end_time: end_time,
            status: status,
        }

        $.ajax({
            url: "<?= base_url('admin/setting/update_hari_operasional/') ?>",
            beforeSend: function () {
                showLoading()
            },
            type: "POST",
            data: obj,
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                    });
                }
            }
        });
    })
</script>