<style>
    .foot-menu, .header {
        display: none;
    }
</style>
<script type="text/javascript" src="<?= base_url('assets/') ?>qrcode.min.js"></script>
<section class="pt-5 pb-5 mb-5" style="min-height:500px;">
    <div class="container">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div>
                <h2 class="h5 text-uppercase">Buboo Coffee</h2>
                <p class="small small mb-1 text-muted">Success Order</p>
            </div>
        </div>
        <div class="d-flex mt-4 w-100 justify-content-center align-items-center">
            <div id="no_pesanan">
                
            </div>
        </div>
        <div class="text-center mt-4">
            <h5>Terimakasih telah melakukan Order. </h5>
            Pesananmu akan segera diproses. Mohon tunggu ya...
            <br>
            <small class="pt-2">
                Screenshoot / Capture QR ini untuk melakukan pembayaran di Kasir setelah selesai. Selamat menikmati !
            </small> 
        </div>
    </div>
  </div>
</section>

<script type="text/javascript">
    var no_pesanan = "<?= $order->no_pesanan ?>";
    var qrcode = new QRCode(document.getElementById("no_pesanan"), {
        // width : 300,
        // height : 300
    });

    // function makeCode () {		
    //     var elText = document.getElementById("text");
        
    //     if (!elText.value) {
    //         alert("Input a text");
    //         elText.focus();
    //         return;
    //     }
        
    // }
    qrcode.makeCode(no_pesanan);
    // makeCode();
</script>