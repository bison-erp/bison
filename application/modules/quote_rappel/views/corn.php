<script>
     $(function functionCron() {

<?php
foreach ($rappels as $rappel) {  //print_r($model[0]); 
    foreach ($quotes as $quote) {
        if ($rappel->quote_id == $quote->quote_id) {
            ?>
                //  body = "<span class='sceditor-selection sceditor-ignore'id='sceditor-end-marker'></span><span class='sceditor-selection sceditor-ignore' id='sceditor-start-marker'> </span><span class='sceditor-selection sceditor-ignore' id='sceditor-end-marker'> </span><span class='sceditor-selection sceditor-ignore' id='sceditor-end-marker'> </span><span class='sceditor-selection sceditor-ignore' id='sceditor-end-marker'> </span><span class='sceditor-selection sceditor-ignore' id='sceditor-end-marker'> </span><p></p><div><font color='#333333' face='Verdana' size='2'>Bonjour,<br><br>Nous vous prions de bien vouloir trouver ci-joint notre devis";
                //body = body + <?php //echo $quote->quote_nature;  ?> + "du " + <?php //echo $quote->quote_date_created;  ?> + "  de ma société<br><br>Souhaitant qu'il retienne votre attention, et vous remerciant de votre confiance, nous vous en souhaitons bonne réception. < br > < br > Bien cordialement, < br > < br > ";
                // body = body + " ppppppppppp  du   2015 - 06 - 06   de ma sociÃ©tÃ©<br><br>Souhaitant qu'il retienne votre attention, et vous remerciant de votre confiance, nous vous en souhaitons bonne rÃ©ception. < br > < br > Bien cordialement, < br > < br > ";
                //body = body +<?php //echo $model[0]->email_template_from_name;  ?> + "<br>" + <?php //echo $model[0]->email_template_from_email;  ?> + "<br><i>" +<?php //echo $quote->user_company;  ?> + "</i><br><br></font><p><font color=\"#333333\" face=\"Verdana\" size=\"1\">" + <?php //echo $quote->user_address_1;  ?> + "<br>" + <?php //echo $quote->user_phone;  ?>;
                //body = body + "ayda <br>  ayda@novatis.org  <br><i> novatis  </i><br><br></font><p><font color=\"#333333\" face=\"Verdana\" size=\"1\">  Av.Houssine bellaaj imm.Moalla et Hammami 3000 Sfax  <br>  + 216 74 212 446";
                //body = body + "<span class='sceditor-selection sceditor-ignore' id='sceditor-end-marker'> </span><a href='http://www.novatis.tn/'></a></font></p></div>";
                $.post("<?php echo site_url('quote_rappel/ajax/send_quote'); ?>", {
                // quote_id: <?php echo $rappel->quote_id; ?>,
                       from_email:'<?php echo $model[0]->email_template_from_email; ?>', //email user
                        //from_name: '<?php //echo $this->session->userdata('user_name');         ?>', //name user
                        //from_name: '<?php echo $model[0]->email_template_from_name; ?>', //name user
                        nature: '<?php echo $quote->quote_nature; ?>', //nature du devis
                        date_created: '<?php echo $quote->quote_date_created; ?>', //date creation devis
                        company: '<?php echo $quote->user_company; ?>', //name company
                        adresse: '<?php echo $quote->user_address_1; ?>', //adresse company
                        phone: '<?php echo $quote->user_phone; ?>', //phone company
                        quote_num: '<?php echo $quote->quote_number; ?>', //quote number
                        quote_id: '<?php echo $quote->quote_id; ?>', //quote id
                        pdf_template: '1', //Modèle de courriel: 
                        to: '<?php echo $rappel->client_email; ?>',
                        //subject: 'Devis# ' + <?php echo $quote->quote_number; ?> + '; ' +<?php echo $quote->quote_nature; ?> + 'ma société du ' +<?php echo $quote->quote_date_created; ?>,
                        //subject: 'Devis#  1065  ;   ppppppppppp  ma sociÃ©tÃ© du   2015 - 06 - 06',
                        cc: '',
                        bcc: '',
                }, function (data) {
                var json_response = eval('(' + data + ')');
                        //self.data('typeahead').source = json_response;
                });
            <?php
        }
    }
}
?>
    });
</script>
<div id="headerbar">
    <h1></h1>

    <div class="pull-right btn-group" style=" display: none">
        <a href="#" class="btn btn-sm btn-success" id="btn_save_quote">
            <i class="fa fa-check"></i>
            <?php echo lang('save'); ?>
        </a>
    </div>
    <?php
//print_r( $this->session->userdata); 
//echo '<pre>';
//print_r($this->session->all_userdata());
//echo '</pre>';die;
    ?>
</div>
<div>
    <!--<pre>
    <?php //print_r($rappels);      ?>
    <?php //print_r($quotes);     ?>
    </pre>-->
    <table border="2px" style=" display: none">
        <tr><td>Quote id</td><td>client_email</td></tr>
        <?php foreach ($rappels as $rappel) { ?>
            <tr><td><?php echo $rappel->quote_id; ?></td><td><?php echo $rappel->client_email; ?></td></tr>
            <?php
        }
        //print_r(getdate());
        ?>
    </table>
</div>
    <form id="quote_form">

        <div class="row">

            <div class="col-md-11">
                <div class="portlet light">
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo lang('quote'); ?></th>
                <th><?php echo lang('quote_nature'); ?></th>
                <th><?php echo lang('client_name_tab'); ?></th>
                <th><?php echo lang('client_email'); ?></th>
                <th><?php echo lang('client_societe'); ?></th>

                <th style=" display: none"><?php echo lang('options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rappels as $rappel) {
                foreach ($quotes as $quote) {
                    if ($rappel->quote_id == $quote->quote_id) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $quote->quote_number ?>
                            </td>
                            <td>
                                <?php echo $quote->quote_nature ?>
                            </td>
                            <td>
                                <?php echo $quote->client_name . '&nbsp;' . $quote->client_prenom ?>&nbsp;
                            </td>
                            <td>
                                <?php echo $quote->client_email ?>
                            </td>
                            <td>
                                <?php echo $quote->client_societe ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>
                </div></div></div></form>