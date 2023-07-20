
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="custom-container p-3">
    <!-- *************************************************************** -->
    <!-- Start First Cards -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-4" onclick="loadMenu('kategori')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="bx:category"></span>
                    <div class="mt-1">Kategori</div>
                </div>
            </div>
        </div>

        <div class="col-4" onclick="loadMenu('menu')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="carbon:product"></span>
                    <div class="mt-1">Menu</div>
                </div>
            </div>
        </div>

        <div class="col-4" onclick="loadMenu('pesanan')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="ion:cart-outline"></span>
                    <div class="mt-1">Pesanan</div>
                </div>
            </div>
        </div>

        <div class="col-4" onclick="loadMenu('penjualan')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="streamline:money-cashier-shop-shopping-pay-payment-cashier-store-cash-register-machine"></span>
                    <div class="mt-1">Kasir/Penjualan</div>
                </div>
            </div>
        </div>

        <div class="col-4" onclick="loadMenu('promo')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="iconamoon:discount-bold"></span>
                    <div class="mt-1">Promosi Toko</div>
                </div>
            </div>
        </div>

        <div class="col-4" onclick="loadMenu('setting')">
            <div class="card">
                <div class="card-body text-center">
                    <span class="iconify fa-2x" data-icon="uil:setting"></span>
                    <div class="mt-1">Setting</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                class="set-doller">Rp</sup><?= number_format($total_omset, 0, "", ".") ?></h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Omset hari Ini
                        </h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $jumlah_order ?></h2>
                            <?php 
                            if ($persentase_jumlah_order < 0) {
                                $bg = "bg-danger";
                            } else if ($persentase_jumlah_order > 0) {
                                $bg = "bg-success";
                            } else {
                                $bg = "bg-warning";
                            }
                            ?>
                            <span class="badge <?= $bg ?> font-12 text-white font-weight-medium badge-pill ml-2 d-md-none d-lg-block"><?= $persentase_jumlah_order ?>% dari orderan kemarin</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Order</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="shopping-cart"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End First Cards -->
    <!-- *************************************************************** -->
    <!-- *************************************************************** -->
    <!-- Start Sales Charts Section -->
    <!-- *************************************************************** -->
    <div class="row px-3">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Omset 1 Minggu</h4>
                    <!-- <div class="net-income mt-4 position-relative" style="height:294px;"></div> -->
                    <canvas id="net-income"></canvas>
                    <ul class="list-inline text-center mt-5 mb-2">
                        <li class="list-inline-item text-muted font-italic">Total Omset 1 Minggu kebelakang</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Produk Terjual 1 Minggu</h4>
                    </div>
                    <div class="pl-4 mb-5">
                        <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
    <!-- *************************************************************** -->
    <!-- End Sales Charts Section -->
    <!-- *************************************************************** -->
    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <!-- <div class="row">
        
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Activity</h4>
                    <div class="mt-4 activity">
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                    <i data-feather="shopping-cart"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">New Product Sold!</h5>
                                <p class="font-14 mb-2 text-muted">John Musa just purchased <br> Cannon 5M
                                    Camera.
                                </p>
                                <span class="font-weight-light font-14 text-muted">10 Minutes Ago</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)"
                                    class="btn btn-danger btn-circle mb-2 btn-item">
                                    <i data-feather="message-square"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">New Support Ticket</h5>
                                <p class="font-14 mb-2 text-muted">Richardson just create support <br>
                                    ticket</p>
                                <span class="font-weight-light font-14 text-muted">25 Minutes Ago</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                    <i data-feather="bell"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">Notification Pending Order!
                                </h5>
                                <p class="font-14 mb-2 text-muted">One Pending order from Ryne <br> Doe</p>
                                <span class="font-weight-light font-14 mb-1 d-block text-muted">2 Hours
                                    Ago</span>
                                <a href="javascript:void(0)" class="font-14 border-bottom pb-1 border-info">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- *************************************************************** -->
    <!-- End Location and Earnings Charts Section -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var chart_omset;
    function loadMenu(url) {
        window.location.href = "<?= base_url('admin/') ?>" + url;
    }

    $(document).ready(function () {
        loadChartOmset();
        getIncomePerWeek().then(function(res) {
            loadChartOmset(res);
        })
        // var data = loadOmsetPerWeek();
    })

    async function getIncomePerWeek() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/dashboard/get_omset_per_week') ?>",
                dataType: 'json',
                success: function (response){
                    resolve(response);
                }
            });
    
        });
    }

    function loadChartOmset(omset = []) {
        var ctx = document.getElementById('net-income');

        var hari = {
            'sun': 'Minggu',
            'mon': 'Senin',
            'tue': 'Selasa',
            'wed': 'Rabu',
            'thu': 'Kamis',
            'fri': 'Jumat',
            'sat': 'Sabtu',
        };
        if (omset.length == 0) {
            var labels = [];
            Object.keys(hari).forEach(function(key) {
                labels.push(hari[key]);
            });
            var data = [0, 0, 0, 0, 0, 0, 0];
        } else {
            var labels = [], data = [];
            omset.forEach(e => {
                labels.push(hari[e.hari.toLowerCase()]);
                data.push(e.omset);
            });
        }
        if (chart_omset != undefined) {
            chart_omset.destroy();
        }
        
        chart_omset = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Omset',
              data: data,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
    }


</script>
        
        
        
            