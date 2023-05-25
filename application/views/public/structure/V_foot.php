<style>
  footer a {
    color: #000;
  }

  .text-menu-active {
    color:#429244;
  }
</style>
<footer class="fixed-bottom foot-menu mt-2" style="background-color:transparent;">
    <div class="p-4 px-4">
      <!-- <div class="d-flex justify-content-between text-center">
        <a class="d-block w-100 <?= $this->uri->segment('1') == '' ? 'text-menu-active' : '' ?>" href="<?= base_url('daftar-menu') ?>">
          <div><span class="fa fa-home"></span></div>
          <div><small>Home</small></div>
        </a>
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'daftar-menu' ? 'text-menu-active' : '' ?>" href="<?= base_url('daftar-menu') ?>">
          <div><span class="fa fa-coffee"></span></div>
          <div><small>Menu</small></div>
        </a>
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'scan' ? 'text-menu-active' : '' ?>" href="<?= base_url('scan') ?>">
          <div><span class="fa fa-qrcode"></span></div>
          <div><small>Pesan</small></div>
        </a>
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'order/history' ? 'text-menu-active' : '' ?>" href="<?= base_url('order') ?>">
          <div><span class="fa fa-shopping-cart"></span></div>
          <div><small>My Order</small></div>
        </a> -->
        <?php 
        if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
          $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
          $counter = count($decode_keranjang);
        } else {
          $counter = 0;
        }
        ?>
        <a id="btn-cart" style="display:none;border-radius:8px;" class="btn btn-block btn-primary w-100" href="<?= base_url('cart') ?>">
          <div><small>Keranjang <span class="badge bg-danger cart_counter"><?= $counter ?></span></small></div>
        </a>
      </div>
    </div>
    </footer>
    <!-- JavaScript files-->
    <script src="<?= base_url('assets/public/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/public/') ?>vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url('assets/public/') ?>vendor/nouislider/nouislider.min.js"></script>
    <script src="<?= base_url('assets/public/') ?>vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url('assets/public/') ?>vendor/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="<?= base_url('assets/public/') ?>js/front.js"></script>
    <script>
    // ------------------------------------------------------- //
    //   Inject SVG Sprite - 
    //   see more here 
    //   https://css-tricks.com/ajaxing-svg-sprite/
    // ------------------------------------------------------ //
    function injectSvgSprite(path) {
    
        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function(e) {
        var div = document.createElement("div");
        div.className = 'd-none';
        div.innerHTML = ajax.responseText;
        document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }
    // this is set to BootstrapTemple website as you cannot 
    // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
    // while using file:// protocol
    // pls don't forget to change to your domain :)
    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
    
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
      function formatRupiah(angka, prefix){
        var number_string = angka.toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }

      function showLoading() {
        return Swal.fire({
          title: 'Processing...',
          width: 600,
          padding: '3em',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
      }

      function messageError(msg){
        return Swal.fire({
          title: 'Oops',
          text: msg,
          icon: 'warning',
        })
      }

      function messageSuccess(msg){
        return Swal.fire({
          title: 'Success',
          text: msg,
          icon: 'success',
        })
      }

      $(document).ready(function () {
        $.ajax({
          type: 'GET',
          url: '<?= base_url() ?>welcome/count_keranjang',
          success: function(response) {
            var res = JSON.parse(response);
            if (res.data > 0) {
              $("#btn-cart").show();
            } else {
              $("#btn-cart").hide();
            }
          },
        });
      })
    </script>
</div>
</body>
</html>