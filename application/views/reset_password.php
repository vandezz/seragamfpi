<?php if($this->session->flashdata('message')): ?>
<div class="alert alert-danger alert-dismissible mb-3">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fas fa-exclamation-circle mr-1"></i>
  <?= htmlspecialchars($this->session->flashdata('message')) ?>
</div>
<?php endif; ?>

<div class="text-center mb-3">
  <h5 class="mb-1"><i class="fas fa-lock-open mr-1"></i> Buat Password Baru</h5>
  <small class="text-muted">Masukkan password baru Anda</small>
</div>

<form method="post" action="<?= base_url('auth/prosesreset'); ?>">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

  <div class="form-group">
    <label>Password Baru</label>
    <div class="input-group">
      <input type="password" name="pw_baru" id="pw_baru" class="form-control"
             placeholder="Password baru" required autofocus>
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-secondary"
                onclick="var i=document.getElementById('pw_baru');i.type=(i.type==='password'?'text':'password')">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label>Ulangi Password Baru</label>
    <div class="input-group">
      <input type="password" name="cpw_baru" id="cpw_baru" class="form-control"
             placeholder="Ulangi password baru" required>
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-secondary"
                onclick="var i=document.getElementById('cpw_baru');i.type=(i.type==='password'?'text':'password')">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block">
    <i class="fas fa-save mr-1"></i> Simpan Password Baru
  </button>
</form>


