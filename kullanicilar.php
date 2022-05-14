<?php
define('SECURITY', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/head.php';
    if (!myHelper::yetki_kontrol("kullanicilar", "listeleme")) {
        header("Location: index.php");
        die;
    }
    ?>
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
                            <h5 class="card-title">Kullanıcılar
                                <a href="kullaniciekle.php" class="btn btn-success btn-xs -pull-right"><i
                                            class="fa fa-plus"></i> Yeni Ekle</a>
                            </h5>
                            <table class="table table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kullanıcı Ad Soyad</th>
                                    <th scope="col">Kullanıcı Mail</th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $kullanicilar = $db->prepare("SELECT * FROM users WHERE id!=:id");
                                $kullanicilar->execute(array(
                                        "id" => $_SESSION['admin_id']
                                ));
                                if ($kullanicilar->rowCount()) {
                                    $kullanicilar = $kullanicilar->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($kullanicilar as $kullanici) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $kullanici['id'] ?></th>
                                            <td><?= $kullanici['name'] ?></td>
                                            <td><?= $kullanici['email'] ?></td>
                                            <td>
                                                <label class="switch">
                                                    <input class="kullaniciAktiflik" data-id="<?=$kullanici['id'] ?>"
                                                           data-url="inc/islem.php"
                                                           type="checkbox" <?= ($kullanici['durum'] == 1) ? 'checked' : '' ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a href="inc/islem.php?kullanicisil=<?= $kullanici['id'] ?>"
                                                   class="btn btn-outline btn-danger btn-sm"><i class="fa fa-times"></i>
                                                    Sil</a>
                                                <a href="kullaniciguncelle.php?id=<?= $kullanici['id'] ?>"
                                                   class="btn btn-outline btn-primary"><i class="fa fa-edit"></i>
                                                    Düzenle</a>
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