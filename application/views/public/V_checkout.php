<style>
    .foot-menu.fixed-bottom {
        display:none;
    }

    .form-control {
        border-radius: 8px;
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

    .modal-open {
        overflow: auto;
        padding: 0 !important;
    }

    .modal-backdrop {
        width: 100% !important;
        height: 100% !important;
    }
</style>
<section class="container pb-5 mb-5" style="min-height:100vh;">
    <div class="p-2">
        <div class="mt-2">
            <div class="form-group mb-1">
                <small style="font-weight:bold;">Nama</small>
                <input type="text" id="nama_customer" class="form-control">
            </div>
            <div class="form-group mb-1">
                <small style="font-weight:bold;">No.HP</small>
                <input type="text" id="no_hp" class="form-control" value="<?= $this->session->userdata('no_hp') ?>" readonly>
                <small class="text-muted">Kami akan mengirimkan Rincian Pesanan melalui Whatsapp</small>
            </div>
        </div>
        <hr>
        <div class="mt-2">
            <div class="d-flex justify-content-between">
                <div><small><b>Tipe Pesanan</b></small></div>
                <div><small><b><a href="<?= base_url('') ?>" class="text-danger">Ganti</a></b></small></div>
            </div>
            
            <?php
            $no_meja = $this->session->userdata('no_meja') == "take-away" ? "Take Away" : "Meja No.". $this->session->userdata('no_meja');
            ?>
            <div class="mt-2">
                <?= $no_meja ?>
            </div>
        </div>
        <hr>
        <?php 
        $total_order = 0;
        if (empty($keranjang)) { ?>
        <div class="text-center p-3">
            <div><span class="iconify" style="font-size:50px;" data-icon="emojione:shopping-cart"></span></div>
            <small>Anda belum memilih menu </small>
        </div>
        <?php } else {
            ?>
            <div id="voucher-label" class="d-flex justify-content-between align-items-center p-2">
                <div>
                    <span class="iconify fa-2x" data-icon="mingcute:coupon-line"></span>
                    <small><b> Makin Murah dengan Voucher</b></small>
                </div>
                <div>
                    <span class="iconify" data-icon="fa:chevron-right"></span>
                </div>
            </div>
            <div id="voucher-used"></div>
            <hr>
            <?php
            echo '<small><b>Produk</b></small>';
            echo '<div class="list_menu_cart">';
            foreach ($keranjang as $key => $cart) { 
                $total_order += $cart->harga * $cart->quantity;
                // $image_menu = json_decode($cart->json_gambar)[0];
                ?>
                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-start">
                            <div>
                                <img src="<?= base_url('assets/public/') ?>img/menu/<?= $cart->thumbnail ?>" height="90px" width="90px" style="border-radius:8px;" alt="">
                            </div>
                            <div class="mx-2">
                                <b><?= $cart->nama_menu ?></b>
                                <div class="text-muted"><small>X <?= number_format($cart->quantity, 0,',','.') ?></small></div>
                            </div>
                        </div>
                        <div class="mx-2">
                            <small>Rp<?= number_format($cart->harga, 0,',','.') ?></small>
                        </div>
                    </div>
                </div>
            <?php }
            echo '</div>';
            ?>
            <div class="mt-2 d-flex justify-content-between align-items-end">
                <div><small class="text-muted">Total</small></div>
                <div><b id="totalorder">Rp<?= number_format($total_order, 0,',','.'); ?></b></div>
            </div>
            <hr>
            <div class="form-group mb-1">
                <small style="font-weight:bold;">Catatan</small>
                <textarea class="form-control" id="catatan" col="3" placeholder="Dapat Dikosongkan(Opsional)"></textarea>
            </div>
            <hr>
            <?php
        }?>

        <footer class="fixed-bottom mt-2" style="background-color:#FFF;box-shadow:0px -4px 17px 0px #c0c0c094">
            <div class="container p-2 px-4">
                <div>
                    <button class="btn btn-primary w-100" style="border-radius:6px;" id="submitOrder">Pesan</button>
                </div>
            </div>
        </footer>
    </div>
  </div>
</section>

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
    var menu_checkout = `<?= json_encode($keranjang) ?>`;
    menu_checkout = JSON.parse(menu_checkout);
    var id_promo_selected = "";

    function hitungTotalOrder(subtotal, diskon = 0) {
        $("#totalorder").html(`Rp${formatRupiah(subtotal - diskon)}`);  
    }

    $(".delete-cart").click(function () {
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
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>order/delete_from_cart',
                    data: {id_menu: id_menu},
                    beforeSend: function() {
                        showLoading();
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status) {
                            swal.close();
                            hitungTotalOrder(res.data.subtotal);
                            location.reload()
                        } else {
                            messageError(res.message);
                        }
                    },
                });
            }
        })
    })

    function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this, args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
				callback.apply(context, args);
			}, ms || 0);
		};
	}

    $(".quantity-cart").on("keyup change", delay(async function () {
        var id_menu = $(this).data('id');
        var quantity = $(this).val();
        var obj = $(this);

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/update_cart',
            data: {id_menu: id_menu, quantity: quantity},
            beforeSend: function() {
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    console.log(res.data.subtotal);
                    hitungTotalOrder(res.data.subtotal);
                }
            },
        });
    }, 50));

    $("#submitOrder").click(function () {
        var nama_customer = $("#nama_customer").val();
        var no_hp = $("#no_hp").val();
        var catatan = $("#catatan").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/create_order',
            data: {nama_customer, no_hp, catatan, id_promo_selected},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    messageSuccess(res.message).then(() => {
                        window.location.href = res.data.redirect_url;
                    });
                } else {
                    messageError(res.message);
                }
            },
        });
    })

    $("#voucher-label").click(function () {
        getVoucherPromo();
    })

    function getVoucherPromo() {
        var no_hp = $("#no_hp").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/get_list_promo',
            data: {menu_checkout, no_hp},
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
                            var color_label = "info";
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
                                    <span class="badge bg-${color_label}"><small>${jenis_promo}</small></span>
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
        loadMenuCart(menu_checkout);
    })
    
    $("#submitVoucher").click(function () {
        var no_hp = $("#no_hp").val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>order/pakai_voucher',
            data: {menu_checkout, no_hp, id_promo_selected},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal.close();
                    loadMenuCart(res.data);
                    $("#modalVoucher").modal("hide");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        $("#resetVoucher").trigger("click");
                    });
                }
            },
        });
    })

    function loadMenuCart(list_menu) {
        var html = "";
        var assets = `<?= base_url('assets/public/') ?>`;
        var total_harga = 0;
        list_menu.forEach(e => {
            var harga = `<small>Rp${formatRupiah(e.harga)}</small>`;
            if (e.harga_diskon != undefined && parseInt(e.harga_diskon) > 0) {
                harga = `
                <div><small class="text-muted text-decoration-line-through">Rp${formatRupiah(e.harga)}</small></div>
                <div><small>Rp${formatRupiah(parseInt(e.harga_diskon))}</small></div>
                `;
                total_harga += parseInt(e.harga_diskon) * parseInt(e.quantity);
            } else {
                total_harga += parseInt(e.harga) * parseInt(e.quantity);
            }
            html += `
            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-start">
                        <div>
                            <img src="${assets}img/menu/${e.thumbnail}" height="90px" width="90px" style="border-radius:8px;" alt="">
                        </div>
                        <div class="mx-2">
                            <b>${e.nama_menu}</b>
                            <div class="text-muted"><small>X ${formatRupiah(e.quantity)}</small></div>
                        </div>
                    </div>
                    <div class="mx-2">
                        ${harga}
                    </div>
                </div>
            </div>`;
        });
        $(".list_menu_cart").html(html);
        $("#totalorder").html(`Rp${formatRupiah(total_harga)}`);
    }

    $("#modalVoucher").on("shown.bs.modal", function () {
        $("body").css("padding-right", "0");
    })
    $("#modalVoucher").on("hidden.bs.modal", function () {
        $("body").css("padding-right", "0");
    })
</script>