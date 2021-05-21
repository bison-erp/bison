<link href="<?php echo base_url(); ?>assets/admin/pages/css/timeline-old.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE CONTENT INNER -->
<div class="portlet light">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="timeline">
                    <?php if (!empty($versions)) {?>
                    <?php foreach ($versions as $version) {?>
                    <?php
$date_time_version = $version->created;
    $date_time_array = explode(" ", $date_time_version);
    $date_version = $date_time_array[0];
    $time_version = $date_time_array[1];
    ?>
                    <li class="timeline-blue">
                        <div class="timeline-time">
                            <span class="date">
                                <?php echo date_from_mysql($date_version, 1); ?> </span>
                            <span class="time">
                                <?php echo substr($time_version, 0, 5); ?> </span>
                        </div>
                        <div class="timeline-icon">
                            <i class="fa fa-bookmark-o"></i>
                        </div>
                        <div class="timeline-body">
                            <h2>Version <?php echo $version->version; ?></h2>
                            <div class="timeline-content">
                                <?php echo $version->description; ?>
                            </div>

                        </div>
                    </li>
                    <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT INNER -->