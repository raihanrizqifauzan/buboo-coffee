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

    .edit_voucher:hover {
        color:#5f76e8;
        cursor:pointer;
    }

    .badge-jenis {
        border-radius:8px;
    }

    .copy-voucher:hover {
        color:#3498db;
    }
    /* The snackbar - position it at the bottom and in the middle of the screen */
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 9999999999;
        left: 50%;
        bottom: 30px;
    }
    
    /* Show the snackbar when clicking on a button (class added with JavaScript) */
    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 1.5s;
        animation: fadein 0.5s, fadeout 0.5s 1.5s;
    }
    
    /* Animations to fade the snackbar in and out */
    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }
    
        to {
            bottom: 30px;
            opacity: 1;
        }
    }
    
    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }
    
        to {
            bottom: 30px;
            opacity: 1;
        }
    }
    
    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }
    
        to {
            bottom: 0;
            opacity: 0;
        }
    }
    
    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }
    
        to {
            bottom: 0;
            opacity: 0;
        }
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Promosi Toko</h4>
            <h6 class="card-subtitle">Kelola Voucher Promosi untuk meningkatkan penjualanmu</h6>
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
                            <button type="button" id="btnAdd" class="btn btn-primary">
                                Tambah Promo
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between w-100 text-center">
                        <div class="w-100 nav-item filter-status active p-2" data-filter="">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="">
                                <i class="mdi mdi-home-variant mr-1"></i>
                                <span class="">Semua</span>
                            </a>
                        </div>
                        <div class="w-100 nav-item filter-status p-2" data-filter="berjalan">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="">
                                <i class="mdi mdi-home-variant mr-1"></i>
                                <span class="">Berjalan</span>
                            </a>
                        </div>
                        <div class="w-100 nav-item filter-status p-2" data-filter="mendatang">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="">
                                <i class="mdi mdi-home-variant mr-1"></i>
                                <span class="">Mendatang</span>
                            </a>
                        </div>
                        <div class="w-100 nav-item filter-status p-2" data-filter="selesai">
                            <a href="#profile" data-toggle="tab" aria-expanded="true" class="">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span class="">Selesai</span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="">
                        <div class="table-responsive">
                            <table class="table" id="tbPromo" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="snackbar">Kode Voucher telah disalin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalVoucher">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Promo Voucher</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 form-group">
                <label for="">Jenis Promo</label>
                <select class="form-control" id="jenis_promo">
                    <option value="potongan harga">Potongan Harga</option>
                    <option value="buy x get y">Buy x Get y</option>
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <label for="">Judul Voucher</label>
                <input type="hidden" class="form-control" id="id_voucher">
                <input type="text" class="form-control" id="judul_voucher">
            </div>
            <div class="col-sm-6 form-group">
                <label for="">Kode Voucher</label>
                <input type="text" class="form-control" id="kode_voucher">
            </div>
            <div class="col-sm-6 form-group buyxgety" style="display:none;">
                <label for="">Syarat Quantity Beli</label>
                <input type="number" class="form-control" id="syarat_quantity">
            </div>
            <div class="col-sm-6 form-group buyxgety" style="display:none;">
                <label for="">Quantity Gratisan</label>
                <input type="text" class="form-control" id="quantity_gratisan">
            </div>
            <div class="col-sm-6 form-group potongan">
                <label for="">Tipe Potongan</label>
                <select class="form-control" id="tipe_potongan">
                    <option value="fix">Fix</option>
                    <option value="persen">Persen</option>
                </select>
            </div>
            <div class="col-sm-6 form-group potongan">
                <label for="">Nilai Potongan</label>
                <input type="number" class="form-control" id="nilai_potongan">
            </div>
            <div class="col-sm-6 form-group potongan">
                <label for="">Maksimal Potongan (Rp)</label>
                <input type="number" class="form-control" id="max_potongan" disabled>
            </div>
            <div class="col-sm-6 form-group">
                <label for="">Maksimal Penggunaan per User</label>
                <input type="number" class="form-control" id="max_penggunaan">
            </div>
            <div class="col-lg-6 form-group">
                <label for="">Menu Promo</label>
                <select id="menu_promo" name="menu_promo[]" multiple="multiple" class="form-control" required>
                    <?php 
                    foreach ($list_menu as $key => $row) { ?>
                        <option value="<?= $row->id_menu ?>"><?= $row->nama_menu ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="">Tanggal Mulai</label>
                <input type="datetime-local" class="form-control" id="datetime_start">
            </div>
            <div class="col-sm-6 form-group">
                <label for="">Tanggal Selesai</label>
                <input type="datetime-local" class="form-control" id="datetime_end">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
    var filter_status = "";
    var action = "create";
    var tbPromo = $('#tbPromo').DataTable({
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
            url: "<?php echo site_url('admin/promo/ajax_get_promo')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = filter_status
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari Disini")
        }
    });

    $("#btnAdd").click(function () {
        action = "create";
        $("#modalVoucher").modal("show");
    })

    $("#modalVoucher").on("hidden.bs.modal", function () {
        $("#id_voucher").val("");
        $("#judul_voucher").val("");
        $("#kode_voucher").val("");
        $("#jenis_promo").val("potongan harga").trigger("change");
        $("#tipe_potongan").val("").trigger("change");
        $("#nilai_potongan").val("");
        $("#max_potongan").val("");
        $("#syarat_quantity").val("");
        $("#quantity_gratisan").val("");
        $("#menu_promo").val("").trigger("change");
        $("#max_penggunaan").val("");
        $("#datetime_start").val("");
        $("#datetime_end").val("");
    })

    $(".filter-status").click(function () {
        $(".filter-status").removeClass("active");
        $(this).addClass("active");
        filter_status = $(this).data("filter");
        tbPromo.ajax.reload();
    })

    $('#menu_promo').select2({
        closeOnSelect: false,
        placeholder: "Pilih Menu",
        width:"100%",
        dropdownPosition: 'below'
    });
    
    $("#jenis_promo").change(function () {
        var tipe = $(this).val();
        if (tipe == "potongan harga") {
            $(".buyxgety").hide();
            $(".potongan").show();
        } else {
            $(".buyxgety").show();
            $(".potongan").hide();
        }
    })

    $("#tipe_potongan").change(function () {
        var tipe = $(this).val();
        if (tipe == "fix") {
            var nilai_potongan = $("#nilai_potongan").val();
            $("#max_potongan").val(nilai_potongan).prop("disabled", true);
        } else {
            $("#max_potongan").prop("disabled", false);
        }
    })

    $("#nilai_potongan").keyup(function () {
        var tipe = $("#tipe_potongan").val();
        var nilai_potongan = $(this).val();
        if (tipe == "fix") {
            $("#max_potongan").val(nilai_potongan);
        }
    })

    $("#btnSave").click(function () {
        var obj = {
            id_voucher: $("#id_voucher").val(),
            jenis_promo: $("#jenis_promo").val(),
            judul_voucher: $("#judul_voucher").val(),
            kode_voucher: $("#kode_voucher").val(),
            tipe_potongan: $("#tipe_potongan").val(),
            nilai_potongan: $("#nilai_potongan").val(),
            max_potongan: $("#max_potongan").val(),
            max_penggunaan: $("#max_penggunaan").val(),
            menu_promo: $("#menu_promo").val(),
            datetime_start: $("#datetime_start").val(),
            datetime_end: $("#datetime_end").val(),
            syarat_quantity: $("#syarat_quantity").val(),
            quantity_gratisan: $("#quantity_gratisan").val(),
        };

        if (action == "create") {
            var func = "create_promo";
        } else {
            var func = "update_promo";
        }

        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/promo/') ?>${func}`,
            data: obj,
            beforeSend: function () {
                showLoading()  
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        $("#modalVoucher").modal("hide")
                        tbPromo.ajax.reload();
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        tbPromo.ajax.reload();
                    });
                }
            }
        });
    })

    $("#tbPromo").on("click", ".edit_voucher", function (e) {
        e.stopImmediatePropagation();
        var id = $(this).data("id");
        action = "update";
        $.ajax({
            type: 'GET',
            url: `<?= base_url('admin/promo/get_detail?id=') ?>`+id,
            beforeSend: function () {
                showLoading()  
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal.close();
                    var data = res.data;
                    $("#id_voucher").val(data.id_voucher);
                    $("#judul_voucher").val(data.judul_voucher);
                    $("#kode_voucher").val(data.kode_voucher);
                    $("#jenis_promo").val(data.jenis_promo).trigger("change");
                    if (data.jenis_promo == "potongan harga") {
                        $("#tipe_potongan").val(data.tipe_potongan).trigger("change");
                        $("#nilai_potongan").val(data.nilai_potongan);
                        $("#max_potongan").val(data.max_potongan);
                    } else {
                        $("#syarat_quantity").val(data.syarat_quantity);
                        $("#quantity_gratisan").val(data.quantity_gratisan);
                    }
                    var id_menu = [];
                    data.menu_promo.forEach(e => {
                        id_menu.push(e.id_menu);
                    });

                    $("#menu_promo").val(id_menu).trigger("change");
                    $("#max_penggunaan").val(data.max_penggunaan);
                    $("#datetime_start").val(data.datetime_start);
                    $("#datetime_end").val(data.datetime_end);
                    $("#modalVoucher").modal("show");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        tbPromo.ajax.reload();
                    });
                }
            }
        });
    })

    $("#tbPromo").on("click", ".status_voucher", function (e) {
        e.stopImmediatePropagation();
        var id_voucher = $(this).data("id");
        var status = $(this).data("status");

        if ($(this).is(":checked")) {
            $(this).prop("checked", false);
            var message = "Aktifkan Voucher ?";
        } else {
            $(this).prop("checked", true);
            var message = "Nonaktifkan Voucher ?";
        }

        swal({
            title: "",
            text: message,
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
                    url: `<?= base_url('admin/promo/update_status_voucher') ?>?id=${id_voucher}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            swal("Sukses", res.message, "success").then(function () {
                                tbPromo.ajax.reload();
                            });
                        } else {
                            swal("Oops...", res.message, "error").then(function () {
                                tbPromo.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })

    function copyKodeVoucher(kode_voucher) {
        var dummy = document.createElement("input");
        // Add it to the document
        document.body.appendChild(dummy);
        // Set its ID
        dummy.setAttribute("id", "dummy_id");
        // Output the array into it
        document.getElementById("dummy_id").value = kode_voucher;
        // Select it
        dummy.select();
        // Copy its contents
        document.execCommand("copy");
        // Remove it as its not needed anymore
        document.body.removeChild(dummy);
    
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function() {
            x.className = x.className.replace("show", "");
        }, 2000);
    }
</script>