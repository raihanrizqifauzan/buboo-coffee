<section class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-6">
          <!-- PRODUCT SLIDER-->
          <div class="row m-sm-0">
            <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
              <div class="swiper product-slider-thumbs">
                <div class="swiper-wrapper">
                  <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="<?= base_url('assets/public/') ?>img/cappucino.jfif" alt="..."></div>
                  <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="<?= base_url('assets/public/') ?>img/es-coklat.png" alt="..."></div>
                </div>
              </div>
            </div>
            <div class="col-sm-10 order-1 order-sm-2">
              <div class="swiper product-slider">
                <div class="swiper-wrapper">
                  <div class="swiper-slide h-auto"><a class="glightbox product-view" href="<?= base_url('assets/public/') ?>img/cappucino.jfif" data-gallery="gallery2" data-glightbox="Product item 1"><img class="img-fluid" src="<?= base_url('assets/public/') ?>img/cappucino.jfif" alt="..."></a></div>
                  <div class="swiper-slide h-auto"><a class="glightbox product-view" href="<?= base_url('assets/public/') ?>img/es-coklat.png" data-gallery="gallery2" data-glightbox="Product item 2"><img class="img-fluid" src="<?= base_url('assets/public/') ?>img/es-coklat.png" alt="..."></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- PRODUCT DETAILS-->
        <div class="col-lg-6">
          <ul class="list-inline mb-2 text-sm">
            <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
            <li class="list-inline-item m-0 1"><i class="fas fa-star small text-warning"></i></li>
            <li class="list-inline-item m-0 2"><i class="fas fa-star small text-warning"></i></li>
            <li class="list-inline-item m-0 3"><i class="fas fa-star small text-warning"></i></li>
            <li class="list-inline-item m-0 4"><i class="fas fa-star small text-warning"></i></li>
          </ul>
          <h1>Caffe Latte</h1>
          <p class="text-muted lead">Rp15.000</p>
          <p class="text-sm mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
          <div class="row align-items-stretch mb-4">
            <div class="col-sm-5 pr-sm-0">
              <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white"><span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                <div class="quantity">
                  <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                  <input class="form-control border-0 shadow-0 p-0" type="text" value="1">
                  <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                </div>
              </div>
            </div>
            <div class="col-sm-3 pl-sm-0"><a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="#">Add to cart</a></div>
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
          <div class="p-4 p-lg-5 bg-white">
            <h6 class="text-uppercase">Product description </h6>
            <p class="text-muted text-sm mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
          <div class="p-4 p-lg-5 bg-white">
            <div class="row">
              <div class="col-lg-8">
                <div class="d-flex mb-3">
                  <div class="flex-shrink-0"><img class="rounded-circle" src="<?= base_url('assets/public/') ?>img/customer-1.png" alt="" width="50"/></div>
                  <div class="ms-3 flex-shrink-1">
                    <h6 class="mb-0 text-uppercase">Jason Doe</h6>
                    <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                    <ul class="list-inline mb-1 text-xs">
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                    </ul>
                    <p class="text-sm mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="flex-shrink-0"><img class="rounded-circle" src="<?= base_url('assets/public/') ?>img/customer-2.png" alt="" width="50"/></div>
                  <div class="ms-3 flex-shrink-1">
                    <h6 class="mb-0 text-uppercase">Jane Doe</h6>
                    <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                    <ul class="list-inline mb-1 text-xs">
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                    </ul>
                    <p class="text-sm mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- RELATED PRODUCTS-->
      <h2 class="h5 text-uppercase mb-4">Related products</h2>
      <div class="row">
        <!-- PRODUCT-->
        <div class="col-lg-3 col-sm-6">
          <div class="product text-center skel-loader">
            <div class="d-block mb-3 position-relative"><a class="d-block" href="<?= base_url('detail-menu') ?>"><img class="img-fluid w-100" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..."></a>
            </div>
            <h6> <a class="reset-anchor" href="<?= base_url('detail-menu') ?>">Green Tea</a></h6>
            <p class="small text-muted">Rp15.000</p>
          </div>
        </div>
      </div>
    </div>
</section>