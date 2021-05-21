<script type="text/javascript">
function myFunctionsus(i){
$('.tt').css("display", "block");
$('#id_select').val(i);
}
$(function() { 
    
    $('#modal-choose-items').modal('show');   
    var called = false;
  
    $('#select-items-confirmx').click(function() {
      
        if (!called) {
            called = true;       
             $.post("<?php echo site_url('users/ajax/delete'); ?>", {
                users_id: $('#users_selectt').val(),
                users_selectt: $('#id_select').val(), 
            }, function(data) { 
                
               window.location.href = "<?php echo site_url('settings'); ?>";
                $('#modal-choose-items').modal('hide'); 
            }); 
        }
    });     
});
</script>
<input type='hidden' id='id_select' value=''>
<input type='hidden' id='users_selectt' value='<?php echo $id ?>'>
<div id="modal-choose-items" class="modal" role="dialog" aria-labelledby="modal-choose-items" aria-hidden="true">

    <div class="modal-content">
        <div class="modal-body commande">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xl-12">
                    <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px;height: 20px;color: #FFF !important;background-image: none !important; background-color: rgb(220, 53, 88) !important;text-align: center;text-indent: 0px;opacity: 1;">
                        <i class="fa fa-close"></i></button>                   
                  
                </div>
            </div>            
            <div class="row ajout-prod">               
                <div class="tt cols-sm-10 col-lg-10 col-md-10 col-xl-10"
                    style=" white-space: nowrap; display:none">
                        <div class="pull-right btn-group">
                 <!--   <button class="btn default" type="button" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        <?php //echo lang('cancel'); ?>
                    </button>-->
                    <button class="btn btn-success" id="select-items-confirmx" type="button">
                        <i class="fa fa-check"></i>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="cols-sm-12 col-lg-12 col-md-12 col-xl-12 table-responsive">
                    <table id="product_select" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="3%" style="border: hidden;">
                                  
                                </th>         
                               
                                <th><?php echo lang('filter_user') ?></th>
                                <th style="white-space: nowrap;"><?php echo lang('client_email_tab') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php foreach($users as $user){ ?>
                            <tr  id="<?php echo $user->user_id ?>">                                
                                <td> 
                                    <div class="md-radio">
                                        <input type="radio" id="radio1<?php echo $user->user_id; ?>" name="user_ids[]"
                                        onclick="myFunctionsus(<?php echo $user->user_id; ?>)"  class="md-radiobtn"
                                            value="<?php echo $user->user_id; ?>">
                                        <label for="radio1<?php echo $user->user_id; ?>">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>
                                </td>
                                <td><?php echo $user->user_name ?></td>
                                <td><?php echo $user->user_email ?></td>
                            </tr>
                        <?php } ?>                                
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    <style>
    .modal {
        right: 20%;
        bottom: 0%;
        left: 10%;
    }
    </style>
    <div>
     