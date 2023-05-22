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

        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 18px;
        }
      
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
      
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            left: 2px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        
        input:checked+.slider {
            background-color: #2196F3;
        }
        
        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }
        
        input:checked+.slider:before {
            -webkit-transform: translateX(14px);
            -ms-transform: translateX(14px);
            transform: translateX(14px);
        }
        
        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }
        
        .slider.round:before {
            border-radius: 50%;
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