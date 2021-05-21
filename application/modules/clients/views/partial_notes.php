<script type="text/javascript">
    function f_del(q){
         if (confirm('voulez vous vraiment supprimer cette note ?'))

        {
            id = q;
            $.post("<?php echo site_url('clients/ajax/supp_note'); ?>", {
            id:id,
    }, function (data) {
                var json_response = eval('(' + data + ')');
                            if (json_response.success == 1) {$('#note'+q).hide();}
            });
           
        }
    }
    </script>
    <style>
span.fa.fa-user.img-circle {
    color: #3699FF;
    background: #E1F0FF;
}
    </style>
<br/>
                            
<table class="table table-condensed table-striped " style="margin-top: 7px; width: 100%;  table-layout: fixed;">
    <tr>
        <th><?php echo lang('date'); ?></th>
        <th style=" width: 57%; "><?php echo lang('field_description'); ?></th>
        <th><?php echo lang('user'); ?></th>
        <th><?php echo lang(ip_adress); ?></th>
        <th style=" width: 25px; "></th>
        <th style=" width: 25px; "></th>
        
    </tr>
<?php foreach ($client_notes as $client_note) { ?>
    <tr id="note<?php echo $client_note->client_note_id;?>">
        <td  style="vertical-align: middle;" >
                       <!--<b><?php //echo date_from_mysql($client_note->client_note_date, TRUE); ?></b>-->

            <?php $dt_not=explode(" ", $client_note->client_note_date);
            $dat_not0= explode("-",$dt_not[0]); 
            echo  $dat_not0[2].'/'. $dat_not0[1].'/'. $dat_not0[0].' '.$dt_not[1]; 
            ?>
        </td>
        <td style="width: 57%;vertical-align: middle;">
          &nbsp;
          <p style="width:100%; word-wrap:break-word;"> <?php echo nl2br($client_note->client_note); ?>  </p>
        </td>
        <td style="vertical-align: middle;">
          &nbsp;
            <?php echo nl2br($client_note->usr); ?>  
        </td>
        <td style="vertical-align: middle;">
          &nbsp;
            <?php echo nl2br($client_note->adr_ip); ?>  
        </td>
        <td style="vertical-align: middle;">
            <?php if($client_note->drap==1){$a='color: #EE2D41;';}
            else {$a='color: #0BB7AF;';}?> 
          <i class="fa fa-bolt" style="<?php echo $a;?>"></i>
        </td>
        <td style="vertical-align: middle;"> <?php if(($this->session->userdata['groupes_user_id'] == 1)||($this->session->userdata['user_id']==$client_note->id_usr)){?>
            <i class="fa fa-minus-square" class="del_not" ind="<?php echo $client_note->client_note_id;?>" onclick="f_del(<?php echo $client_note->client_note_id;?>)"style="color: #EE2D41;cursor: pointer;"></i></td>
        <?php }?>
    </tr>
        
      
   
<?php } ?>
</table>