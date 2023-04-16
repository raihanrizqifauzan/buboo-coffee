<style>
  footer a {
    color: #000;
  }

  .text-menu-active {
    color:#429244;
  }
</style>
<footer class="fixed-bottom mt-2" style="background-color:#FFF;box-shadow:0px -4px 17px 0px #c0c0c094">
    <div class="container p-2 px-4">
      <div class="d-flex justify-content-between text-center">
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'daftar-menu' ? 'text-menu-active' : '' ?>" href="<?= base_url('daftar-menu') ?>">
          <div><span class="fa fa-coffee"></span></div>
          <div><small>Menu</small></div>
        </a>
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'scan' ? 'text-menu-active' : '' ?>" href="<?= base_url('scan') ?>">
          <div><span class="fa fa-qrcode"></span></div>
          <div><small>Scan Meja</small></div>
        </a>
        <a class="d-block w-100 <?= $this->uri->segment('1') == 'keranjang' ? 'text-menu-active' : '' ?>" href="#">
          <div><span class="fa fa-shopping-cart"></span></div>
          <div><small>Keranjang</small></div>
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
    </script>
</div>
</body>
</html>