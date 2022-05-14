<?php
if (!defined("SECURITY"))
    die;
?>

<?php
require_once 'inc/baglan.php';
require_once 'inc/class.myhelper.php';
?>


<?php
if (!isset($_SESSION['adminlogin'])) {
    header("Location: login.php");
}
?>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Responsive Admin Dashboard Template">
<meta name="keywords" content="admin,dashboard">
<meta name="author" content="stacks">
<!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<!-- Title -->
<title>Circl - Responsive Admin Dashboard Template</title>

<!-- Styles -->
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
<link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
<link href="assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">


<!-- Theme Styles -->
<link href="assets/css/main.min.css" rel="stylesheet">
<link href="assets/css/custom.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->