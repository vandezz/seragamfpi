<div class="row">
  <div class="col-12 col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user mr-2"></i>My Profile</h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <tbody>
              <tr>
                <td width="35%"><strong>Nama</strong></td>
                <td><?=$k->nama_karyawan;?></td>
              </tr>
              <tr>
                <td><strong>Alamat</strong></td>
                <td><?=$k->alamat.", ".$k->kota;?></td>
              </tr>
              <tr>
                <td><strong>Tempat, Tgl Lahir</strong></td>
                <td><?=$k->tmp_lahir.", ".$k->tgl_lahir;?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
