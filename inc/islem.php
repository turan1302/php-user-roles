<?php
include 'class.myhelper.php';

// GIRIS YAPMA ISLEMI
if (isset($_POST['girisyap'])) {

    $email = post('email');
    $password = post('password');


    if ($email == "" || $password == "") {
        header("Location: ../login.php?durum=bos");
        die;
    }

    // EMAIL KONTROLU
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?durum=gecersizemail");
        die;
    }

    // KULLANICI BILGI KONTROLU
    $kullanici = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password AND durum=1");
    $kullanici->execute(array(
        ":email" => $email,
        ":password" => sha1(md5($password))
    ));

    if ($kullanici->rowCount()) {
        $kullanici_cek = $kullanici->fetch(PDO::FETCH_ASSOC);

        $_SESSION['adminlogin'] = true;
        $_SESSION['admin_id'] = $kullanici_cek['id'];
        $_SESSION['admin_name'] = $kullanici_cek['name'];
        $_SESSION['admin_email'] = $kullanici_cek['email'];
        $_SESSION['admin_yetki'] = $kullanici_cek['yetki'];
        $_SESSION['admin_super'] = $kullanici_cek['isSuperAdmin'];

        header("Location: ../index.php");
        die;
    } else {
        header("Location: ../login.php?durum=kullaniciyok");
        die;
    }
}

// YETKI EKLEME ISLEMI
if (isset($_POST['yetki_ekle'])) {
    $baslik = post('baslik');

    if ($baslik == "") {
        header("Location: ../yetkiekle.php?durum=bos");
        die;
    }

    $ekle = $db->prepare("INSERT INTO yetkiler SET baslik=:baslik,yetkiler=:yetkiler");
    $sonuc = $ekle->execute(array(
        ":baslik" => $baslik,
        ":yetkiler" => "[]"
    ));

    if ($sonuc) {
        header("Location: ../yetkiekle.php?durum=yes");
        die;
    } else {
        header("Location: ../yetkiekle.php?durum=no");
        die;
    }
}

// YETKI SILME ISLEMI
if (isset($_GET['yetkisil'])) {
    $yetki_id = get('yetkisil'); // SILINECEK OLAN YETKI ID SINI ALDIK

    $sil = $db->prepare("DELETE FROM yetkiler WHERE id=:id");
    $delete = $sil->execute(array(
        ":id" => $yetki_id
    ));

    if ($delete) {
        header("Location: ../yetkiler.php?durum=basarili");
        die;
    } else {
        header("Location: ../yetkiler.php?durum=basarisiz");
        die;
    }
}

// YETKI DURUM GUNCELLEME ISLEMI
if (isset($_POST['yetki_guncelle'])) {
    $yetki_id = post('id');
    $data = (post('data') == "true") ? 1 : 0;

    $yetki_guncelle = $db->prepare("UPDATE yetkiler SET durum=:durum WHERE id=:id");
    $update = $yetki_guncelle->execute(array(
        ":durum" => $data,
        ":id" => $yetki_id
    ));

    if ($update) {
        echo 1; // BASARILI
    } else {
        echo 0; // BASARISIZ
    }
}

// YETKI GUNCELLEME KISMI
if (isset($_POST['yetki_edit'])) {
    $baslik = post('baslik');
    $id = post('id');

    if ($baslik == "") {
        header("Location: ../yetkiguncelle.php?id=$id&durum=bos");
        die;
    }

    $guncelle = $db->prepare("UPDATE yetkiler SET baslik=:baslik WHERE id=:id");
    $update = $guncelle->execute(array(
        ":id" => $id,
        ":baslik" => $baslik
    ));

    if ($update) {
        header("Location: ../yetkiguncelle.php?id=$id&durum=yes");
        die;
    } else {
        header("Location: ../yetkiguncelle.php?id=$id&durum=no");
        die;
    }
}

// YETKI AYARLAMALARI ISLEMLERI YAPILMASINI GERCEKLESTIRLIM
if (isset($_POST['yetki_ayarla'])) {
    $id = get('id');
    $yetkiler = (count($_POST['yetkiler']) > 0) ? json_encode($_POST['yetkiler']) : '[]';


    $ekle = $db->prepare("UPDATE yetkiler SET yetkiler=:yetkiler WHERE id=:id");
    $sonuc = $ekle->execute(array(
        ":yetkiler" => $yetkiler,
        ":id" => $id
    ));

    if ($sonuc) {
        header("Location: ../yetkiayar.php?id=$id&durum=yes");
        die;
    } else {
        header("Location: ../yetkiayar.php?id=$id&durum=no");
        die;
    }
}


/******************************* KULLANICI ISLEMLERI ******************************** **/
// YENI KULLANICI EKLEME ISLEMI
if (isset($_POST['yeni_kullanici'])) {

    // YETKI KONTROLU
    if (!myHelper::yetki_kontrol("kullanicilar", "ekleme")) {
        header("Location: index.php");
        die;
    }

    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_tekrar = post('password_tekrar');
    $yetki_id = post('yetki_id');

    // ALANLAR BOŞ İSE
    if ($name == "" || $email == "" || $password == "" || $password_tekrar == "" || $yetki_id == "") {
        header("Location: ../kullaniciekle.php?durum=bos");
        die;
    }

    // EMAIL GECERLI MI
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../kullaniciekle.php?durum=gecersizmail");
        die;
    }

    // SIFRELER ESLESIYOR MU KONTROL EDELIM
    if (strlen($password) >= 8) {
        if ($password != $password_tekrar) {
            header("Location: ../kullaniciekle.php?durum=sifrelerfarkli");
            die;
        }
    } else {
        header("Location: ../kullaniciekle.php?durum=kisasifre");
        die;
    }


    $kullanici = $db->prepare("SELECT * FROM users WHERE email=:email");
    $kullanici->execute(array(
        "email" => $email
    ));

    if ($kullanici->rowCount()) {
        header("Location: ../kullaniciekle.php?durum=emailmevcut");
        die;
    } else {

        $kullanici_ekle = $db->prepare("INSERT INTO users SET name=:name,email=:email,password=:password,yetki=:yetki");
        $sonuc = $kullanici_ekle->execute(array(
            ":name" => $name,
            ":email" => $email,
            ":password" => sha1(md5($password)),
            ":yetki" => $yetki_id
        ));

        if ($sonuc) {
            header("Location: ../kullaniciekle.php?durum=yes");
            die;
        } else {
            header("Location: ../kullaniciekle.php?durum=no");
            die;
        }
    }
}

// KULLANICI DURUM GUNCELLEME ISLEMI
if (isset($_POST['kullanici_guncelle'])) {

    if (!myHelper::yetki_kontrol("kullanicilar", "guncelleme")) {
        header("Location: index.php");
        die;
    }

    $kullanici_id = post('id');
    $data = (post('data') == "true") ? 1 : 0;

    $kullanici_guncelle = $db->prepare("UPDATE users SET durum=:durum WHERE id=:id");
    $update = $kullanici_guncelle->execute(array(
        ":durum" => $data,
        ":id" => $kullanici_id
    ));

    if ($update) {
        echo 1; // BASARILI
    } else {
        echo 0; // BASARISIZ
    }
}


// KULLANICI GUNCELLEME ISLEMLERI
if (isset($_POST['kullanici_edit'])){

    if (!myHelper::yetki_kontrol("kullanicilar", "guncelleme")) {
        header("Location: index.php");
        die;
    }


    $id = post('id');
    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_tekrar = post('password_tekrar');
    $yetki_id = post('yetki_id');



    // ALANLAR BOŞ İSE
    if ($name == "" || $email == "" || $yetki_id == "") {
        header("Location: ../kullaniciguncelle.php?id=$id?durum=bos");
        die;
    }

    // EMAIL GECERLI MI
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../kullaniciguncelle.php?id=$id?durum=gecersizmail");
        die;
    }

    // SIFRELER ESLESIYOR MU KONTROL EDELIM
    if (strlen($password) >= 8) {
        if ($password != $password_tekrar) {
            header("Location: ../kullaniciguncelle.php?id=$id?durum=sifrelerfarkli");
            die;
        }
    }



    $varsayilan_kullanici = $db->prepare("SELECT * FROM users WHERE id=:id");
    $varsayilan_kullanici->execute(array(
        ":id" => $id
    ));
    $varsayilan_kullanici_cek = $varsayilan_kullanici->fetch(PDO::FETCH_ASSOC);


    if ($password != "") {
        // PASSWORD DOLU ISE
        if (strlen($password) >= 8) {
            if ($password == $password_tekrar) {
                // SIFRE ESITLEME

                if ($varsayilan_kullanici_cek['email'] == $email) {
                    // EMAIL VE ADMIN SESSION BIRBIRINE ESIT ISE

                    $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email,password=:password, yetki=:yetki WHERE id=:id");
                    $update = $guncelle->execute(array(
                        ":name" => $name,
                        ":email" => $email,
                        ":password" => sha1(md5($password)),
                        ":yetki" => $yetki_id,
                        ":id" => $id
                    ));

                    if ($update) {
                        // SESSION BILGILERINI GUNCELLEYELIM

                        header("Location: ../kullaniciguncelle.php?id=$id?durum=yes");
                        die;
                    } else {
                        header("Location: ../kullaniciguncelle.php?id=$id?durum=no");
                        die;
                    }

                } else {
                    // EMAIL ADMIN SESSION BIRBIIRINE ESIT DEGIL ISE
                    $email_kontrol = $db->prepare("SELECT * FROM users WHERE email=:email");
                    $email_kontrol->execute(array(
                        ":email" => $email
                    ));
                    if ($email_kontrol->rowCount()) {
                        header("Location: ../kullaniciguncelle.php?id=$id?durum=emailmevcut");
                        die;
                    } else {
                        $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email,password=:password, yetki=:yetki WHERE id=:id");
                        $update = $guncelle->execute(array(
                            ":name" => $name,
                            ":email" => $email,
                            ":password" => sha1(md5($password)),
                            ":yetki" => $yetki_id,
                            ":id" => $id
                        ));

                        if ($update) {
                            header("Location: ../kullaniciguncelle.php?id=$id?durum=yes");
                            die;
                        } else {
                            header("Location: ../kullaniciguncelle.php?id=$id?durum=no");
                            die;
                        }
                    }
                }

            } else {
                // SIFRELER ESIT DEGIL
                header("Location: ../kullaniciguncelle.php?id=$id?durum=sifrelerfarkli");
                die;
            }
        } else {
            // KISA SIFRE
            header("Location: ../kullaniciguncelle.php?id=$id?durum=kisasifre");
            die;
        }

    } else {
        // PASSWORD BOŞ İSE
        if ($varsayilan_kullanici_cek['email'] == $email) {
            // EMAIL VE ADMIN SESSION BIRBIRINE ESIT ISE

            $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email, yetki=:yetki WHERE id=:id");
            $update = $guncelle->execute(array(
                ":name" => $name,
                ":email" => $email,
                ":yetki" => $yetki_id,
                ":id" => $id
            ));

            if ($update) {
                // SESSION BILGILERINI GUNCELLEYELIM

                header("Location: ../kullaniciguncelle.php?id=$id?durum=yes");
                die;
            } else {
                header("Location: ../kullaniciguncelle.php?id=$id?durum=no");
                die;
            }

        } else {
            // EMAIL ADMIN SESSION BIRBIIRINE ESIT DEGIL ISE
            $email_kontrol = $db->prepare("SELECT * FROM users WHERE email=:email");
            $email_kontrol->execute(array(
                ":email" => $email
            ));
            if ($email_kontrol->rowCount()) {
                header("Location: ../kullaniciguncelle.php?id=$id?durum=emailmevcut");
                die;
            } else {
                $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email, yetki=:yetki WHERE id=:id");
                $update = $guncelle->execute(array(
                    ":name" => $name,
                    ":email" => $email,
                    ":yetki" => $yetki_id,
                    ":id" => $id
                ));

                if ($update) {
                    header("Location: ../kullaniciguncelle.php?id=$id?durum=yes");
                    die;
                } else {
                    header("Location: ../kullaniciguncelle.php?id=$id?durum=no");
                    die;
                }
            }
        }
    }

}


// KULLANICI SILME ISLEMI
if (isset($_GET['kullanicisil'])) {

    if (!myHelper::yetki_kontrol("kullanicilar", "silme")) {
        header("Location: ../index.php");
        die;
    }

    $yetki_id = get('kullanicisil'); // SILINECEK OLAN YETKI ID SINI ALDIK

    $sil = $db->prepare("DELETE FROM users WHERE id=:id");
    $delete = $sil->execute(array(
        ":id" => $yetki_id
    ));

    if ($delete) {
        header("Location: ../kullanicilar.php?durum=basarili");
        die;
    } else {
        header("Location: ../kullanicilar.php?durum=basarisiz");
        die;
    }
}

/******************************* PROFIL ISLEMLERI ******************************** **/

// PROFIL KISMI
if (isset($_POST['profil_guncelle'])) {
    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_tekrar = post('password_tekrar');

    if ($name == "" || $email == "") {
        header("Location: ../profil.php?durum=bos");
        die;
    }

    // EMAIL KONTROLU
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../profil.php?durum=gecersizemail");
        die;
    }

    if ($password != "") {
        // PASSWORD DOLU ISE
        if (strlen($password) >= 8) {
            if ($password == $password_tekrar) {
                // SIFRE ESITLEME

                if ($_SESSION['admin_email'] == $email) {
                    // EMAIL VE ADMIN SESSION BIRBIRINE ESIT ISE

                    $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email,password=:password WHERE id=:id");
                    $update = $guncelle->execute(array(
                        ":name" => $name,
                        ":email" => $email,
                        ":password" => sha1(md5($password)),
                        ":id" => $_SESSION['admin_id']
                    ));

                    if ($update) {
                        // SESSION BILGILERINI GUNCELLEYELIM
                        $_SESSION['admin_name'] = $name;
                        $_SESSION['admin_email'] = $email;

                        header("Location: ../profil.php?durum=yes");
                        die;
                    } else {
                        header("Location: ../profil.php?durum=no");
                        die;
                    }

                } else {
                    // EMAIL ADMIN SESSION BIRBIIRINE ESIT DEGIL ISE
                    $email_kontrol = $db->prepare("SELECT * FROM users WHERE email=:email");
                    if ($email_kontrol->rowCount()) {
                        header("Location: ../profil.php?durum=emailmevcut");
                        die;
                    } else {
                        $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email,password=:password WHERE id=:id");
                        $update = $guncelle->execute(array(
                            ":name" => $name,
                            ":email" => $email,
                            ":password" => sha1(md5($password)),
                            ":id" => $_SESSION['admin_id']
                        ));

                        if ($update) {
                            // SESSION BILGILERINI GUNCELLEYELIM
                            $_SESSION['admin_name'] = $name;
                            $_SESSION['admin_email'] = $email;

                            header("Location: ../profil.php?durum=yes");
                            die;
                        } else {
                            header("Location: ../profil.php?durum=no");
                            die;
                        }
                    }
                }

            } else {
                // SIFRELER ESIT DEGIL
                header("Location: ../profil.php?durum=sifrelerfarkli");
                die;
            }
        } else {
            // KISA SIFRE
            header("Location: ../profil.php?durum=kisasifre");
            die;
        }

    } else {
        // PASSWORD BOŞ İSE
        if ($_SESSION['admin_email'] == $email) {
            // EMAIL VE ADMIN SESSION BIRBIRINE ESIT ISE

            $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email WHERE id=:id");
            $update = $guncelle->execute(array(
                ":name" => $name,
                ":email" => $email,
                ":id" => $_SESSION['admin_id']
            ));

            if ($update) {
                // SESSION BILGILERINI GUNCELLEYELIM
                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;

                header("Location: ../profil.php?durum=yes");
                die;
            } else {
                header("Location: ../profil.php?durum=no");
                die;
            }

        } else {
            // EMAIL ADMIN SESSION BIRBIIRINE ESIT DEGIL ISE
            $email_kontrol = $db->prepare("SELECT * FROM users WHERE email=:email");
            if ($email_kontrol->rowCount()) {
                header("Location: ../profil.php?durum=emailmevcut");
                die;
            } else {
                $guncelle = $db->prepare("UPDATE users SET name=:name, email=:email WHERE id=:id");
                $update = $guncelle->execute(array(
                    ":name" => $name,
                    ":email" => $email,
                    ":id" => $_SESSION['admin_id']
                ));

                if ($update) {
                    // SESSION BILGILERINI GUNCELLEYELIM
                    $_SESSION['admin_name'] = $name;
                    $_SESSION['admin_email'] = $email;

                    header("Location: ../profil.php?durum=yes");
                    die;
                } else {
                    header("Location: ../profil.php?durum=no");
                    die;
                }
            }
        }
    }
}