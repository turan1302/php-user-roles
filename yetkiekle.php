<?php
define('SECURITY', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/head.php'; ?>
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
                            <h5 class="card-title"> Yetki Ekle</h5>
                            <form action="inc/islem.php" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Yetki Başlığı</label>
                                    <input type="text" class="form-control" name="baslik" placeholder="Yetki Başlığı">
                                </div>
                                <a href="yetkiler.php" class="btn btn-danger"><i class="fa fa-times"></i> Vazgeç</a>
                                <button type="submit" name="yetki_ekle" class="btn btn-primary"><i class="fa fa-edit"></i> Ekle</button>
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