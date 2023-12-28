<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $title ?>
        </title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/fontawesome-free/css/all.min.css"); ?>>
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" >
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"); ?>>
        <!-- iCheck -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>>
        <!-- JQVMap -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/jqvmap/jqvmap.min.css"); ?>>
        <!-- Theme style -->
        <link rel="stylesheet" href=<?php self::publicDisk("dist/css/adminlte.min.css"); ?>>
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/overlayScrollbars/css/OverlayScrollbars.min.css" );?>>
        <!-- Daterange picker -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/daterangepicker/daterangepicker.css"); ?>>
        <!-- summernote -->
        <link rel="stylesheet" href=<?php self::publicDisk("plugins/summernote/summernote-bs4.min.css"); ?>>
    </head>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php $this->extends('Templates/Wrapper') ?>
    <!-- jQuery -->
    <script src=<?php self::publicDisk("plugins/jquery/jquery.min.js"); ?>></script>
    <!-- jQuery UI 1.11.4 -->
    <script src=<?php self::publicDisk("plugins/jquery-ui/jquery-ui.min.js"); ?>></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src=<?php self::publicDisk("plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>></script>
    <!-- ChartJS -->
    <script src=<?php self::publicDisk("plugins/chart.js/Chart.min.js"); ?>></script>
    <!-- Sparkline -->
    <script src=<?php self::publicDisk("plugins/sparklines/sparkline.js"); ?>></script>
    <!-- JQVMap -->
    <script src=<?php self::publicDisk("plugins/jqvmap/jquery.vmap.min.js"); ?>></script>
    <script src=<?php self::publicDisk("plugins/jqvmap/maps/jquery.vmap.usa.js"); ?>></script>
    <!-- jQuery Knob Chart -->
    <script src=<?php self::publicDisk("plugins/jquery-knob/jquery.knob.min.js"); ?>></script>
    <!-- daterangepicker -->
    <script src=<?php self::publicDisk("plugins/moment/moment.min.js"); ?>></script>
    <script src=<?php self::publicDisk("plugins/daterangepicker/daterangepicker.js"); ?>></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src=<?php self::publicDisk("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>></script>
    <!-- Summernote -->
    <script src=<?php self::publicDisk("plugins/summernote/summernote-bs4.min.js"); ?>></script>
    <!-- overlayScrollbars -->
    <script src=<?php self::publicDisk("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>></script>
    <!-- AdminLTE App -->
    <script src=<?php self::publicDisk("dist/js/adminlte.js"); ?>></script>
    <!-- AdminLTE for demo purposes -->
    <script src=<?php self::publicDisk("dist/js/demo.js"); ?>></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src=<?php self::publicDisk("dist/js/pages/dashboard.js"); ?>></script>


</body>

</html>