<?php
if (function_exists('validation_errors')) {
    if (validation_errors()) {
        echo validation_errors('<div class="alert alert-danger">', '<button class="close" data-close="alert"></button></div>');
    }
}
?>
<?php if ($this->session->flashdata('alert_success')) { ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?>
     <button class="close" data-close="alert"></button></div>
<?php } ?>

<?php if ($this->session->flashdata('alert_info')) { ?>
    <div class="alert alert-info"><?php echo $this->session->flashdata('alert_info'); ?>
     <button class="close" data-close="alert"></button></div>
    
<?php } ?>

<?php if ($this->session->flashdata('alert_error')) { ?>
    <div  class=" alert alert-danger "><?php echo $this->session->flashdata('alert_error'); ?>
        <button class="close" data-close="alert"></button>
    </div>
<?php } ?>