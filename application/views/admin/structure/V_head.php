<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/public/img/logo.jpg">
    <title>Dashboard - Buboo Coffee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?= base_url() ?>assets/admin/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="<?= base_url('assets/admin/') ?>dist/css/style.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        label {
            font-weight: 500;
        }
        .select2-container--default .select2-selection--single {
            min-height: 38px;
            padding-top: 5px;
            border: 1px solid rgba(170, 170, 170, 0.3);
            border-radius: 5px !important;
        }
        
        .select2-container--default .select2-selection--multiple {
            border: 1px solid rgba(170, 170, 170, 0.3);
            border-radius: 5px !important;
            min-height: 38px;
            padding-top: 5px;
        }
        
        .select2-selection__arrow {
            margin-top: 5px;
        }
        
        .select2-container--default .select2-selection--multiple:active {
            border: 1px solid #197ED1;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">