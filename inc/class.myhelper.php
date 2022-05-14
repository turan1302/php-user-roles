<?php

require_once 'baglan.php';

class myHelper
{
    // YETKILER BU KISIMDAN ALINACAK
    public static function yetkiler()
    {
        return [
            "yetkiler" => "Yetkiler",
            "kullanicilar" => "Kullanıcılar",
        ];
    }

    // YETKI KONTROL KISMI AYARLANMASI
    public static function yetki_kontrol($modul, $islem)
    {
        global $db;
        $yetki = $db->prepare("SELECT * FROM yetkiler WHERE id=:id AND durum=:durum");
        $yetki->execute(array(
            ":id" => @$_SESSION['admin_yetki'],
            ":durum" => 1
        ));

        if ($yetki->rowCount()){
            $yetki_cek = $yetki->fetch(PDO::FETCH_ASSOC);
            $yetki_analiz = json_decode($yetki_cek['yetkiler'], true);


            if (array_key_exists($modul, $yetki_analiz) && array_key_exists($islem, $yetki_analiz[$modul])) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}