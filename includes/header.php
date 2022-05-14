<?php
if (!defined("SECURITY"))
    die;
?>

<div class="page-header">
    <nav class="navbar navbar-expand-lg d-flex justify-content-between">
        <div class="" id="headerNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false"><img
                            src="assets/images/avatars/profile-image.png" alt="Kullanıcı Rolleri | MFSoftware Blog"></a>
                    <div class="dropdown-menu dropdown-menu-end profile-drop-menu"
                         aria-labelledby="profileDropDown">
                        <a class="dropdown-item" href="profil.php"><i class="fa fa-user"></i> Profil</a>
                        <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off"></i> Çıkış Yap</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>