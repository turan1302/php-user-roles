<?php
define('SECURITY', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/head.php';

    if (!myHelper::yetki_kontrol("kullanicilar", "ekleme")) {
        header("Location: index.php");
        die;
    }
    ?>
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
                            <h5 class="card-title"> Kullanıcı Ekle</h5>
                            <form action="inc/islem.php" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Kullanıcı Ad Soyad</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Kullanıcı Ad Soyad">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">E-Mail Adresiniz</label>
                                    <input type="email" class="form-control" name="email"
                                           placeholder="Kullanıcı E-Mail Adresi">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Şifreniz (Min: 8 Karakter) (Boş
                                        Bırakırsanız Değişmez)</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Kullanıcı Şifre">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Şifre Tekrar</label>
                                    <input type="password" class="form-control" name="password_tekrar"
                                           placeholder="Kullanıcı Şifre Tekrar">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Kullanıcı Yetkisi</label>
                                    <?php
                                    $yetkiler = $db->prepare("SELECT * FROM yetkiler WHERE durum=:durum");
                                    $yetkiler->execute(array(
                                        ":durum" => 1
                                    ));
                                    if ($yetkiler->rowCount()) {
                                        ?>
                                        <select name="yetki_id" class="form-control">
                                            <option value="">- Seçiniz -</option>
                                            <?php
                                            $yetki_cek = $yetkiler->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($yetki_cek as $yetki) { ?>
                                                <option value="<?= $yetki['id'] ?>"><?= $yetki['baslik'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>

                                </div>
                                <a href="kullanicilar.php" class="btn btn-danger"><i class="fa fa-times"></i> Vazgeç</a>
                                <button type="submit" name="yeni_kullanici" class="btn btn-primary"><i
                                            class="fa fa-save"></i> Ekle
                                </button>
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