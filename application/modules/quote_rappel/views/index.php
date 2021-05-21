

<div id="headerbar">
    <h1></h1>

    <div class="pull-right btn-group">
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
	<table border="2px">
		<tr><td>Quote id</td><td>client_email</td></tr>
		<?php foreach($rappels as $rappel){?>
			<tr><td><?php echo $rappel->quote_id;?></td><td><?php echo $rappel->client_email;?></td></tr>
		<?php }
                print_r(getdate());?>
	</table>
</div>
