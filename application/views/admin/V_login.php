<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/public/img/logo.jpg">
    <title>Buboo Coffee - Login</title>
    <link href="<?= base_url() ?>assets/admin/dist/css/style.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
            <div class="auth-box row">
                <div class="col-md-6 d-md-block d-none modal-bg-img" style="background-image: url(<?= base_url() ?>assets/public/img/logo.jpg);">
                </div>
                <div class="col-md-6 col-sm-12 bg-white">
                    <div class="p-3">
                        <h2 class="mt-3 text-center">Login Admin</h2>
                        <p class="text-center">Halaman khusus untuk pegawai di Buboo Coffee.</p>
                        <form class="mt-4" action="<?= base_url('admin/login/auth') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Username</label>
                                        <input class="form-control" autocomplete="off" name="username" type="text" placeholder="enter your username">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">Password</label>
                                        <input class="form-control" autocomplete="off" name="password" type="password" placeholder="enter your password">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center mb-5">
                                    <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/admin/libs/jquery/dist/jquery.min.js "></script>
    <script src="<?= base_url() ?>assets/admin/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="<?= base_url() ?>assets/admin/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".preloader ").fadeOut();
    </script>

    <?php 
    if(!empty($this->session->flashdata('notif_icon'))) {
        $icon = $this->session->flashdata('notif_icon');
        $message = $this->session->flashdata('notif_message');
        echo '<button id="alert-flashdata" class="d-none"></button>';
    } else {
        $icon = "";
        $message = "";
    } ?>

    <script>
        var icon_flashdata = "<?= $icon ?>";
        var msg_flashdata = "<?= $message ?>";
        var error = $("#alert-flashdata").length;
        if (error > 0) {
            Swal.fire({
                icon: icon_flashdata,
                text: msg_flashdata,
            })
        }
    </script>
</body>

</html>