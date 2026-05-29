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

  public function lupapassword(){
    if($this->session->userdata('authenticated'))
      redirect('page/home');
    $this->render_login('lupa_password');
  }

  public function ceknik(){
    $this->output->set_content_type('application/json');

    $nik = trim($this->input->post('nik'));
    if(empty($nik)){
      echo json_encode(array('ok' => false, 'msg' => 'NIK tidak boleh kosong.'));
      return;
    }

    $user = $this->UserModel->get($nik);
    if(empty($user)){
      echo json_encode(array('ok' => false, 'msg' => 'NIK tidak ditemukan.'));
      return;
    }

    $email = $user->email ?? '';
    if(empty(trim($email))){
      echo json_encode(array('ok' => false, 'msg' => 'Akun ini tidak memiliki email terdaftar. Hubungi admin.'));
      return;
    }

    echo json_encode(array('ok' => true, 'email' => $this->_maskEmail(trim($email))));
  }

  public function kirimreset(){
    $this->output->set_content_type('application/json');

    $nik = trim($this->input->post('nik'));
    if(empty($nik)){
      echo json_encode(array('ok' => false, 'msg' => 'NIK tidak valid.'));
      return;
    }

    $user = $this->UserModel->get($nik);
    if(empty($user) || empty(trim($user->email ?? ''))){
      echo json_encode(array('ok' => false, 'msg' => 'NIK tidak ditemukan atau tidak memiliki email.'));
      return;
    }

    $token      = bin2hex(random_bytes(32));
    $expired_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $this->UserModel->simpanToken($nik, $token, $expired_at);

    $reset_url = base_url('auth/resetpassword/' . $token);

    try {
      // Cek apakah config email tersedia
      if(!file_exists(APPPATH . 'config/email.php')){
        throw new Exception('File konfigurasi email tidak ditemukan di server.');
      }

      $this->load->config('email');
      $this->email->initialize(array(
        'protocol'    => $this->config->item('protocol'),
        'smtp_host'   => $this->config->item('smtp_host'),
        'smtp_port'   => (int)$this->config->item('smtp_port'),
        'smtp_crypto' => $this->config->item('smtp_crypto'),
        'smtp_user'   => $this->config->item('smtp_user'),
        'smtp_pass'   => $this->config->item('smtp_pass'),
        'charset'     => 'utf-8',
        'mailtype'    => 'html',
        'newline'     => "\r\n",
      ));

      $this->email->from($this->config->item('from_email'), $this->config->item('from_name'));
      $this->email->to(trim($user->email));
      $this->email->subject('Reset Password - Seragam FPI');
      $this->email->message('
        <div style="font-family:Arial,sans-serif;max-width:480px;margin:auto;padding:24px;border:1px solid #ddd;border-radius:8px;">
          <h2 style="color:#0d47a1;">Reset Password</h2>
          <p>Halo <strong>' . htmlspecialchars($user->nama_karyawan) . '</strong>,</p>
          <p>Kami menerima permintaan reset password untuk akun Anda (NIK: <strong>' . htmlspecialchars($nik) . '</strong>).</p>
          <p>Klik tombol di bawah untuk membuat password baru. Link ini berlaku selama <strong>1 jam</strong>.</p>
          <p style="text-align:center;margin:32px 0;">
            <a href="' . $reset_url . '" style="background:#0d47a1;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-size:15px;">
              Reset Password
            </a>
          </p>
          <p style="font-size:12px;color:#888;">Jika Anda tidak merasa meminta reset password, abaikan email ini.</p>
          <hr style="border:none;border-top:1px solid #eee;">
          <p style="font-size:11px;color:#aaa;">PT. Fuji Presisi-Tool Indonesia &copy; ' . date('Y') . '</p>
        </div>
      ');

      $sent = $this->email->send(FALSE); // FALSE = jangan throw exception
      ob_clean();
      if($sent){
        echo json_encode(array('ok' => true));
      } else {
        $debug = $this->email->print_debugger(array('headers'));
        log_message('error', 'Reset password email gagal: ' . $debug);
        echo json_encode(array('ok' => false, 'msg' => 'Gagal mengirim email. Periksa konfigurasi SMTP.'));
      }
    } catch(Exception $e){
      log_message('error', 'kirimreset exception: ' . $e->getMessage());
      ob_clean();
      echo json_encode(array('ok' => false, 'msg' => 'Error: ' . $e->getMessage()));
    }
  }

  public function resetpassword($token = NULL){
    if(empty($token)) redirect('auth');

    $data = $this->UserModel->cekToken($token);
    if(empty($data)){
      $this->session->set_flashdata('message', 'Link reset tidak valid atau sudah kadaluarsa.');
      redirect('auth');
    }

    $this->render_login('reset_password', array('token' => $token));
  }

  public function prosesreset(){
    $token    = $this->input->post('token');
    $pw_baru  = $this->input->post('pw_baru');
    $cpw_baru = $this->input->post('cpw_baru');

    if(empty($token) || empty($pw_baru) || empty($cpw_baru)){
      $this->session->set_flashdata('message', 'Semua field wajib diisi.');
      redirect('auth/resetpassword/' . $token);
    }

    if($pw_baru !== $cpw_baru){
      $this->session->set_flashdata('message', 'Konfirmasi password tidak cocok.');
      redirect('auth/resetpassword/' . $token);
    }

    $data = $this->UserModel->cekToken($token);
    if(empty($data)){
      $this->session->set_flashdata('message', 'Link reset tidak valid atau sudah kadaluarsa.');
      redirect('auth');
    }

    $this->UserModel->updatepassByNik($data->nik, md5($pw_baru));
    $this->UserModel->hapusToken($token);

    $this->session->set_flashdata('message_success', 'Password berhasil direset. Silakan login.');
    redirect('auth');
  }

  private function _maskEmail($email){
    $parts  = explode('@', $email);
    $local  = $parts[0];
    $domain = $parts[1];

    // Mask local: tampil 1 karakter pertama + * + 1 karakter terakhir (jika cukup panjang)
    if(strlen($local) <= 2){
      $maskedLocal = str_repeat('*', strlen($local));
    } else {
      $maskedLocal = substr($local, 0, 1) . str_repeat('*', strlen($local) - 2) . substr($local, -1);
    }

    // Mask domain: tampil 1 karakter pertama domain + *** + .tld
    $dotPos      = strrpos($domain, '.');
    $domainName  = substr($domain, 0, $dotPos);
    $tld         = substr($domain, $dotPos);
    $maskedDomain = substr($domainName, 0, 1) . str_repeat('*', max(strlen($domainName) - 1, 2)) . $tld;

    return $maskedLocal . '@' . $maskedDomain;
  }
}