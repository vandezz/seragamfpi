<form method="post" action="<?php echo base_url('index.php/auth/login'); ?>">
  <div class="input-group mb-3">
    <input type="text" name="username" class="form-control" placeholder="Nomor Induk Karyawan" autofocus>
    <div class="input-group-append">
      <div class="input-group-text"><span class="fas fa-id-badge"></span></div>
    </div>
  </div>
  <div class="input-group mb-4">
    <input type="password" name="password" class="form-control" placeholder="Password">
    <div class="input-group-append">
      <div class="input-group-text"><span class="fas fa-lock"></span></div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <button type="submit" class="btn btn-primary btn-block">
        <i class="fas fa-sign-in-alt mr-1"></i> Masuk
      </button>
    </div>
  </div>
</form>
