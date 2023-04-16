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
                <ul class="navbar-nav ms-auto">               
                  <li class="nav-item"><a class="nav-link" href="javascript:void(0)"> <i class="fas fa-shopping-cart me-1"></i><small class="fw-normal">(2)</small></a></li>
                  <li class="nav-item"><a class="nav-link" href="#!"> <i class="fas fa-user me-1"></i></a></li>
                </ul>
              </div>
            </nav>
          </div>
        </header>