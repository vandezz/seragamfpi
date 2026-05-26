<div class="pull-right">
    <a href="<?php echo base_url('page/unduh');?>" class="btn btn-success">Export Excel</a>

</div>
<div class="pull-right">
    <a href="<?php echo base_url('page/copyukuran');?>" class="btn btn-warning">Copy Ukuran</a>

</div>

<h2 style="margin-top: 0;margin-bottom: 0;">karyawan yang belum ngisi</h2>
<div class="clearfix"></div>
<hr />

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
				<th>Ukuran Baju</th>
				<th>Lengan Baju</th>
				<th>Ukuran Celana</th>
				<th>Bahan Celana</th>
				<th>Jenis Celana</th>
				<th>Jenis Baju</th>
				<th>Keterangan Baju</th>
				<th>Keterangan/Note</th>
				<th>Copy</th>
        </thead>
		

        <tbody>
			<?php
			$no=1;
			$thnlalu = date('Y')-1;
			foreach($blm->result() as $t){
				$dprev = $this->UserModel->showw2('seragam','idkaryawan',$t->idkaryawan,'periode',$thnlalu);
				
				echo "<tr><td>".$no."</td><td>".$t->nama_karyawan."</td>";
				
				echo "<td>".$dprev->size_baju."</td>";
				echo "<td>".$dprev->lengan."</td>";
				echo "<td>".$dprev->size_celana."</td>";
				echo "<td>".$dprev->bahan_celana."</td>";
				echo "<td>".$dprev->bahan_baju."</td>";
				echo "<td>".$dprev->jenis_celana."</td>";
				echo "<td>".$dprev->jenis_baju."</td>";
				echo "<td>".$dprev->keterangan."</td>";
				echo "<td><a href='".base_url()."index.php/page/copyukuran/".$t->idkaryawan."'><button class='btn btn-info'>Copy Ukuran</button></a></td>";

				echo "</tr>";
				$no++;
			}
           ?>
        
        </tbody>
    </table>
</div>