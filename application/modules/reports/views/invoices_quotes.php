<style>

    .datepicker table tr td.day:hover,.datepicker table tr td.day.focused{background:#eee;cursor:pointer;border-radius: 4px;    text-align: center;}
    .datepicker .active{  background-color: #4B8DF8 !important;background-image: none !important;filter: none !important;border-radius: 4px;
        color: #FFF;}
</style>
<div id="headerbar_empty">
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Meilleurs Devis / Factures</span>
                </div>

            </div>
            <div class="portlet-body">

                <div class="row">                 
                    <div class="col-xs-12 col-md-6">
                        <?php foreach ($devises as $devise) { ?>

                            <div class="panel panel-default overview">

                                <div class="panel-heading">
                                    <b><i class="fa fa-bar-chart fa-margin"></i> Meilleurs Factures (<?php echo $devise->devise_symbole; ?>)</b>
                                    <span class="pull-right text-muted"></span>
                                </div>

                                <table  class="table table-striped table-bordered table-hover no-footer" >
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <td>Facture</td>
                                            <td>Montant</td>
                                            <td>Status</td>
                                            <td>Client</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i < 6; $i++) { ?>
                                            <tr>
                                                <td><a href="<?php echo site_url("invoices/view/1"); ?>"><?php echo $i; ?></a></td>
                                                <td><?php echo format_devise(30.000, $devise->devise_id); ?></td>
                                                <td>Payé</td>
                                                <td><a href="<?php echo site_url("clients/view/1"); ?>">Client <?php echo $i; ?></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                        <?php } ?>
                    </div>    
                    <div class="col-xs-12 col-md-6">
                        <?php foreach ($devises as $devise) { ?>

                            <div class="panel panel-default overview">

                                <div class="panel-heading">
                                    <b><i class="fa fa-bar-chart fa-margin"></i> Meilleurs Devis (<?php echo $devise->devise_symbole; ?>)</b>
                                    <span class="pull-right text-muted"></span>
                                </div>
                                <table  class="table table-striped table-bordered table-hover no-footer" >
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <td>Facture</td>
                                            <td>Montant</td>
                                            <td>Status</td>
                                            <td>Client</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i < 6; $i++) { ?>
                                            <tr>
                                                <td><a href="<?php echo site_url("quotes/view/1"); ?>"><?php echo $i; ?></a></td>
                                                <td><?php echo format_devise(rand(0, 30), $devise->devise_id); ?></td>
                                                <td>Payé</td>
                                                <td><a href="<?php echo site_url("clients/view/1"); ?>">Client <?php echo $i; ?></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>

                        <?php } ?>
                    </div>    

                </div>

            </div>
        </div>




        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Aperçu Factures</span>
                </div>
                <div class="pull-right" style="width: 50%;     padding: 4px;">

                    <div class=" pull-right" style="margin: 0 0 10px; padding: 0;">
                        <div class="quote-properties has-feedback">
                               <button type="button" class="btn blue btn-sm">Valider</button> 
                        </div>                    
                    </div>
                    <div class=" pull-right" style="margin: 0 10px; padding: 0; width: 130px;">
                        <div class="has-feedback">
                            <div class="input-group">
                                <input name="from" style="padding: 0 5px;" class="form-control input-sm datepicker"  value="<?php echo date('d/m/Y'); ?>">
                                <div class="form-control-focus" ></div>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>                    
                    </div>
                    <div class=" pull-right" style="margin: 0 10px; padding: 0; width: 130px;">
                        <div class="has-feedback">
                            <div class="input-group">
                                <input name="from" style="padding: 0 5px;" class="form-control input-sm datepicker"  value="<?php echo date('d/m/Y'); ?>">
                                <div class="form-control-focus" ></div>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>                    
                    </div>


                </div>

            </div>
            <div class="portlet-body">
                <div class="row">
                    <?php foreach ($devises as $devise) { ?>
                        <div class="col-xs-12 col-md-12">


                            <div class="panel panel-default overview">

                                <div class="panel-heading">
                                    <b><i class="fa fa-bar-chart fa-margin"></i> Aperçu des factures (<?php echo $devise->devise_symbole; ?>)</b>
                                    <span class="pull-right text-muted"></span>
                                </div>
                                <table  class="table table-striped table-bordered table-hover no-footer" >
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <td>Date</td>
                                            <?php foreach ($invoice_statuses as $key => $value) { ?>
                                                <td class="<?php echo $value['class']; ?>"><?php echo $value['label']; ?></td>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < 10; $i++) { ?>
                                            <tr>
                                                <td><b><?php echo date("d/m/Y"); ?></b></td>
                                                <?php foreach ($invoice_statuses as $key => $value) { ?>
                                                <td class="<?php echo $value['class']; ?>"><b><?php echo format_devise(rand(1000, 9999), $devise->devise_id); ?></b></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    <?php } ?>
                </div>  


            </div>
        </div>


        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Aperçu Devis</span>
                </div>
                                <div class="pull-right" style="width: 50%;    padding: 4px;" >

                    <div class=" pull-right" style="margin: 0 0 10px; padding: 0;">
                        <div class="quote-properties has-feedback">
                               <button type="button" class="btn blue btn-sm">Valider</button> 
                        </div>                    
                    </div>
                    <div class=" pull-right" style="margin: 0 10px; padding: 0; width: 130px;">
                        <div class="has-feedback">
                            <div class="input-group">
                                <input name="from" style="padding: 0 5px;" class="form-control input-sm datepicker"  value="<?php echo date('d/m/Y'); ?>">
                                <div class="form-control-focus" ></div>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>                    
                    </div>
                    <div class=" pull-right" style="margin: 0 10px; padding: 0; width: 130px;">
                        <div class="has-feedback">
                            <div class="input-group">
                                <input name="from" style="padding: 0 5px;" class="form-control input-sm datepicker"  value="<?php echo date('d/m/Y'); ?>">
                                <div class="form-control-focus" ></div>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>                    
                    </div>


                </div>

            </div>
            <div class="portlet-body">
                <div class="row">
                    <?php foreach ($devises as $devise) { ?>
                        <div class="col-xs-12 col-md-12">


                            <div class="panel panel-default overview">

                                <div class="panel-heading">
                                    <b><i class="fa fa-bar-chart fa-margin"></i> Aperçu des factures (<?php echo $devise->devise_symbole; ?>)</b>
                                    <span class="pull-right text-muted"></span>
                                </div>
                                <table  class="table table-striped table-bordered table-hover no-footer" >
                                    <thead>
                                        <tr style="font-weight: bold;">
                                            <td>Date</td>
                                            <?php foreach ($quote_statuses as $key => $value) { ?>
                                                <td class="<?php echo $value['class']; ?>"><?php echo $value['label']; ?></td>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < 10; $i++) { ?>
                                            <tr>
                                                <td><b><?php echo date("d/m/Y"); ?></b></td>
                                                <?php foreach ($quote_statuses as $key => $value) { ?>
                                                <td class="<?php echo $value['class']; ?>"><b><?php echo format_devise(rand(1000,9999), $devise->devise_id); ?></b></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    <?php } ?>
                </div>  


            </div>
        </div>



    </div>
</div>


