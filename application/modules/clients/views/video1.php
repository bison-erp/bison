<div id="modal-choose-items-vid" class="modal devis-client col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 6px;">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header devis-client"
            style=" width: 64%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 100xp;  background-color: rgb(255, 255, 255) !important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
                <div class="row">
                    <div class="col-md-3" style="font-weight: 600;font-size: 18px;margin-bottom: 14px;">
                        <?php echo lang('add_client'); ?> </div>
                    <div class=" col-md-3">
                        <input type="text" class="form-control" name="filter_client" id="filter_client"
                            placeholder="<?php echo lang('client_name'); ?>" value="<?php echo $filter_client ?>"
                            autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add_client_btn_modal"
                            class="btn btn-default"><?php echo lang('create_client'); ?></button>
                    </div>
                    <div class=" col-md-3" id="mod_footer" style=" white-space: nowrap;width: 250px;display: none">
                        <div class="btn-group">
                            <button class="btn default" type="button" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                <?php echo lang('cancel'); ?>
                            </button>
                            <button class="btn btn-success" id="select-items-confirmx" type="button">
                                <i class="fa fa-check"></i>
                                <?php echo lang('submit'); ?>
                            </button>
                        </div>
                    </div>
                    <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                        <i class="fa fa-close"></i></button>
                </div>
            </div>

        </div>
        <div class="modal-body" style="  z-index: 888; margin-top: 94px;  ">
            <div class="table-responsive">
                <table id="clients_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style=" width: 20px">&nbsp;</th>
                            <th><?php echo lang('client_name_tab'); ?></th>
                            <th><?php echo lang('client_raison_tab'); ?></th>
                            <th><?php echo lang('client_email_tab'); ?></th>
                            <th><?php echo lang('client_telFix_tab'); ?></th>
                            <th><?php echo lang('client_telmobile_tab'); ?></th>
                            <th style=" display: none"><?php echo lang('active'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client) {?>
                        <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $client->client_id; ?>" name="client_ids[]"
                                        onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $client->client_id; ?>">
                                    <label for="radio1<?php echo $client->client_id; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="text-left">
                                <b><?php echo $client->client_name . ' ' . $client->client_prenom; ?></b>
                            </td>
                            <td>
                                <b><?php echo $client->client_societe; ?></b>
                            </td>
                            <td>
                                <?php echo $client->client_email; ?>
                            </td>
                            <td>
                                <?php echo $client->client_phone; ?>
                            </td>
                            <td>
                                <?php echo $client->client_mobile; ?>
                            </td>
                            <td style=" display: none">
                                <?php echo ($client->client_active) ? lang('yes') : lang('no'); ?>
                            </td>
                        </tr>

                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        function myFunction() {
            $("#mod_footer").show();
        }
        </script>
    </div>

</div>