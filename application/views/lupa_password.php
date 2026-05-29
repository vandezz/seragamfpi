<div class="text-center mb-3">
  <h5 class="mb-1"><i class="fas fa-key mr-1"></i> Lupa Password</h5>
  <small class="text-muted">Masukkan NIK Anda untuk melihat email terdaftar</small>
</div>

<div class="form-group">
  <input type="text" id="inp_nik" class="form-control" placeholder="Nomor Induk Karyawan" autofocus>
</div>

<button type="button" class="btn btn-primary btn-block" id="btn_cek">
  <i class="fas fa-search mr-1"></i> Cek
</button>

<div id="info_email" class="d-none mt-3">
  <div class="alert alert-info py-2 mb-3">
    <i class="fas fa-envelope mr-1"></i>
    Email terdaftar: <strong id="txt_email"></strong>
  </div>
  <button type="button" class="btn btn-success btn-block" id="btn_kirim">
    <i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email
  </button>
</div>

<div id="info_sukses" class="alert alert-success py-2 mt-3 d-none">
  <i class="fas fa-check-circle mr-1"></i>
  <span id="txt_sukses"></span>
</div>

<div id="info_error" class="alert alert-danger py-2 mt-3 d-none">
  <i class="fas fa-exclamation-circle mr-1"></i>
  <span id="txt_error"></span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var btnCek    = document.getElementById('btn_cek');
  var btnKirim  = document.getElementById('btn_kirim');
  var inpNik    = document.getElementById('inp_nik');
  var infoEmail = document.getElementById('info_email');
  var infoSukses= document.getElementById('info_sukses');
  var infoError = document.getElementById('info_error');
  var txtEmail  = document.getElementById('txt_email');
  var txtSukses = document.getElementById('txt_sukses');
  var txtError  = document.getElementById('txt_error');

  function resetInfo(){
    infoEmail.classList.add('d-none');
    infoSukses.classList.add('d-none');
    infoError.classList.add('d-none');
  }

  function cekNik(){
    var nik = inpNik.value.trim();
    if(!nik) return;
    resetInfo();
    btnCek.disabled = true;
    btnCek.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memeriksa...';

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
      btnCek.innerHTML = '<i class="fas fa-search mr-1"></i> Cek';
    });
  }

  function kirimReset(){
    var nik = inpNik.value.trim();
    infoError.classList.add('d-none');
    btnKirim.disabled = true;
    btnKirim.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mengirim...';

    var body = new URLSearchParams();
    body.append('nik', nik);

    fetch('<?= base_url('auth/kirimreset'); ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
    .then(function(r){ return r.text(); })
    .then(function(text){
      var res;
      try { res = JSON.parse(text); } catch(e){
        txtError.textContent = 'Server error: ' + text.substring(0, 200);
        infoError.classList.remove('d-none');
        btnKirim.disabled = false;
        btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
        return;
      }
      if(res.ok){
        infoEmail.classList.add('d-none');
        btnCek.classList.add('d-none');
        inpNik.disabled = true;
        txtSukses.textContent = 'Link reset telah dikirim ke email Anda. Periksa kotak masuk (atau folder spam).';
        infoSukses.classList.remove('d-none');
      } else {
        txtError.textContent = res.msg;
        infoError.classList.remove('d-none');
        btnKirim.disabled = false;
        btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
      }
    })
    .catch(function(e){
      txtError.textContent = 'Network error: ' + e.message;
      infoError.classList.remove('d-none');
      btnKirim.disabled = false;
      btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
    });
  }

  btnCek.addEventListener('click', cekNik);
  inpNik.addEventListener('keydown', function(e){ if(e.key === 'Enter') cekNik(); });
  btnKirim.addEventListener('click', kirimReset);
});
</script>


<div id="info_email" class="d-none">
  <div class="alert alert-info py-2 mb-3">
    <i class="fas fa-envelope mr-1"></i>
    Email terdaftar: <strong id="txt_email"></strong>
  </div>
  <button type="button" class="btn btn-primary btn-block" id="btn_kirim">
    <i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email
  </button>
</div>

<div id="info_sukses" class="alert alert-success py-2 d-none">
  <i class="fas fa-check-circle mr-1"></i>
  <span id="txt_sukses"></span>
</div>

<div id="info_error" class="alert alert-danger py-2 d-none">
  <i class="fas fa-exclamation-circle mr-1"></i>
  <span id="txt_error"></span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var btnCek    = document.getElementById('btn_cek');
  var btnKirim  = document.getElementById('btn_kirim');
  var inpNik    = document.getElementById('inp_nik');
  var infoEmail = document.getElementById('info_email');
  var infoSukses= document.getElementById('info_sukses');
  var infoError = document.getElementById('info_error');
  var txtEmail  = document.getElementById('txt_email');
  var txtSukses = document.getElementById('txt_sukses');
  var txtError  = document.getElementById('txt_error');

  function resetInfo(){
    infoEmail.classList.add('d-none');
    infoSukses.classList.add('d-none');
    infoError.classList.add('d-none');
  }

  function cekNik(){
    var nik = inpNik.value.trim();
    if(!nik) return;
    resetInfo();
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

  function kirimReset(){
    var nik = inpNik.value.trim();
    resetInfo();
    btnKirim.disabled = true;
    btnKirim.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mengirim...';

    var body = new URLSearchParams();
    body.append('nik', nik);

    fetch('<?= base_url('auth/kirimreset'); ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
    .then(function(r){ return r.text(); })
    .then(function(text){
      var res;
      try { res = JSON.parse(text); } catch(e){
        // Bukan JSON — tampilkan raw response untuk debug
        txtError.textContent = 'Server error: ' + text.substring(0, 200);
        infoError.classList.remove('d-none');
        infoEmail.classList.remove('d-none');
        btnKirim.disabled = false;
        btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
        return;
      }
      if(res.ok){
        infoEmail.classList.add('d-none');
        txtSukses.textContent = 'Link reset telah dikirim ke email Anda. Periksa kotak masuk (atau folder spam).';
        infoSukses.classList.remove('d-none');
        btnKirim.classList.add('d-none');
        inpNik.disabled = true;
        btnCek.disabled = true;
      } else {
        txtError.textContent = res.msg;
        infoError.classList.remove('d-none');
        infoEmail.classList.remove('d-none');
        btnKirim.disabled = false;
        btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
      }
    })
    .catch(function(e){
      txtError.textContent = 'Network error: ' + e.message;
      infoError.classList.remove('d-none');
      btnKirim.disabled = false;
      btnKirim.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset ke Email';
    });
  }

  btnCek.addEventListener('click', cekNik);
  inpNik.addEventListener('keydown', function(e){ if(e.key === 'Enter') cekNik(); });
  btnKirim.addEventListener('click', kirimReset);
});
</script>


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
