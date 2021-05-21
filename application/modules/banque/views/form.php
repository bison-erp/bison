<form method="post" class="form-horizontal">

    <div id="headerbar" style=" margin-top: -3%">
        <h1></h1>
        <?php $this->layout->load_view('layout/header_buttons');?>
    </div><br><br>

    <div id="content" style="margin-left: 40px;">

        <div class="row" style=" margin-left: -15px; margin-right: -15px">

            <div class="col-md-12">
                <?php $this->layout->load_view('layout/alerts');?>
                <div class="portlet light">
                    <div class="row">
                        <div class="form-group form-md-line-input has-info"
                            style="margin-right: -15px;margin-left: 40px;">
                            <div class="col-md-10">

                                <input value="<?php

echo $this->mdl_banque->form_value('nom_banque'); ?>" type="text" class="form-control" id="nom_banque"
                                    name="nom_banque">
                                <div class="form-control-focus" style="margin: 0px;"></div>
                                <label for="form_control_1"
                                    style="margin-left: -15px;font-size: 13px; color: #899a9a;margin-top: -15px;">Nom de banque<span
                                        style="color: #F60922; margin-left: 5px;">*</span></label>

                            </div>
                        </div>
                    </div>
                    <br><br><br>
                </div>

            </div>
        </div>
    </div>

</form>