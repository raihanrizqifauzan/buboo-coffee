<style>
    .foot-menu.fixed-bottom {
        display:none;
    }
</style>
<section class="pb-5">
    <div class="container pt-2" style="min-height:100vh">
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
                <div style="border-bottom:1px solid silver">
                    <div class="d-flex justify-content-between py-3 align-items-end">
                        <div class="d-flex align-items-end">
                            <div>
                                <img src="<?= base_url('assets/public/') ?>img/menu/<?= $image_menu ?>" height="90px" width="90px" alt="" style="border-radius:10px;">
                            </div>
                            <div class="mx-2">
                                <b><?= $cart->nama_menu ?></b>
                                <div class="text-muted">
                                    <small>Rp<?= number_format($cart->harga) ?></small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3 px-1 bg-white border-white">
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

        <footer class="fixed-bottom mt-2" style="background-color:#FFF;box-shadow:0px -4px 17px 0px #c0c0c094">
            <div class="container p-2 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Order</small>
                        <div><b id="totalorder">Rp<?= number_format($total_order) ?></b></div>
                    </div>
                    <div>
                        <a href="<?= base_url('order') ?>"><button class="px-5 btn btn-primary" style="border-radius:6px;">Pesan</button></a>
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

    $(".dec-btn").click(function () {
        var value = $(this).closest(".quantity").find(".quantity-cart").val();
        $(this).closest(".quantity").find(".quantity-cart").val(value).trigger("change");
    })

    $(".inc-btn").click(function () {
        var value = $(this).closest(".quantity").find(".quantity-cart").val();
        $(this).closest(".quantity").find(".quantity-cart").val(value).trigger("change");
    })

    $(".quantity-cart").on("keyup change", delay(async function () {
        var id_menu = $(this).data('id');
        var quantity = $(this).val();
        var obj = $(this);

        if (quantity < 1) {
            $(this).val("1").trigger("change");
            return false;
        }

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
</script>