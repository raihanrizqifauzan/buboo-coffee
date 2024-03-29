<style>
    .foot-menu.fixed-bottom {
        display:none;
    }
    li.nav-item {
        display:inline;
    }

    .filter-status {
        cursor:pointer;
    }

    .filter-status a {
        color: #222 !important;
    }

    .filter-status.active a{
        border-bottom: 1px solid #429244;
        color:#429244!important;
    }

    td {
        border:none !important;
    }
    
</style>
<section class="">
    <div class="container pt-2" style="min-height:100vh">
        <div class="d-flex justify-content-between align-items-center w-100 text-center" style="overflow-x:auto;white-space:nowrap">
            <div class="w-100 nav-item filter-status p-2 active" data-filter="pending">
                <a href="#home" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                    <span class="">Belum Dibayar</span>
                </a>
            </div>
            <div class="w-100 nav-item filter-status p-2" data-filter="on process">
                <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link">
                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                    <span class="">Diproses</span>
                </a>
            </div>
            <div class="w-100 nav-item filter-status p-2" data-filter="success">
                <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link">
                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                    <span class="">Selesai</span>
                </a>
            </div>
            <div class="w-100 nav-item filter-status p-2" data-filter="cancel">
                <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link">
                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                    <span class="">Dibatalkan</span>
                </a>
            </div>
        </div>
        <div class="tab-content mt-2 pb-4">
            <div class="table-responsive">
                <table class="table" width="100%" id="tbPesanan">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalDetail">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <div>
            <div>No. Pesanan</div>
            <h5 class="modal-title" id="detail-no_pesanan"></h5>
        </div>
        <div id="detail-status_order"></div>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body" id="detail-area">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCloseDetail" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    var filter_status = "pending";
    var tbPesanan = $('#tbPesanan').DataTable({
        language: {
            "lengthMenu": "_MENU_",
            "search": "",
            "zeroRecords": `<div class="empty-table-custom"></div>`,
        },
        bDestroy: true,
        bLengthChange: false,
        order: [[ 0, "desc" ]],
        bInfo: false,
        paging: false,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('welcome/table_riwayat_order')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = filter_status
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari No. Pesanan")
        },
        drawCallback: function() {
            var empty_table = $(".empty-table-custom").length;
            if (parseInt(empty_table) > 0) {
                $(".empty-table-custom").html(`<img width="200px" src="https://class.buildwithangga.com/images/website_thumbnail.svg" width="100" style="margin-bottom:20px"><br>Tidak ada data `);
                // $(".pagination").hide()
                // $("[type='search']").hide();
            } else {
                // $(".pagination").show()
                // $("[type='search']").show();
            }
        }
    });

    $(".filter-status").click(function () {
        $(".filter-status").removeClass("active");
        $(this).addClass("active");
        filter_status = $(this).data("filter");
        tbPesanan.ajax.reload();
    })

    $("#tbPesanan").on("click", ".btnDetail", function (e) {
        var no_pesanan = $(this).data("id");
        
        $.ajax({
            type: 'GET',
            url: `<?= base_url('welcome/ajax_detail_pesanan') ?>?no_pesanan=${no_pesanan}`,
            dataType: "JSON",
            beforeSend: function () {
                showLoading()
            },
            success: function(res) {
                if (res.status) {
                    swal.close()
                    loadViewDetailPesanan(res.data);
                    $("#modalDetail").modal("show");
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbPesanan.ajax.reload();
                    });
                }
            }
        });
    })

    $("#btnCloseDetail").click(function () {
        $("#detail-area").html("");
        $("#modalDetail").modal("hide");
    })

    function loadViewDetailPesanan(data) {
        var order = data.data_order;
        var detail_order = data.detail_order;
        $("#detail-no_pesanan").html(`#${order.no_pesanan}`);
        var status_order = `<label class="badge bg-warning text-dark">Belum Dibayar</label>`;
        if (order.status_order == "on process") {
            status_order = `<label class="badge bg-info text-light">Sedang Diproses</label>`;
        } else if (order.status_order == "success") {
            status_order = `<label class="badge bg-success text-light">Sudah Diantarkan</label>`;
        } else if (order.status_order == "cancel") {
            status_order = `<label class="badge bg-danger text-light">Dibatalkan</label>`;
        }
        $("#detail-status_order").html(status_order);

        var html_detailorder = ``;
        detail_order.forEach(e => {
            html_detailorder += `
            <div class="d-flex p-2" style="border-bottom:1px solid #EFEFEF">
                <div class="px-2 align-self-center">
                    <img src="${e.thumbnail}" style="width:50px">
                </div>
                <div class="px-2 align-self-center w-100">
                    <b style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;">${e.nama_menu}</b>
                    <div class="text-muted">${formatRupiah(e.quantity)}x</div>
                </div>
                <div class="p-1 align-self-end">
                    <div class="text-muted">Rp${formatRupiah(parseInt(e.harga) - parseInt(e.potongan))}</div>
                </div>
            </div>`;
        });
        var html = `
        <div class="d-flex">
            <div><span class="iconify" data-icon="ri:user-line"></span></div>
            <div class="mx-2">
                <div><b>Informasi Customer</b></div>
                <div>${order.nama_customer}</div>
                <div>${order.no_hp}</div>
            </div>
        </div>
        <div class="d-flex mt-4">
            <div><span class="iconify" data-icon="icon-park-outline:time"></span></div>
            <div class="mx-2">
                <div><b>Tanggal Order</b></div>
                <div>${order.datetime_order}</div>
            </div>
        </div>
        <div class="d-flex mb-2 mt-4">
            <div class="w-100">
                <div class="align-self-start shadow" style="border-radius:10px">
                    ${html_detailorder}
                    <div id="totalPesanan">
                        <div class="d-flex justify-content-between px-2 py-1">
                            <div class="text-right w-100"><small>Total</small></div>
                            <div class="px-2 align-self-center">
                                <div><b>Rp${formatRupiah(order.total_order)}</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $("#detail-area").html(html);
    }
</script>