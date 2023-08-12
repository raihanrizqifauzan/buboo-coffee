<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <!-- <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a> -->
            
            <div class="d-block d-md-none d-lg-none">
                <?php if (!empty($back_url)) { ?> <a href="<?= $back_url ?>"><span class="iconify mx-3" data-icon="formkit:arrowleft"></span></a>  <?php } ?>
                
                <?php if (!empty($judul)) { ?> <b class="<?= empty($back_url) ? 'mx-3' : '' ?>"><?= $judul ?></b> <?php } ?>
            </div>
            <div class="d-block d-md-none d-lg-none">
                <ul class="navbar-nav float-right" style="line-height: 1rem!important;">
                    <!-- Notification -->
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                            id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span><i data-feather="bell" class="svg-icon"></i></span>
                            <span class="badge badge-primary notify-no rounded-circle">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                            <ul class="list-style-none">
                                <li>
                                    <div class="message-center notifications position-relative">
                                        <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                            <div class="btn btn-danger rounded-circle btn-circle"><i data-feather="airplay" class="text-white"></i></div>
                                            <div class="w-75 d-inline-block v-middle pl-2">
                                                <div class="mb-1"><b>Luanch Admin</b></div>
                                                <small>Tes</small>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                        <strong>Check all notifications</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    <!-- End Notification -->

                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="<?= base_url() ?>assets/admin/images/users/profile-pic.jpg" alt="user" class="rounded-circle"
                                width="40">
                            <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                    class="text-dark">Jason Doe</span> <i data-feather="chevron-down"
                                    class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <!-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                                Account Setting
                            </a>
                            <div class="dropdown-divider"></div> -->
                            <a class="dropdown-item" href="javascript:void(0)"><i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand d-none d-md-block d-lg-block">
                <a href="index.html">
                    <b class="logo-icon">
                        <img src="<?= base_url() ?>assets/admin/images/logo-icon.png" alt="homepage" class="dark-logo" />
                        <img src="<?= base_url() ?>assets/admin/images/logo-icon.png" alt="homepage" class="light-logo" />
                    </b>
                    <span class="logo-text">
                        Buboo Coffee
                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <!-- <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a> -->
        </div>

        <!-- <div class="d-none d-md-block d-lg-block">
            
        </div> -->
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse justify-content-end" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right" style="line-height: 1rem!important;">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge badge-primary notify-no rounded-circle">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown" style="width:350px!important;left:-60px">
                        <ul class="list-style-none">
                            <li>
                                <div class="message-center notifications position-relative">
                                    <!-- Message -->
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-danger rounded-circle btn-circle"><i data-feather="airplay" class="text-white"></i></div>
                                        <div class="w-100 d-inline-block v-middle pl-2">
                                            <div class="mb-1"><b>Luanch Admin</b></div>
                                            <small>Tes</small>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
    
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url() ?>assets/admin/images/users/profile-pic.jpg" alt="user" class="rounded-circle"
                            width="40">
                        <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                class="text-dark">Jason Doe</span> <i data-feather="chevron-down"
                                class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                            Account Setting
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                            Logout
                        </a>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->