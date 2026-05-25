<div class="pull-right">
    <a href="<?php echo base_url('index.php/page/unduh');?>" class="btn btn-success">Export Excel</a>

</div>

<h2 style="margin-top: 0;margin-bottom: 0;">Periode <?=date('Y');?> | responden :<a href="yangbelum"><?php echo $c;?> karyawan <?php echo (214-$c);?> lagi</a></h2>
<div class="clearfix"></div>
<hr />

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Ukuran Baju</th>
                <th>Lengan</th>
				<th>Bahan Baju</th>
				<th>Jenis Baju</th>
				<th>Ukuran Celana</th>
				<th>Bahan Celana</th>
				<th>BAGIAN</th>
				<th>NOTE</th>
            </tr>
        </thead>
		

        <tbody>
			<?php
			$no=1;
			foreach($g->result() as $t){
				echo "<tr><td>".$no."</td><td>".$t->Nama."</td><td>".$t->Sizebaju."</td><td>".$t->Lengan."</td><td>".$t->BahanBaju.
				"</td><td>".$t->JenisBaju."</td><td>".$t->SizeCelana."</td><td>".$t->JenisCelana."</td><td>".$t->Bagian."</td>
				<td>".$t->Ket."</td></tr>";
				$no++;
			}
           ?>
        
        </tbody>
    </table>
</div>