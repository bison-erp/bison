<style>
    .icon-logout{color: #C1CCD1; cursor:pointer;}
    .icon-logout:hover{color: #666;}
</style>
<script>
function logoutUser(){
            $.post("ajax.php", {
            action: "logout_user",
        },
                function (data) {
                    window.location.href = "index.php";

                });
}
</script>
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <div class="container-fluid">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.php">
                        <img style="margin-top: 19px;" src="../../assets/admin/layout3/img/logo_erp.png" alt="logo" class="logo-default">
						</a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler"></a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown dropdown-user dropdown-dark tooltips" data-placement="bottom" data-original-title="Profil" onclick="window.location.href='index.php?module=profil';" style="cursor:pointer;">
                            <?php $superadmin = getUserInfoById($_SESSION[$session_name]['superadmin_id']); ?>
                            <div class="col-md-3 col-sm-4" style="color: #A0A7AA; width: 100%; padding: 2px 10px 1px 6px;    line-height: 46px;">
                                <i class="glyphicon glyphicon-user" style="color: #A0A7AA; padding: 0px 21px 0px 6px; "></i> <?php echo $superadmin['fullname']; ?>									</div>
                        </li>

                        <li class="droddown dropdown-separator">
                            <span class="separator"></span>
                        </li>

                        <li class="dropdown dropdown-user " id="logout_icon" style="line-height:57px;">
                            <i style="font-size: 19px;" class="icon-logout tooltips" onclick="logoutUser()" data-placement="bottom" data-original-title="D&eacute;connexion"></i>
                        </li>
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>


        </div>
    </div>
    <!-- END HEADER TOP -->
    <?php include('tpl/menu.php') ?>

</div>
<!-- END HEADER -->