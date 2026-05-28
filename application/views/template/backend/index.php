<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Seragam <?php echo date('Y'); ?> | FPI</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/uniform.png'); ?>" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url('css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/OverlayScrollbars.min.css'); ?>">
  <?php if(isset($pageStyles)) echo $pageStyles; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url('assets/img/uniform.png'); ?>" alt="SeragamFPI" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url('page/home'); ?>" class="nav-link">
          <i class="fas fa-home mr-1"></i> Home
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if($this->session->userdata('role') == '1'): ?>
      <li class="nav-item dropdown" id="notif-chat-item">
        <a class="nav-link" href="<?php echo base_url('page/chatAdmin'); ?>" id="notif-chat-btn" title="Chat Karyawan">
          <i class="fas fa-comments"></i>
          <span class="badge badge-warning navbar-badge" id="notif-chat-badge" style="display:none">0</span>
        </a>
      </li>
      <?php endif; ?>
      <li class="nav-item">
        <span class="nav-link text-light">
          <i class="fas fa-user-circle mr-1"></i>
          <?php echo $this->session->userdata('nama'); ?>
        </span>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url('auth/logout'); ?>" class="nav-link">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo base_url('page/home'); ?>" class="brand-link">
      <img src="<?php echo base_url('assets/img/uniform.png'); ?>" alt="FPI Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
      <span class="brand-text font-weight-light">SeragamFPI</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url('assets/img/uniform.png'); ?>" class="img-circle elevation-2" alt="User">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
          <small class="text-muted">NIK: <?php echo $this->session->userdata('username'); ?></small>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php echo $headernya; ?>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Seragam <small class="text-muted"><?php echo date('Y'); ?></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('page/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">PT. Fuji Presisi-Tool Indonesia</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <?php echo $contentnya; ?>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <strong>&copy; <?php echo date('Y'); ?> PT. Fuji Presisi-Tool Indonesia</strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>SeragamFPI</b> v1.0
    </div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.overlayScrollbars.min.js'); ?>"></script>
<script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
<?php if(isset($pageScripts)) echo $pageScripts; ?>
<?php if($this->session->userdata('role') == '1'): ?>
<script>
(function(){
  var BASE  = '<?php echo base_url(); ?>';
  var badge = document.getElementById('notif-chat-badge');
  var prev  = 0;
  function checkUnread(){
    fetch(BASE + 'index.php/page/chatUnread')
      .then(function(r){ return r.json(); })
      .then(function(d){
        var n = d.count || 0;
        if(n > 0){
          badge.textContent = n > 99 ? '99+' : n;
          badge.style.display = '';
          if(n > prev){
            // ubah warna navbar sebentar sebagai sinyal visual
            var nav = document.querySelector('.main-header.navbar');
            if(nav){ nav.classList.add('navbar-warning'); nav.classList.remove('navbar-primary'); }
            setTimeout(function(){
              if(nav){ nav.classList.remove('navbar-warning'); nav.classList.add('navbar-primary'); }
            }, 3000);
          }
        } else {
          badge.style.display = 'none';
        }
        prev = n;
      }).catch(function(){});
  }
  checkUnread();
  setInterval(checkUnread, 15000);
})();
</script>
<?php endif; ?>
</body>
</html>