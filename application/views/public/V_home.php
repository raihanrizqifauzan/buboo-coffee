<!-- HERO SECTION-->
<div class="container">
  <!-- <section class="hero pb-3 bg-cover bg-center d-flex align-items-center text-light" style="background: url(<?= base_url('assets/public/') ?>img/bg2.jpg)">
    <div class="container py-5">
      <div class="row px-4 px-lg-5">
        <div class="">
          <p class="small text-uppercase mb-2">WELCOME TO</p>
          <h1 class="h2 text-uppercase mb-3">BUBOO COFFEE</h1><a class="btn btn-dark" href="<?= base_url('daftar-menu') ?>">Lihat Menu</a>
        </div>
      </div>
    </div>
  </section> -->
  <!-- CATEGORIES SECTION-->
  <section class="">
    <header class="">
      <p class="small small mb-1 text-muted">Welcome To Buboo Coffee</p>
      <h2 class="h5 text-uppercase">Cari Kategori Menu</h2>
      <div class="d-flex justify-content-between w-100">
        <a class="d-block w-100 mx-1" href="<?= base_url('daftar-menu?kategori=1') ?>">
          <div class="card-kategori w-100 d-flex justify-content-between align-items-center" style="background:#6a462f;padding:5px 10px 5px 5px;border-radius:4px;min-width:80px;margin-right:10px;">
            <div>
              <span class="iconify fa-2x" data-icon="openmoji:drip-coffee-maker"></span>
            </div>
            <div class="text-light d-flex">
              <div>
                <b class="small">Kopi</b>
              </div>
            </div>
          </div>
        </a>

        <a class="d-block w-100 mx-1" href="<?= base_url('daftar-menu?kategori=2') ?>">
          <div class="card-kategori w-100 d-flex justify-content-between align-items-center" style="background:#ff8a14;padding:5px 10px 5px 5px;border-radius:4px;min-width:80px;margin-right:10px;">
            <div>
              <span class="iconify fa-2x" data-icon="streamline-emojis:tropical-drink"></span>
            </div>
            <div class="text-light">
              <b class="small">Non Kopi</b>
            </div>
          </div>
        </a>

        <a class="d-block w-100 mx-1" href="<?= base_url('daftar-menu?kategori=3') ?>">
          <div class="card-kategori w-100 d-flex justify-content-between align-items-center" style="background:#db1d1d;padding:5px 10px 5px 5px;border-radius:4px;min-width:80px;margin-right:10px;">
            <div>
              <span class="iconify fa-2x" data-icon="fxemoji:hamburger"></span>
            </div>
            <div class="text-light">
              <b class="small"> Makanan</b>
            </div>
          </div>
        </a>
        
      </div>
    </header>
  </section>
</div>
<!-- TRENDING PRODUCTS-->
<!-- <section class="pb-4 pt-3 mt-2" style="padding-left:0px;padding-right:0px;">
  <header class="container">
    <p class="small small text-uppercase mb-1">Menu Best Seller</p>
  </header>
  <div class="d-flex mt-2 px-2 py-3" style="margin-bottom:30px;overflow-x:auto;background:#444;margin:0px!important;">
    <div class="card-menu">
      <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
      <div class="p-2">
        <div><small class="small text-muted">Taro Latte</small></div>
        <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
      </div>
    </div>

    <div class="card-menu">
      <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
      <div class="p-2">
        <div><small class="small text-muted">Taro Latte</small></div>
        <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
      </div>
    </div>

    <div class="card-menu">
      <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
      <div class="p-2">
        <div><small class="small text-muted">Taro Latte</small></div>
        <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
      </div>
    </div>

    <div class="card-menu">
      <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
      <div class="p-2">
        <div><small class="small text-muted">Taro Latte</small></div>
        <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
      </div>
    </div>

    <div class="card-menu">
      <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
      <div class="p-2">
        <div><small class="small text-muted">Taro Latte</small></div>
        <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
      </div>
    </div>
  </div>
</section> -->

<section class="container py-5">
  <div class="d-flex justify-content-between">
    <h2 class="h5 text-uppercase">Best Seller Menu</h2>
    <div><a href="<?= base_url('daftar-menu') ?>">Lihat Semua</a></div>
  </div>
  <div class="row mt-4" style="min-height:250px;padding-left:0!important;padding-right:0!important">
    <div class="col-6 mb-2">
      <a href="" style="color:#000">
        <div class="card-menu w-100" style="border:1px solid #e5e5e5">
          <img class="" height="200px" width="100%" src="<?= base_url('assets/public/') ?>img/cappucino.jfif" alt="..." style="border-radius:10px;">
          <div class="p-2">
            <div><small class="small text-muted">Cappucino</small></div>
            <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-6 mb-2">
      <a href="" style="color:#000">
        <div class="card-menu w-100" style="border:1px solid #e5e5e5">
          <img class="" height="200px" width="100%" src="<?= base_url('assets/public/') ?>img/es-coklat.png" alt="..." style="border-radius:10px;">
          <div class="p-2">
            <div><small class="small text-muted">Chocolate</small></div>
            <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-6 mb-2">
      <a href="" style="color:#000">
        <div class="card-menu w-100" style="border:1px solid #e5e5e5">
          <img class="" height="200px" width="100%" src="<?= base_url('assets/public/') ?>img/menu/vietnam.png" alt="..." style="border-radius:10px;">
          <div class="p-2">
            <div><small class="small text-muted">Vietnamese Coffee</small></div>
            <div><b class="small" style="margin-top:-15px;">Rp13.000</b></div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-6 mb-2">
      <a href="" style="color:#000">
        <div class="card-menu w-100" style="border:1px solid #e5e5e5">
          <img class="" height="200px" width="100%" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..." style="border-radius:10px;">
          <div class="p-2">
            <div><small class="small text-muted">Greentea</small></div>
            <div><b class="small" style="margin-top:-15px;">Rp15.000</b></div>
          </div>
        </div>
      </a>
    </div>
  </div>
</section>
  <!-- SERVICES-->
  <!-- <section class="py-5 bg-light">
    <div class="container">
      <div class="row text-center gy-3">
        <div class="col-lg-4">
          <div class="d-inline-block">
            <div class="d-flex align-items-end">
              <svg class="svg-icon svg-icon-big svg-icon-light">
                <use xlink:href="#delivery-time-1"> </use>
              </svg>
              <div class="text-start ms-3">
                <h6 class="text-uppercase mb-1">Free shipping</h6>
                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="d-inline-block">
            <div class="d-flex align-items-end">
              <svg class="svg-icon svg-icon-big svg-icon-light">
                <use xlink:href="#helpline-24h-1"> </use>
              </svg>
              <div class="text-start ms-3">
                <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="d-inline-block">
            <div class="d-flex align-items-end">
              <svg class="svg-icon svg-icon-big svg-icon-light">
                <use xlink:href="#label-tag-1"> </use>
              </svg>
              <div class="text-start ms-3">
                <h6 class="text-uppercase mb-1">Festivaloffers</h6>
                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  
      
      