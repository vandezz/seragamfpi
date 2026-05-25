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
	 
    if($this->session->userdata('role') != '1') // Jika user yg login bukan admin
      show_404(); // Redirect ke halaman 404 Not found
	  $th = date('Y');
	  $data['g']= $this->UserModel->seragamlist($th);
	  $data['c']= $this->UserModel->seragamlist($th)->num_rows();
	  $data['k'] =$this->UserModel->gwssort('karyawan','KONDISI','aktif','nama_karyawan');
	  $data['total_k'] = $data['k']->num_rows();
	  $data['p'] = $this->UserModel->disting('seragam','periode');
	
	  $this->render_backend('admin',$data); // load view admin.php
  }
  
  
  public function showseragamperiode(){
	  $thn = $this->input->post('periode');
   $this->pengguna($thn);
  }
  
  public function compareseragam()
  {
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
	
 
}