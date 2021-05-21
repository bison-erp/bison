<script type="text/javascript">
$(function() {

    $(".name_prod").focus();
    $('.name_prod').typeahead();

    var fixHelper = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    $("#item_table tbody").sortable({
        // helper: fixHelper,
        axis: 'y'
    });
});
</script>
<style>
.label_calcul {
    line-height: 28px;
}

.mnt_calcul {
    margin-left: -50px;
}
</style>
<?php
$this->load->model('settings/mdl_settings');
?>
<?php
if ($this->mdl_settings->gettypetaxeinvoice() == 0) {
    ?>
<div class="table-responsive">
    <table id="item_table" class="items table table-striped table-condensed table-bordered">
        <thead>
            <tr>
                <th style="width:25px;"></th>
               <!-- <th style="width:25px;">Logo</th>-->
                <th style="width: 200px;"><?php echo lang('item'); ?></th>
                <th><?php echo lang('description'); ?></th>
                <th style="width:100px;"><?php echo lang('quantity'); ?></th>
                <th style="width: 150px;">PU(<span class="devise_view"></span>)</th>
                <th style="display:none;width: 130px;"><?php echo lang('subtotal'); ?> (<span
                        class="devise_view"></span>)</th>
                <th style="display:none;width: 110px;"><?php echo lang('tax_rate'); ?></th>
                <th style="width: 120px;">Total (<span class="devise_view"></span>)</th>
                <th style="width:40px;"></th>
            </tr>
        </thead>
        <tbody class="ui-sortable">
        </tbody>
    </table>
</div>

<div class="col-xs-12 col-md-6" id="remise_bloc">

    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('pourcentage_remise'); ?> :</div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="pourcent_remise_invoice" value="0.00" /></div>
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('montant'); ?> (<span class="devise_view"></span>) :
    </div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="montant_remise_invoice" value="0.000" /></div>
    <br /><br />
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('accompte_remise'); ?> :</div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="pourcent_acompte_invoice" value="0.00" /></div>
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('montant'); ?> (<span class="devise_view"></span>) :
    </div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="montant_acompte_invoice" value="0.000" /></div>
</div>

<div class="col-xs-12 col-md-6" id="total_bloc">
    <div class="col-xs-12 col-md-3"></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span class="amount"></span><span
            style="display:none" id="montant_sous_tot_invoice">0.000</span> <span style="display:none"
            class="devise_view view_after"></span>
    </div>
    <div class="col-xs-12 col-md-3"></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span style="display:none"
            class="amount"></span><span style="display:none" id="tot_tva_invoice">0.000</span> <span
            style="display:none" class="devise_view view_after"></span>
    </div>

    <div class="col-xs-12 col-md-3"><?php echo lang('default_item_timbre'); ?></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span id="timbre_fiscale_span">0.000</span>
        <span class="devise_view view_after"></span>
    </div>
    <div class="col-xs-12 col-md-3"><?php echo lang('total'); ?></div>
    <div class="col-xs-12 col-md-9"  id="bloc_tot_apayer">
        <div class="col-md-4" style="padding:0;">
            <strong class="amount">
                <span class="devise_view view_before" style="display:none;"></span> <span
                    id="total_invoice">0.000</span> <span class="devise_view view_after"> </span>
            </strong>
        </div>
        <div class="col-xs-12 col-md-4 total_a_payer_bloc">
            <?php echo lang('total_a_payer'); ?>
        </div>
        <div class="col-xs-12 col-md-4 total_a_payer_bloc">
            <strong class="amount">
                <span class="devise_view view_before" style="display:none;"></span> <span
                    id="total_a_payer_invoice">0.000</span> <span class="devise_view view_after"></span>
            </strong>
        </div>
    </div>
</div>
<?php } else {?>
<div class="table-responsive">
    <table id="item_table" class="items table table-striped table-condensed table-bordered">
        <thead>
            <tr>
                <th style="width:25px;"></th>
                
               <!-- <th style="width:200px;">Logo</th>-->
                <th style="width: 100px;"><?php echo lang('item'); ?></th>
                <th><?php echo lang('description'); ?></th>
                <th style="width: 100px;"><?php echo lang('quantity'); ?></th>
                <th hidden style="width: 150px;"><?php echo lang('price'); ?> (<span class="devise_view"></span>)</th>
                <th hidden style="width: 130px;"><?php echo lang('subtotal'); ?> (<span class="devise_view"></span>)</th>
                <th hidden style="width: 110px;"><?php echo lang('tax_rate'); ?></th>
                <th hidden style="width: 120px;"><?php echo lang('total'); ?> (<span class="devise_view"></span>)</th>
                <th style="width:40px;"></th>
            </tr>
        </thead>
        <tbody class="ui-sortable">
        </tbody>
    </table>
</div>

<div hidden class="col-xs-12 col-md-6" id="remise_bloc" >

    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('pourcentage_remise'); ?> :</div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="pourcent_remise_invoice" value="0.00" /></div>
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('montant'); ?> (<span class="devise_view"></span>) :
    </div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="montant_remise_invoice" value="0.000" /></div>
    <br /><br />
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('accompte_remise'); ?> :</div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="pourcent_acompte_invoice" value="0.00" /></div>
    <div class="col-xs-12 col-md-3 label_calcul"><?php echo lang('montant'); ?> (<span class="devise_view"></span>) :
    </div>
    <div class="col-xs-12 col-md-3 mnt_calcul"><input class="input-sm form-control" type="text"
            id="montant_acompte_invoice" value="0.000" /></div>
</div>

<div hidden class="col-xs-12 col-md-6" id="total_bloc">
    <div class="col-xs-12 col-md-3"><?php echo lang('subtotal'); ?></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span class="amount"></span><span
            id="montant_sous_tot_invoice">0.000</span> <span class="devise_view view_after"></span>
    </div>
    <div class="col-xs-12 col-md-3"><?php echo lang('item_tax'); ?></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span class="amount"></span><span
            id="tot_tva_invoice">0.000</span> <span class="devise_view view_after"></span>
    </div>

    <div class="col-xs-12 col-md-3"><?php echo lang('default_item_timbre'); ?></div>
    <div class="col-xs-12 col-md-9">
        <span class="devise_view view_before" style="display:none;"></span> <span id="timbre_fiscale_span">0.000</span>
        <span class="devise_view view_after"></span>
    </div>
    <div class="col-xs-12 col-md-3"><?php echo lang('total'); ?></div>
    <div class="col-xs-12 col-md-9" id="bloc_tot_apayer">
        <div class="col-md-4" style="padding:0;">
            <strong class="amount">
                <span class="devise_view view_before" style="display:none;"></span> <span
                    id="total_invoice">0.000</span> <span class="devise_view view_after"> </span>
            </strong>
        </div>
        <div class="col-xs-12 col-md-4 total_a_payer_bloc">
            <?php echo lang('total_a_payer'); ?>
        </div>
        <div class="col-xs-12 col-md-4 total_a_payer_bloc">
            <strong class="amount">
                <span class="devise_view view_before" style="display:none;"></span> <span
                    id="total_a_payer_invoice">0.000</span> <span class="devise_view view_after"></span>
            </strong>
        </div>
    </div>
</div>
<?php }?>