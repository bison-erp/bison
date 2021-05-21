<script>
    function addUpdate() {
        
        var description = $("#description").val();
        var query = $("#query").val();
        var description = $("#description").val();

        if(confirm("Voulez Vous effectuer cette modification à toutes les base de données ?")){
        $.post("ajax.php", {
            action: "add_update",
            description: description,
            query: query,
        },
                function (data) {
                    $.post("<?php echo url() . '/superadmin_connect/updateDatabases'; ?>", {
                        id: data
                    },
                    function (data2) {
                        alert(data2);
                        window.location.href="index.php?module=updates";
                    });

                }
        );

}




    }
</script>
<style>
    table tr td{
        padding:10px;
    }
</style>
<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="index.php?module=updates">Mise à jour</a>
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
            <div class="col-xs-12 col-md-12">

                <div class="form-group">
                    <label for="form_control_1" style="font-size: 13px; color: #899a9a;">Description</label>
                    <textarea id="description" rows="5" class="form-control"></textarea>                                
                </div>
            </div>
            <div class="col-xs-12 col-md-12">

                <div class="form-group">
                    <label for="form_control_1" style="font-size: 13px; color: #899a9a;">Requete SQL</label>
                    <textarea id="query" rows="5" class="form-control"></textarea>                              
                </div>
            </div>
        </div>


        <div style="text-align:center; margin-top:20px;" class="pull-right">
            <a href="index.php?module=updates" class="btn default" >Annuler</a>
            <button class="btn blue" onclick="addUpdate()"><i class="fa fa-check"></i> Exécuter </button>
        </div>
        <div class="clearfix"></div>


    </div>
</div>
<!-- END PAGE CONTENT INNER -->