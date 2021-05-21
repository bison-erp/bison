<script>
function editClient() {
    var nom = $("#nom").val();
    var id_client = $("#id_client").val();
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
    var pack_id = $("#pack_id").val();
    var licence_key = $("#licence_key").text();
    var status = $("#status").val();
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

    if (error == 0) {
        $.post("ajax.php", {
                action: "edit_client",
                nom: nom,
                id_client: id_client,
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
                pack_id: pack_id,
                status: status,
            },
            function(data) {
                $("#message_alert_succees").show();
                //                          alert(data);
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


        <div class="alert alert-success" style="display:none;" id="message_alert_succees">
            <button class="close" data-close="alert"></button>
            <span>
                Mise à jour effectu&eacute;e avec succ&egrave;es. </span>
        </div>

        <input type="hidden" id="id_client" value="<?php echo $client['abonne_id']; ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nom</label>
                    <input type="text" id="nom" class="form-control" placeholder="Nom du client"
                        value="<?php echo $client['nom']; ?>">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Pr&eacute;nom</label>
                    <input type="text" id="prenom" class="form-control" placeholder="Pr&eacute;nom du client"
                        value="<?php echo $client['prenom']; ?>">

                </div>
            </div>
            <!--/span-->
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Site Web</label>
                    <input type="text" id="website" class="form-control" placeholder="Site web"
                        value="<?php echo $client['site_web']; ?>">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Adresse Email"
                        value="<?php echo $client['email']; ?>">

                </div>
            </div>
            <!--/span-->
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">N&ordm; de T&eacute;l&eacute;phone</label>
                    <input type="text" id="telephone" class="form-control"
                        placeholder="N&ordm; de T&eacute;l&eacute;phone" value="<?php echo $client['telephone']; ?>">
                </div>
            </div>
            <!--/span-->
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Portable</label>
                    <input type="text" id="mobile" class="form-control" placeholder="Portable"
                        value="<?php echo $client['mobile']; ?>">

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Fax</label>
                    <input type="text" id="fax" class="form-control" placeholder="Fax"
                        value="<?php echo $client['fax']; ?>">

                </div>
            </div>
            <!--/span-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Ville</label>
                <input type="text" id="ville" class="form-control" placeholder="Ville"
                    value="<?php echo $client['ville']; ?>">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Code postal</label>
                <input type="text" id="code_postal" class="form-control" placeholder="ZIP"
                    value="<?php echo $client['code_postal']; ?>">

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Pays</label>
                <input type="text" id="pays" class="form-control" placeholder="Pays"
                    value="<?php echo $client['pays']; ?>">

            </div>
        </div>
        <!--/span-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Adresse</label>
                <textarea id="adresse" class="form-control"
                    placeholder="Adresse"><?php echo $client['adresse']; ?></textarea>
            </div>
        </div>
        <!--/span-->

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Soci&eacute;t&eacute;</label>
                <input type="text" id="societe" class="form-control" placeholder="Nom de la Soci&eacute;t&eacute;"
                    value="<?php echo $client['societe']; ?>">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Matricule fiscale</label>
                <input type="text" id="matricule_fiscale" class="form-control" placeholder="Matricule fiscale"
                    value="<?php echo $client['matricule_fiscale']; ?>">
            </div>
        </div>
        <!--/span-->
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Registre de commerce</label>
                <input type="text" id="registre_commerce" class="form-control" placeholder="Registre de commerce"
                    value="<?php echo $client['registre_commerce']; ?>">
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
                    <option <?php if ($client['statut'] == "1") {
    echo "selected";
}
?> value="1">Actif</option>
                    <option <?php if ($client['statut'] == "0") {
    echo "selected";
}
?> value="0">Non Actif</option>
                </select>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Licence Key</label>
                <div class="form-control">

                    <div style="float:left;font-family: monospace;" id="licence_key">
                        <?php echo $client['licence_key']; ?></div>
                    <!--<div style="float:right"> <i class="fa fa-refresh tooltips" style="cursor:pointer;" data-container="body" data-placement="top" data-original-title="G&eacute;n&eacute;rer licence key" onclick="regenerateLicence()"></i></div>-->

                </div>


            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Pack du client</label>
                <select id="pack_id" class="form-control">
                    <?php $packs = getPacksList();?>
                    <?php if (count($packs) != 0) {?>
                    <?php foreach ($packs as $pack) {?>
                    <option value="<?php echo $pack['pack_id']; ?>"
                        <?php if ($client['pack_id'] == $pack['pack_id']) {echo "selected";}?>>
                        <?php echo utf8_encode($pack['pack_name']); ?></option>
                    <?php }?>
                    <?php }?>
                </select>
            </div>
        </div>

        <!--/span-->


    </div>
    <!--/row-->


    <div style="text-align:right">
        <a href="index.php?module=clients" class="btn default">Cancel</a>
        <button class="btn blue" onclick="editClient()"><i class="fa fa-check"></i> Save</button>
    </div>







</div>
</div>
<!-- END PAGE CONTENT INNER -->