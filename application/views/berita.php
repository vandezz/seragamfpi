<div class="row">
<div class="col-12">
<div class="card card-primary card-outline">
<div class="card-header d-flex justify-content-between align-items-center">
  <h3 class="card-title"><i class="fas fa-tshirt mr-2"></i>Input Seragam Tahun <?php echo date('Y');?></h3>
  <?php if($this->session->userdata('role') == '1'): ?>
  <a href="" class="btn btn-success btn-sm"><i class="fas fa-plus mr-1"></i>Tambah Data</a>
  <?php endif; ?>
</div>
<div class="card-body">
<p class="text-danger font-weight-bold"><i class="fas fa-info-circle mr-1"></i>Per karyawan mendapatkan 1 Stel seragam</p>
<div class="clearfix"></div>
<hr />

<div class="table-responsive">
<form name="fukuran" id="fukuran" action="<?=base_url();?>index.php/page/ukuran" method="post">
<?php
$default_baju   = !empty($ds->size_baju)  ? $ds->size_baju  : (!empty($lalu->size_baju)  ? $lalu->size_baju  : '');
$default_lengan = !empty($ds->lengan)     ? $ds->lengan     : (!empty($lalu->lengan)     ? $lalu->lengan     : '');
$default_celana = !empty($ds->size_celana)? $ds->size_celana: (!empty($lalu->size_celana)? $lalu->size_celana: '');
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan='3' align="center">UKURAN Seragam</th>
                <th bgcolor="#f2f3f4">SERAGAM TAHUN LALU</th>
            </tr>
        </thead>
        <tbody>
			<?php if($this->session->userdata('jk')== 'Laki-laki')
			{ ?>
            <tr>
                
                <td>Ukuran BAJU</td>
                <td> 
				<select class="form-control" name="sizebaju" id="sizebaju">
				  <option value="S" <?=($default_baju=='S'?'selected':'')?>>S</option>
				  <option value="M" <?=($default_baju=='M'?'selected':'')?>>M</option>
				  <option value="L" <?=($default_baju=='L'?'selected':'')?>>L</option>
				  <option value="XL" <?=($default_baju=='XL'?'selected':'')?>>XL</option>
				  <option value="XXL" <?=($default_baju=='XXL'?'selected':'')?>>XXL</option>
				  <option value="XXXL" <?=($default_baju=='XXXL'?'selected':'')?>>XXXL</option>
				  <option value="other" <?=($default_baju=='other'?'selected':'')?>>Other</option>
				</select> 
				</td>
                <td>
					<select class="form-control" name="lengan" id="lengan">
						<option value="Lengan Pendek" <?=($default_lengan=='Lengan Pendek'?'selected':'')?>>Lengan Pendek</option>
						<option value="Lengan Panjang" <?=($default_lengan=='Lengan Panjang'?'selected':'')?>>Lengan Panjang</option>
					</select>
				</td>
				<td bgcolor='#f2f3f4'>
					<?php echo "Ukuran : ".$lalu->size_baju.", ".$lalu->lengan; ?>
				</td>
            </tr>
            <tr>
				<td>
					Ukuran CELANA
				</td>
				<td>
					<select class="form-control" name="sizecelana" id="sizecelana">
						<?php 
						if(!empty($ds->size_celana)){
							echo "<option value='".$ds->size_celana."' selected>".$ds->size_celana."</option>";
						}?>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>
						<option value="32">32</option>
						<option value="33">33</option>
						<option value="34">34</option>
						<option value="35">35</option>
						<option value="36">36</option>
						<option value="37">37</option>
						<option value="38">38</option>
						<option value="39">39</option>
						<option value="40">40</option>
						<option value="other">Other</option>
						
					</select>
				</td>
				<td></td>
				<td bgcolor='#f2f3f4'>
					<?php echo "Ukuran celana :".$lalu->size_celana; ?>
				</td>
			</tr>
			<?php } else { ?>
				<tr>
                
                <td>Ukuran BAJU</td>
                <td> 
				<select class="form-control" name="sizebaju" id="sizebaju">
				  <option value="S" <?=($default_baju=='S'?'selected':'')?>>S</option>
				  <option value="M" <?=($default_baju=='M'?'selected':'')?>>M</option>
				  <option value="L" <?=($default_baju=='L'?'selected':'')?>>L</option>
				  <option value="XL" <?=($default_baju=='XL'?'selected':'')?>>XL</option>
				  <option value="XXL" <?=($default_baju=='XXL'?'selected':'')?>>XXL</option>
				  <option value="XXXL" <?=($default_baju=='XXXL'?'selected':'')?>>XXXL</option>
				  <option value="other" <?=($default_baju=='other'?'selected':'')?>>Other</option>
				</select> </td>
                <td>
					<select class="form-control" name="lengan" id="lengan">
						<option value="Lengan Panjang" <?=($default_lengan=='Lengan Panjang'?'selected':'')?>>Lengan Panjang</option>
						<option value="Lengan Pendek" <?=($default_lengan=='Lengan Pendek'?'selected':'')?>>Lengan Pendek</option>
					</select>
				</td>
				<td>
					<?php echo "Ukuran : ".$lalu->size_baju.", ".$lalu->lengan; ?>
				</td>
            </tr>
            <tr>
				<td>
					Ukuran CELANA
				</td>
				<td>
					<select class="form-control" name="sizecelana" id="sizecelana">
					<option value="27" <?=($default_celana=='27'?'selected':'')?>>27</option>
					<option value="28" <?=($default_celana=='28'?'selected':'')?>>28</option>
					<option value="29" <?=($default_celana=='29'?'selected':'')?>>29</option>
					<option value="30" <?=($default_celana=='30'?'selected':'')?>>30</option>
					<option value="31" <?=($default_celana=='31'?'selected':'')?>>31</option>
					<option value="32" <?=($default_celana=='32'?'selected':'')?>>32</option>
					<option value="33" <?=($default_celana=='33'?'selected':'')?>>33</option>
					<option value="34" <?=($default_celana=='34'?'selected':'')?>>34</option>
					<option value="35" <?=($default_celana=='35'?'selected':'')?>>35</option>
					<option value="36" <?=($default_celana=='36'?'selected':'')?>>36</option>
					<option value="37" <?=($default_celana=='37'?'selected':'')?>>37</option>
					<option value="38" <?=($default_celana=='38'?'selected':'')?>>38</option>
					<option value="39" <?=($default_celana=='39'?'selected':'')?>>39</option>
					<option value="40" <?=($default_celana=='40'?'selected':'')?>>40</option>
					<option value="41" <?=($default_celana=='41'?'selected':'')?>>41</option>
					<option value="42" <?=($default_celana=='42'?'selected':'')?>>42</option>
					<option value="43" <?=($default_celana=='43'?'selected':'')?>>43</option>
					<option value="44" <?=($default_celana=='44'?'selected':'')?>>44</option>
					<option value="45" <?=($default_celana=='45'?'selected':'')?>>45</option>
					<option value="46" <?=($default_celana=='46'?'selected':'')?>>46</option>
					<option value="47" <?=($default_celana=='47'?'selected':'')?>>47</option>
					<option value="other" <?=($default_celana=='other'?'selected':'')?>>Other</option>
					</select>
				</td>
				<td></td>
				<td>
					<?php echo "Ukuran celana :".$lalu->size_celana; ?>
				</td>
			</tr>
			
			
		<?php }
			$keterangan = !empty($ds->keterangan) ? $ds->keterangan : (!empty($lalu->keterangan) ? $lalu->keterangan : '');
		?>
			<tr>
				<td>Keterangan</td>
				
				<td colspan="2"><textarea class="form-control" class="form-control" rows="4" name="keterangan" id="keterangan"><?php echo $keterangan;?></textarea></td>
				<td bgcolor='#f2f3f4'></td>
			</tr>
			<?php 
			$tglmax = '2026-01-01';
			//$tglmax = $tglmx->row()->tanggalmax;
			'2023-10-04';
			if((date('Y-m-d')< $tglmax) || ($this->session->userdata('role') == '1'))
			{ ?>
			<tr>
				<td colspan='3' align='center'><input class="btn btn-success" type='submit'
				<?php 
				if(!empty($ds->size_baju))
				{
					echo "value='Update'>";
				}
				else
				{
					echo "value='Submit'>";
				}
				?>
				</td>
			</tr>
			<?php 
			}
			?>
        </tbody>
    </table>
	</form>
</div>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-12">
<div class="card card-info card-outline">
<div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Keterangan</h3></div>
<div class="card-body">
<ul>
	<li>Jika tidak ada pilihan pada opsi, pilih Other, isi di kolom Keterangan</li>
	<li>Setelah Submit, hasil pengisian akan muncul di halaman berikutnya</li>
	<li>Anda masih bisa edit Pilihan Anda setelah Submit. Klik tombol Edit</li>
	<li>Pengisian form ukuran Seragam paling lambat hari <b style ='color:red'> 
	<?php
		$due = $this->UserModel->showall('seragam_param')->row();
		$t = $due->tanggalmax;
		$ts = strtotime($t);

		$hari_id = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
		$bulan_id = ['','Januari','Februari','Maret','April','Mei','Juni',
		             'Juli','Agustus','September','Oktober','November','Desember'];

		echo $hari_id[date('w', $ts)];
		echo ", ";
		echo date('j', $ts) . " ";
		echo $bulan_id[(int)date('n', $ts)];
		echo " " . date('Y', $ts);
	?>
	</b></li>
</ul>
</div>
</div>
</div>
</div>