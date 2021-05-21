<script type="text/javascript">
    function maxLengthDesc(str,max){
        var rest = parseInt(max) - parseInt(str.length);
        rest = rest>=0 ? rest:0;
        $(".max_number").html(rest);
        return str.substr(0, max);
    }
    $().ready(function () {
        $('#add_document_btn').click(function () {
            $('#form_add_document').submit();
        });

        $('#document_desc').keyup(function () {
            // $(this).val(maxLengthDesc($(this).val(), 50));
			var length_val =  maxLengthDesc($(this).val(), 50);
			if($(this).val().length > 50){
				
				$(this).val(length_val);
			}
			
            
			$(this).focusout(function () {
                // $(this).val(maxLengthDesc($(this).val(), 50));
				var length_val =  maxLengthDesc($(this).val(), 50);
							if($(this).val().length > 50){
				
				$(this).val(length_val);
			}

            });
        });

    });
</script>
<br>
<form method="post" action="" id="form_add_document" enctype="multipart/form-data" >
    <table class="table table-bordered table-condensed no-margin">
        <tr>
            <td width="60%"><input name="document_desc" id="document_desc" type="text" class="form-control" autocomplete="off" placeholder="Description du fichier">
                <span class="pull-right" style="font-size:9px; line-height:11px;margin-top:3px;font-weight:bold"><?php echo lang('caractcres_restantes'); ?><span class="max_number">50</span> </span>
            </td>
            <td><input type="file" name="document_import" class="form-control" style="height: auto;">
                
            </td>
            <th width="50"><button id="add_document_btn" class="btn btn-default"><?php echo lang('upload'); ?></button></th>
        </tr>
    </table>
    <input type="hidden" name="add_document" value="1">
    <input type="hidden" name="client_id" value="<?php echo $client->client_id ?>">
</form>
<hr>

<table class="table table-condensed table-striped " style="margin-top: 7px; width: 100%;  table-layout: fixed;">
    <thead>
        <tr>
            <th width="100"><?php echo lang('date'); ?></th>
            <th><?php echo lang('file'); ?></th>
            <th><?php echo lang('product_description2'); ?></th>
            <th width="70"><?php echo lang('Size');?></th>
            <th width="250"><?php echo lang('user');?></th>
            <th width="80"><?php echo lang('action');?></th>
        </tr>
    </thead>
<tbody>
        <?php if (!empty($documents)) { ?>
            <?php foreach ($documents as $document) { ?>
                <tr>
                    <td><?php echo date_from_mysql($document->created, 1); ?></td>
                    <td><?php echo $document->file_name; ?></td>
                    <td>
                        <span title="<?php echo $document->description; ?>">
                            <?php
                            $description = $document->description;
                            echo substr($description, 0, 40);
                            if (strlen($description) > 40)
                                echo'<b style="color:#1BC5BD">...</b>';
                            ?>
                        </span>
                    </td>
                    <td><?php echo convertOctet($document->size); ?></td>
                    <td>
                        <span title="<?php echo $document->user_name . " (" . $document->user_email . ")"; ?>">
                            <?php
                            $fulluser = $document->user_name . " (" . $document->user_email . ")";
                            echo substr($fulluser, 0, 25);
                                echo'<b style="color:#1BC5BD">...</b>';
                            if (strlen($fulluser) > 25)
                            ?>
                        </span>

                    </td>
                    <td width="50" class="">

                        <a href="<?php echo base_url(); ?>clients/download_document/<?php echo $document->id_document; ?>" class="btn btn-xs blue" title = "Télécharger">
                            <i class="fa fa-download"></i>
                        </a>
                        <a href="<?php echo base_url(); ?>clients/delete_document/<?php echo $document->id_document; ?>" class="btn btn-xs red" title="Supprimer" onclick="return confirm('Voulez vous supprimer ce document ?');">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>

                </tr>
    <?php } ?>
        <?php } ?>

    </tbody>
</table>
