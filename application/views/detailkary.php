<div class="pull-right">
	<a href="<?php echo base_url('page/editkary/'); echo $d->id_karyawan;?>" class="btn btn-warning">EDIT</a>
</div>
<div class="pull-right">
    <a href="<?php echo base_url('page/unduh');?>" class="btn btn-success">Export Excel</a>

</div>

<h2 style="margin-top: 0;margin-bottom: 0;">Detail Karyawan </h2>
<div class="clearfix"></div>
<hr />

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
              
            </tr>
        </thead>
		

        <tbody>
			<?php
				echo "<tr><td>NAMA</td><td>".$d->nama_karyawan."</td></tr>";
				echo "<tr><td>NIK</td><td>".$d->nik."</td></tr>";
				echo "<tr><td>ALAMAT</td><td>".$d->alamat.", ".$d->kecamatan.", ".$d->kota."</td></tr>";
				echo "<tr><td>KTP</td><td>".anchor("http://www.fujipresisi.com/form_karyawan/picture/ktp/".$d->id_karyawan.".jpg",$d->no_ktp)."</td></tr>";
				echo "<tr><td>KK</td><td>".anchor("http://www.fujipresisi.com/form_karyawan/picture/kk/".$d->id_karyawan.".jpg",$d->no_kk)."</td></tr>";
				echo "<tr><td>HP</td><td>".$d->handphone."</td></tr>";
				echo "<tr><td>JAMSOSTEK</td><td>".$d->no_jamsostek."</td></tr>";
				echo "<tr><td>BPJS KESEHATAN</td><td>".$d->no_bpjs."</td></tr>";
				echo "<tr><td>EMAIL</td><td>".$d->email."</td></tr>";
				echo "<tr><td>NAMA</td><td>".$d->nama_karyawan."</td></tr>";
				
			
           ?>
        
        </tbody>
    </table>
</div>