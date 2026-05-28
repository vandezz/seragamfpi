<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {
	public function __construct(){
    parent::__construct();

    $this->load->model('UserModel');
  }

  public function home(){
    // function render_backend tersebut dari file core/MY_Controller.php
	$yr = date('Y');
	$idk = $this->session->userdata('idkaryawan');
	$data['idkar'] =$this->session->userdata('idkaryawan');
	$data['dt']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr);
	$data['dtk']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr-1);
	$data['sejarah'] = $this->UserModel->sejarahseragam($idk);
	//$data['sejarah'] = $this->UserModel->showall('seragam');
    $this->render_backend('home',$data); // load view home.php
  }

  public function berita(){
    // function render_backend tersebut dari file core/MY_Controller.php
	$idk = $this->session->userdata('idkaryawan');
	$th = $this->session->userdata('periodenow');
	$data['tglmx'] = $this->UserModel->showall('seragam_param');
	$ca = $this->UserModel->cek($idk,$th);
	
	if($ca->num_rows()>0){
		$data['ds'] = $this->UserModel->gw1($idk,$this->session->userdata('periodenow'));
		$data['lalu']=$this->UserModel->gw1($idk,$this->session->userdata('periodenow')-1);
		$this->render_backend('berita',$data); // load view berita.php
		
	}
	else{
		$data['lalu']=$this->UserModel->gw1($idk,$this->session->userdata('periodenow')-1);
		$this->render_backend('berita',$data); // load view berita.php
		
	}
	
	
    
  }

  public function pengguna(){
    if($this->session->userdata('role') != '1') show_404();

    $this->load->library('pagination');

    $thn      = $this->input->get('periode') ?: date('Y');
    $per_page = 15;
    $page     = max(1, (int)($this->input->get('page') ?: 1));
    $offset   = ($page - 1) * $per_page;
    $total    = $this->UserModel->seragamlistCount($thn);

    $config['base_url']             = base_url('index.php/page/pengguna');
    $config['total_rows']           = $total;
    $config['per_page']             = $per_page;
    $config['use_page_numbers']     = TRUE;
    $config['page_query_string']    = TRUE;
    $config['query_string_segment'] = 'page';
    $config['reuse_query_string']   = TRUE;
    $config['full_tag_open']        = '<ul class="pagination pagination-sm mb-0">';
    $config['full_tag_close']       = '</ul>';
    $config['attributes']           = array('class' => 'page-link');
    $config['num_tag_open']         = '<li class="page-item">';
    $config['num_tag_close']        = '</li>';
    $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']        = '</span></li>';
    $config['prev_link']            = '&laquo;';
    $config['next_link']            = '&raquo;';
    $config['prev_tag_open']        = '<li class="page-item">';
    $config['prev_tag_close']       = '</li>';
    $config['next_tag_open']        = '<li class="page-item">';
    $config['next_tag_close']       = '</li>';
    $config['first_link']           = FALSE;
    $config['last_link']            = FALSE;
    $this->pagination->initialize($config);

    $data['g']             = $this->UserModel->seragamlistPaged($thn, $per_page, $offset);
    $data['c']             = $total;
    $data['thn']           = $thn;
    $data['offset']        = $offset;
    $data['per_page']      = $per_page;
    $data['total_seragam'] = $total;
    $data['paginasi']      = $this->pagination->create_links();
    $data['k']             = $this->UserModel->gwssort('karyawan','KONDISI','aktif','nama_karyawan');
    $data['total_k']       = $data['k']->num_rows();
    $data['p']             = $this->UserModel->disting('seragam','periode');

    $this->render_backend('admin', $data);
  }

  public function showseragamperiode(){
    $thn = $this->input->post('periode');
    redirect('page/pengguna?periode=' . urlencode($thn));
  }
  
  public function compareseragam()
  {
	  if($this->session->userdata('role') != '1') show_404();
	  $data['periode'] = $this->UserModel->disting('seragam','periode');
	  $data['dt'] = $this->UserModel->allseragamlist();
	  
	  $this->render_backend('compareseragam',$data); 
  }
  

  public function kontak(){
    // function render_backend tersebut dari file core/MY_Controller.php
	$idk = $this->session->userdata('idkaryawan');
	$data['k']=$this->UserModel->showw('karyawan','id_karyawan',$idk);
    $this->render_backend('kontak',$data); // load view kontak.php
  }
  
 public function ukuran(){
	 //function untuk input ukuran seragam
	 $idk = $this->session->userdata('idkaryawan');
	 $sbaju   = $this->input->post('sizebaju');
	 $scelana = $this->input->post('sizecelana');
	 $lengan  = $this->input->post('lengan');
	 $ket	  = $this->input->post('keterangan');
	 $bahancelana = 'Taipan';
	 $jenisbaju='Baju Pria';
	 $bahanbaju="Taipan";
	 $thnow = $this->session->userdata('periodenow');
	 $idkom = $_SERVER['HTTP_USER_AGENT']." di IP :".$_SERVER['REMOTE_ADDR'];
	 
		
	 	if(($this->session->userdata("jk")=="Laki-laki") and ($this->session->userdata('office')=='F')){
			//echo  "Laki-laki Produksi";
			$jeniscelana = "Celana Pria Taipan";
			$bahancelana = 'Taipan';
			
		}
		
		else if(($this->session->userdata("jk")=="Laki-laki") and ($this->session->userdata('office')=='O')){
			//echo "Laki-laki bahan Celana Katun";
			$bahancelana = 'Executive';
			$jeniscelana = "Celana Pria Executive";
		}
		
		else if(($this->session->userdata("jk")=="Perempuan") and ($this->session->userdata('office')=='F')){
			//echo "Perempuan Produksi";
			$jeniscelana = "Celana Wanita Taipan";
			$jenisbaju = "Baju Wanita Taipan";
			
		}
		
		else if(($this->session->userdata("jk")=="Perempuan") and ($this->session->userdata('office')=='O')){
			//echo "Perempuan Office";
			$bahancelana = 'Executive';
			$jeniscelana = "Celana Wanita Executive";
			$bahanbaju = "Executive";
			$jenisbaju = "Baju Wanita Executive";
		}
		
		else if(($this->session->userdata("jk")=="Laki-laki") and ($this->session->userdata('office')=='W')){
			//echo "Wearpak";
			$bahancelana = 'American Drill';
			$bahanbaju = "American Drill";
			$jeniscelana = "Wearpak";
			$jenisbaju = "Wearpak";
		}
		
		
	date_default_timezone_set('Asia/Jakarta');
	$tm = $date = date('Y-m-d');	
	$c = $this->UserModel->cek($idk,$thnow);	
	if ($c->num_rows() > 0){ //Jika sudah pernah ngisi
		// update data terbaru
			
			//maksimal isi tgl 9 Agt 2022
			 
			$this->UserModel->supdateW($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$thnow); 
		
	 }
	 else
	 {	
		// input data 
		$this->UserModel->isi($idk,$sbaju,$lengan,$scelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$thnow);
	 }
			
		$thnow=date('Y');
		$idk = $this->session->userdata('idkaryawan');
		$data['sejarah'] = $this->UserModel->sejarahseragam($idk);
		$data['dt']=$this->UserModel->gwnow($idk,$thnow);
		$data['dtk']=$this->UserModel->gwnow($idk,$thnow-1);
		$this->render_backend('home',$data); // load view home.php
		
	
	
 }
 
 public function editukuran(){
	 $idser = $this->uri->segment(3);
	 $nama = $this->uri->segment(4);
	 $data['idseragam'] = $idser;
	 $data['dser'] = $this->UserModel->gws('seragam','idseragam',$idser)->row();
	 $d = $this->UserModel->gws('seragam','idseragam',$idser)->row();
	 $idkar = $d->idkaryawan;;
		
	 $data['kary'] = $this->UserModel->gws('karyawan_s','id_karyawan',$idkar)->row();
	 //$data['tag']="form";
	 $this->render_backend('editseragam',$data); 
		
 }
 
 public function editseragamx()
 {
	 $idseragam = $this->input->post('idseragam');
	 $sbaju 	= $this->input->post('sbaju');
	 $lengan	= $this->input->post('lengan');
	 $size_celana	= $this->input->post('scelana');
	 $ket		= $this->input->post('tket');
	 
	 $this->UserModel->updateseragam($idseragam,$sbaju,$size_celana,$ket);
	 
	 $this->pengguna();
		 
	 
 }
 
 public function gantipassword(){
	 $uname = $this->session->userdata['idkaryawan'];
	  $this->render_backend('vgantipass'); 
 }
 
 public function gantipasswordx()
 {
	 
        $idk = $this->session->userdata['idkaryawan'];
		
		$pm = $this->UserModel->gws('karyawan','id_karyawan',$idk)->row('password');
		$this->form_validation->set_rules('pw_lama','password lama','required|matches[]');
        $this->form_validation->set_rules('pw_baru','password baru','required');
        $this->form_validation->set_rules('cpw_baru','password kedua','required|matches[pw_baru]');

        $this->form_validation->set_message('required','%s wajib diisi');

        $this->form_validation->set_error_delimiters('<p class="alert">','</p>');
		
		$np = md5($this->input->post('pw_baru'));

        if( $this->form_validation->run() == FALSE ){
           // $this->load->view('vgantipass');
			/* $this->render_backend('vgantipass'); 
            $post = $this->input->post();
            
            $data = array(
                'password' => md5($post['pw_baru']),
            );

            $this->UserModel->updatepass($idk, $data['password'],'karyawan');
			*/
			$this->UserModel->updatepass($np,$idk);
			// $this->render_backend('home');
			
			$yr = date('Y');
			$data['dt']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr);
			$data['dtk']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr-1);
			$this->render_backend('home',$data); // load view home.php
        }
		
 }
 
 public function resetpassword()
 {
	 $idkar = $this->input->post('skr');
	 $passbaru = md5($this->input->post('npass'));
	 $this->UserModel->updatepass($passbaru, $idkar);
	 
	 $this->pengguna();
 }
 
 public function showall(){
	 $pd = $this->session->userdata('periodenow');
	 $data['g']= $this->UserModel->seragamlist($pd);
	 $this->render_backend('pengguna',$data);
	 
 }
 
 public function ukuran2(){
	 $idk = $this->session->userdata('idkaryawan');
	  $c = $this->UserModel->cek($idk);
	 if($c->num_rows()>0){
		 echo "sudah ada isi";
	 }
	 else{
		 echo "belum";
	 }
		 
 }
 
 public function laporan()
 {
	 if($this->session->userdata('role') != '1') show_404();

	 $this->load->library('pagination');

	 $thn      = $this->input->get('periode') ?: date('Y');
	 $per_page = 15;
	 $page     = max(1, (int)($this->input->get('page') ?: 1));
	 $offset   = ($page - 1) * $per_page;
	 $belum_total = $this->UserModel->belumIsiTahunCount($thn);

	 $config['base_url']             = base_url('index.php/page/laporan');
	 $config['total_rows']           = $belum_total;
	 $config['per_page']             = $per_page;
	 $config['use_page_numbers']     = TRUE;
	 $config['page_query_string']    = TRUE;
	 $config['query_string_segment'] = 'page';
	 $config['reuse_query_string']   = TRUE;
	 $config['full_tag_open']        = '<ul class="pagination pagination-sm mb-0">';
	 $config['full_tag_close']       = '</ul>';
	 $config['attributes']           = array('class' => 'page-link');
	 $config['num_tag_open']         = '<li class="page-item">';
	 $config['num_tag_close']        = '</li>';
	 $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
	 $config['cur_tag_close']        = '</span></li>';
	 $config['prev_link']            = '&laquo;';
	 $config['next_link']            = '&raquo;';
	 $config['prev_tag_open']        = '<li class="page-item">';
	 $config['prev_tag_close']       = '</li>';
	 $config['next_tag_open']        = '<li class="page-item">';
	 $config['next_tag_close']       = '</li>';
	 $config['first_link']           = FALSE;
	 $config['last_link']            = FALSE;
	 $this->pagination->initialize($config);

	 $data['thn']            = $thn;
	 $data['periode_list']   = $this->UserModel->disting('seragam','periode');
	 $data['total_k']        = $this->UserModel->gws('karyawan','kondisi','AKTIF')->num_rows();
	 $data['sudah']          = $this->UserModel->seragamlist($thn)->num_rows();
	 $data['rekap_baju']     = $this->UserModel->rekapBaju($thn);
	 $data['rekap_celana']   = $this->UserModel->rekapCelana($thn);
	 $data['belum_list']     = $this->UserModel->belumIsiTahunPaged($thn, $per_page, $offset);
	 $data['belum_total']    = $belum_total;
	 $data['belum_offset']   = $offset;
	 $data['per_page']       = $per_page;
	 $data['paginasi_belum'] = $this->pagination->create_links();
	 $data['pageScripts']    = '<script src="'.base_url('js/Chart.min.js').'"></script>';
	 $this->render_backend('laporan', $data);
 }

 public function exportExcel()
 {
     if($this->session->userdata('role') != '1') show_404();

     $thn = $this->input->get('periode') ?: date('Y');

     $rekap_baju   = $this->UserModel->rekapBaju($thn)->result();
     $rekap_celana = $this->UserModel->rekapCelana($thn)->result();
     $belum_list   = $this->UserModel->belumIsiTahun($thn)->result();
     $sudah        = $this->UserModel->seragamlist($thn)->num_rows();

     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
     $spreadsheet->getProperties()
         ->setTitle('Laporan Seragam ' . $thn)
         ->setCreator('SeragamFPI');

     // ── Sheet 1: Rekap Ukuran Baju ──────────────────────────────
     $sheet1 = $spreadsheet->getActiveSheet()->setTitle('Rekap Baju');
     $sheet1->fromArray(['Ukuran Baju', 'Jumlah', 'Persentase (%)'], NULL, 'A1');
     $sheet1->getStyle('A1:C1')->getFont()->setBold(true);
     $row = 2;
     foreach ($rekap_baju as $r) {
         $pct = ($sudah > 0) ? round($r->jumlah / $sudah * 100, 1) : 0;
         $sheet1->fromArray([$r->ukuran, (int)$r->jumlah, $pct], NULL, 'A' . $row++);
     }
     $sheet1->fromArray(['Total', $sudah, 100], NULL, 'A' . $row);
     $sheet1->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true);

     // ── Sheet 2: Rekap Ukuran Celana ────────────────────────────
     $sheet2 = $spreadsheet->createSheet()->setTitle('Rekap Celana');
     $sheet2->fromArray(['Ukuran Celana', 'Jumlah', 'Persentase (%)'], NULL, 'A1');
     $sheet2->getStyle('A1:C1')->getFont()->setBold(true);
     $row = 2;
     foreach ($rekap_celana as $r) {
         $pct = ($sudah > 0) ? round($r->jumlah / $sudah * 100, 1) : 0;
         $sheet2->fromArray([$r->ukuran, (int)$r->jumlah, $pct], NULL, 'A' . $row++);
     }
     $sheet2->fromArray(['Total', $sudah, 100], NULL, 'A' . $row);
     $sheet2->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true);

     // ── Sheet 3: Belum Mengisi ───────────────────────────────────
     $sheet3 = $spreadsheet->createSheet()->setTitle('Belum Mengisi');
     $sheet3->fromArray(['No', 'Nama Karyawan', 'Bagian'], NULL, 'A1');
     $sheet3->getStyle('A1:C1')->getFont()->setBold(true);
     $no = 1;
     foreach ($belum_list as $b) {
         $sheet3->fromArray([$no++, $b->nama_karyawan, $b->kd_bagian], NULL, 'A' . $no);
     }

     // Auto-size columns for all sheets
     foreach ($spreadsheet->getAllSheets() as $sheet) {
         foreach (range('A', 'C') as $col) {
             $sheet->getColumnDimension($col)->setAutoSize(true);
         }
     }

     $spreadsheet->setActiveSheetIndex(0);

     $filename = 'Laporan-Seragam-' . $thn . '.xlsx';
     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     header('Content-Disposition: attachment; filename="' . $filename . '"');
     header('Cache-Control: max-age=0');

     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
     $writer->save('php://output');
     exit;
 }

 public function unduh()
 {
	// echo "aneh";
	 $pd = $this->session->userdata('periodenow');
	 $thn = date('Y');
	 header("Content-type: application/vnd-ms-excel");
     header("Content-Disposition: attachment; filename=Angket-Seragam-".$thn.".xls");
	 $data['tahun'] = $thn;
	 $data['xls'] = $this->UserModel->seragamlist($thn);
	 $this->load->view('unduh',$data);
 }
 
 public function yangbelum()
 {
	 $pd = $this->session->userdata('periodenow');
	 $data['blm'] = $this->UserModel->yangbelum2();
	 $this->render_backend('belum',$data);
	 
 }
 
 public function ckar(){
	 if($this->session->userdata('role') == '1'){
		 $data['tag']=1;
		 $data['dk'] = $this->UserModel->gwssort('karyawan_s','is_active','1');
		 $data['dkr'] = NULL;
		 $data['pageScripts'] = $this->_autocomplete_scripts();
		 $this->render_backend('fkar',$data);
	 }
	 else{ $this->home(); }
 }
 
 public function ckarx(){
	 if($this->session->userdata('role') == '1'){
		 // Support both POST (form) and GET (button fallback)
		 $n = $this->input->post('tkar') ?: $this->input->get('tkar');
		 $data['tag']=2;
		 $data['dk'] = $this->UserModel->gwssort('karyawan_s','is_active','1');
		 $data['dkr']=$this->UserModel->showlike('karyawan_s','nama_karyawan',$n,'is_active','1');
		 $data['pageScripts'] = $this->_autocomplete_scripts();
		 $this->render_backend('fkar',$data);
	 }
	 else{ $this->home(); }
 }

 private function _autocomplete_scripts(){
	 return '<script src="'.base_url('js/jquery-ui.min.js').'"></script>
<script>
(function(){
  $("#tkar").autocomplete({
    source: window._employees || [],
    minLength: 1,
    delay: 0,
    select: function(event, ui){
      window.location = window._ckarBase + ui.item.id;
      return false;
    }
  });
  $("#btnCari").on("click", function(){
    var q = $("#tkar").val().trim();
    if(q) window.location = window._ckarxUrl + "?tkar=" + encodeURIComponent(q);
  });
  $("#tkar").on("keydown", function(e){
    if(e.key === "Enter"){
      var q = $(this).val().trim();
      if(q) window.location = window._ckarxUrl + "?tkar=" + encodeURIComponent(q);
    }
  });
})();
</script>';
 }

 public function ckary(){
	 if($this->session->userdata('role') == '1'){ // Jika role-nya admin
		 $idky = $this->uri->segment(3);
		 $data['d']=$this->UserModel->showw('karyawan_s','id_karyawan',$idky);
		 $this->render_backend('detailkary',$data);
	 }
	 else{ $this->home(); }
 }
 
 
 public function editkary()
 {
	 $idk = $this->uri->segment(3);
	 $data['m'] = $this->UserModel->showw('karyawan_s','id_karyawan',$idk);
	 $this->render_backend('editkaryawan',$data);
	 
 }
 public function rubahtanggalmax()
 {
	 $data['tglm'] = $this->UserModel->showall('seragam_param');
	 $data['pageStyles']  = '<link rel="stylesheet" href="'.base_url('css/tempusdominus-bootstrap-4.min.css').'">';
	 $data['pageScripts'] = '<script src="'.base_url('js/moment.min.js').'"></script>
<script src="'.base_url('js/tempusdominus-bootstrap-4.min.js').'"></script>
<script>
$(function(){
  $("#datepicker").datetimepicker({
    format: "YYYY-MM-DD",
    locale: "id",
    useCurrent: false,
    icons: {
      time: "fas fa-clock",
      date: "fas fa-calendar",
      up: "fas fa-arrow-up",
      down: "fas fa-arrow-down",
      previous: "fas fa-chevron-left",
      next: "fas fa-chevron-right",
      today: "fas fa-calendar-check",
      clear: "fas fa-trash",
      close: "fas fa-times"
    }
  });
});
</script>';
	 $this->render_backend('parameter',$data);
 }
 
 public function xtanggalmax()
 {
	$newtgl = $this->input->post('tglmax');
	$this->UserModel->updateparam($newtgl);
	
	$this->pengguna();
 }
 
	public function copyukuran(){
		$idkr = $this->uri->segment(3);
		$thnlalu = date('Y')-1;
		$m = $this->UserModel->cek($idkr,$thnlalu)->row();
		
		$sizebaju 	= $m->size_baju;
		$lengan		= $m->lengan;
		$sizecelana	= $m->size_celana;
		$bahancelana = $m->bahan_celana;
		$bahanbaju	= $m->bahan_baju;
		$jeniscelana = $m->jenis_celana;
		$jenisbaju	= $m->jenis_baju;
		$ket		= 'manual by admin';
		
		$tm = $date = date('Y-m-d');
		$thnnow = date('Y');
		$idkom = $_SERVER['HTTP_USER_AGENT']." di IP :".$_SERVER['REMOTE_ADDR'];

		/* $inst = array (
			'size_baju'		=> $sizebaju,
			'lengan'		=> $lengan,
			'size_celana'	=> $sizecelana,
			'bahan_celana'	=> $bahancelana,
			'bahan_baju'	=> $bahanbaju,
			'jenis_celana'	=> $jeniscelana,
			'jenis_baju'	=> $jenisbaju,
			'keterangan'	=> $ket
			);
		*/
		
		$this->UserModel->isi($idkr,$sizebaju,$lengan,$sizecelana,$bahancelana,$bahanbaju,$jeniscelana,$jenisbaju,$ket,$idkom,$tm,$thnnow);
		                     
		$this->yangbelum();
		
		
	
	}

	// ── Manajemen Karyawan ─────────────────────────────────────────

	private function _paginationConfig($base_url, $total, $per_page) {
		return array(
			'base_url'             => $base_url,
			'total_rows'           => $total,
			'per_page'             => $per_page,
			'use_page_numbers'     => TRUE,
			'page_query_string'    => TRUE,
			'query_string_segment' => 'page',
			'reuse_query_string'   => TRUE,
			'full_tag_open'        => '<ul class="pagination pagination-sm mb-0">',
			'full_tag_close'       => '</ul>',
			'attributes'           => array('class' => 'page-link'),
			'num_tag_open'         => '<li class="page-item">',
			'num_tag_close'        => '</li>',
			'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close'        => '</span></li>',
			'prev_link'            => '&laquo;',
			'next_link'            => '&raquo;',
			'prev_tag_open'        => '<li class="page-item">',
			'prev_tag_close'       => '</li>',
			'next_tag_open'        => '<li class="page-item">',
			'next_tag_close'       => '</li>',
			'first_link'           => FALSE,
			'last_link'            => FALSE,
		);
	}

	public function mKaryawan() {
		if($this->session->userdata('role') != '1') show_404();
		$this->load->library('pagination');

		$keyword  = $this->input->get('search')  ?: '';
		$kondisi  = $this->input->get('kondisi') ?: 'AKTIF';
		$jk       = $this->input->get('jk')      ?: '';
		$bagian   = $this->input->get('bagian')  ?: '';
		$tipe     = $this->input->get('tipe')    ?: '';
		$per_page = 20;
		$page     = max(1, (int)($this->input->get('page') ?: 1));
		$offset   = ($page - 1) * $per_page;
		$total    = $this->UserModel->karyawanCount($keyword, $kondisi, $jk, $bagian, $tipe);

		$this->pagination->initialize(
			$this->_paginationConfig(base_url('page/mKaryawan'), $total, $per_page)
		);

		$data['list']      = $this->UserModel->karyawanPaged($per_page, $offset, $keyword, $kondisi, $jk, $bagian, $tipe);
		$data['total']     = $total;
		$data['aktif']     = $this->UserModel->karyawanCount('', 'AKTIF');
		$data['nonaktif']  = $this->UserModel->karyawanCount('', 'NONAKTIF');
		$data['keyword']   = $keyword;
		$data['kondisi']   = $kondisi;
		$data['jk']        = $jk;
		$data['bagian']    = $bagian;
		$data['tipe']      = $tipe;
		$data['bagian_list'] = $this->UserModel->karyawanBagian();
		$data['offset']    = $offset;
		$data['per_page']  = $per_page;
		$data['paginasi']  = $this->pagination->create_links();
		$this->render_backend('karyawan_list', $data);
	}

	public function mkTambah() {
		if($this->session->userdata('role') != '1') show_404();
		$data['mode'] = 'tambah';
		$data['k']    = null;
		$this->render_backend('karyawan_form', $data);
	}

	public function mkSimpan() {
		if($this->session->userdata('role') != '1') show_404();

		$nik  = trim($this->input->post('nik'));
		$pass = trim($this->input->post('password'));

		// NIK uniqueness check
		if($this->UserModel->gws('karyawan', 'nik', $nik)->num_rows() > 0) {
			$this->session->set_flashdata('msg_error', 'NIK "' . htmlspecialchars($nik) . '" sudah digunakan karyawan lain.');
			redirect('page/mkTambah');
		}

		$data = array(
			'nama_karyawan'  => trim($this->input->post('nama_karyawan')),
			'nik'            => $nik,
			'password'       => md5($pass ?: '12345'),
			'jns_kelamin'    => $this->input->post('jns_kelamin'),
			'kd_bagian'      => strtoupper(trim($this->input->post('kd_bagian'))),
			'seragam_office' => $this->input->post('seragam_office'),
			'id_levell'      => $this->input->post('id_levell'),
			'kondisi'        => 'AKTIF',
		);
		$this->UserModel->tambahKaryawan($data);
		$this->session->set_flashdata('msg_success', 'Karyawan "' . $data['nama_karyawan'] . '" berhasil ditambahkan.');
		redirect('page/mKaryawan');
	}

	public function mkEdit() {
		if($this->session->userdata('role') != '1') show_404();
		$id = $this->uri->segment(3);
		$data['mode'] = 'edit';
		$data['k']    = $this->UserModel->showw('karyawan', 'id_karyawan', $id);
		$this->render_backend('karyawan_form', $data);
	}

	public function mkUpdate() {
		if($this->session->userdata('role') != '1') show_404();

		$id  = $this->input->post('id_karyawan');
		$nik = trim($this->input->post('nik'));

		// NIK uniqueness check (exclude self)
		$existing = $this->UserModel->showw2('karyawan', 'nik', $nik, 'id_karyawan !=', $id);
		if($existing) {
			$this->session->set_flashdata('msg_error', 'NIK "' . htmlspecialchars($nik) . '" sudah digunakan karyawan lain.');
			redirect('page/mkEdit/' . $id);
		}

		$data = array(
			'nama_karyawan'  => trim($this->input->post('nama_karyawan')),
			'nik'            => $nik,
			'jns_kelamin'    => $this->input->post('jns_kelamin'),
			'kd_bagian'      => strtoupper(trim($this->input->post('kd_bagian'))),
			'seragam_office' => $this->input->post('seragam_office'),
			'id_levell'      => $this->input->post('id_levell'),
			'kondisi'        => $this->input->post('kondisi'),
		);
		$pass = trim($this->input->post('password'));
		if($pass !== '') $data['password'] = md5($pass);

		$this->UserModel->editKaryawan($id, $data);
		$this->session->set_flashdata('msg_success', 'Data karyawan "' . $data['nama_karyawan'] . '" berhasil diupdate.');
		redirect('page/mKaryawan');
	}

	public function mkToggle() {
		if($this->session->userdata('role') != '1') show_404();
		$id = $this->uri->segment(3);
		$this->UserModel->toggleKondisi($id);
		$this->session->set_flashdata('msg_success', 'Status karyawan berhasil diubah.');
		redirect('page/mKaryawan');
	}

	// ── Chat ──────────────────────────────────────────────────────────

	/** POST: kirim pesan (user atau admin) */
	public function chatKirim() {
		if(!$this->session->userdata('authenticated')) show_404();
		$this->output->set_content_type('application/json');

		$pesan = trim($this->input->post('pesan'));
		if($pesan === '') {
			echo json_encode(array('ok' => false, 'msg' => 'Pesan kosong'));
			return;
		}

		$role = (int)$this->session->userdata('role');
		$nama = $this->session->userdata('nama');

		// admin kirim ke user tertentu; user kirim ke dirinya sendiri
		if($role === 1) {
			$id_karyawan = (int)$this->input->post('id_karyawan');
			if(!$id_karyawan) {
				echo json_encode(array('ok' => false, 'msg' => 'id_karyawan diperlukan'));
				return;
			}
		} else {
			$id_karyawan = (int)$this->session->userdata('idkaryawan');
		}

		$ok = $this->UserModel->chatKirim($id_karyawan, $role, $nama, $pesan);
		echo json_encode(array('ok' => (bool)$ok));
	}

	/** GET: ambil pesan terbaru (polling) */
	public function chatAmbil() {
		if(!$this->session->userdata('authenticated')) show_404();
		$this->output->set_content_type('application/json');

		$role        = (int)$this->session->userdata('role');
		$after_id    = (int)$this->input->get('after_id');

		if($role === 1) {
			$id_karyawan = (int)$this->input->get('id_karyawan');
			if(!$id_karyawan) { echo json_encode(array()); return; }
			$this->UserModel->chatBacaAdmin($id_karyawan);
		} else {
			$id_karyawan = (int)$this->session->userdata('idkaryawan');
			$this->UserModel->chatBacaUser($id_karyawan);
		}

		$rows = $this->UserModel->chatAmbil($id_karyawan, $after_id);
		$out  = array();
		foreach($rows as $r) {
			$out[] = array(
				'id'        => (int)$r->id,
				'role'      => (int)$r->pengirim_role,
				'nama'      => htmlspecialchars($r->nama_pengirim),
				'pesan'     => htmlspecialchars($r->pesan),
				'waktu'     => date('d/m H:i', strtotime($r->created_at)),
			);
		}
		echo json_encode($out);
	}

	/** GET: halaman kelola chat admin (daftar thread) */
	public function chatAdmin() {
		if($this->session->userdata('role') != '1') show_404();
		$data['threads'] = $this->UserModel->chatThreadList();
		$this->render_backend('chatadmin', $data);
	}

	/** GET: jumlah pesan belum dibaca (untuk notifikasi admin) */
	public function chatUnread() {
		if($this->session->userdata('role') != '1') {
			echo json_encode(array('count' => 0)); return;
		}
		$this->output->set_content_type('application/json');
		echo json_encode(array('count' => $this->UserModel->chatUnreadTotal()));
	}

}