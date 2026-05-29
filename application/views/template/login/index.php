<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Seragam FPI</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/uniform.png'); ?>" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url('css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/adminlte.min.css'); ?>">
  <style>
    .login-page { background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%); }
    .login-box { width: 380px; }
    .login-logo a { color: #fff; font-size: 1.8rem; }
    .login-logo img { height: 55px; margin-bottom: 8px; }
    .card { border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
    .login-card-body { padding: 2rem; }
    .login-box-msg { color: #6c757d; font-size: 0.9rem; }
    .btn-primary { background: linear-gradient(135deg, #1a237e, #0d47a1); border: none; border-radius: 6px; padding: 10px; font-size: 1rem; }
    .btn-primary:hover { background: linear-gradient(135deg, #0d47a1, #01579b); }
    .input-group-text { background: #f8f9fa; }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo text-center mb-3">
    <img src="<?php echo base_url('assets/img/uniform.png'); ?>" alt="Logo FPI"><br>
    <a href="#"><b>Seragam</b>FPI</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk menggunakan Nomor Induk Karyawan Anda</p>

      <?php if($this->session->flashdata('message_success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i>
        <?php echo $this->session->flashdata('message_success'); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      <?php endif; ?>

      <?php if($this->session->flashdata('message')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i>
        <?php echo $this->session->flashdata('message'); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      <?php endif; ?>

      <?php echo $contentnya; ?>

    </div>
  </div>

  <div class="text-center mt-3">
    <?php if($this->uri->segment(2) !== 'index' && $this->uri->segment(1) === 'auth' && $this->uri->segment(2) !== ''): ?>
    <a href="<?php echo base_url('auth'); ?>" style="color:rgba(255,255,255,0.75); font-size:0.85rem;">
      <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
    </a><br><br>
    <?php endif; ?>
    <span style="color:rgba(255,255,255,0.6); font-size:0.8rem;">
      &copy; <?php echo date('Y'); ?> PT. Fuji Presisi-Tool Indonesia
    </span>
  </div>
</div>

<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
</body>
</html>