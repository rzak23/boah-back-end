<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Boah | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#">Boah</a>
  </div>

  <div class="register-box-body">
    <?php echo $this->session->flashdata('message') ?>
    <?php echo form_open('register') ?>
      <?php echo form_error('nama','<small style="color:#FF0101">','</small>') ?>
      <div class="form-group has-feedback">
        <input type="text" name="nama" class="form-control" value="<?php echo set_value('nama') ?>" placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <?php echo form_error('uname','<small style="color:#FF0101">','</small>') ?>
      <div class="form-group has-feedback">
        <input type="text" name="uname" class="form-control" value="<?php echo set_value('uname') ?>" placeholder="Username">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <?php echo form_error('email','<small style="color:#FF0101">','</small>') ?>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" value="<?php echo set_value('email') ?>" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <?php echo form_error('pass','<small style="color:#FF0101">','</small>') ?>
      <div class="form-group has-feedback">
        <input type="password" name="pass" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          <a href="<?php echo site_url('login') ?>" class="btn btn-success btn-block text-center">
            I already have a membership
          </a>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close() ?>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
