<?php
define('SECURITY', 1);
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
                            <h5 class="card-title">Yetkiler
                                <a href="yetkiekle.php" class="btn btn-success btn-xs -pull-right"><i class="fa fa-plus"></i> Yeni
                                    Ekle</a>
                            </h5>
                            <table class="table table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Yetki</th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $yetkiler = $db->prepare("SELECT * FROM yetkiler");
                                $yetkiler->execute();
                                if ($yetkiler->rowCount()) {
                                    $yetki_cek = $yetkiler->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($yetki_cek as $yetki) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $yetki['id'] ?></th>
                                            <td><?= $yetki['baslik'] ?></td>
                                            <td>
                                                <label class="switch">
                                                    <input class="yetkiAktiflik" data-id="<?=$yetki['id'] ?>" data-url="inc/islem.php" type="checkbox" <?= ($yetki['durum']==1) ? 'checked' : ''?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a href="inc/islem.php?yetkisil=<?= $yetki['id'] ?>" class="btn btn-outline btn-danger btn-sm"><i class="fa fa-times"></i> Sil</a>
                                                <a href="yetkiguncelle.php?id=<?=$yetki['id'] ?>" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i> Düzenle</a>
                                                <a href="yetkiayar.php?id=<?=$yetki['id'] ?>" class="btn btn-outline btn-warning"><i class="fa fa-list"></i> Yetki Ayarlamaları</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/scripts.php'; ?>
<script src="assets/js/custom.js"></script>
</body>
</html>