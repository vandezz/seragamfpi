<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

  public function __construct(){
    parent::__construct();

    $this->load->model('UserModel');
  }

  public function index(){
    if($this->session->userdata('authenticated')) // Jika user sudah login (Session authenticated ditemukan)
      redirect('page/home'); // Redirect ke page home

    // function render_login tersebut dari file core/MY_Controller.php
    $this->render_login('login'); // Load view login.php
  }

  public function login(){
    $username = $this->input->post('username'); // Ambil isi dari inputan username pada form login
    $password = md5($this->input->post('password')); // Ambil isi dari inputan password pada form login dan encrypt dengan md5

    $user = $this->UserModel->get($username); // Panggil fungsi get yang ada di UserModel.php
	
	$th = date('Y');

    if(empty($user)){ // Jika hasilnya kosong / user tidak ditemukan
      $this->session->set_flashdata('message', 'Username atau Password Salah!'); // Buat session flashdata
      redirect('auth'); // Redirect ke halaman login
    }else{
      if($password == $user->password){ // Jika password yang diinput sama dengan password yang didatabase
        $session = array(
          'authenticated'	=>true, // Buat session authenticated dengan value true
          'username'		=>$user->nik,  // Buat session username
          'nama'			=>$user->nama_karyawan, // Buat session nama
          'role'			=>$user->id_levell, // Buat session role,
		  'jk'				=>$user->jns_kelamin,  //Jenis Kelamin
		  'idkaryawan' 		=> $user->id_karyawan, //id karyawan
		  'office' 			=> $user->seragam_office, //jenis bahan seragam
		  'periodenow'		=> $th // periode tahun ini
        );

        $this->session->set_userdata($session); // Buat session sesuai $session
        redirect('page/home'); // Redirect ke halaman home
      }else{
         $this->session->set_flashdata('message', 'Username atau Password salah'); //Buat session flashdata
		 //$this->render_login('login'); // Load view login.php
        redirect('auth'); // Redirect ke halaman login
      }
    }
  }

  public function logout(){
    $this->session->sess_destroy(); // Hapus semua session
    redirect('auth'); // Redirect ke halaman login
  }
}