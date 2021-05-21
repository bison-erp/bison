<script>
function addClient() {
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();
    var website = $("#website").val();
    var email = $("#email").val();
    var telephone = $("#telephone").val();
    var mobile = $("#mobile").val();
    var fax = $("#fax").val();
    var ville = $("#ville").val();
    var code_postal = $("#code_postal").val();
    var pays = $("#pays").val();
    var adresse = $("#adresse").val();
    var societe = $("#societe").val();
    var matricule_fiscale = $("#matricule_fiscale").val();
    var registre_commerce = $("#registre_commerce").val();
    var licence_key = $("#licence_key").text().trim();
    var status = $("#status").val();
    var password = $("#password").val();
    var password2 = $("#password2").val();
    var pack_id = $("#pack_id").val().trim();
    //        alert(nom + " | " + prenom + " | " + website + " | " + email + " | " + telephone + " | " + mobile + " | " + fax + " | " + ville + " | " + code_postal + " | " + pays + " | " + adresse + " | " + complement + " | " + societe + " | " + matricule_fiscale + " | " + registre_commerce + " | " + status);
    var error = 0;
    var error_msg = 0;

    if (nom.length < 2) {
        error = 1;
        $("#nom").parent().addClass("has-error");
    } else {
        $("#nom").parent().removeClass("has-error");
    }
    if (prenom.length < 2) {
        error = 1;
        $("#prenom").parent().addClass("has-error");
    } else {
        $("#prenom").parent().removeClass("has-error");
    }
    if (societe.length < 2) {
        error = 1;
        $("#societe").parent().addClass("has-error");
    } else {
        $("#societe").parent().removeClass("has-error");
    }
    if (societe.length < 2) {
        error = 1;
        $("#societe").parent().addClass("has-error");
    } else {
        $("#societe").parent().removeClass("has-error");
    }

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

    if (error == 0) {
        $.post("ajax.php", {
                action: "add_client",
                nom: nom,
                prenom: prenom,
                website: website,
                email: email,
                telephone: telephone,
                mobile: mobile,
                fax: fax,
                ville: ville,
                code_postal: code_postal,
                pays: pays,
                adresse: adresse,
                societe: societe,
                matricule_fiscale: matricule_fiscale,
                registre_commerce: registre_commerce,
                licence_key: licence_key,
                status: status,
                password: password,
                pack_id: pack_id,
            },
            function(data) {
                window.location.href = "index.php?module=clients";
                //                        alert(data);
                //                        document.write(data);

            });
    }


}

function regenerateLicence() {
    $.post("ajax.php", {
            action: "regenerer_licence_key",
        },
        function(data) {
            $("#licence_key").text(data);

        });
}

function generatePassword() {
    $.post("ajax.php", {
            action: "generatePassword",
        },
        function(data) {
            $("#password").val(data);
            $("#password2").val(data);

        });
}
</script>

<style>
textarea {
    max-width: 100%;
}
</style>

<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="index.php?module=clients">Clients</a>
        <i class="fa fa-circle"></i>
    </li>
    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase"><?php echo $title; ?></span>
        </div>

    </div>
    <div class="portlet-body">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nom</label>
                    <input type="text" id="nom" class="form-control" placeholder="Nom du client">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Pr&eacute;nom</label>
                    <input type="text" id="prenom" class="form-control" placeholder="Pr&eacute;nom du client">

                </div>
            </div>
            <!--/span-->
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Site Web</label>
                    <input type="text" id="website" class="form-control" placeholder="Site web">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Adresse Email">

                </div>
            </div>
            <!--/span-->
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Mot de passe</label>
                    <input type="text" id="password" class="form-control" placeholder="Mot de passe">
                    <div style="float:right"> <i class="fa fa-refresh tooltips"
                            style="cursor:pointer; position: absolute; top: 37px; right: 24px;" data-container="body"
                            data-placement="top" data-original-title="G&eacute;n&eacute;rer mot de passe"
                            onclick="generatePassword()"></i></div>

                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Confirmation mot de passe</label>
                    <input type="text" id="password2" class="form-control" placeholder="Confirmation mot de passe">

                </div>
            </div>
            <!--/span-->
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">N&ordm; de T&eacute;l&eacute;phone</label>
                    <input type="text" id="telephone" class="form-control"
                        placeholder="N&ordm; de T&eacute;l&eacute;phone">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Portable</label>
                    <input type="text" id="mobile" class="form-control" placeholder="Portable">

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Fax</label>
                    <input type="text" id="fax" class="form-control" placeholder="Fax">

                </div>
            </div>
            <!--/span-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Ville</label>
                <input type="text" id="ville" class="form-control" placeholder="Ville">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Code postal</label>
                <input type="text" id="code_postal" class="form-control" placeholder="ZIP">

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Pays</label>
                <input type="text" id="pays" class="form-control" placeholder="Pays">

            </div>
        </div>
        <!--/span-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Adresse</label>
                <textarea id="adresse" class="form-control" placeholder="Adresse"></textarea>
            </div>
        </div>
        <!--/span-->

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Soci&eacute;t&eacute;</label>
                <input type="text" id="societe" class="form-control" placeholder="Nom de la Soci&eacute;t&eacute;">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Matricule fiscale</label>
                <input type="text" id="matricule_fiscale" class="form-control" placeholder="Matricule fiscale">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Registre de commerce</label>
                <input type="text" id="registre_commerce" class="form-control" placeholder="Registre de commerce">
            </div>
        </div>
        <!--/span-->
    </div>


    <!--/row-->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Status</label>
                <select class="form-control" id="status">
                    <option value="1">Actif</option>
                    <option value="0">Non Actif</option>
                </select>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Licence Key</label>
                <div class="form-control">

                    <div style="float:left;font-family: monospace;" id="licence_key"><?php echo generateLicenceKey(); ?>
                    </div>
                    <div style="float:right"> <i class="fa fa-refresh tooltips" style="cursor:pointer;"
                            data-container="body" data-placement="top"
                            data-original-title="G&eacute;n&eacute;rer licence key" onclick="regenerateLicence()"></i>
                    </div>

                </div>


            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Pack du client</label>
                <select id="pack_id" class="form-control">
                    <?php $packs = getPacksList();?>
                    <?php if (count($packs) != 0) {?>
                    <?php foreach ($packs as $pack) {?>
                    <option value="<?php echo $pack['pack_id']; ?>"><?php echo utf8_encode($pack['pack_name']); ?>
                    </option>
                    <?php }?>
                    <?php }?>
                </select>
            </div>
        </div>


    </div>
    <!--/row-->


    <div style="text-align:right">
        <a href="index.php?module=clients" class="btn default">Cancel</a>
        <button class="btn blue" onclick="addClient()"><i class="fa fa-check"></i> Save</button>
    </div>







</div>
</div>
<!-- END PAGE CONTENT INNER -->