<div class="container">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
          <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
              <h1 class="h2 text-uppercase mb-0">Tentang Kami</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                  <li class="breadcrumb-item"><a class="text-dark" href="<?= base_url() ?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row">
            <div class="col-md-12 text-justify">
                <?= $data->content_about ?>
            </div>
        </div>
    </section>
</div>
  
      
      