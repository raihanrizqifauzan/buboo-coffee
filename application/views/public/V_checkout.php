<style>
    .foot-menu.fixed-bottom {
        display:none;
    }

    .form-control {
        border-radius: 8px;
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
            echo '<small><b>Produk</b></small>';
            foreach ($keranjang as $key => $cart) { 
                $total_order += $cart->harga * $cart->quantity;
                $image_menu = json_decode($cart->json_gambar)[0];
                ?>
                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-start">
                            <div>
                                <img src="<?= base_url('assets/public/') ?>img/menu/<?= $image_menu ?>" height="90px" width="90px" style="border-radius:8px;" alt="">
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
            ?>
            <div class="mt-2 d-flex justify-content-between align-items-center">
                <div><small class="text-muted">Total</small></div>
                <div><b>Rp<?= number_format($total_order, 0,',','.'); ?></b></div>
            </div>
            <hr>
            <div class="form-group mb-1">
                <small style="font-weight:bold;">Catatan</small>
                <textarea class="form-control" id="catatan" col="3" placeholder="Dapat Dikosongkan(Opsional)"></textarea>
            </div>
            <hr>
            <!-- <div class="d-flex justify-content-between align-items-center p-2" style="border:1px solid #222;border-radius:10px;">
                <div>
                    <span class="iconify fa-2x" data-icon="mingcute:coupon-line"></span>
                    <small><b> Makin Murah dengan Voucher</b></small>
                </div>
                <div>
                    <span class="iconify" data-icon="fa:chevron-right"></span>
                </div>
            </div> -->
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

<script>

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
            data: {nama_customer, no_hp, catatan},
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
</script>