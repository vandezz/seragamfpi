<?php
$is_edit    = ($mode === 'edit');
$title      = $is_edit ? 'Edit Karyawan' : 'Tambah Karyawan Baru';
$action_url = $is_edit
    ? base_url('page/mkUpdate')
    : base_url('page/mkSimpan');

$msg_err = $this->session->flashdata('msg_error');

// Shorthand fields (safely handles null for tambah mode)
$v = function($field) use ($k) {
    if(!$k) return '';
    return htmlspecialchars($k->{$field} ?? '');
};
?>

<?php if($msg_err): ?>
<div class="alert alert-danger alert-dismissible mb-3">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($msg_err) ?>
</div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-12 col-lg-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-<?= $is_edit ? 'user-edit' : 'user-plus' ?> mr-2"></i><?= $title ?>
        </h3>
      </div>
      <form action="<?= $action_url ?>" method="post" id="frmKaryawan">
        <?php if($is_edit): ?>
        <input type="hidden" name="id_karyawan" value="<?= $v('id_karyawan') ?>">
        <?php endif; ?>
        <div class="card-body">

          <div class="form-row">
            <!-- Nama Karyawan -->
            <div class="form-group col-12">
              <label>Nama Karyawan <span class="text-danger">*</span></label>
              <input type="text" name="nama_karyawan" class="form-control"
                     value="<?= $v('nama_karyawan') ?>" placeholder="Nama lengkap" required>
            </div>

            <!-- NIK & Password -->
            <div class="form-group col-md-6">
              <label>NIK (Login) <span class="text-danger">*</span></label>
              <input type="text" name="nik" class="form-control"
                     value="<?= $v('nik') ?>" placeholder="Nomor Induk Karyawan" required>
            </div>
            <div class="form-group col-md-6">
              <label>
                Password
                <?php if($is_edit): ?>
                <small class="text-muted">(kosongkan jika tidak diubah)</small>
                <?php else: ?>
                <span class="text-danger">*</span>
                <small class="text-muted">(default: 12345)</small>
                <?php endif; ?>
              </label>
              <div class="input-group">
                <input type="password" name="password" id="inpPassword" class="form-control"
                       placeholder="<?= $is_edit ? 'Isi untuk mengubah password...' : 'Password baru...' ?>"
                       <?= $is_edit ? '' : 'required' ?>>
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" id="btnTogglePass" tabindex="-1"
                          onclick="var i=document.getElementById('inpPassword'); i.type=(i.type==='password'?'text':'password')">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <!-- Jenis Kelamin -->
            <div class="form-group col-md-4">
              <label>Jenis Kelamin <span class="text-danger">*</span></label>
              <select name="jns_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki"  <?= ($v('jns_kelamin') === 'Laki-laki')  ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan"  <?= ($v('jns_kelamin') === 'Perempuan')  ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>

            <!-- Kode Bagian / Departemen -->
            <div class="form-group col-md-4">
              <label>Kode Bagian <span class="text-danger">*</span></label>
              <input type="text" name="kd_bagian" class="form-control"
                     value="<?= $v('kd_bagian') ?>" placeholder="Contoh: PRODUKSI, HRD, PPIC" required>
            </div>

            <!-- Tipe Seragam -->
            <div class="form-group col-md-4">
              <label>Tipe Seragam <span class="text-danger">*</span></label>
              <select name="seragam_office" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="F" <?= ($v('seragam_office') === 'F') ? 'selected' : '' ?>>
                  F – Factory / Produksi (Taipan)
                </option>
                <option value="O" <?= ($v('seragam_office') === 'O') ? 'selected' : '' ?>>
                  O – Office / Kantor (Executive)
                </option>
                <option value="W" <?= ($v('seragam_office') === 'W') ? 'selected' : '' ?>>
                  W – Wearpak (American Drill)
                </option>
              </select>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group">
            <label>Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
              </div>
              <input type="email" name="email" class="form-control"
                     value="<?= $v('email') ?>" placeholder="Alamat email karyawan (opsional)">
            </div>
          </div>

          <div class="form-row">
            <!-- Level / Role -->
            <div class="form-group col-md-6">
              <label>Level Akses <span class="text-danger">*</span></label>
              <select name="id_levell" class="form-control" required>
                <option value="2" <?= ($v('id_levell') !== '1') ? 'selected' : '' ?>>User (karyawan biasa)</option>
                <option value="1" <?= ($v('id_levell') === '1') ? 'selected' : '' ?>>Admin</option>
              </select>
            </div>

            <!-- Status (edit only) -->
            <?php if($is_edit): ?>
            <div class="form-group col-md-6">
              <label>Status</label>
              <select name="kondisi" class="form-control">
                <option value="AKTIF"    <?= (strtoupper($v('kondisi')) === 'AKTIF')    ? 'selected' : '' ?>>Aktif</option>
                <option value="NONAKTIF" <?= (strtoupper($v('kondisi')) === 'NONAKTIF') ? 'selected' : '' ?>>Nonaktif</option>
              </select>
            </div>
            <?php endif; ?>
          </div>

        </div><!-- /card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-save mr-1"></i><?= $is_edit ? 'Simpan Perubahan' : 'Tambah Karyawan' ?>
          </button>
          <a href="<?= base_url('page/mKaryawan') ?>" class="btn btn-secondary">
            <i class="fas fa-times mr-1"></i>Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
