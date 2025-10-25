<?php
include 'config/app.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CRUD PHP</title>

  <!-- DataTables -->
  <link rel="stylesheet" href="assets-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets-template/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Bootstrap 5 CSS (UPGRADE) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets-template/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets-template/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets-template/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets-template/plugins/summernote/summernote-bs4.min.css">

  <!-- jQuery -->
<script src="assets-template/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
<img class="animation__shake" src="assets-template/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="assets-template/dist/img/cutie.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CRUD PHP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         <img src="assets-template/dist/img/candice.jpeg" class="img-circle elevation-2" alt="User Image">

        </div>
        <div class="info">
          <a href="#" class="d-block">Nabilla</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

     <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-header">DAFTAR MENU</li>

        
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Data Barang</p>
            </a>
          </li>
         

          
          <li class="nav-item">
            <a href="mahasiswa.php" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Data Mahasiswa</p>
            </a>
          </li>
         

          <li class="nav-item">
            <a href="pegawai.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Pegawai (Realtime)</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="email.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>Kirim Email (PHPMailer)</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="crud-modal.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Data Akun</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Yakin ingin keluar?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>