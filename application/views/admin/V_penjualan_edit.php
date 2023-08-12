<style>
    .col-sm-12, .col-12 {
        padding-left: 0px;
        padding-right: 0px;
    }

    .container-fluid {
        padding: 30px;
    }

    .card-body {
        padding: 10px;
    }

    th {
        display:none;
        border:none;
    }

    td {
        padding: 10px 3px !important;
    }
    
    #tbKategori_filter label {
        width:100%!important;
    }

    [type=search] {
        margin-left:0px!important;
        width:100%!important;
    }

    .card-barang:hover {
        background:#eee;
        cursor:pointer;
    }
</style>
<div class="container-fluid">
    <div class="row h-100">
        <div class="col-sm-8">
            <div class="card p-3" style="min-height:300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <div><?= date("d F Y") ?></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">No. Meja</label>
                                <input type="number" class="form-control" id="no_meja">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nama Customer</label>
                                <input type="text" class="form-control" id="nama_customer">
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <!-- <div class="col-sm-12"> -->
                            <div class="">
                                <table id="table_menu" class="table w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card p-1" style="min-height:300px;">
                <div class="card-body">
                    <h4 class="card-title">Keranjang</h4>
                    <div class="mt-2" id="area-keranjang">
                        
                    </div>
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <b>Potongan Harga</b>
                                <div><span id="diskon_cart">Rp0</span></div>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <b>Total</b>
                                <div id="total_cart">Rp0</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 border-bottom pb-2">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-end align-items-end">
                                <button class="btn btn-success" disabled id="btnSubmit">Submit</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalQty">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Quantity</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_menu" class="form-control">
        <input type="number" id="quantity" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnClose" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addToCart">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDiskon">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Diskon</h5>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <div class="col-sm-2">Rp</div>
            <div class="col-sm-10">
                <input type="number" id="diskon" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCloseDiskon" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitDiskon">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
    var menu_cart = [];
    var total_cart = 0, diskon_cart = 0;
    var table_menu = $('#table_menu').DataTable({
        language: {
            "lengthMenu": "_MENU_",
            "search": ""
        },
        bDestroy: true,
        bLengthChange: false,
        order: [[ 0, "desc" ]],
        bInfo: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('admin/penjualan/ajax_get_menu')?>",
            type: "POST",
            data: function (data) {
                data.filter_status = "aktif"
            }
        },
        initComplete: function( settings ) {
            $("[type='search']").attr("placeholder", "Cari Menu Disini")
        },
        "pageLength": 9
    });

    $(document).ready(function () {
        loadKeranjang(menu_cart);
    })

    $(document).on("click", ".card-barang", function () {
        var id_menu = $(this).data("id");
        $("#id_menu").val(id_menu);
        $("#modalQty").modal("show")
    })

    $("#modalDiskon").on("shown.bs.modal", function () {
        $("#diskon").val(diskon_cart);
        if (total_cart == 0) {
            messageError("Pilih menu terlebih dahulu");
            $("#modalDiskon").modal("hide")
            return false;
        }
    });

    $("#modalQty").on("hidden.bs.modal", function () {
        $("#id_menu").val("");
        $("#quantity").val("");
    })

    $("#submitDiskon").click(function () {
        var check = $("#diskon").val();
        if (parseInt(check) < 0) {
            messageError("Diskon tidak valid");
            return false;
        }

        diskon_cart = check;
        loadKeranjang(menu_cart);
        $("#modalDiskon").modal("hide");
    })

    function loadKeranjang(menu_cart) {
        var html = '';
        total_cart = 0;
        if (menu_cart.length > 0) {
            menu_cart.forEach(e => {
                html += `
                <div class="row mt-2 border-bottom">
                    <div class="col-lg-12">
                        <b>${e.nama_menu}</b>
                        <div class="d-flex justify-content-between">
                            <div><small>${formatRupiah(e.quantity)} pcs</small></div>
                            <div>Rp${formatRupiah(e.harga)},00 <a href="javascript:void(0)" class="text-danger deleteFromCart"  data-id="${e.id_menu}"><i class="mx-1 fa fa-trash text-danger"></i></a></div>
                        </div>
                    </div>
                </div>`;
                total_cart += parseInt(e.harga) * parseInt(e.quantity);
            });
            total_cart -= parseInt(diskon_cart);
            $("#btnSubmit").prop("disabled", false);
        } else {
            html += `
            <div class="text-center mt-4">
                <span class="iconify" style="font-size:50px;" data-icon="emojione:shopping-cart"></span><br>
                <small>Pilih menu & tambahkan ke keranjang</small>
            </div>`;
            $("#btnSubmit").prop("disabled", true);
        }
        $("#total_cart").html("Rp"+formatRupiah(total_cart)+",00");
        $("#diskon_cart").html("Rp"+formatRupiah(diskon_cart)+",00");
        $("#area-keranjang").html(html)
    }

    $("#addToCart").click(function () {
        var id_menu = $("#id_menu").val();
        var quantity = $("#quantity").val();
        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/penjualan/add_to_cart') ?>`,
            data: {id_menu: id_menu, quantity: quantity},
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        var data = res.data;
                        var check = menu_cart.filter(o => o.id_menu.includes(data.id_menu));
                        if (check == undefined || check.length == 0) {
                            menu_cart.push(data);
                        } else {
                            for (let i = 0; i < menu_cart.length; i++) {
                                if (menu_cart[i].id_menu == data.id_menu) {
                                    var new_qty = parseInt(menu_cart[i].quantity) + parseInt(data.quantity);
                                    menu_cart[i].quantity = new_qty;
                                    break;
                                }
                            }
                        }
                        loadKeranjang(menu_cart);
                        $("#btnClose").trigger("click")
                        table_menu.ajax.reload();
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbMenu.ajax.reload();
                    });
                }
            }
        });
    })

    
    $(document).on("click", ".deleteFromCart", function () {
        var id_menu = $(this).data("id");
        swal({
            title: '',
            html: "Menu akan dihapus dari keranjang ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0050',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.value) {
                var idx_hapus = null;
                for (let i = 0; i < menu_cart.length; i++) {
                    if (menu_cart[i].id_menu == id_menu) {
                        idx_hapus = i;
                        break;
                    }
                }

                if (idx_hapus != null) {
                    menu_cart.splice(idx_hapus, 1);
                    loadKeranjang(menu_cart);
                }
            }
        })
    })

    $("#btnSubmit").click(function () {
        var obj = {
            no_meja: $("#no_meja").val(),
            nama_customer: $("#nama_customer").val(),
            diskon_cart,
            list_menu: menu_cart,
        };
        console.log(obj);

        $.ajax({
            type: 'POST',
            url: `<?= base_url('admin/penjualan/create_order') ?>`,
            data: obj,
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    swal("Sukses", res.message, "success").then(function () {
                        location.reload();
                    });
                } else {
                    swal("Oops...", res.message, "error").then(function () {
                        // tbMenu.ajax.reload();
                    });
                }
            }
        });
    })
</script>