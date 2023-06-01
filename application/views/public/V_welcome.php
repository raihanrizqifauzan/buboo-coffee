<style>
    .pilih-opsi:hover {
        background: #DDD!important;
    }

    .foot-menu {
        display:none;
    }
</style>
<div class="container" style="min-height:100vh;background:#f3f4f6!important">
    <div class="d-flex justify-content-center px-4" style="padding-top:150px;">
        <div class="p-2" style="width:100%;background:#FFF;height:200px;border-radius:8px;">
            <div class="picture" style="width:120px;height:120px;background:#ddd;border:6px solid #FFF;border-radius:50%;margin: -50px auto 20px auto">
                <img src="<?= base_url('assets/public/img/logo2.png') ?>" alt="" class="img-fluid">
            </div>
            <div class="text-center">
                <h5>Buboo Coffee</h5>
                <small>Jl. dr. Sudarsono, Kota Banjar</small>
                <div>
                    <span class="iconify mx-2" data-icon="bi:alarm"></span> 
                    <small>Sekarang - <span class="text-primary">Buka</span>, Tutup <span class="text-danger">23:59</span></small>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between text-center mt-4 mx-3">
        <div class="mx-2 w-100 py-3 pilih-opsi" data-url="scan" style="background:#FFF;border-radius:8px;cursor:pointer">
            <span class="iconify fa-3x" data-icon="openmoji:fork-and-knife-with-plate"></span>
            <div><b>Dine In</b></div>
        </div>
        <div class="mx-2 w-100 py-3 pilih-opsi" data-url="daftar-menu?p=take-away" style="background:#FFF;border-radius:8px;cursor:pointer">
            <span class="iconify fa-3x" data-icon="openmoji:takeout-box"></span>
            <div><b>Take Away</b></div>
        </div>
    </div>
</div>

<script>
    $(".pilih-opsi").click(function () {
        var url = $(this).data("url");
        window.location.href = `<?= base_url() ?>` + url;
        // return swal({
        //     title: "Good job!",
        //     text: "You clicked the button!",
        //     type: "success",
        // });
    })
</script>