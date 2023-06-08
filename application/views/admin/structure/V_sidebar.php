<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i data-feather="info" class="feather-icon"></i>
                        <span class="hide-menu">Informasi Website </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="<?= base_url('admin/informasi-website/contact') ?>" class="sidebar-link">
                                <span class="hide-menu"> Kontak</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('admin/informasi-website/about') ?>" class="sidebar-link">
                                <span class="hide-menu"> Tentang Kami</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <!-- <li class="nav-small-cap"><span class="hide-menu">Applications</span></li> -->
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('admin/kategori') ?>" aria-expanded="false">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Manage Kategori</span>
                    </a>
                </li>
                <!-- <li class="sidebar-item"> 
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i data-feather="coffee" class="feather-icon"></i>
                        <span class="hide-menu">Manage Menu </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="<?= base_url('admin/menu/') ?>" class="sidebar-link">
                                <span class="hide-menu"> Daftar Menu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('admin/menu/best-seller') ?>" class="sidebar-link">
                                <span class="hide-menu"> Menu Best Seller</span>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('admin/menu/') ?>" aria-expanded="false">
                        <i data-feather="coffee" class="feather-icon"></i>
                        <span class="hide-menu">Manage Menu</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('admin/pesanan/') ?>" aria-expanded="false">
                        <i data-feather="phone-incoming" class="feather-icon"></i>
                        <span class="hide-menu">Manage Pesanan</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->