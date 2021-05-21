<style>

</style>
<div id="headerbar_empty">
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Aperçu Devis </span>
                </div>

            </div>
            <div class="portlet-body">
<?php foreach($users as $user){ ?>
                <div class="row">                 
                    <div class="col-xs-12 col-md-12">


                        <div class="panel panel-default overview">

                            <div class="panel-heading">
                                <b><i class="fa fa-bar-chart fa-margin"></i> <?php echo $user->user_name." (".$user->user_code.")"; ?> </b>
                                <span class="pull-right text-muted"><?php echo "<b>(".$user->designation.")</b>"; ?> </span>
                                
                            </div>



                            <table   class="table table-striped table-bordered table-hover no-footer" >
                                <thead>
                                <tr style="font-weight: bold;">
                                    <td>

                                    </td>
                                    <?php foreach ($devises as $devise) { ?>
                                        <td class="amount">
                                            <span>
                                                <?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?>
                                            </span>
                                        </td>
                                    <?php } ?>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($quote_statuses as $key => $value) { ?>
                                    <tr style="font-weight: bold;">
                                        <td >
                                            <a >
                                                <?php echo $value['label']; ?>
                                            </a>
                                        </td>
                                        <?php foreach ($devises as $devise) { ?>
                                            <td class="amount">
                                                <span class="<?php echo $value['class']; ?>">
                                                    <span class="badge bg-grey-cascade pull-right "><?php echo rand(1, 11) ?></span>
                                                     <?php echo format_devise(rand(10000, 999999)/100, $devise->devise_id); ?>
                                                </span>
                                            </td>
                                        <?php } ?>

                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot >
                                <tr style="font-weight: bold;" class="bg-grey">
                                    <td>
                                        TOTAL
                                    </td>
                                    <?php foreach ($devises as $devise) { ?>
                                        <td class="amount">
                                            <span class="white">
                                                <span class="badge bg-grey-cascade pull-right "><?php echo rand(20, 31) ?></span>
                                                 <?php echo format_devise(27512.21, $devise->devise_id); ?>
                                            </span>
                                        </td>
                                    <?php } ?>

                                </tr>
                                </tfoot>
                                
                            </table>




                        </div>


                    </div>    


                </div>
<?php } ?>

            </div>
        </div>





    </div>
</div>


