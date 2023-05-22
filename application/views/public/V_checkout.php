<style>
    .foot-menu.fixed-bottom {
        display:none;
    }
</style>
<section class="pt-2 pb-5 mb-5" style="min-height:500px;">
    <div class="container">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div>
                <h2 class="h5 text-uppercase">Keranjang Saya</h2>
                <p class="small small mb-1 text-muted">Halaman Checkout</p>
            </div>
            <div>
                <a href="<?= base_url('daftar-menu') ?>" class="btn btn-sm btn-secondary" style="border-radius:50px;"><span class="fa fa-chevron-left"></span></a>
            </div>
        </div>
        <div id="list-menu-order">
            
        </div>
        <?php 
        $total_order = 0;
        if (empty($keranjang)) { ?>
        <div class="text-center p-3">
            <div><span class="iconify" style="font-size:50px;" data-icon="emojione:shopping-cart"></span></div>
            <small>Anda belum memilih menu </small>
        </div>
        <?php } else {
            foreach ($keranjang as $key => $cart) { 
                $total_order += $cart->harga * $cart->quantity;
                $image_menu = json_decode($cart->json_gambar)[0];
                ?>
                <div class="mt-2">
                    <div class="d-flex justify-content-between p-2 align-items-end" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
                        <div class="d-flex align-items-end">
                            <div>
                                <img src="<?= base_url('assets/public/') ?>img/menu/<?= $image_menu ?>" width="60px" width="60px" alt="">
                            </div>
                            <div class="mx-2">
                                <b><?= $cart->nama_menu ?></b>
                                <div class="text-muted">
                                    <small>Rp<?= number_format($cart->harga) ?></small>
                                </div>
                                <div class="border d-flex align-items-center justify-content-between mt-3 px-3 bg-white border-white">
                                    <span class="small text-uppercase text-gray no-select"></span>
                                    <div class="quantity">
                                        <button class="dec-btn p-0" data-id="<?= $cart->id_menu ?>"><i class="fas fa-caret-left"></i></button>
                                        <input class="form-control border-0 shadow-0 p-0 quantity-cart" type="text" value="<?= $cart->quantity ?>" min="1" data-id="<?= $cart->id_menu ?>">
                                        <button class="inc-btn p-0" data-id="<?= $cart->id_menu ?>"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-2">
                            <a href="#" class="delete-cart" style="color:#000" data-id="<?= $cart->id_menu ?>">
                                <span class="iconify" style="font-size:20px;" data-icon="ph:trash-bold"></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php }
        }?>
        
        <!-- <div class="d-flex p-2 mt-3" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
            <div class="col-8">
                <input type="text" class="form-control" placeholder="Gunakan Kode Voucher agar lebih hemat">
            </div>
            <div class="col-4">
                <button class="btn btn-dark w-100">Pakai Voucher</button>
            </div>
        </div> -->
        
        <div class="p-2 mt-3" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
            <p class="small small mb-1 text-muted">Data Customer</p>
            <div class="form-group mb-1">
                <label for="">No. Meja</label>
                <input type="text" readonly class="form-control" value="1">
            </div>
            <div class="form-group mb-1">
                <label for="">Nama</label>
                <input type="text" id="nama_customer" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="">No.HP</label>
                <input type="number" id="no_hp" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="">Catatan</label>
                <textarea class="form-control" id="catatan" col="3" placeholder="Dapat Dikosongkan(Opsional)"></textarea>
            </div>
        </div>

        <footer class="fixed-bottom mt-2" style="background-color:#FFF;box-shadow:0px -4px 17px 0px #c0c0c094">
            <div class="container p-2 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Order</small>
                        <div><b id="totalorder">Rp<?= number_format($total_order) ?></b></div>
                    </div>
                    <div>
                        <button class="btn btn-primary" style="border-radius:6px;" id="submitOrder">Submit Order</button>
                    </div>
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
        Swal.fire({
            title: '',
            html: "Menu akan dihapus dari keranjang ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0050',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
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
                            Swal.close();
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