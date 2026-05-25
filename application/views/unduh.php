DATA UKURAN SERAGAM TAHUN <?=$tahun;?> (PT. Fuji Presisi-Tool Indoonesia)
</br>
    <table border='1'>
        <thead>
            <tr>
                <th>No</th>
				<th>ID Karyawan</th>
                <th>Nama Karyawan</th>
				<th>Bagian</th>
                <th>Ukuran Baju</th>
                <th>Lengan</th>
				<th>Bahan Baju</th>
				<th>Jenis Baju</th>
				<th>Ukuran Celana</th>
				<th>Bahan Celana</th>
				<th>Note</th>
				
            </tr>
        </thead>
		

        <tbody>
			<?php
			$no=1;
			foreach($xls->result() as $t){
				echo "<tr><td>".$no."</td><td>".$t->idk."</td><td>".$t->Nama."</td><td>".$t->Bagian."</td><td>".$t->Sizebaju."</td><td>".$t->Lengan."</td><td>".$t->BahanBaju.
				"</td><td>".$t->JenisBaju."</td><td>".$t->SizeCelana."</td><td>".$t->JenisCelana."</td><td>".$t->Ket."</td>
				</tr>";
				$no++;
			}
           ?>
        
        </tbody>
    </table>
