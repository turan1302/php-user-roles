<?php
if (!defined("SECURITY"))
    die;

?>

<div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
        <li>
            <a href="index.php"><i data-feather="home"></i>Anasayfa</a>
        </li>
        <?php if (myHelper::yetki_kontrol("yetkiler", "listeleme") || @$_SESSION['admin_super']==1) { ?>
            <li>
                <a href="yetkiler.php"><i data-feather="key"></i>Yetkiler</a>
            </li>
        <?php } ?>
        <?php if (myHelper::yetki_kontrol("kullanicilar", "listeleme")) { ?>
            <li>
                <a href="kullanicilar.php"><i data-feather="users"></i>Kullanıcılar</a>
            </li>
        <?php } ?>
    </ul>
</div>
