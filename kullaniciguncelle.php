<?php
define('SECURITY', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/head.php';

    if (!myHelper::yetki_kontrol("kullanicilar", "guncelleme")) {
        header("Location: index.php");
        die;
    }
    ?>
</head>
<body>

<div class="page-container">

    <?php require_once 'includes/header.php' ?>

    <?php require_once 'includes/sidebar.php' ?>

    <?php
    if (!isset($_GET['id'])){
        header("Location: index.php");
    }else{
        $yetki_id = get('id');

        $kullanici = $db->prepare("SELECT * FROM users WHERE id=:id");
        $kullanici->execute(array(
            ":id" => $yetki_id
        ));
        if (!$kullanici->rowCount()){
            header("Location: index.php");
        }else{
            $kullanici_cek = $kullanici->fetch(PDO::FETCH_ASSOC);
        }
    }
    ?>

    <div class="page-content">
        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b><?=$kullanici_cek['name'] ?></b> Kullanıcısını Güncelle</h5>
                            <form action="inc/islem.php" method="POST">
                                <input type="hidden" name="id" value="<?=$kullanici_cek['id'] ?>">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Kullanıcı Ad Soyad</label>
                                    <input type="text" class="form-control" name="name" value="<?= $kullanici_cek['name'] ?>"
                                           placeholder="Kullanıcı Ad Soyad">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">E-Mail Adresiniz</label>
                                    <input type="email" class="form-control" name="email" value="<?= $kullanici_cek['email'] ?>"
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
                                                <option <?= ($yetki['id']==$kullanici_cek['yetki']) ? 'selected' : '' ?> value="<?= $yetki['id'] ?>"><?= $yetki['baslik'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>

                                </div>
                                <a href="kullanicilar.php" class="btn btn-danger"><i class="fa fa-times"></i> Vazgeç</a>
                                <button type="submit" name="kullanici_edit" class="btn btn-primary"><i
                                            class="fa fa-edit"></i> Güncelle
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