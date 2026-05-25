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
	$data['dt']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr);
	$data['dtk']=$this->UserModel->gwnow($this->session->userdata('idkaryawan'),$yr-1);
    $this->render_backend('home',$data); // load view home.php
  }

  public function berita(){
    // function render_backend tersebut dari file core/MY_Controller.php
	$idk = $this->session->userdata('idkaryawan');
	$th = $this->session->userdata('periodenow');
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
	  $data['k'] =$this->UserModel->gws('karyawan','KONDISI','aktif');
	 // $data['belum']=$this->UserModel->belumisi();
	
    // function render_backend tersebut dari file core/MY_Controller.php
    //$this->render_backend('pengguna',$data); // load view pengguna.php
	//$this->render_backend('admin',$data); // load view pengguna.php
	$this->load->view('admin',$data); // load view admin.php
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
			$jeniscelana = "Celana Wanita Executive";
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
		$data['dt']=$this->UserModel->gwnow($idk,$thnow);
		$data['dtk']=$this->UserModel->gwnow($idk,$thnow-1);
		$this->render_backend('home',$data); // load view home.php
		
	
	
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
     header("Content-Disposition: attachment; filename=Seragam2023.xls");
	 $data['xls'] = $this->UserModel->seragamlist($thn);
	 $this->load->view('unduh',$data);
 }
 
 public function yangbelum()
 {
	  $pd = $this->session->userdata('periodenow');
	 $data['blm'] = $this->UserModel->yangbelum($pd);
	 $this->render_backend('belum',$data);
	 
 }
 
 public function ckar(){
	 if($this->session->userdata('role') == '1'){ // Jika role-nya admin
		 $data['tag']=1;
		 $data['dk'] = $this->UserModel->showw('karyawan_s','is_active','1');
		 $this->render_backend('fkar',$data);
	 }
	 else{ $this->home(); }
 }
 
 public function ckarx(){
	 if($this->session->userdata('role') == '1'){ // Jika role-nya admin
		 $n=$this->input->post('tkar');
		 $data['tag']=2;
		 $data['dkr']=$this->UserModel->showlike('karyawan_s','nama_karyawan',$n,'is_active','1');
		 $this->render_backend('fkar',$data);
	 }
	 else{ $this->home(); }
 }
 public function ckary(){
	 if($this->session->userdata('role') == '1'){ // Jika role-nya admin
		 $idky = $this->uri->segment(3);
		 $data['d']=$this->UserModel->showw('karyawan_s','id_karyawan',$idky);
		 $this->render_backend('detailkary',$data);
	 }
	 else{ $this->home(); }
 }
 
 public function rubahtanggalmax()
 {
	 $data['tgl'] = $this->UserModel->showall('seragam_param');
	 
	 $this->render_backend('parameter',$data);
 }
 
 
}