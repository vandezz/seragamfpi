<?php $tgl = $tglm->row(); ?>

<div class="row justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    <div class="card card-danger card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i>Parameter Tanggal Maksimal</h3>
      </div>
      <div class="card-body">
        <p class="text-muted mb-3">Atur batas tanggal terakhir karyawan dapat mengisi form seragam.</p>
        <form action="<?= base_url('index.php/page/xtanggalmax') ?>" method="post">
          <div class="form-group">
            <label>Tanggal Maksimal</label>
            <div class="input-group date" id="datepicker" data-target-input="nearest">
              <div class="input-group-prepend" data-target="#datepicker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
              </div>
              <input type="text" name="tglmax" id="tglmax"
                     class="form-control datetimepicker-input"
                     data-target="#datepicker"
                     value="<?= $tgl->tanggalmax ?>"
                     placeholder="YYYY-MM-DD"
                     autocomplete="off">
            </div>
            <small class="text-muted">Format: YYYY-MM-DD (contoh: <?= date('Y-m-d') ?>)</small>
          </div>
          <button type="submit" class="btn btn-danger btn-block">
            <i class="fas fa-save mr-1"></i>Simpan Perubahan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>