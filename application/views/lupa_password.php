<div class="text-center mb-3">
  <h5 class="mb-1"><i class="fas fa-key mr-1"></i> Lupa Password</h5>
  <small class="text-muted">Masukkan NIK Anda untuk melihat email terdaftar</small>
</div>

<div class="form-group">
  <div class="input-group">
    <input type="text" id="inp_nik" class="form-control" placeholder="Nomor Induk Karyawan" autofocus>
    <div class="input-group-append">
      <button type="button" class="btn btn-outline-secondary" id="btn_cek">
        <i class="fas fa-search"></i> Cek
      </button>
    </div>
  </div>
</div>

<div id="info_email" class="alert alert-info py-2 d-none">
  <i class="fas fa-envelope mr-1"></i>
  Email terdaftar: <strong id="txt_email"></strong>
</div>

<div id="info_error" class="alert alert-danger py-2 d-none">
  <i class="fas fa-exclamation-circle mr-1"></i>
  <span id="txt_error"></span>
</div>

<a href="<?= base_url('auth'); ?>" class="btn btn-secondary btn-block mt-2">
  <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
</a>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var btnCek    = document.getElementById('btn_cek');
  var inpNik    = document.getElementById('inp_nik');
  var infoEmail = document.getElementById('info_email');
  var infoError = document.getElementById('info_error');
  var txtEmail  = document.getElementById('txt_email');
  var txtError  = document.getElementById('txt_error');

  function cekNik(){
    var nik = inpNik.value.trim();
    if(!nik) return;

    infoEmail.classList.add('d-none');
    infoError.classList.add('d-none');
    btnCek.disabled = true;
    btnCek.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    var body = new URLSearchParams();
    body.append('nik', nik);

    fetch('<?= base_url('auth/ceknik'); ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
    .then(function(r){ return r.json(); })
    .then(function(res){
      if(res.ok){
        txtEmail.textContent = res.email;
        infoEmail.classList.remove('d-none');
      } else {
        txtError.textContent = res.msg;
        infoError.classList.remove('d-none');
      }
    })
    .catch(function(){
      txtError.textContent = 'Terjadi kesalahan, coba lagi.';
      infoError.classList.remove('d-none');
    })
    .finally(function(){
      btnCek.disabled = false;
      btnCek.innerHTML = '<i class="fas fa-search"></i> Cek';
    });
  }

  btnCek.addEventListener('click', cekNik);
  inpNik.addEventListener('keydown', function(e){ if(e.key === 'Enter') cekNik(); });
});
</script>
