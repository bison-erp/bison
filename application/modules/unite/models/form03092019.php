<form method="post" class="form-horizontal">
    <?php
if ($typetaxe == 1) {
    ?>

    <div id="headerbar" style="margin-top: -3%;">
        <?php $this->layout->load_view('layout/header_buttons');?>
    </div><br>

    <div id="content" style="margin-top: 20px;">

        <?php $this->layout->load_view('layout/alerts');?>

        <div class="row">
            <div class="col-md-6 ">
                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">
                                <?php if ($this->mdl_products->form_value('product_id')): ?>
                                #<?php echo $this->mdl_products->form_value('product_id'); ?>&nbsp;
                                <?php echo $this->mdl_products->form_value('product_name'); ?>
                                <?php else: ?>
                                <?php echo lang('new_product'); ?>
                                <?php endif;?></span>
                        </div>

                    </div>
                    <br>
                    <!--                    <pre><?php print_r($this->mdl_products->form_values);?>
<?php print_r($prix_ventes);?>
                    </pre>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input has-info"
                                style="margin: 0px 11px 20px;width: 95%;">
                                <select class="form-control" name="family_id" id="family_id">
                                    <!--<option value=""></option>-->
                                    <?php foreach ($families as $family) {?>
                                    <option value="<?php echo $family->family_id; ?>"
                                        <?php if ($this->mdl_products->form_value('family_id') == $family->family_id) {?>selected="selected"
                                        <?php }?>><?php echo $family->family_name; ?></option>
                                    <?php }?>
                                </select>
                                <div class="form-control-focus" style="margin: 0px;"></div>
                                <label for="form_control_1"
                                    style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('select_family'); ?><span
                                        style="color: #F60922; margin-left: 5px;">*</span></label>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-6">
                                    <input value="<?php echo $this->mdl_products->form_value('product_sku'); ?>"
                                        type="text" class="form-control" id="product_sku" name="product_sku">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_sku'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>

                                </div>
                                <div class="col-md-6">
                                    <input value="<?php echo $this->mdl_products->form_value('product_name'); ?>"
                                        type="text" class="form-control" id="product_name" name="product_name">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_name'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <textarea name="product_description" rows="1" id="product_description"
                                        class="form-control"><?php echo $this->mdl_products->form_value('product_description'); ?></textarea>
                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_description'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-6">
                                    <input value="<?php echo $this->mdl_products->form_value('purchase_price'); ?>"
                                        type="text" class="form-control" name="purchase_price" id="purchase_price">

                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('purchase_price'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="tax_rate_id" id="tax_rate_id">
                                        <!--<option value=""></option>-->
                                        <?php foreach ($tax_rates as $tax_rate) {?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                            <?php if ($this->mdl_products->form_value('tax_rate_id') == $tax_rate->tax_rate_id) {?>
                                            selected="selected" <?php }?>><?php echo $tax_rate->tax_rate_name; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('tax_rate'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
            </div>


            <div class="col-md-6  ">
                <div class="portlet light" style="min-height: 375px !important;">
                    <br>
                    <?php
if ($this->mdl_products->form_value('product_id')) { //cas de formulaire de modification
        foreach ($devises as $value) {
            $prix = '';
            $tva = '';
            foreach ($prix_ventes as $pvalue) { ///echo '<pre>'; print_r($pvalue);echo '</pre>';
                if (($pvalue->id_devise == $value->devise_id)) {
                    $prix = $pvalue->prix_vente;
                    $tva = $pvalue->id_tax;
                }}?>

                    <div class="row">
                        <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">


                                <div class="col-md-6">
                                    <input value="<?php echo $prix; ?>" type="text" class="calcvente form-control"
                                        name="prx[<?php echo $value->devise_id; ?>][product_price]"
                                        id="prx[<?php echo $value->devise_id; ?>][product_price]">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>



                                </div>

                                <div class="col-md-6">
                                    <select class="form-control"
                                        name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                        id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                        <!--<option value=""></option>-->
                                        <?php foreach ($tax_rates as $tax_rate) {?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                            <?php if ($tva == $tax_rate->tax_rate_id) {?> selected="selected" <?php }?>>
                                            <?php echo $tax_rate->tax_rate_name; ?></option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('tax_rate'); ?></label>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
}

    } else {
        foreach ($devises as $value) {
            ?>
                    <div class="row">
                        <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                    id="prx[<?php echo $value->devise_id; ?>][devise]"
                                    value="<?php echo $value->devise_id; ?>">


                                <div class="col-md-6">
                                    <input value="" type="text" class="calcvente form-control"
                                        name="prx[<?php echo $value->devise_id; ?>][product_price]"
                                        id="prx[<?php echo $value->devise_id; ?>][product_price]">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>

                                </div>

                                <div class="col-md-6">
                                    <select class="form-control"
                                        name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                        id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                        <!--<option value=""></option>-->
                                        <?php foreach ($tax_rates as $tax_rate) {?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>">
                                            <?php echo $tax_rate->tax_rate_name; ?></option>
                                        <?php }?>
                                    </select>
                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('tax_rate'); ?></label>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
}
    }
    ?>


                    <br> <br>

                </div>




            </div>


        </div>





    </div>

    <div id="headerbar">
        <?php $this->layout->load_view('layout/header_buttons');?>
    </div>
    </div>
    <?php } else {?>
    <div id="headerbar" style="margin-top: -3%;">
        <?php $this->layout->load_view('layout/header_buttons');?>
    </div><br>

    <div id="content" style="margin-top: 20px;">

        <?php $this->layout->load_view('layout/alerts');?>

        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">
                                <?php if ($this->mdl_products->form_value('product_id')): ?>
                                #<?php echo $this->mdl_products->form_value('product_id'); ?>&nbsp;
                                <?php echo $this->mdl_products->form_value('product_name'); ?>
                                <?php else: ?>
                                <?php echo lang('new_product'); ?>
                                <?php endif;?></span>
                        </div>

                    </div>
                    <br>
                    <!--                    <pre><?php print_r($this->mdl_products->form_values);?>
<?php print_r($prix_ventes);?>
                    </pre>-->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input has-info"
                                style="margin: 0px 11px 20px;width: 95%;">
                                <select class="form-control" name="family_id" id="family_id">
                                    <!--<option value=""></option>-->
                                    <?php foreach ($families as $family) {?>
                                    <option value="<?php echo $family->family_id; ?>"
                                        <?php if ($this->mdl_products->form_value('family_id') == $family->family_id) {?>selected="selected"
                                        <?php }?>><?php echo $family->family_name; ?></option>
                                    <?php }?>
                                </select>
                                <div class="form-control-focus" style="margin: 0px;"></div>
                                <label for="form_control_1"
                                    style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('select_family'); ?><span
                                        style="color: #F60922; margin-left: 5px;">*</span></label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-6">
                                    <input value="<?php echo $this->mdl_products->form_value('product_sku'); ?>"
                                        type="text" class="form-control" id="product_sku" name="product_sku">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_sku'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>

                                </div>
                                <div class="col-md-6">
                                    <input value="<?php echo $this->mdl_products->form_value('product_name'); ?>"
                                        type="text" class="form-control" id="product_name" name="product_name">
                                    <div class="form-control-focus"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_name'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>

                                </div>
                            </div>
                        </div>

                    </div>




                    <div class="row"><br>
                        <div class="col-md-12" style="margin-left: 0%;width: 94%;">
                            <div class="form-group form-md-line-input has-info">
                                <div class="col-md-12">
                                    <textarea name="product_description" rows="1" id="product_description"
                                        class="form-control"><?php echo $this->mdl_products->form_value('product_description'); ?></textarea>
                                    <div class="form-control-focus" style="margin: 0px;"></div>
                                    <label for="form_control_1"
                                        style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_description'); ?><span
                                            style="color: #F60922; margin-left: 5px;">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="visibility: hidden">
                        <select class="form-control" name="tax_rate_id" id="tax_rate_id">
                            <!--<option value=""></option>-->
                            <?php foreach ($tax_rates as $tax_rate) {?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                <?php if ($this->mdl_products->form_value('tax_rate_id') == $tax_rate->tax_rate_id) {?>
                                selected="selected" <?php }?>><?php echo $tax_rate->tax_rate_name; ?>
                            </option>
                            <?php }?>
                        </select>

                    </div>
                    <div class="form-group form-md-line-input has-info">
                        <div class="col-md-3">
                            <input value="<?php echo $this->mdl_products->form_value('purchase_price'); ?>" type="text"
                                class="form-control" name="purchase_price" id="purchase_price">

                            <div class="form-control-focus" style="margin: 0px;"></div>
                            <label for="form_control_1"
                                style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('purchase_price'); ?><span
                                    style="color: #F60922; margin-left: 5px;">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="input-sm form-control" type="text" name="remise" id="pourcent_remise"
                                value="<?php echo $this->mdl_products->form_value('remise'); ?>">
                            <div class="form-control-focus" style="margin: 0px;"></div>
                            <label for="form_control_1"
                                style="font-size: 13px; color: #899a9a;margin-top: -15px;">Remise<span
                                    style="color: #F60922; margin-left: 5px;"> </span></label>

                        </div>




                        <div class="col-md-6  ">
                            <div class="portlet light">

                                <?php
if ($this->mdl_products->form_value('product_id')) { //cas de formulaire de modification
    foreach ($devises as $value) {
        $prix = '';
        $tva = '';
        foreach ($prix_ventes as $pvalue) { ///echo '<pre>'; print_r($pvalue);echo '</pre>';
            if (($pvalue->id_devise == $value->devise_id)) {
                $prix = $pvalue->prix_vente;
                $tva = $pvalue->id_tax;
            }}?>

                                <div class="row">
                                    <div class="col-md-12" style="margin-left: 2%;width: 94%;">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                                id="prx[<?php echo $value->devise_id; ?>][devise]"
                                                value="<?php echo $value->devise_id; ?>">


                                            <div class="col-md-12" style="margin-top:-18px">

                                                <input value="<?php echo $prix; ?>" type="text"
                                                    class="calcvente form-control"
                                                    name="prx[<?php echo $value->devise_id; ?>][product_price]"
                                                    id="prx[<?php echo $value->devise_id; ?>][product_price]">
                                                <div class="form-control-focus"></div>
                                                <label for="form_control_1"
                                                    style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>



                                            </div>

                                            <div class="col-md-6" style="visibility: hidden">
                                                <select class="form-control"
                                                    name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                                    id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                                    <!--<option value=""></option>-->
                                                    <?php foreach ($tax_rates as $tax_rate) {?>
                                                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                                        <?php if ($tva == $tax_rate->tax_rate_id) {?>
                                                        selected="selected" <?php }?>>
                                                        <?php echo $tax_rate->tax_rate_name; ?></option>
                                                    <?php }?>
                                                </select>
                                                <div class="form-control-focus" style="margin: 0px;"></div>
                                                <label for="form_control_1"
                                                    style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('tax_rate'); ?></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
}

} else {
    foreach ($devises as $value) {
        ?>

                                <div class="col-md-6" style=" margin-top: -3%;margin-left: 2%;width: 94%;">

                                    <div class="form-group form-md-line-input has-info">
                                        <input type="hidden" name="prx[<?php echo $value->devise_id; ?>][devise]"
                                            id="prx[<?php echo $value->devise_id; ?>][devise]"
                                            value="<?php echo $value->devise_id; ?>">


                                        <div class="col-md-12">
                                            <input value="" type="text" class="calcvente form-control"
                                                name="prx[<?php echo $value->devise_id; ?>][product_price]"
                                                id="prx[<?php echo $value->devise_id; ?>][product_price]">
                                            <div class="form-control-focus"></div>
                                            <label for="form_control_1"
                                                style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('product_price') . '&nbsp;(' . $value->devise_symbole . ')'; ?></label>

                                        </div>

                                        <div class="col-md-6" style="visibility: hidden">
                                            <select class="form-control"
                                                name="prx[<?php echo $value->devise_id; ?>][tax_rate_id]"
                                                id="prx[<?php echo $value->devise_id; ?>][tax_rate_id]">
                                                <!--<option value=""></option>-->
                                                <?php foreach ($tax_rates as $tax_rate) {?>
                                                <option value="<?php echo $tax_rate->tax_rate_id; ?>">
                                                    <?php echo $tax_rate->tax_rate_name; ?></option>
                                                <?php }?>
                                            </select>
                                            <div class="form-control-focus" style="margin: 0px;"></div>
                                            <label for="form_control_1"
                                                style="font-size: 13px; color: #899a9a;margin-top: -15px;"><?php echo lang('tax_rate'); ?></label>

                                        </div>

                                    </div>
                                </div>

                                <?php
}
}
    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="headerbar">
        <?php $this->layout->load_view('layout/header_buttons');?>
    </div>
    </div>
    <script>
    $(".calcvente").keyup(function() {
        var purchase_price = 0;
        var calcvente = 0;
        purchase_price += $("#purchase_price").val();
        calcvente += $(".calcvente").val();
        var result = (((calcvente / purchase_price) - 1) * 100).toFixed(3);
        var res = result.split(".");
        var result1 = 0;
        if (res[1] != '0') {
            result1 = parseFloat(result1 + result);
        } else {
            result1 += (((calcvente / purchase_price) - 1) * 100);
        }
        if ($("#purchase_price").val() != '') {
            $('#pourcent_remise').val(result1);
        } else {
            var remise12 = parseFloat($("#pourcent_remise").val(), 10);
            var vente12 = parseFloat($(".calcvente").val(), 10);
            var res = ((remise12 / 100) + 1);

            $('#purchase_price').val(vente12 / res);
        }

    })
    $("#pourcent_remise").keyup(function() {
        var purchase_price1 = parseFloat($("#purchase_price").val(), 10);
        var remise1 = parseFloat($("#pourcent_remise").val(), 10);
        var remiseprice1 = ((remise1 * purchase_price1) / 100);
        if ($('#pourcent_remise').val().length > 0 && $('#purchase_price').val().length > 0) {
            $('.calcvente').val(remiseprice1 + purchase_price1);
        }
    })
    $("#purchase_price").keyup(function() {
        var purchase_price1 = parseFloat($("#purchase_price").val(), 10);
        var remise1 = parseFloat($("#pourcent_remise").val(), 10);
        if ($("#pourcent_remise").val() != '0') {
            var remiseprice1 = ((remise1 * purchase_price1) / 100);
            if ($('#pourcent_remise').val().length > 0 && $('#purchase_price').val().length > 0) {
                $('.calcvente').val(remiseprice1 + purchase_price1);
            }
        }

    })
    </script>
    <?php }?>
</form>