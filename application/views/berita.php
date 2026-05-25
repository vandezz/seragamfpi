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
				<?php 
				if(!empty($ds->size_baju)){
					echo "<option value='".$ds->size_baju."' selected>".$ds->size_baju."</option>";
				}?>
				  <option value="S">S</option>
				  <option value="M">M</option>
				  <option value="L">L</option>
				  <option value="XL">XL</option>
				  <option value="XXL">XXL</option>
				  <option value="XXXL">XXXL</option>
				  <option value="other">Other</option>
				</select> 
				</td>
                <td>
					<select class="form-control" name="lengan" id="lengan">
						<?php 
						if(!empty($ds->lengan)){
						echo "<option value='".$ds->lengan."' selected>".$ds->lengan."</option>";
						}?>
						<option value="Lengan Pendek">Lengan Pendek</option>
						<option value="Lengan Panjang">Lengan Panjang</option>
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
				  <option value="S">S</option>
				  <option value="M">M</option>
				  <option value="L">L</option>
				  <option value="XL">XL</option>
				  <option value="XXL">XXL</option>
				  <option value="XXXL">XXXL</option>
				  <option value="other">Other</option>
				</select> </td>
                <td>
					<select class="form-control" name="lengan" id="lengan">
						<option value="Lengan Panjang">Lengan Panjang</option>
						<option value="Lengan Pendek">Lengan Pendek</option>
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
						<option value="41">41</option>
						<option value="42">42</option>
						<option value="43">43</option>
						<option value="44">44</option>
						<option value="45">45</option>
						<option value="46">46</option>
						<option value="47">47</option>
						<option value="other">Other</option>
						
					</select>
				</td>
				<td></td>
				<td>
					<?php echo "Ukuran celana :".$lalu->size_celana; ?>
				</td>
			</tr>
			
			
		<?php } 
			if(empty($ds->keterangan)){
				$keterangan = '';
			}
			else{
				$keterangan = $ds->keterangan;
			}
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
		$t =$due->tanggalmax;
		$tg = explode('-',$t);
		$tgl = $tg[2];
		$bln = $tg[1];
		$thn = $tg[0];
		
		echo date('l', strtotime(date('Y-m-d')));
		echo ", ";
		echo $tgl."-";
		echo date('M', strtotime(date('Y-m-d')));
		echo "-".$thn;
		
		
	?>
	</b></li>
</ul>
</div>
</div>
</div>
</div>