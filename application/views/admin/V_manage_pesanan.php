<style>
    li.nav-item {
        display:inline;
    }

    .filter-status {
        cursor:pointer;
    }

    .filter-status.active a{
        background: #5f76e8;
        color:#FFF!important;
    }

    td {
        border:none !important;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    
    input[type=number] {
        -moz-appearance:textfield; /* Firefox */
    }

    .btn-qty {
        width: 20px;
        height: 20px;
        padding: 1px;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Pesanan</h4>
            <h6 class="card-subtitle">Kelola Pesanan Customer</h6>
        </div>
    </div>
</div>
<div class="container-fluid" style="padding-top:20px!important">
    <div class="row">
        <div id="editForm" class="col-sm-12" style="display:none">
            <div class="card p-1">
                <div class="card-body">
                    <h4 class="card-title">Edit Detail Pesanan <span id="no_pesanan_edit"></span></h4>
                    <div class="mt-2" id="area-keranjang">
                        <div class="row mt-2 border-bottom">
                            <div class="col-8">
                                <select class="form-control" id="id_menu_edit">
                                    <option value="">- Pilih Menu untuk Ditambahkan -</option>
                                    <?php 
                                    foreach ($list_menu as $key => $menu) { ?>
                                        <option value="<?= $menu->id_menu ?>" data-nama="<?= $menu->nama_menu ?>" data-harga="<?= $menu->harga ?>"><?= $menu->nama_menu ?> (<?= "Rp".number_format($menu->harga, 0, ",", ".") ?>)</option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <input class="form-control" id="qtyCart" type="number" placeholder="Qty" />
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary btn-sm btn-block" id="addToCart"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="col-lg-12 mt-4" id="areaPesanan">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><small>Total :</small> <span id="total_cart">Rp0</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-end align-items-end">
                                <button class="btn btn-danger" id="btnBack">Back</button>
                                <button class="btn btn-success" id="btnSubmit">Submit</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-sm-12" id="tableArea">
            <div class="card">
                <div class="card-body">
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
                    
                    <div class="tab-content mt-2">
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
            </div>
        </div>
    </div>
</div>


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
    var temp_order = [];
    $("[name='icon_kategori']").select2({
        width: "100%"
    });

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
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('admin/pesanan/ajax_get_pesanan')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = filter_status
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari No. Pesanan / Nama Customer")
        },
        drawCallback: function() {
            var empty_table = $(".empty-table-custom").length;
            if (parseInt(empty_table) > 0) {
                $(".empty-table-custom").html(`<img width="200px" src="https://class.buildwithangga.com/images/website_thumbnail.svg" width="100" style="margin-bottom:20px"><br>Tidak ada data `);
                $(".pagination").hide()
            } else {
                $(".pagination").show()
            }
        }
    });

    $("#id_menu_edit").select2({
        width: "100%"
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
            url: `<?= base_url('admin/pesanan/ajax_detail_pesanan') ?>?no_pesanan=${no_pesanan}`,
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

    $("#tbPesanan").on("click", ".btnCancel", function (e) {
        e.stopImmediatePropagation();
        var no_pesanan = $(this).data("id");

        swal({
            title: `Pesanan ${no_pesanan} akan di Cancel ?`,
            text: `Notes: Pesanan yang di Cancel tidak dapat dikembalikan`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: `<?= base_url('admin/pesanan/cancel_order') ?>?no_pesanan=${no_pesanan}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            swal("Sukses", res.message, "success").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        } else {
                            swal("Oops...", res.message, "error").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })

    $("#tbPesanan").on("click", ".btnProses", function (e) {
        e.stopImmediatePropagation();
        var no_pesanan = $(this).data("id");

        swal({
            title: `Pesanan ${no_pesanan} akan diproses ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5f76e8",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: `<?= base_url('admin/pesanan/process_order') ?>?no_pesanan=${no_pesanan}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            swal("Sukses", res.message, "success").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        } else {
                            swal("Oops...", res.message, "error").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })

    $("#tbPesanan").on("click", ".btnSend", function (e) {
        e.stopImmediatePropagation();
        var no_pesanan = $(this).data("id");

        swal({
            title: `Pesanan ${no_pesanan} sudah selesai diproses ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5f76e8",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: `<?= base_url('admin/pesanan/send_order') ?>?no_pesanan=${no_pesanan}`,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            swal("Sukses", res.message, "success").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        } else {
                            swal("Oops...", res.message, "error").then(function () {
                                tbPesanan.ajax.reload();
                            });
                        }
                    }
                });
            }
        });
    })

    $("#tbPesanan").on("click", ".btnEdit", function (e) {
        e.stopImmediatePropagation();
        var no_pesanan = $(this).data("id");
        var id_voucher = $(this).data("voucher");

        var msg = "";
        if (id_voucher != "") {
            msg = "Warning : Dalam mengedit pesanan, Penggunaan voucher akan dihapus terlebih dahulu";
        }

        swal({
            title: `Edit pesanan dengan No. ${no_pesanan} ?`,
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5f76e8",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
        }).then((result) => {
            if (result.value) {
                window.location.href = "<?= base_url('admin/penjualan/edit/') ?>"+no_pesanan;
                // getDetailPesanan(no_pesanan);
            }
        });
    })

    $("#btnBack").click(function () {
        $("#tableArea").show();
        $("#editForm").hide();
    })

    // $("#btnSubmit")

    $("#btnMinus").click(function () {
        var harga = 15000;
        var qty = parseInt($("#qtyEdit").val()) - 1;

        if (qty > 0) {
            $("#qtyEdit").val(qty)
            $("#total_cart").html("Rp"+formatRupiah((qty * harga)));
        }

    })

    $("#btnPlus").click(function () {
        var harga = 15000;
        var qty = parseInt($("#qtyEdit").val()) + 1;
        $("#qtyEdit").val(qty)
        $("#total_cart").html("Rp"+formatRupiah((qty * harga)));
    })

    $("#addToCart").click(function () {
        var id_menu_selected = $("#id_menu_edit").val();
        var qty = $("#qtyCart").val();
        var id_menu_option = $("#id_menu_edit option:selected");
        var nama_menu = $(id_menu_option).data('nama');
        var harga_menu = $(id_menu_option).data('harga');
        console.log(nama_menu);

        if (id_menu_selected != "" && qty != "" && qty > 0) {
            // var obj = {
            //     id_menu: 
            // };
        }
    })

    function getDetailPesanan(no_pesanan) {
        $.ajax({
            type: 'GET',
            url: `<?= base_url('admin/pesanan/ajax_detail_pesanan') ?>?no_pesanan=${no_pesanan}`,
            dataType: "JSON",
            success: function(res) {
                if (res.status) {
                    var html = "";
                    var data = res.data;
                    $("#no_pesanan_edit").html(`#${data.data_order.no_pesanan}`);
                    var subtotal = 0;
                    data.detail_order.forEach(e => {
                        var temp = {
                            id_menu: e.id_menu, 
                            nama_menu: e.nama_menu, 
                            harga: e.harga, 
                            quantity: e.quantity, 
                        };
                        temp_order.push(temp);
                        html += `
                        <div class="d-flex justify-content-between">
                            <div><b>${e.nama_menu}</b></div>
                            <a href="javascript:void(0)" class="text-danger deleteFromCart mx-2"  data-id="${e.id_menu}"><i class="mx-1 fa fa-trash text-danger"></i></a>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small><s></s></small> Rp${formatRupiah(e.harga)}
                            </div>
                            <div>
                                <div class="d-flex align-items-center" class="ctaQty">
                                    <button class="btn btn-sm btn-circle btn-success btn-qty btnMinus"><i class="fa fa-minus"></i></button>
                                    <input type="number" class="form-control text-center" style="border:none;width:60px;" value="${e.quantity}" id="qtyEdit">
                                    <button class="btn btn-sm btn-circle btn-success btn-qty btnPlus"><i class="fa fa-plus"></i></button>
                                </div> 
                            </div>
                        </div>`;
                        subtotal += parseInt(e.quantity) * parseInt(e.harga);
                    });

                    $("#total_cart").html("Rp"+formatRupiah(subtotal))
                    $("#areaPesanan").html(html);
                    $("#tableArea").hide();
                    $("#editForm").show();
                    console.log(temp_order);
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        tbPesanan.ajax.reload();
                    });
                }
            }
        });
        
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        $(document).on("change", "#qtyEdit", delay(async function (e) {
            var id_menu = $(this).data('id');
            var quantity = $(this).val();
            var obj = $(this);
    
            if (quantity < 1) {
                $(this).val("1").trigger("change");
                return false;
            }
    
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>order/update_cart',
                data: {id_menu: id_menu, quantity: quantity},
                beforeSend: function() {
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status) {
                        console.log(res.data.subtotal);
                        hitungTotalOrder(res.data.subtotal);
                    }
                },
            });
        }, 50))
    }
</script>