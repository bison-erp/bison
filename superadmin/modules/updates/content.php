
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="index.php">Home</a><i class="fa fa-circle"></i>
    </li>

    <li class="active">
        <?php echo $title; ?>
    </li>
</ul>
<div class="">
    <a href="index.php?module=updates&action=add" class="btn btn-sm green" style="margin: 14px 22px;"><i class="fa fa-plus"></i> Nouvelle mise à jour </a>
</div>
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
        <div class="row margin-bottom-30">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:70px;text-align:center;">Version</th>
                                <th>Description</th>
                                <th>Requête</th>
                                <th style="width:150px;text-align:center;">Date</th>
                                <th style="width:50px;text-align:center;"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($updates) != 0) { ?>
                                <?php foreach ($updates as $update) { ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $update['version']; ?></td>
                                        <td style="min-width: 300px;"><?php echo utf8_encode($update['description']); ?></td>
                                        <td style="min-width: 300px;"><?php echo utf8_encode($update['database_query']); ?></td>
                                        <td style="text-align:center;"><?php echo dateTimeSlashes($update['created']); ?></td>
                                        <td style="text-align:center;"><a href="index.php?module=updates&action=edit&id=<?php echo $update['id']; ?>" class="btn default btn-xs blue "><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/row-->

    </div>
</div>
<!-- END PAGE CONTENT INNER -->