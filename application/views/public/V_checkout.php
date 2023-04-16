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
                <a href="<?= base_url('daftar-menu') ?>" class="btn btn-sm btn-secondary" style="border-radius:50px;"><span class="fa fa-plus"></span></a>
            </div>
        </div>
        <div class="mt-4">
            <div class="d-flex justify-content-between p-2 align-items-end" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
                <div class="d-flex align-items-end">
                    <div>
                        <img src="<?= base_url('assets/public/') ?>img/greentea.jfif" width="60px" width="60px" alt="">
                    </div>
                    <div class="mx-2">
                        <b>Green Tea</b>
                        <div class="text-muted">
                            <small>Rp15.000</small>
                        </div>
                        <div class="border d-flex align-items-center justify-content-between mt-3 px-3 bg-white border-white">
                            <span class="small text-uppercase text-gray no-select"></span>
                            <div class="quantity">
                                <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                                <input class="form-control border-0 shadow-0 p-0" type="text" value="1" id="quantity">
                                <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-2">
                    <a href="#" class="delete-cart" style="color:#000">
                        <span class="iconify" style="font-size:20px;" data-icon="ph:trash-bold"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-2 mt-3" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
            <p class="small small mb-1 text-muted">Data Customer</p>
            <div class="form-group mb-1">
                <label for="">No. Meja</label>
                <input type="text" readonly class="form-control" value="1">
            </div>
            <div class="form-group mb-1">
                <label for="">Nama</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="">No.HP</label>
                <input type="number" class="form-control">
            </div>
            <div class="form-group mb-1">
                <label for="">Catatan</label>
                <textarea class="form-control" col="3" placeholder="Contoh : Gula nya sedikit"></textarea>
            </div>
        </div>
        <div class="d-flex p-2 mt-3" style="box-shadow:0px -4px 17px 0px #c0c0c094;border-radius:10px;">
            <div class="col-8">
                <input type="text" class="form-control" placeholder="Gunakan Kode Voucher agar lebih hemat">
            </div>
            <div class="col-4">
                <button class="btn btn-dark w-100">Pakai Voucher</button>
            </div>
        </div>
        <footer class="fixed-bottom mt-2" style="background-color:#FFF;box-shadow:0px -4px 17px 0px #c0c0c094">
            <div class="container p-2 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Order</small>
                        <div><b>Rp15.000</b></div>
                    </div>
                    <div>
                        <button class="btn btn-primary" style="border-radius:6px;">Submit Order</button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
  </div>
</section>