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
$(function(){
  function cekNik(){
    var nik = $('#inp_nik').val().trim();
    if(!nik) return;

    $('#info_email, #info_error').addClass('d-none');
    $('#btn_cek').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

    $.post('<?= base_url('auth/ceknik'); ?>', { nik: nik }, function(res){
      if(res.ok){
        $('#txt_email').text(res.email);
        $('#info_email').removeClass('d-none');
      } else {
        $('#txt_error').text(res.msg);
        $('#info_error').removeClass('d-none');
      }
    }, 'json').always(function(){
      $('#btn_cek').prop('disabled', false).html('<i class="fas fa-search"></i> Cek');
    });
  }

  $('#btn_cek').on('click', cekNik);
  $('#inp_nik').on('keydown', function(e){ if(e.key === 'Enter') cekNik(); });
});
</script>
