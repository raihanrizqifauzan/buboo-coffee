<style>
  .menu-page .active {
    background:#FFF !important;
    color: #429244 !important;
    border-bottom: 2px solid #429244;
  }

  .desc-product, .title-product {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
  }

  .desc-product {
    -webkit-line-clamp: 2;
  }
  
  .title-product {
    -webkit-line-clamp: 2;
  }

  .price-product {
    position: absolute;
    bottom: 0;
  }
</style>

<div class="container pb-5" style="min-height:100vh">
  <section class="pt-2 menu-page">
    <div class="">
      <div class="">
        <div class="mb-5 mb-lg-0">
          <div class="row mb-2 align-items-center w-100">
            <div class="col-8 mb-2 mb-lg-0">
              <input type="text" class="form-control w-100" id="search_menu" placeholder="Cari Menu..." autocomplete="off">
            </div>
            <div class="col-4 mb-2 mb-lg-0 p-0 px-1">
              <select class="form-control" id="selectpicker">
                <option value>Sort By </option>
                <!-- <option value="popularity">Popularity </option> -->
                <option value="low-high">Harga Terendah </option>
                <option value="high-low">Harga Tertinggi </option>
              </select>
            </div>
          </div>
  
          <!-- Tab Categories -->
          <ul class="nav nav-tabs justify-content-between" role="tablist" id="section-menu">
            <li class="nav-item">
              <a class="nav-link active" href="javascript:void(0)" role="tab" data-toggle="tab" data-id="">Semua</a>
            </li>
            <?php 
            foreach ($list_kategori as $key => $kategori) { ?>
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" role="tab" data-toggle="tab" data-id="<?= $kategori->id_kategori ?>"><?= $kategori->nama_kategori ?></a>
              </li>
            <?php }
            ?>
          </ul>
          <!-- End Tab Categories -->
  
          <div class="row mt-4" id="view-product" style="padding-left:0!important;padding-right:0!important">
            
          </div>
          <!-- PAGINATION-->
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center justify-content-lg-end" id="view-pagination">
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  var filter_kategori = "";
  var page = 1;
  var filter_search = "";
  var order_by = "";
  var load_param = "<?= $this->input->get('kategori') ?>";

  $(document).ready(function () {
    if (load_param != "" && load_param != null) {
      $(`.nav-link[data-id='${load_param}']`).trigger("click");
    } else {
      get_list_menu();
    }
  })

  $("#search_menu").keyup(function () {
    filter_search = $(this).val();
    get_list_menu();
  })

  $("#selectpicker").change(function () {
    order_by = $(this).val();
    get_list_menu();
  })

  $(".nav-link").click(function () {
    $("#section-menu .nav-link").removeClass("active");
    $(this).addClass("active");
    filter_kategori = $(this).data("id");
    get_list_menu();
  })

  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    page = $(this).data("page");
    get_list_menu();
  })

  function get_list_menu() {
    $.ajax({
      url: `<?= base_url('welcome/ajax_get_menu') ?>?page=${page}&id_kategori=${filter_kategori}&search=${filter_search}&order_by=${order_by}`,
      beforeSend: function () {
        // showLoading()
      },
      success: function(response){
        var res = JSON.parse(response);
        generateViewMenu(res);
      }
    });
  }

  function generateViewMenu(res) {
    var detail_url = "<?= base_url('detail-menu/') ?>";
    var list_menu = res.list_menu;
    var html = "";
    res.totalPages = parseInt(res.totalPages);
    res.currentPage = parseInt(res.currentPage);
    if (list_menu.length == 0) {
      html = `<div class="text-center pt-4"><i class="fa fa-window-close fa-2x"></i><br>Menu tidak tersedia</div>`;
    } else {
      list_menu.forEach(e => {
        var url_menu = e.nama_menu.toLowerCase().replace(" ", "-")+"."+e.id_menu;
        var img_habis = "";
        var ket_habis = "";
        if (e.status == "nonaktif" || e.stock <= 0) {
          img_habis = `<div style="position:absolute;top:32%;left:20px;background:#FFF;padding:5px 20px;opacity:.5">HABIS</div>`;
          ket_habis = `<span class="text-danger"><small><i>(Stok Habis)</i></small></span>`;
        }
        html += `
        <div class="mb-4">
          <a href="${detail_url+url_menu}" class="text-dark">
            <div class="d-flex w-100">
              <div style="position: relative;">
                <img src="<?= base_url('assets/public/img/menu/') ?>${e.thumbnail}" style="border-radius:10px;" width="130" height="130">
                ${img_habis}
              </div>
              <div class="w-100" style="padding-left:10px;position:relative">
                <b><small class="title-product">${e.nama_menu}</small></b>
                <div class="desc-product"><small class="text-muted">${e.deskripsi}</small></div>
                <div>${ket_habis}</div>
                <div class="pb-2 price-product"><b>Rp${formatRupiah(e.harga)}</b></div>
              </div>
            </div>
          </a>
        </div>`;
        
      });
    }
    $("#view-product").html(html);

    var pagination_control = "";
    if (res.totalPages > 1) {
      if (res.currentPage > 1) {
        var before = res.currentPage - 1;
        pagination_control += `<li class="page-item mx-1"><a class="page-link" data-page="${before}" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left"></i></span></a></li>`;

        for (let i = res.currentPage - 2; i < res.currentPage; i++) {
          if (i > 0) {
            pagination_control += `<li class="page-item mx-1"><a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a></li>`;
          }
        }
      }

      pagination_control += `<li class="page-item mx-1 active"><a class="page-link" href="javascript:void(0)" data-page="${res.currentPage}">${res.currentPage}</a></li>`;

      for (let i = res.currentPage + 1; i <= res.totalPages; i++) {
        pagination_control += `<li class="page-item mx-1"><a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a></li>`;
        if (i == res.currentPage + 2) {
          break;
        }
      }

      if (res.currentPage < res.totalPages) {
        var next = res.currentPage + 1;
        pagination_control += `<li class="page-item mx-1"><a class="page-link" data-page="${next}" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-right"></i></span></a></li>`;
      }
    }

    $("#view-pagination").html(pagination_control);
  }

  function formatRupiah(angka, prefix){
    var number_string = angka.toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
  
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
  
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
</script>