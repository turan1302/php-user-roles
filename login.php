<?php

if (isset($_SESSION['adminlogin'])){
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Circl - Responsive Admin Dashboard Template</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<div class='loader'>
    <div class='spinner-grow text-primary' role='status'>
        <span class='sr-only'>Loading...</span>
    </div>
</div>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-4">
            <div class="card login-box-container">
                <div class="card-body">
                    <div class="authent-logo">
                        <img src="assets/images/logo@2x.png" alt="Kullanıcı Rolleri | MFSoftware Blog">
                    </div>
                    <div class="authent-text">
                        <p>Kullanıcı Rolleri | MFSoftware Blog</p>
                        <p>Kullanıcı Rolleri İşlemi Admin Paneli | MFSoftware Blog</p>
                    </div>

                    <form action="inc/islem.php" method="POST">
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="E-Mail Adresiniz">
                                <label for="floatingInput">E-Mail Adresiniz</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Şifreniz">
                                <label for="floatingPassword">Şifreniz</label>
                            </div>
                        </div>
                        <div class="authent-reg">
                            <p>
                                <button type="submit" name="girisyap" class="btn btn-success btn-sm">Giriş Yap</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Javascripts -->
<script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="assets/js/main.min.js"></script>
</body>
</html>