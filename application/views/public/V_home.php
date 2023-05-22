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
      <h2 class="h5 text-uppercase">Kategori Menu</h2>
      <div class="d-flex justify-content-between w-100" style="overflow-x: auto;white-space: nowrap;">
        <?php 
        foreach ($list_kategori as $i => $kategori) { ?>
          <a class="d-block w-100 mx-1" href="<?= base_url('daftar-menu?kategori='.$kategori->id_kategori) ?>">
            <div class="card-kategori w-100 d-flex justify-content-between align-items-center" style="border:1px solid #6a462f;padding:5px 10px 5px 5px;border-radius:4px;min-width:80px;margin-right:10px;">
              <div>
                <span class="iconify fa-2x" data-icon="openmoji:<?= $kategori->icon_kategori ?>"></span>
              </div>
              <div class="text-dark d-flex">
                <div>
                  <b class="small"><?= $kategori->nama_kategori ?></b>
                </div>
              </div>
            </div>
          </a>
        <?php }
        ?>
        
      </div>
    </header>
  </section>
</div>

<section class="container py-5 mb-4">
  <div class="d-flex justify-content-between">
    <h2 class="h5 text-uppercase">Best Seller Menu</h2>
    <div><a href="<?= base_url('daftar-menu') ?>">Lihat Semua</a></div>
  </div>
  <div class="row mt-2" style="min-height:250px;padding-left:0!important;padding-right:0!important">
    <?php 
    foreach ($list_recommendation as $i => $menu) { 
      $thumbnail = json_decode($menu->json_gambar, TRUE)[0];
      ?>
      <div class="col-6 mb-2">
        <a href="" style="color:#000">
          <div class="card-menu w-100" style="border:1px solid #e5e5e5">
            <img class="" height="200px" width="100%" src="<?= base_url('assets/public/') ?>img/menu/<?= $thumbnail ?>" alt="..." style="border-radius:10px;">
            <div class="p-2">
              <div><small class="small text-muted"><?= $menu->nama_menu ?></small></div>
              <div><b class="small" style="margin-top:-15px;">Rp<?= number_format($menu->harga, 0, '', '.') ?></b></div>
            </div>
          </div>
        </a>
      </div>
    <?php }
    ?>
  </div>
</section>
  
      
      