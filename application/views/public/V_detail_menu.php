<section class="pt-2 pb-5">
  <div class="container">
    <div class="row mb-5">
      <!-- PRODUCT DETAILS-->
      <div class="col-12">
        <ul class="list-inline mb-2 text-sm">
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 1"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 2"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 3"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 4"><i class="fas fa-star small text-warning"></i></li>
        </ul>
        <h1><?= $menu->nama_menu ?></h1>
        <p class="text-muted lead">Rp<?= number_format($menu->harga, 0, '', '.') ?></p>
        <p class="text-sm mb-4"><?= $menu->deskripsi ?></p>
        <div class="row align-items-stretch mb-4">
          <div class="col-6 pl-0 ml-0" style="padding-left:0px;">
            <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white"><span class="small text-uppercase text-gray mr-4 no-select">Qty :</span>
              <div class="quantity">
                <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                <input class="form-control border-0 shadow-0 p-0" type="text" value="1" id="quantity">
                <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
              </div>
            </div>
          </div>
          <div class="col-6 pr-0 mr-0"><a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" id="btnAdd" href="#"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Order</a></div>
        </div>
      </div>
      <div class="col-12">
        <!-- PRODUCT SLIDER-->
        <div class="row m-sm-0">
          <div class="col-2 p-sm-0 order-2 mt-2 mt-sm-0 px-xl-2">
            <div class="swiper product-slider-thumbs">
              <div class="swiper-wrapper">
                <?php 
                $image_menu = json_decode($menu->json_gambar);
                foreach ($image_menu as $key => $img) { ?>
                  <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="<?= base_url('assets/public/') ?>img/<?= $img ?>" alt="..."></div>
                <?php }
                ?>
              </div>
            </div>
          </div>
          <div class="col-10 order-2">
            <div class="swiper product-slider">
              <div class="swiper-wrapper">
                <?php 
                $image_menu = json_decode($menu->json_gambar);
                foreach ($image_menu as $key => $img) { ?>
                  <div class="swiper-slide h-auto"><a class="glightbox product-view" href="<?= base_url('assets/public/') ?>img/<?= $img ?>" data-gallery="gallery2" data-glightbox="Product item 1"><img class="img-fluid" src="<?= base_url('assets/public/') ?>img/<?= $img ?>" alt="..."></a></div>
                <?php }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <!-- DETAILS TABS-->
    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
      <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
      <li class="nav-item"><a class="nav-link text-uppercase" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a></li>
    </ul>
    <div class="tab-content mb-5" id="myTabContent">
      <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
        <div class="pt-4 bg-white">
          <h6 class="text-uppercase">Product description </h6>
          <p class="text-muted text-sm mb-0"><?= $menu->deskripsi ?></p>
        </div>
      </div>
      <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
        <div class="pt-4 bg-white">
          <div class="row">
            <div class="col-lg-8">
              <div class="d-flex mb-3">
                <div class="flex-shrink-0"><img class="rounded-circle" src="<?= base_url('assets/public/') ?>img/customer-1.png" alt="" width="50"/></div>
                <div class="ms-3 flex-shrink-1">
                  <h6 class="mb-0 text-uppercase">Raihan</h6>
                  <p class="small text-muted mb-0 text-uppercase">20 Mar 2023</p>
                  <ul class="list-inline mb-1 text-xs">
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                  </ul>
                  <p class="text-sm mb-0 text-muted">Enak</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- RELATED PRODUCTS-->
    <?php 
    if (!empty($related_menu)) {
      ?>
      <h2 class="h5 text-uppercase mb-1">Menu lainnya</h2>
      <div class="row">
        <div class="d-flex mt-2 px-2 py-2" style="margin-bottom:30px;overflow-x:auto;">
        <!-- PRODUCT-->
          <?php 
          foreach ($related_menu as $key => $row) { 
            $nama_menu = str_replace(" ", "-", $row->nama_menu);
            $nama_menu = strtolower($nama_menu);
            ?>
            <a class="card-menu" href="<?= base_url('detail-menu/').$nama_menu.".".$row->id_menu ?>" style="color:#000;box-shadow:0px 0px 17px 0px #c0c0c094;">
              <img class="" height="120px" width="100%" src="<?= base_url('assets/public/') ?>img/<?= $row->thumbnail ?>" alt="..." style="border-radius:10px;">
              <div class="p-2">
                <div><small class="small text-muted"><?= $row->nama_menu ?></small></div>
                <div><b class="small" style="margin-top:-15px;">Rp<?= number_format($row->harga, 0, '', '.')  ?></b></div>
              </div>
            </a>
          <?php }
          ?>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
</section>

<script>
  var id_menu = "<?= $menu->id_menu ?>";

  function messageError(msg) {
    return Swal.fire({
      title: 'Oops',
      text: msg,
      icon: 'warning',
    })
  }
    
    function messageSuccess(msg) {
      return Swal.fire({
        title: 'Berhasil',
        icon: 'success',
        text: msg,
      })
    }

  $("#btnAdd").click(function () {
    var qty = $("#quantity").val();

    $.ajax({
      type: 'POST',
      url: `<?= base_url() ?>order/add_to_cart`,
      data: { 
        id_menu: id_menu, 
        quantity: qty,
      },
      beforeSend: function() {
        Swal.fire({
          title: 'Mohon Tunggu...',
          width: 600,
          padding: '3em',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
      },
      success: function(response) {
        var res = JSON.parse(response);
        if (res.status) {
          var data = res.data;
          messageSuccess(res.message).then(function () {
            $("#cart_counter").removeClass("d-none").html(data.total_keranjang);
          })
        } else {
          messageError(res.message);
        }
      }
    });
  })
</script>