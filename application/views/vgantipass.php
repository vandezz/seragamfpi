<?php $data = $this->session->userdata(); ?>

<div class="row justify-content-center">
  <div class="col-12 col-sm-8 col-md-6 col-lg-5">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-key mr-2"></i>Ganti Password</h3>
      </div>
      <div class="card-body">
        <p class="text-muted">Hai <strong><?= $data['nama']; ?></strong>, silakan ganti password Anda.</p>
        <form action="<?= base_url('page/gantipasswordx'); ?>" method="POST">
          <div class="form-group">
            <label>Password Baru</label>
            <div class="input-group">
              <input type="password" name="pw_baru" class="form-control" placeholder="Masukkan password baru" autofocus>
              <div class="input-group-append">
                <div class="input-group-text"><i class="fas fa-lock"></i></div>
              </div>
            </div>
            <small class="text-danger"><?= form_error('pw_baru'); ?></small>
          </div>
          <div class="form-group">
            <label>Ulangi Password Baru</label>
            <div class="input-group">
              <input type="password" name="cpw_baru" class="form-control" placeholder="Ulangi password baru">
              <div class="input-group-append">
                <div class="input-group-text"><i class="fas fa-lock"></i></div>
              </div>
            </div>
            <small class="text-danger"><?= form_error('cpw_baru'); ?></small>
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save mr-1"></i> Simpan Password
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
