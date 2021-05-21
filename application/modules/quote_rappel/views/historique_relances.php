
<script>

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
   <!-- <pre>
    <?php print_r($rappels); ?>
    <?php print_r($quotes); ?>
    </pre>-->
    <table border="2px" style=" display: none">
        <tr><td>Quote id</td><td>client_email</td></tr>
        <?php foreach ($rappels as $rappel) { ?>
            <tr><td><?php echo $rappel->quote_id; ?></td>
                <td><?php echo $rappel->client_email; ?></td></tr>
            <?php
        }
        //print_r(getdate());
        ?>
    </table>
</div>
<div class="row">
    <div class="col-md-12">
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
                <th><?php echo lang('date_Rappel'); ?></th>
                <th><?php echo lang('etat_relance'); ?></th>

                <th style=" display: none"><?php echo lang('options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $last_rapel_id = 0;
           
            foreach ($rappels as $rappel) {
                foreach ($quotes as $quote) {

                    if ($rappel->quote_id == $quote->quote_id) {
                        ?>
                                                    <!---<pre>
                        <?php print_r($quote); ?>
                        <?php print_r($rappel); ?>
                        <?php print_r($model); ?></pre>-->
                        <?php
                        
                                if(($last_rapel_id!=$rappel->rappel_id)){
                        ?>

                        <tr>
                            <td>
                                <a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>"
                                   title="<?php echo lang('edit'); ?>">
                                    <?php echo $quote->quote_number ?></a>
                            </td>
                            <td>
                                <?php echo $quote->quote_nature ?>
                            </td>
                            <td>
                                <a href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"
                                           title="<?php echo lang('view_client'); ?>">
                                <?php echo $quote->client_name . '&nbsp;' . $quote->client_prenom ?>&nbsp;
                                </a>
                            </td>
                            <td>
                                <?php echo $quote->client_email ?>
                            </td>
                            <td>
                                <?php echo $quote->client_societe ?>
                            </td>
                            <td>
                                <?php echo $rappel->rappel_date ?>
                            </td>
                            <td>
                                <?php
                                if ($rappel->rappel_status == 0)
                                    echo ' <span style=" background-color: #54a0c6;color: white !important;display: block;font-weight: normal;padding: 0.3em 0.6em;
    width: 60%;border-radius: 0.25em;font-size: 75%;line-height: 1;box-sizing: border-box;">En attente</span>';
                                if ($rappel->rappel_status == 1)
                                    echo '<span style=" background-color: #b3b3b3;color: white !important;display: block;font-weight: normal;padding: 0.3em 0.6em;
    width: 60%;border-radius: 0.25em;font-size: 75%;line-height: 1;box-sizing: border-box;">Envoyé</span>';
                                if ($rappel->rappel_status == 2)
                                    echo '<span style=" background-color: #d398c5;color: white !important;display: block;font-weight: normal;padding: 0.3em 0.6em;
    width: 60%;border-radius: 0.25em;font-size: 75%;line-height: 1;box-sizing: border-box;">Annuler</span>';
                                //echo $rappel->rappel_status;
                                ?>

                            </td>
                            <td style=" display: none">
                                &nbsp;
                            </td>
                        </tr>
                                <?php 
                           $last_rapel_id=$rappel->rappel_id;
                                }
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>
</div></div></div>