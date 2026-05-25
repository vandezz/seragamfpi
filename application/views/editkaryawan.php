<form name="edk" action="<?=base_url();?>editkaryx"  method="post">

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
				echo "<tr><td>NAMA</td><td><input type='text' name='tnama' value='".$m->nama_karyawan."'></td></tr>";
				echo "<tr><td>NIK</td><td>".$m->nik."</td></tr>";
				echo "<tr><td>ALAMAT</td><td>".$m->alamat.", ".$m->kecamatan.", ".$m->kota."</td></tr>";
				echo "<tr><td>KTP</td><td>".anchor("http://www.fujipresisi.com/form_karyawan/picture/ktp/".$m->id_karyawan.".jpg",$m->no_ktp)."</td></tr>";
				echo "<tr><td>KK</td><td>".anchor("http://www.fujipresisi.com/form_karyawan/picture/kk/".$m->id_karyawan.".jpg",$m->no_kk)."</td></tr>";
				echo "<tr><td>HP</td><td>".$m->handphone."</td></tr>";
				echo "<tr><td>JAMSOSTEK</td><td>".$m->no_jamsostek."</td></tr>";
				echo "<tr><td>BPJS KESEHATAN</td><td>".$m->no_bpjs."</td></tr>";
				echo "<tr><td>EMAIL</td><td>".$m->email."</td></tr>";
				echo "<tr><td>NAMA</td><td>".$m->nama_karyawan."</td></tr>";
				echo "<tr><td></td><td><input type='submit' value='Edit' class='btn btn-success'></td></tr>";
				
			
           ?>
        
        </tbody>
    </table>
</div>
</form>