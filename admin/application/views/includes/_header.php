<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= isset($title)? $title.' - ' : 'Title -' ?> <?= $this->general_settings['application_name']; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/adminlte.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
  <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>

  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/bootstrap/css/jquery.jgrowl.min.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/email_multiple/email.multiple.css" />

<script src="<?= base_url()?>assets/plugins/jquery/jquery.jgrowl.min.js"></script>
<script src="<?= base_url()?>assets/email_multiple/jquery.email.multiple.js"></script>




</head>

<body class="hold-transition sidebar-mini">

<!-- Main Wrapper Start -->
<div class="wrapper">

  <!-- Navbar -->

  <?php if(!isset($navbar)): ?>

  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('admin') ?>" class="nav-link">Home</a>
      </li>  -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
       <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('logout') ?>" class="nav-link">Logout</a>
    </li>       
    </ul>
  </nav> 
  <?php endif; ?>

  <!-- /.navbar -->  
  <!-- Sideabr --> 
  <?php if(!isset($sidebar)): ?>

  <?php $this->load->view('includes/_sidebar'); ?>

  <?php endif; ?>

  <!-- / .Sideabr -->
