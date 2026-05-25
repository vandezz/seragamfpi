<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Input Seragam</title>

    <!-- Load File CSS Bootstrap  -->
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading{
        margin-bottom: 10px;
    }
    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-signin">
            <h5 class="form-signin-heading"><center>Login Pengisian Seragam (Gunakan Nomor Induk Karyawan)</center></h5>
			<br>
			<!-- Jika anda kembali ke halaman ini, berarti password Anda salah! -->
            <?php
            /*
            * Variabel $contentnya diambil dari core MY_Controller
            * (application/core/MY_Controller.php)
            * */
			
			echo "<center><h3>".$this->session->userdata('message')."</h3></center>";
            echo $contentnya;
			
            ?>
        </div>
    </div>
</body>
</html>