<!-- BEGIN HEADER MENU -->
<div class="page-header-menu">
    <div class="container">
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu ">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Tableau de bord</a>
                </li>

                <li class="menu-dropdown classic-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Clients <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">


                        <li>
                            <a href="index.php?module=clients&action=add">
                                <i class="icon-pencil"></i>
                                Ajouter un client </a>
                        </li>
                        <li>
                            <a href="index.php?module=clients">
                                <i class="icon-list"></i>
                                Liste des clients </a>
                        </li>

                    </ul>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Liste des Packs <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">


                        <li>
                            <a href="index.php?module=packs&action=add">
                                <i class="icon-pencil"></i>
                                Ajouter un pack </a>
                        </li>
                        <li>
                            <a href="index.php?module=packs">
                                <i class="icon-list"></i>
                                Liste des Packs </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="index.php?module=updates">Mise à jour</a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                        Modéles des emails <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li>
                            <a href="index.php?module=packs&action=addmodele">
                                <i class="icon-pencil"></i>
                                Ajouter un modéle </a>
                        </li>
                        <li>
                            <a href="index.php?module=packs&action=listmodele">
                                <i class="icon-list"></i>
                                Liste des modéles </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
        <!-- END MEGA MENU -->
        <br>
        <div style=" color: #bcc2cb; text-align: right;margin-top: -2px;">
            <span id="connect_client" style="text-align: right; width: 100%; color:#FFF;"></span>

        </div>
    </div>
</div>
<!-- END HEADER MENU -->

<script>
showConnected() ;
    function showConnected() {
        $.get("<?php echo url() . '/superadmin_connect/getLicenceConnected'; ?>", function (data) {

            var parsed = JSON.parse(data);
            json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            connected = json_response[0];
            licence = json_response[1];
            if (connected == true) {
                $('#connect_client').html('Connecté en tant que : <b style="color:#D00">' + licence + '</b>');
            }
            else {
                $('#connect_client').html('');
            }
        });
    }

    window.setInterval(function () {
        showConnected();
    }, 5000);
</script>
<?php

function url() {
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}
?>