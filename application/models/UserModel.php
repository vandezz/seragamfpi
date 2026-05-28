<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {
    
    public function get($username){
        $this->db->where('nik', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('karyawan')->row(); // Untuk mengeksekusi dan mengambil data hasil query

        return $result;
    }
	
	public function cek($v,$thn){
		$this->db->where('idkaryawan', $v);
		$this->db->where('periode', $thn);
		$result = $this->db->get('seragam');
		return $result;
	}
	
	public function isi($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$thnow){
		$data = array(
			'idkaryawan'   => $idk,
			'size_baju'    => $sbaju,
			'lengan'       => $lengan,
			'size_celana'  => $scelana,
			'bahan_celana' => $bahancelana,
			'bahan_baju'   => $bahanbaju,
			'jenis_celana' => $jeniscelana,
			'jenis_baju'   => $jenisbaju,
			'keterangan'   => $ket,
			'idkomputer'   => $idkom,
			'timestamp'    => $tm,
			'periode'      => $thnow,
		);
		$entri = $this->db->insert('seragam', $data);
		return $entri;
	}
	
	public function supdate($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm){
		$data = array(
			'size_baju'    => $sbaju,
			'lengan'       => $lengan,
			'size_celana'  => $scelana,
			'timestamp'    => $tm,
			'bahan_celana' => $bahancelana,
			'bahan_baju'   => $bahanbaju,
			'jenis_celana' => $jeniscelana,
			'jenis_baju'   => $jenisbaju,
			'keterangan'   => $ket,
			'idkomputer'   => $idkom,
		);
		$this->db->where('idkaryawan', $idk);
		$u = $this->db->update('seragam', $data);
		return $u;
	}
	
	public function supdateW($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$prd){
		$data = array(
			'size_baju'    => $sbaju,
			'lengan'       => $lengan,
			'size_celana'  => $scelana,
			'timestamp'    => $tm,
			'bahan_celana' => $bahancelana,
			'bahan_baju'   => $bahanbaju,
			'jenis_celana' => $jeniscelana,
			'jenis_baju'   => $jenisbaju,
			'keterangan'   => $ket,
			'idkomputer'   => $idkom,
		);
		$this->db->where('idkaryawan', $idk);
		$this->db->where('periode', $prd);
		$u = $this->db->update('seragam', $data);
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
		$this->db->where('id_karyawan', $idk);
		return $this->db->update($table, array('password' => $data));
    }
	
	public function seragamlist($thn){
		$f = $this->db->query(
			"SELECT a.id_karyawan as 'idk', a.nama_karyawan as 'Nama', a.kd_bagian as 'Bagian',
				b.size_baju as 'Sizebaju', b.lengan as 'Lengan',
				b.size_celana as 'SizeCelana', b.bahan_celana as 'BahanCelana', b.bahan_baju as 'BahanBaju',
				b.jenis_celana as 'JenisCelana', b.jenis_baju as 'JenisBaju', b.keterangan as 'Ket',
				b.periode as 'periode', b.idseragam as 'idseragam'
			FROM karyawan a, seragam b
			WHERE a.id_karyawan = b.idkaryawan AND b.periode = ?",
			array($thn)
		);
		return $f;
	}

	public function seragamlistCount($thn){
		$this->db->from('karyawan a');
		$this->db->join('seragam b', 'a.id_karyawan = b.idkaryawan');
		$this->db->where('b.periode', $thn);
		return $this->db->count_all_results();
	}

	public function seragamlistPaged($thn, $limit, $offset){
		return $this->db->query(
			"SELECT a.id_karyawan as 'idk', a.nama_karyawan as 'Nama', a.kd_bagian as 'Bagian',
				b.size_baju as 'Sizebaju', b.lengan as 'Lengan',
				b.size_celana as 'SizeCelana', b.bahan_celana as 'BahanCelana', b.bahan_baju as 'BahanBaju',
				b.jenis_celana as 'JenisCelana', b.jenis_baju as 'JenisBaju', b.keterangan as 'Ket',
				b.periode as 'periode', b.idseragam as 'idseragam'
			FROM karyawan a, seragam b
			WHERE a.id_karyawan = b.idkaryawan AND b.periode = ?
			ORDER BY a.nama_karyawan ASC
			LIMIT ? OFFSET ?",
			array($thn, $limit, $offset)
		);
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
		$this->db->where('id_karyawan', $idk);
		return $this->db->update('karyawan', array('password' => $np));
	}
	
	public function yangbelum($pd){
		return $this->db->query(
			"SELECT nama_karyawan FROM karyawan
			LEFT JOIN seragam ON karyawan.id_karyawan = seragam.idkaryawan
			WHERE seragam.idkaryawan IS NULL
			AND karyawan.kondisi = 'AKTIF'
			AND seragam.periode = ?
			ORDER BY karyawan.nama_karyawan",
			array($pd)
		);
	}
	
	public function yangbelum2()
	{
		$thisyear = (int) date('Y');
		$lastyear = $thisyear - 1;
		return $this->db->query(
			"SELECT seragam.idkaryawan, karyawan.nama_karyawan
			FROM seragam INNER JOIN karyawan ON seragam.idkaryawan = karyawan.id_karyawan
			WHERE periode = ?
			EXCEPT (
				SELECT seragam.idkaryawan, karyawan.nama_karyawan
				FROM seragam INNER JOIN karyawan ON seragam.idkaryawan = karyawan.id_karyawan
				WHERE periode = ?
			)",
			array($lastyear, $thisyear)
		);
	}
	public function showlike($tb,$f1,$v1,$f2,$v2){
		$this->db->like($f1, $v1);
		$this->db->where($f2, $v2);
		return $this->db->get($tb);
	}
	
	public function showall($tbl){
		return $this->db->get($tbl);
	}

	public function updateparam($t)
	{
		$this->db->update('seragam_param', array('tanggalmax' => $t));
	}
	
	public function sejarahseragam($idk)
	{
		$this->db->where('idkaryawan', $idk);
		return $this->db->get('seragam');
	}
	
	public function updateseragam($ids,$sbaju,$scelana,$ket){
		$data = array(
			'size_baju'   => $sbaju,
			'size_celana' => $scelana,
			'keterangan'  => $ket,
		);
		$this->db->where('idseragam', $ids);
		$u = $this->db->update('seragam', $data);
		return $u;
	}
	
	public function disting($tbl,$f){
		$this->db->distinct();
		$this->db->select($f);
		return $this->db->get($tbl);
	}

	public function rekapBaju($thn){
		return $this->db->query(
			"SELECT size_baju as ukuran, COUNT(*) as jumlah
			FROM seragam WHERE periode = ?
			GROUP BY size_baju ORDER BY jumlah DESC",
			array($thn)
		);
	}

	public function rekapCelana($thn){
		return $this->db->query(
			"SELECT size_celana as ukuran, COUNT(*) as jumlah
			FROM seragam WHERE periode = ?
			GROUP BY size_celana ORDER BY jumlah DESC",
			array($thn)
		);
	}

	public function belumIsiTahun($thn){
		return $this->db->query(
			"SELECT k.nama_karyawan, k.kd_bagian
			FROM karyawan k
			WHERE k.kondisi = 'AKTIF'
			AND k.id_karyawan NOT IN (SELECT idkaryawan FROM seragam WHERE periode = ?)
			ORDER BY k.nama_karyawan",
			array($thn)
		);
	}

	public function belumIsiTahunCount($thn){
		return $this->db->query(
			"SELECT COUNT(*) as total FROM karyawan k
			WHERE k.kondisi = 'AKTIF'
			AND k.id_karyawan NOT IN (SELECT idkaryawan FROM seragam WHERE periode = ?)",
			array($thn)
		)->row()->total;
	}

	public function belumIsiTahunPaged($thn, $limit, $offset){
		return $this->db->query(
			"SELECT k.nama_karyawan, k.kd_bagian
			FROM karyawan k
			WHERE k.kondisi = 'AKTIF'
			AND k.id_karyawan NOT IN (SELECT idkaryawan FROM seragam WHERE periode = ?)
			ORDER BY k.nama_karyawan
			LIMIT ? OFFSET ?",
			array($thn, $limit, $offset)
		);
	}

	// ── Manajemen Karyawan ─────────────────────────────────────────

	public function karyawanBagian() {
		return $this->db->select('kd_bagian')->distinct()->order_by('kd_bagian ASC')->get('karyawan')->result();
	}

	public function karyawanCount($keyword = '', $kondisi = 'semua', $jk = '', $bagian = '', $tipe = '') {
		if($kondisi !== 'semua') $this->db->where('TRIM(kondisi)', strtoupper($kondisi));
		if($keyword  !== '')     $this->db->like('nama_karyawan', $keyword);
		if($jk       !== '')     $this->db->where('jns_kelamin', $jk);
		if($bagian   !== '')     $this->db->where('kd_bagian', $bagian);
		if($tipe     !== '')     $this->db->where('seragam_office', $tipe);
		$this->db->from('karyawan');
		return $this->db->count_all_results();
	}

	public function karyawanPaged($limit, $offset, $keyword = '', $kondisi = 'semua', $jk = '', $bagian = '', $tipe = '') {
		if($kondisi !== 'semua') $this->db->where('TRIM(kondisi)', strtoupper($kondisi));
		if($keyword  !== '')     $this->db->like('nama_karyawan', $keyword);
		if($jk       !== '')     $this->db->where('jns_kelamin', $jk);
		if($bagian   !== '')     $this->db->where('kd_bagian', $bagian);
		if($tipe     !== '')     $this->db->where('seragam_office', $tipe);
		$this->db->order_by('FIELD(TRIM(kondisi),"AKTIF","NONAKTIF"), nama_karyawan ASC');
		$this->db->limit($limit, $offset);
		return $this->db->get('karyawan');
	}

	public function tambahKaryawan($data) {
		return $this->db->insert('karyawan', $data);
	}

	public function editKaryawan($id, $data) {
		$this->db->where('id_karyawan', $id);
		return $this->db->update('karyawan', $data);
	}

	public function toggleKondisi($id) {
		$row = $this->db->select('kondisi')->where('id_karyawan', $id)->get('karyawan')->row();
		$new = (trim(strtoupper($row->kondisi)) === 'AKTIF') ? 'NONAKTIF' : 'AKTIF';
		$this->db->where('id_karyawan', $id);
		return $this->db->update('karyawan', array('kondisi' => $new));
	}

	// ── Chat ─────────────────────────────────────────────────────────

	public function chatKirim($id_karyawan, $pengirim_role, $nama_pengirim, $pesan) {
		return $this->db->insert('seragam_chat', array(
			'id_karyawan'    => (int)$id_karyawan,
			'pengirim_role'  => (int)$pengirim_role,
			'nama_pengirim'  => $nama_pengirim,
			'pesan'          => $pesan,
			'created_at'     => date('Y-m-d H:i:s'),
		));
	}

	public function chatAmbil($id_karyawan, $after_id = 0) {
		$this->db->where('id_karyawan', (int)$id_karyawan);
		if($after_id > 0) $this->db->where('id >', (int)$after_id);
		$this->db->order_by('id', 'ASC');
		return $this->db->get('seragam_chat')->result();
	}

	public function chatBacaAdmin($id_karyawan) {
		$this->db->where('id_karyawan', (int)$id_karyawan);
		$this->db->where('pengirim_role', 0);
		return $this->db->update('seragam_chat', array('is_read' => 1));
	}

	public function chatBacaUser($id_karyawan) {
		$this->db->where('id_karyawan', (int)$id_karyawan);
		$this->db->where('pengirim_role', 1);
		return $this->db->update('seragam_chat', array('is_read' => 1));
	}

	public function chatThreadList() {
		return $this->db->query(
			"SELECT k.id_karyawan, k.nama_karyawan, k.kd_bagian,
				(SELECT pesan FROM seragam_chat WHERE id_karyawan = k.id_karyawan ORDER BY id DESC LIMIT 1) AS pesan_terakhir,
				(SELECT created_at FROM seragam_chat WHERE id_karyawan = k.id_karyawan ORDER BY id DESC LIMIT 1) AS waktu_terakhir,
				(SELECT COUNT(*) FROM seragam_chat WHERE id_karyawan = k.id_karyawan AND pengirim_role = 0 AND is_read = 0) AS belum_dibaca
			FROM karyawan k
			WHERE EXISTS (SELECT 1 FROM seragam_chat sc WHERE sc.id_karyawan = k.id_karyawan)
			ORDER BY waktu_terakhir DESC"
		)->result();
	}

	public function chatLastId($id_karyawan) {
		$r = $this->db->select_max('id')->where('id_karyawan', (int)$id_karyawan)->get('seragam_chat')->row();
		return $r ? (int)$r->id : 0;
	}

	public function chatUnreadTotal() {
		// Semua pesan dari karyawan (role=0) yang belum dibaca admin
		$r = $this->db->where('pengirim_role', 0)->where('is_read', 0)->get('seragam_chat')->num_rows();
		return (int)$r;
	}

}