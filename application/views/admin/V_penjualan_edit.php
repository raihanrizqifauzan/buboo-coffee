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

    .card-barang:hover {
        background:#eee;
        cursor:pointer;
    }

    #voucher-label {
        border:1px solid silver;
        border-radius:10px;
        cursor:pointer;
    }

    #voucher-label:hover {
        background: #222;
        color:#FFF;
    }

    .card-voucher {
        /* box-shadow: 1px 1px 15px 2px #e0e0e0b5; */
        border: 1px solid #ada8a8b5;
        border-radius: 10px;
        margin-bottom:5px;
    }
    
    .card-voucher:hover {
        color: #222 !important;
    }
</style>
<div class="container-fluid">
    <div class="row h-100">
        <div class="col-sm-8">
            <div class="card p-3" style="min-height:300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <div><?= $data_order->datetime_order ?></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">No. Meja</label>
                                <input type="text" readonly class="form-control" id="no_meja" value="<?= $data_order->no_meja ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nama Customer</label>
                                <input type="text" class="form-control" id="nama_customer" value="<?= $data_order->nama_customer ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <!-- <div class="col-sm-12"> -->
                            <div class="">
                                <table id="table_menu" class="table w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
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
                    <div class="row mt-4">
                        <div class="col-lg-12 text-right">
                            <a href="javascript:void(0)" id="showVoucher">Gunakan Voucher <i class="fa fa-chevron-right"></i></a>
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
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalQty">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Quantity</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_menu" class="form-control">
        <input type="number" id="quantity" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnClose" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addToCart">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDiskon">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Diskon</h5>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <div class="col-sm-2">Rp</div>
            <div class="col-sm-10">
                <input type="number" id="diskon" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCloseDiskon" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitDiskon">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalVoucher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Voucher</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- <div class="row mb-4" style="padding: 0px 4px;">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="Kode Voucher" id="kode_voucher">
                        <small class="text-danger" id="alert_cari_voucher" style="display:none">Voucher tidak ditemukan</small>
                    </div>
                    <div class="col-sm-12 mt-1">
                        <button class="btn btn-primary w-100" id="pakai_voucher">Pakai</button>
                    </div>
                </div> -->
                <div id="area-list-voucher">
                    <div id="list-voucher"></div>
                </div>
                <div class="text-end mt-2">
                    <a href="javascript:void(0)" class="text-info" id="resetVoucher" style="display:none"><u>Batal gunakan Voucher</u></a>
                </div>
            </div>
            <div class="modal-footer" style="border:none!important">
                <!-- <button type="button" class="btn btn-secondary" id="resetVoucher">Jangan Pakai</button> -->
                <button type="button" class="btn btn-primary w-100" id="submitVoucher">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    var menu_cart = `<?= json_encode($detail_order) ?>`;
    menu_cart = JSON.parse(menu_cart);
    var id_promo_selected = null;
    var no_hp = "<?= $data_order->no_pesanan ?>";
    var total_cart = 0, diskon_cart = 0;
    var table_menu = $('#table_menu').DataTable({
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
            url: "<?php echo site_url('admin/penjualan/ajax_get_menu')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = "aktif"
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari Menu Disini")
        },
        "pageLength": 9
    });

    $(document).ready(function () {
        loadKeranjang(menu_cart);
    })

    $(document).on("click", ".card-barang", function () {
        var id_menu = $(this).data("id");
        $("#id_menu").val(id_menu);
        $("#modalQty").modal("show")
    })

    $("#modalDiskon").on("shown.bs.modal", function () {
        $("#diskon").val(diskon_cart);
        if (total_cart == 0) {
            messageError("Pilih menu terlebih dahulu");
            $("#modalDiskon").modal("hide")
            return false;
        }
    });

    $("#modalQty").on("hidden.bs.modal", function () {
        $("#id_menu").val("");
        $("#quantity").val("");
    })

    $("#submitDiskon").click(function () {
        var check = $("#diskon").val();
        if (parseInt(check) < 0) {
            messageError("Diskon tidak valid");
            return false;
        }

        diskon_cart = check;
        loadKeranjang(menu_cart);
        $("#modalDiskon").modal("hide");
    })

    function loadKeranjang(menu_cart) {
        var html = '';
        total_cart = 0;
        if (menu_cart.length > 0) {
            menu_cart.forEach(e => {
                var harga = `<small>Rp${formatRupiah(e.harga)}</small> <a href="javascript:void(0)" class="text-danger deleteFromCart"  data-id="${e.id_menu}"><i class="mx-1 fa fa-trash text-danger"></i></a>`;
                if (e.harga_diskon != undefined && parseInt(e.harga_diskon) > 0) {
                    harga = `
                    <div><small class="text-muted"><s>Rp${formatRupiah(e.harga)}</s></small></div>
                    <div><small>Rp${formatRupiah(parseInt(e.harga_diskon))}</small> <a href="javascript:void(0)" class="text-danger deleteFromCart"  data-id="${e.id_menu}"><i class="mx-1 fa fa-trash text-danger"></i></a></div>
                    `;
                    total_cart += parseInt(e.harga_diskon) * parseInt(e.quantity);
                } else {
                    total_cart += parseInt(e.harga) * parseInt(e.quantity);
                }

                html += `
                <div class="row mt-2 border-bottom">
                    <div class="col-lg-12">
                        <b>${e.nama_menu}</b>
                        <div class="d-flex justify-content-between">
                            <div><small>${formatRupiah(e.quantity)} pcs</small></div>
                            <div>${harga} </div>
                        </div>
                    </div>
                </div>`;
            });
            total_cart -= parseInt(diskon_cart);
            $("#btnSubmit").prop("disabled", false);
        } else {
            html += `
            <div class="text-center mt-4">
                <span class="iconify" style="font-size:50px;" data-icon="emojione:shopping-cart"></span><br>
                <small>Pilih menu & tambahkan ke keranjang</small>
            </div>`;
            $("#btnSubmit").prop("disabled", true);
        }
        $("#total_cart").html("Rp"+formatRupiah(total_cart)+",00");
        $("#diskon_cart").html("Rp"+formatRupiah(diskon_cart)+",00");
        $("#area-keranjang").html(html)
    }

    $("#addToCart").click(function () {
        var id_menu = $("#id_menu").val();
        var quantity = $("#quantity").val();
        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/penjualan/add_to_cart') ?>`,
            data: {id_menu: id_menu, quantity: quantity},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        var data = res.data;
                        var check = menu_cart.filter(o => o.id_menu.includes(data.id_menu));
                        if (check == undefined || check.length == 0) {
                            menu_cart.push(data);
                        } else {
                            for (let i = 0; i < menu_cart.length; i++) {
                                if (menu_cart[i].id_menu == data.id_menu) {
                                    var new_qty = parseInt(menu_cart[i].quantity) + parseInt(data.quantity);
                                    menu_cart[i].quantity = new_qty;
                                    break;
                                }
                            }
                        }
                        loadKeranjang(menu_cart);
                        $("#btnClose").trigger("click")
                        table_menu.ajax.reload();
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbMenu.ajax.reload();
                    });
                }
            }
        });
    })

    
    $(document).on("click", ".deleteFromCart", function () {
        var id_menu = $(this).data("id");
        swal({
            title: '',
            html: "Menu akan dihapus dari keranjang ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0050',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.value) {
                var idx_hapus = null;
                for (let i = 0; i < menu_cart.length; i++) {
                    if (menu_cart[i].id_menu == id_menu) {
                        idx_hapus = i;
                        break;
                    }
                }

                if (idx_hapus != null) {
                    menu_cart.splice(idx_hapus, 1);
                    loadKeranjang(menu_cart);
                }
            }
        })
    })

    $("#btnSubmit").click(function () {
        var obj = {
            no_meja: $("#no_meja").val(),
            nama_customer: $("#nama_customer").val(),
            diskon_cart,
            list_menu: menu_cart,
            id_promo_selected,
            no_pesanan: "<?= $data_order->no_pesanan ?>"
        };
        console.log(obj);

        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/penjualan/update_order') ?>`,
            data: obj,
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        window.location.href = "<?= base_url('admin/pesanan') ?>"
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbMenu.ajax.reload();
                    });
                }
            }
        });
    })

    $("#showVoucher").click(function () {
        getVoucherPromo();
    })

    function getVoucherPromo() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/get_list_promo',
            data: {menu_checkout: menu_cart, no_hp},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                swal.close();
                var list_promo = JSON.parse(response);
                if (list_promo.length == 0) {
                    $("#list-voucher").html(`<div class="text-center">Voucher tidak tersedia</div>`);
                } else {
                    var html = "";
                    list_promo.forEach(e => {
                        if (e.jenis_promo == "potongan harga") {
                            var color_label = "success";
                            var desc = `Rp${formatRupiah(e.nilai_potongan)}`;
                            if (e.tipe_potongan == "persen") {
                                desc = `${formatRupiah(e.nilai_potongan)}% maks : Rp${formatRupiah(e.max_potongan)}`;
                            }
                            var jenis_promo = `Potongan Harga ${desc}`;
                        } else {
                            var color_label = "warning";
                            var jenis_promo = `Promo gratis menu`;
                        }

                        var icon = `<span class="iconify" data-icon="material-symbols:circle-outline"></span>`;
                        if (id_promo_selected == e.id_voucher) {
                            icon = `<i class="fa fa-check-circle text-primary"></i>`;
                        }
                        html += `
                        <div class="card-voucher" data-id="${e.id_voucher}">
                            <div class="mb-0 d-flex justify-content-between align-items-end">
                                <div class="px-2 pt-2">
                                    <span class="badge bg-${color_label} text-light"><small>${jenis_promo}</small></span>
                                    <div class="mt-1"><b><small>${e.judul_voucher}</small></b></div>
                                </div>
                                <div class="px-2 sign-voucher">
                                    ${icon}
                                </div>
                            </div>
                            <div class="px-2 pb-2 mt-0 text-muted"><small>${e.keterangan}</small></div>
                        </div>`;
                    });
                    $("#list-voucher").html(html)
                }
                $("#modalVoucher").modal("show");
            },
        });
    }

    $(document).on("click", ".card-voucher", function (e) {
        var icon = $(this).find(".sign-voucher").html();
        var icon_checked = `<i class="fa fa-check-circle text-primary"></i>`;
        var icon_empty = `<span class="iconify" data-icon="material-symbols:circle-outline"></span>`;
        $(".sign-voucher").html(icon_empty)
        if (icon != icon_checked) {
            id_promo_selected = $(this).data("id");
            $(this).find(".sign-voucher").html(icon_checked);
            $("#resetVoucher").show();
        } else {
            id_promo_selected = "";
            $(this).find(".sign-voucher").html(icon_empty);
        }
    })

    $("#resetVoucher").click(function () {
        id_promo_selected = "";
        var icon_empty = `<span class="iconify" data-icon="material-symbols:circle-outline"></span>`;
        $(".sign-voucher").html(icon_empty);
        $("#resetVoucher").hide();
        loadKeranjang(menu_cart);
    })

    $("#submitVoucher").click(function () {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/pakai_voucher',
            data: {menu_checkout: menu_cart, no_hp, id_promo_selected},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal.close();
                    loadKeranjang(res.data);
                    $("#modalVoucher").modal("hide");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        $("#resetVoucher").trigger("click");
                    });
                }
            },
        });
    })
</script>