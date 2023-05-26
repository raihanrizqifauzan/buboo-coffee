<style>
    .foot-menu, .header {
        display: none;
    }
</style>
<script type="text/javascript" src="<?= base_url('assets/') ?>qrcode.min.js"></script>
<section class="container pt-4" style="min-height:100vh;">
    <div class="d-flex align-items-center">
        <div class="picture" style="width:70px;height:70px;background:#ddd;border:6px solid #FFF;border-radius:50%;">
            <img src="<?= base_url('assets/public/img/logo2.png') ?>" alt="" class="img-fluid">
        </div>
        <div>
            <b>Buboo Coffee</b>
            <div><small>Jl. dr. Sudarsono, Kota Banjar</small></div>
        </div>
    </div>
    <div class="d-flex mt-4 w-100 justify-content-center align-items-center">
        <div id="no_pesanan">
            
        </div>
    </div>
    <div class="mt-4">
        <div class="text-center ">
            <h5>Hi, <?= $order->nama_customer ?> !</h5>
            <small>Terimakasih telah melakukan order di Buboo Coffee. Silahkan lakukan pembayaran dengan memberikan QR Code ini ke kasir agar pesananmu segera kami Proses.</small>
        </div>
        <br>
        <small class="pt-2">
            <table class="table">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                </tr>
                <?php
                $total = 0;
                foreach ($detail_order as $key => $detail) { 
                    $total += $detail->quantity * $detail->harga;
                    ?>
                    <tr>
                        <td><?= $detail->nama_menu." (x".$detail->quantity.")" ?></td>
                        <td>Rp<?= number_format($detail->harga, 0,',','.'); ?></td>
                    </tr>
                <?php }?>
                <tr>
                    <th class="text-end">Total</th>
                    <th><?= number_format($total, 0,',','.'); ?></th>
                </tr>
            </table>
        </small> 
    </div>
    <div class="d-flex mt-4 justify-content-center">
        <div>
            <a href="<?= base_url('') ?>" class="btn btn-primary">Kembali ke Menu Utama</a>
        </div>
    </div>
</section>

<script type="text/javascript">
    var no_pesanan = "<?= $order->no_pesanan ?>";
    var qrcode = new QRCode(document.getElementById("no_pesanan"), {
        width : 100,
        height : 100
    });
    qrcode.makeCode(no_pesanan);
</script>