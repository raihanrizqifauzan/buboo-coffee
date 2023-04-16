<style>
  .badge-info, .badge-default {
    padding: 0px 5px;
    border-radius: 3px;
    color: #fff;
  }

  .badge-info{
    background: #007bff;
  }

  .badge-default {
    background: #343a40;
  }
</style>
<body id="body-container">
    <div class="page-holder">
        <!-- navbar-->
        <header class="header bg-white">
          <div class="container px-lg-3">
            <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
              <a style="background: #444;padding: 5px;border-radius: 25px;" class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url('assets/public/img/logo.jpg') ?>" alt="" width="30px;"></a>
              <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                  <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment('1') == '' ? 'active' : '' ?>" href="<?= base_url('') ?>">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment('1') == 'daftar-menu' ? 'active' : '' ?>" href="<?= base_url('daftar-menu') ?>">Daftar Menu</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment('1') == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Kontak</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment('1') == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">Tentang Kami</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </header>

        <div class="px-2 mb-3">
        <?php 
        if ($this->session->userdata('no_meja')) { ?>
          <span class="badge-info">No. Meja : <?= $this->session->userdata('no_meja') ?></span>
        <?php } else {?>
          <span class="badge-default">No. Meja : Belum di Scan</span>
        <?php }
        ?>
        </div>