<?php


define('SECURITY', 1);

include 'inc/class.myhelper.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/head.php'; ?>
    <link rel="stylesheet" href="assets/css/toggle.css">
</head>
<body>

<div class="page-container">

    <?php require_once 'includes/header.php' ?>

    <?php require_once 'includes/sidebar.php' ?>

    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> Profil Güncelle</h5>
                            <form action="inc/islem.php" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Adınız</label>
                                    <input type="text" class="form-control" name="name" value="<?=$_SESSION['admin_name'] ?>" placeholder="Adınız Soyadınız">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">E-Mail Adresiniz</label>
                                    <input type="email" class="form-control" name="email" value="<?=$_SESSION['admin_email'] ?>" placeholder="E-Mail Adresiniz">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Şifreniz (Min: 8 Karakter) (Boş Bırakırsanız Değişmez)</label>
                                    <input type="password" class="form-control" name="password" value="" placeholder="Şifreniz">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Şifre Tekrar</label>
                                    <input type="password" class="form-control" name="password_tekrar" value="" placeholder="Şifre Tekrar">
                                </div>
                                <a href="index.php" class="btn btn-danger"><i class="fa fa-times"></i> Vazgeç</a>
                                <button type="submit" name="profil_guncelle" class="btn btn-primary"><i class="fa fa-edit"></i> Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/scripts.php'; ?>
</body>
</html>