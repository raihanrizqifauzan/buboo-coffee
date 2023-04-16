<div class="container">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
          <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
              <h1 class="h2 text-uppercase mb-0">Kontak</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                  <li class="breadcrumb-item"><a class="text-dark" href="<?= base_url() ?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row" style="margin:0 auto;">
            <div class="col-md-6 col-sm-12" style="padding:0px;!important">
                <iframe id="maps_viewer" src="https://maps.google.com/maps?q=<?= $data->latitude_longitude ?>&z=15&output=embed" style="border:0;position: relative; height: 100%; width: 100%;"></iframe>
            </div>
            <div class="col-md-6 col-sm-12 h-100" style="padding:0px;!important;">
                <div class="" style="background:#242424;color:#FFF;padding:50px 40px;">
                    <div class="d-flex justify-content-start">
                        <div>
                            <span class="iconify" data-icon="material-symbols:location-on-outline"></span>
                        </div>
                        <div style="margin-left:5px;">
                            <b>Address</b><br>
                            <?= $data->alamat_lengkap ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-3">
                        <div>
                            <span class="iconify" data-icon="mdi:phone-classic"></span>
                        </div>
                        <div style="margin-left:5px;">
                            <b>No. HP</b><br>
                            <?= $data->no_telp ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-3">
                        <div>
                            <span class="iconify" data-icon="material-symbols:nest-clock-farsight-analog-outline-rounded"></span>
                        </div>
                        <div style="margin-left:5px;">
                            <b>Jam Operasional</b><br>
                            <?= $data->hari_operasional ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-3">
                        <a href="https://wa.me/<?= $data->no_telp ?>?text=Halo Admin mau Tanya"><button class="btn btn-success"><span class="iconify" data-icon="ic:baseline-whatsapp"></span> Hubungi Kami</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>