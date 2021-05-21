<script>
    function updateProfil() {
        var fullname = $("#fullname").val();
        var password = $("#password").val();
        var password2 = $("#password2").val();

        var error = 0;
        var update_password = 0;

        if (password.trim() != "") {

            update_password = 1;

            if (password.length < 4) {
                error = 1;
                $("#password").parent().addClass("has-error");
            } else {
                $("#password").parent().removeClass("has-error");
            }

            if (password2 != password) {
                error = 1;
                $("#password2").parent().addClass("has-error");
            } else {
                $("#password2").parent().removeClass("has-error");
            }
        }


        if (error == 0) {
            $.post("ajax.php", {
                action: "update_profil",
                fullname: fullname,
                update_password: update_password,
                password: password,
            },
                    function (data) {
//                        window.location.href = "index.php?module=profil";
                         $("#message_alert_succees").show();
//                        document.write(data);

                    });
        }


    }
</script>

<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <!--li>
            <a href="page_about.html">Pages</a>
            <i class="fa fa-circle"></i>
    </li-->
    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="portlet light">
    <div class="portlet-title" >
        <div class="caption">
            <i class="fa fa-cogs font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase"><?php echo $title; ?></span>
        </div>

    </div>
    <div class="portlet-body">
                <div class="alert alert-success" style="display:none;" id="message_alert_succees">
			<button class="close" data-close="alert"></button>
			<span>
			Mise à jour effectu&eacute;e avec succ&egrave;es. </span>
		</div>
        <div class="row margin-bottom-30">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Nom Complet</label>
                            <input type="text" id="fullname" class="form-control" placeholder="Nom Complet" value="<?php echo $superadmin['fullname']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Changer mot de passe</label>
                            <input type="password" id="password" class="form-control" placeholder="Mot de passe">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Confirmation mot de passe</label>
                            <input type="password" id="password2" class="form-control" placeholder="Confirmation mot de passe">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--/row-->

    <div style="text-align:right">
        <a href="index.php?module=profil" class="btn default" >Cancel</a>
        <button class="btn blue" onclick="updateProfil()"><i class="fa fa-check"></i> Save</button>
    </div>
</div>
</div>
<!-- END PAGE CONTENT INNER -->