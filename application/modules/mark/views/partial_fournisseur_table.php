<?php
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];


						  foreach ($mark as $marque)
						   { ?>
                            <tr class="odd gradeX">
                                <td><?php echo $marque->name_mark; ?></td>
                                <td>
                                    <?php if (($sess_devis_add == 1) || ($sess_devis_del == 1)) {?> <div
                                        class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            href="#">
                                            <i class="fa fa-cog"></i> <?php echo lang('options'); ?>
                                        </a>
                                        <ul class="dropdown-menu" style="margin-left: -114px;margin-top: 1px; position: relative">
                                            <li>
                                                <?php if ($sess_devis_add == 1) {?> <a
                                                    href="<?php echo site_url('mark/form/' . $marque->id_mark); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                                </a><?php }?>
                                            </li>
                                            <li>
                                            <?php if ($sess_devis_del == 1) {?>
												<a href="<?php echo site_url('mark/delete/' . $marque->id_mark); ?>"onclick="return confirm('<?php echo lang('delete_record_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i>
                                              <?php echo lang('delete'); ?>
                                                </a><?php }?>
                                            </li>
                                        </ul>
                                    </div><?php }?>
                                </td>
                            </tr>
                            <?php }?>




<tr style="display:none">
    <?php
$nb_pages = isset($nb_pages) ? $nb_pages : 1;
$start_page = isset($start_page) ? $start_page : 1;
$nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
$start_line = isset($start_line) ? $start_line : 1;
?>
    <input type="hidden" value="<?php echo $nb_pages ?>" id="nbpage">
    <input type="hidden" value="<?php echo $start_page ?>" id="start_page">
    <input type="hidden" value="<?php echo $nb_all_lines ?>" id="nb_all_lines">
    <input type="hidden" value="<?php echo $start_line ?>" id="start_line">
    <script>
    nb_pages = $('#nbpage').val();
    start_page = $('#start_page').val();
    nb_all_lines = $('#nb_all_lines').val();
    start_line = $('#start_line').val();
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1 || start_page == 0) 
	{
        $("#btn_fast_backward").addClass("disabled");
        $("#btn_fa_backward").addClass("disabled");
    } else 
	{
        $("#btn_fast_backward").removeClass("disabled");
        $("#btn_fa_backward").removeClass("disabled");
    }
    if (start_page == nb_pages) {
        $("#btn_fast_forward").addClass("disabled");
        $("#btn_fa_forward").addClass("disabled");
    } else 
	{
        $("#btn_fast_forward").removeClass("disabled");
        $("#btn_fa_forward").removeClass("disabled");
    }
    </script>
</tr>