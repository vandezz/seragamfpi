<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {
    
    public function get($username){
        $this->db->where('nik', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('karyawan')->row(); // Untuk mengeksekusi dan mengambil data hasil query

        return $result;
    }
	
	public function cek($v,$thn){
		
		$result = $this->db->query("SELECT * FROM seragam WHERE idkaryawan='$v' AND periode='$thn'");
		
		return $result;
	}
	
	public function isi($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$thnow){
		$entri = $this->db->query("INSERT INTO seragam(idkaryawan,size_baju,lengan,size_celana,bahan_celana,bahan_baju,jenis_celana,jenis_baju,keterangan,idkomputer,timestamp,periode)
		VALUES('$idk','$sbaju','$lengan','$scelana','$bahancelana','$bahanbaju','$jeniscelana','$jenisbaju','$ket','$idkom',$tm,$thnow)");
		return $entri;
	}
	
	public function supdate($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm){
		$u = $this->db->query("UPDATE seragam SET size_baju='$sbaju',lengan='$lengan',size_celana='$scelana',timestamp='$tm',
			bahan_celana='$bahancelana',bahan_baju='$bahanbaju',jenis_celana='$jeniscelana',jenis_baju='$jenisbaju',keterangan='$ket',idkomputer='$idkom'
			WHERE idkaryawan='$idk'");
		return $u;
	}
	
	public function supdateW($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$prd){
		$u = $this->db->query("UPDATE seragam SET size_baju='$sbaju',lengan='$lengan',size_celana='$scelana',timestamp='$tm',
			bahan_celana='$bahancelana',bahan_baju='$bahanbaju',jenis_celana='$jeniscelana',jenis_baju='$jenisbaju',keterangan='$ket',idkomputer='$idkom'
			WHERE idkaryawan='$idk' AND periode='$prd'");
		return $u;
	}
	
	public function gww($idk,$pd){
		$this->db->where('idkaryawan',$idk);
		$this->db->where('periode',$pd);
		$rr = $this->db->get('seragam')->result();
		return $rr;
	}
	
	public function gwnow($idk,$pr){
		$this->db->where('idkaryawan',$idk);
		$this->db->where('periode',$pr);
		$rr = $this->db->get('seragam')->result();
		return $rr;
	}
	
	public function gws($tbl,$fd,$nilai){
		$this->db->where($fd,$nilai);
		$rr = $this->db->get($tbl);
		return $rr;
	}
	
	public function gwssort($tbl,$fd,$nilai){
		$this->db->where($fd,$nilai);
		$this->db->order_by('nama_karyawan','asc');
		$rr = $this->db->get($tbl);
		return $rr;
	}
	
	public function gw1($idk,$th){
		$this->db->where('idkaryawan',$idk);
		$this->db->where('periode',$th);
		$rr = $this->db->get('seragam')->row();
		return $rr;
	}
	public function showw($namatabel,$w1,$v1){
		$this->db->where($w1,$v1);
		$j = $this->db->get($namatabel)->row();
		return $j;
	}
	
	public function showw2($namatabel, $w1,$v1,$w2,$v2)
	{
		$this->db->where($w1,$v1);
		$this->db->where($w2,$v2);
		$v = $this->db->get($namatabel)->row();
		return $v;
	}
	
	public function update($idk,$data,$table)
    {
		return $this->db->query("UPDATE $table SET password='$data' WHERE id_karyawan='$idk'");
		
         //id apa yang mau di update, lalu DATA apa yang mau dikirim ke tabel di database
        //$this->db->where('id_karyawan',$idk);
        //$this->db->update($table,$data);
    }
	
	public function seragamlist($thn){
		$f=$this->db->query("SELECT a.id_karyawan as 'idk', a.nama_karyawan as 'Nama', a.kd_bagian as 'Bagian',b.size_baju as 'Sizebaju', b.lengan as 'Lengan',
				b.size_celana as 'SizeCelana', b.bahan_celana as 'BahanCelana', b.bahan_baju as 'BahanBaju', 
				b.jenis_celana as 'JenisCelana',b.jenis_baju as 'JenisBaju', b.keterangan as 'Ket', b.periode as 'periode',b.idseragam as 'idseragam'
				FROM karyawan a, seragam b
				WHERE a.id_karyawan=b.idkaryawan AND periode='$thn'");
		return $f;
	}
	
	
	public function allseragamlist(){
		$f=$this->db->query("SELECT a.id_karyawan as 'idk', a.nama_karyawan as 'Nama', a.kd_bagian as 'Bagian',
				b.size_baju as 'Sizebaju', b.lengan as 'Lengan',
				b.size_celana as 'SizeCelana', b.bahan_celana as 'BahanCelana', b.bahan_baju as 'BahanBaju', 
				b.jenis_celana as 'JenisCelana',b.jenis_baju as 'JenisBaju', b.keterangan as 'Ket', b.periode as 'periode',b.idseragam as 'idseragam'
				FROM karyawan a, seragam b
				WHERE a.id_karyawan=b.idkaryawan AND a.kondisi='AKTIF'");
		return $f;
	}
	
	public function seragampivot()
	{
		$r = $this->db->query("SELECT idkaryawan,
			IF(periode='2022') AS p2022,
			IF(periode='2023') AS p2023,
			IF(periode='2024') AS p2024
			
			FROM seragam 
			GROUP BY idkaryawan
		");
		return $r;
	}

/*	+++++++++++++++++++++++++++++++++
	SELECT  nama,
	SUM( IF( MONTH(tgl_trx) = 1, nilai_trx, 0) ) AS januari,
	SUM( IF( MONTH(tgl_trx) = 2, nilai_trx, 0) ) AS februari,
	SUM( IF( MONTH(tgl_trx) = 3, nilai_trx, 0) ) AS maret,
	SUM( nilai_trx ) AS total_trx
FROM tabel_sales
GROUP BY nama	
	+++++++++++++++++++++++++++++++++
*/
	
	public function belumisi(){
		return $this->db->query("SELECT a.nama_karyawan as 'Nama',b.periode as 'Periode' FROM karyawan a, seragam b WHERE a.id_karyawan=b.idkaryawan AND b.periode='2023' AND a.id_karyawan NOT IN (SELECT * FROM seragam WHERE periode='2022')");
	}
	
	public function updatepass($np,$idk){
		return $this->db->query("UPDATE karyawan SET password='$np' WHERE id_karyawan=$idk");
	}
	
	public function yangbelum($pd){
		return $this->db->query("SELECT nama_karyawan FROM `karyawan` 
				LEFT JOIN seragam
				ON karyawan.id_karyawan=seragam.idkaryawan
				where  seragam.idkaryawan IS NULL
				and karyawan.kondisi='AKTIF' 
				AND seragam.periode='$pd'
				ORDER BY karyawan.nama_karyawan");
	}
	
	public function yangbelum2()
	{
		$thisyear = date("Y");
		$lastyear = $thisyear - 1;
		
		return $this->db->query("SELECT seragam.idkaryawan,karyawan.nama_karyawan 
		FROM seragam INNER JOIN karyawan ON seragam.idkaryawan=karyawan.id_karyawan WHERE periode='$lastyear'
		except (select seragam.idkaryawan,karyawan.nama_karyawan from seragam INNER JOIN karyawan ON seragam.idkaryawan=karyawan.id_karyawan where periode='$thisyear')");
		
	}
	public function showlike($tb,$f1,$v1,$f2,$v2){
		return $this->db->query("SELECT * FROM $tb WHERE $f1 LIKE '%$v1%' AND $f2='$v2'");
	}
	
	public function showall($tbl){
		return $this->db->query("SELECT * FROM $tbl");
	}

	public function updateparam($t)
	{
		$this->db->query("UPDATE seragam_param SET tanggalmax='$t'");
	}
	
	public function sejarahseragam($idk)
	{
		return $this->db->query("SELECT * FROM seragam where idkaryawan=$idk");
	}
	
	public function updateseragam($ids,$sbaju,$scelana,$ket){
		$u = $this->db->query("UPDATE seragam SET size_baju='$sbaju',size_celana='$scelana', keterangan='$ket'	WHERE idseragam='$ids'");
		return $u;
	}
	
	public function disting($tbl,$f){
		return $h = $this->db->query("SELECT DISTINCT $f FROM $tbl");
	}
	
	
	
}