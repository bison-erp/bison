<script>
    function editUpdate() {
        
        var description = $("#description").val();
        var id_update = $("#id_update").val();


        $.post("ajax.php", {
            action: "edit_update",
            description: description,
            id_update: id_update,
        },
                function (data) {
                     window.location.href="index.php?module=updates";
                }
        );






    }
</script>
<style>
    table tr td{
        padding:10px;
    }
</style>
<input type="hidden" id="id_update" value="<?php echo $update['id']; ?>">
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
                    <textarea id="description" rows="5" class="form-control"><?php echo $update['description']; ?></textarea>                                
                </div>
            </div>
            <div class="col-xs-12 col-md-12">

                <div class="form-group">
                    <label for="form_control_1" style="font-size: 13px; color: #899a9a;">Requete SQL</label>
                    <textarea id="query" readonly="" rows="5" class="form-control"><?php echo $update['database_query']; ?></textarea>                              
                </div>
            </div>
            <div class="col-xs-12 col-md-12">

                <div class="form-group">
                    <label for="form_control_1" style="font-size: 13px; color: #899a9a;">Version</label>
                    <input type="text" readonly="" class="form-control" value="<?php echo $update['version']; ?>">                              
                </div>
            </div>
            <div class="col-xs-12 col-md-12">

                <div class="form-group">
                    <label for="form_control_1" style="font-size: 13px; color: #899a9a;">Date création</label>
                    <input type="text" readonly="" class="form-control" value="<?php echo dateTimeSlashes($update['created']); ?>">                              
                </div>
            </div>
        </div>


        <div style="text-align:center; margin-top:20px;" class="pull-right">
            <a href="index.php?module=updates" class="btn default" >Annuler</a>
            <button class="btn blue" onclick="editUpdate()"><i class="fa fa-check"></i> Enregistrer </button>
        </div>
        <div class="clearfix"></div>


    </div>
</div>
<!-- END PAGE CONTENT INNER -->