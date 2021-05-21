<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">

            <?php
if (isset($main) && is_file($main)) {
    include $main;
}
?>

        </div>
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->