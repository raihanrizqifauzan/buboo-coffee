<div class="container">
    <section class="py-5">
      <div class="container p-0">
        <div class="row">
          <div class="col-lg-12 order-1 order-lg-2 mb-5 mb-lg-0">
            <div class="row mb-5 align-items-center">
              <div class="col-12 col-md-3 mb-2 mb-lg-0">
                <select class="selectpicker" data-customclass="form-control form-control-sm">
                  <option value>Kategori </option>
                  <option value="default">Default sorting </option>
                  <option value="popularity">Popularity </option>
                  <option value="low-high">Price: Low to High </option>
                  <option value="high-low">Price: High to Low </option>
                </select>
              </div>
              <div class="col-12 col-md-6 mb-2 mb-lg-0">
                <input type="text" class="form-control" placeholder="Cari Menu..." autocomplete="off">
              </div>
              <div class="col-12 col-md-3 mb-2 mb-lg-0">
                <select class="selectpicker" data-customclass="form-control form-control-sm">
                  <option value>Sort By </option>
                  <option value="default">Default sorting </option>
                  <option value="popularity">Popularity </option>
                  <option value="low-high">Price: Low to High </option>
                  <option value="high-low">Price: High to Low </option>
                </select>
                <!-- <ul class="list-inline d-flex align-items-center justify-content-end mb-0">
                  <li class="list-inline-item">
                  </li>
                </ul> -->
              </div>
            </div>
            <div class="row">
              <!-- PRODUCT-->
              <div class="col-6 col-md-3 col-sm-6">
                <div class="product text-center">
                  <div class="mb-3 position-relative">
                    <div class="badge text-white bg-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="<?= base_url('assets/public/') ?>img/cappucino.jfif" alt="..."></a>
                  </div>
                  <h6> <a class="reset-anchor" href="detail.html">Cappucino</a></h6>
                  <p class="small text-muted">Rp15.000</p>
                </div>
              </div>

              <!-- PRODUCT-->
              <div class="col-6 col-md-3 col-sm-6">
                <div class="product text-center">
                  <div class="mb-3 position-relative">
                    <div class="badge text-white bg-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="<?= base_url('assets/public/') ?>img/greentea.jfif" alt="..."></a>
                  </div>
                  <h6> <a class="reset-anchor" href="detail.html">Green Tea</a></h6>
                  <p class="small text-muted">Rp15.000</p>
                </div>
              </div>
            </div>
            <!-- PAGINATION-->
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center justify-content-lg-end">
                <li class="page-item mx-1"><a class="page-link" href="#!" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                <li class="page-item mx-1 active"><a class="page-link" href="#!">1</a></li>
                <li class="page-item mx-1"><a class="page-link" href="#!">2</a></li>
                <li class="page-item mx-1"><a class="page-link" href="#!">3</a></li>
                <li class="page-item ms-1"><a class="page-link" href="#!" aria-label="Next"><span aria-hidden="true">»</span></a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </section>
    </div>