<style>
    .col-sm-12, .col-12 {
        padding-left: 0px;
        padding-right: 0px;
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

    [type=search] {
        margin-left:0px!important;
        width:100%!important;
    }
</style>
<div class="container-fluid">
    <div class="row h-100">
        <div class="col-sm-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="w-100">
                            <h4 class="card-title">Report</h4>
                            <h6 class="card-subtitle">Unduh Laporan Omset harian, Laporan Data Order, dan Laporan Menu Terjual</h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">File Report</label>
                                <select class="form-control" id="jenis">
                                    <option value="semua">Semua</option>
                                    <option value="omset_per_hari">Omset per Hari</option>
                                    <option value="data_order">Data Order</option>
                                    <option value="barang_terjual">Barang Terjual</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Dari Tanggal</label>
                                <input type="date" class="form-control" id="date_start">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="date_end">
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-success" id="btnExport">Unduh</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-sm-12">
            <div class="card p-1" style="min-height:300px;">
                <div class="card-body">
                    <h4 class="card-title">Keranjang</h4>
                    <div class="mt-2" id="area-keranjang">
                        
                    </div>
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <b>Potongan Harga</b>
                                <div><span id="diskon_cart">Rp0</span></div>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <b>Total</b>
                                <div id="total_cart">Rp0</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-end align-items-end">
                                <button class="btn btn-success" disabled id="btnSubmit">Submit</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div> -->
    </div>
</div>

<script>
    $("#btnExport").click(function () {
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();
        prosesExport("omset per hari", date_start, date_end);
        prosesExport("data order", date_start, date_end);
        prosesExport("menu terjual", date_start, date_end);
    })

    async function prosesExport(type, date_start, date_end) {
        var urlExport;
        if (type == "omset per hari") {
            urlExport = "export_omset_per_hari";
        } else if (type == "data order") {
            urlExport = "export_data_order";
        } else if (type == "menu terjual") {
            urlExport = "export_menu_terjual";
        } else {
            swal("Gagal", "Terjadi Kesalahan", "error");
            return;
        }
    
        swal({
            title: "Checking...",
            text: "Please wait",
            imageUrl: "https://www.boasnotas.com/img/loading2.gif",
            showConfirmButton: false,
            allowOutsideClick: true,
            allowOutsideClick: true,
        });
    
        $.ajax({
            url: "report/"+urlExport,
            data: {
                date_start,
                date_end
            },
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function(data) {
                swal.close();
                if (type == "menu terjual") {
                    downloadZipReport(date_start, date_end)
                }
            }
        });
    
    }
    
    async function downloadZipReport(date_start, date_end) {
        $.ajax({
            url: "<?= base_url('admin/report/zip_report') ?>",
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                date_start, date_end
            },
            success: function(data) {
                console.log(data);
                if (data.status) {
                    window.location.href = data.link;
                } else {
                    swal("Gagal", "Gagal mengunduh file. Terjadi Kesalahan", "error");
                }
            }
        });
    }
</script>