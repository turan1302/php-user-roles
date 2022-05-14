<?php

session_start();
ob_start();

$database = "php-user-roles";
$user = "root";
$password = 12345678;

try{
    $db = new PDO("mysql:host=localhost;dbname=$database;charset=utf8",$user,$password);
}catch (PDOException $e){
    echo $e->getMessage();
}


/** GET ISTEKLERI **/
function get($get){
    return strip_tags(trim($_GET[$get]));
}

/** POST ISTEKLERI */
function post($post){
    return strip_tags(trim($_POST[$post]));
}

/*** AKTIF SESSION GUNCELLENMESI ***/
$kullanici = $db->prepare("SELECT * FROM users WHERE email=:email AND durum=:durum");
$kullanici->execute(array(
    ":email" => $_SESSION['admin_email'],
    ":durum" => 1
));

$kullanici_cek = $kullanici->fetch(PDO::FETCH_ASSOC);

$_SESSION['adminlogin'] = true;
$_SESSION['admin_id'] = $kullanici_cek['id'];
$_SESSION['admin_name'] = $kullanici_cek['name'];
$_SESSION['admin_email'] = $kullanici_cek['email'];
$_SESSION['admin_yetki'] = $kullanici_cek['yetki'];
$_SESSION['admin_super'] = $kullanici_cek['isSuperAdmin'];