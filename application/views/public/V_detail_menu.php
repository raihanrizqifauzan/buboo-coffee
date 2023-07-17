<style>
  .menu-navigation .sec-2 {
    display: none !important;
  }
  
</style>
<section class="">
  <div style="height:300px;background:url(<?= base_url('assets/public/img/menu/'.$menu->thumbnail) ?>);background-size:cover; background-position: 50% 50%;">

  </div>
  <div class="container" style="min-height:70vh">
    <div class="row pt-2">
      <!-- PRODUCT DETAILS-->
      <div class="col-12">
        <!-- <ul class="list-inline mb-2 text-sm">
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 1"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 2"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 3"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0 4"><i class="fas fa-star small text-warning"></i></li>
        </ul> -->
        <h1><?= $menu->nama_menu ?></h1>
        <p class="text-muted lead">Rp<?= number_format($menu->harga, 0, '', '.') ?></p>
        <p class="text-sm mb-4"><?= $menu->deskripsi ?></p>
        <div class="row mb-4">
          <div class="col-4" style="padding-left:0px;">
            <div class="d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
              <div class="quantity">
                <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                <input class="form-control border-0 shadow-0 p-0" type="text" value="1" id="quantity">
                <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
              </div>
            </div>
          </div>
          <div class="col-8 pr-0 mr-0">
            <?php if (getStatusToko() == "tutup") {?>
              <button class="btn btn-sm w-100 btn-danger" disabled><span class="iconify" data-icon="system-uicons:no-sign"></span>&nbsp;&nbsp; Toko sudah Tutup</button>
            <?php } else if ($menu->status == "aktif") { ?>
              <a class="btn btn-dark btn-sm h-100 d-flex align-items-center justify-content-center px-0" id="btnAdd" href="#"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Order</a>
            <?php } else { ?>
              <button class="btn btn-sm w-100 btn-danger" disabled><span class="iconify" data-icon="system-uicons:no-sign"></span>&nbsp;&nbsp; Stok Habis</button>
            <?php } ?>
          </div>
        </div>
      </div>
      
    </div>
    <!-- RELATED PRODUCTS-->
    <?php 
    if (!empty($related_menu)) {
      ?>
      <h2 class="h5 text-uppercase mb-1 mt-4">Menu lainnya</h2>
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
    return swal({
      title: 'Oops',
      type: msg,
      icon: 'warning',
    })
  }
  
  function messageSuccess(msg) {
    return swal({
      title: 'Berhasil',
      type: 'success',
      text: msg,
    })
  }

  function showLoading() {
    return swal({
      title: "Loading...",
      text: "Please wait",
      imageUrl: "https://www.boasnotas.com/img/loading2.gif",
      showConfirmButton: false,
      allowOutsideClick: true
    }); 
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
        showLoading();
      },
      success: function(response) {
        var res = JSON.parse(response);
        if (res.status) {
          var data = res.data;
          messageSuccess(res.message).then(function () {
            $("#btn-cart").show();
            $(".cart_counter").html(data.total_keranjang);
          })
        } else {
          messageError(res.message);
        }
      }
    });
  })
</script>