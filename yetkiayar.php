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

    <?php
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        die;
    } else {
        $yetki_id = get('id');

        $yetki = $db->prepare("SELECT * FROM yetkiler WHERE id=:id");
        $yetki->execute(array(
            ":id" => $yetki_id
        ));
        if (!$yetki->rowCount()) {
            header("Location: index.php");
        } else {
            $yetki_cek = $yetki->fetch(PDO::FETCH_ASSOC);
        }

        $yetkiler = json_decode($yetki_cek['yetkiler'],true);
    }
    ?>

    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <form action="inc/islem.php?id=<?=$yetki_cek['id'] ?>" method="POST">
                            <div class="card-body">
                                <h5 class="card-title"><b><?= $yetki_cek['baslik'] ?></b> Yetkisi Ayarlamaları</h5>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Yetki Adı</th>
                                        <th scope="col">Listeleme</th>
                                        <th scope="col">Ekleme</th>
                                        <th scope="col">Silme</th>
                                        <th scope="col">Güncelleme</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (count(myHelper::yetkiler()) > 0) {
                                        foreach (myHelper::yetkiler() as $k => $v) { ?>
                                            <tr>
                                                <td scope="row"><?= $v ?></td>
                                                <td>
                                                    <!-- LISTELEME KSIMI -->
                                                    <label class="switch">
                                                        <input type="checkbox" name="yetkiler[<?= $k ?>][listeleme]"
                                                            <?= (array_key_exists($k, $yetkiler) && array_key_exists("listeleme", $yetkiler[$k]) && $yetkiler[$k]["listeleme"] == "on") ? 'checked' : '' ?>
                                                        >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <!-- EKLEME KISMI -->
                                                    <label class="switch">
                                                        <input type="checkbox" name="yetkiler[<?= $k ?>][ekleme]"
                                                            <?= (array_key_exists($k, $yetkiler) && array_key_exists("ekleme", $yetkiler[$k]) && $yetkiler[$k]["ekleme"] == "on") ? 'checked' : '' ?>
                                                        >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <!-- SILME KISMI -->
                                                    <label class="switch">
                                                        <input type="checkbox" name="yetkiler[<?= $k ?>][silme]"
                                                            <?= (array_key_exists($k, $yetkiler) && array_key_exists("silme", $yetkiler[$k]) && $yetkiler[$k]["silme"] == "on") ? 'checked' : '' ?>
                                                        >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <!-- GUNCELLEME KISMI -->
                                                    <label class="switch">
                                                        <input type="checkbox" name="yetkiler[<?= $k ?>][guncelleme]"
                                                            <?= (array_key_exists($k, $yetkiler) && array_key_exists("guncelleme", $yetkiler[$k]) && $yetkiler[$k]["guncelleme"] == "on") ? 'checked' : '' ?>
                                                        >
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card">
                                <div class="col-md-8">
                                    <a href="yetkiler.php" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Vazgeç</a>
                                    <button type="submit" name="yetki_ayarla" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/scripts.php'; ?>
</body>
</html>