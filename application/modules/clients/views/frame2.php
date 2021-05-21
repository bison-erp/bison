<!DOCTYPE html>
<?php 
?>
<style>
.modal .modal-header {
    height: 10px;
}

.md-radio label {
    padding-left: 20px !important;
}

#clients_table {
    margin-top: 6px;
}
</style>
<html>


<body>
<div id="modal-choose-items" class="modal devis-client col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 95%;overflow:hidden !important;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 0px;">
    <div class="modal-content" style=" width: 100% ;height: 90%">
	 <div class="modal-header devis-client"
            style=" width: 64%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 90xp;  background-color: rgb(255, 255, 255) !important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
				<button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px; height: 15px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                        <i class="fa fa-close"></i></button>
						</div>
	</div>
       <div class="modal-body">
			<div class="embed-responsive embed-responsive-16by9">
			<iframe width="100%" height="120" src="https://www.youtube.com/embed/BeRa7hakIoM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div> 
	</div>
</div>										
<script>
$(function() {
    $('#modal-choose-items').modal('show');
});
</script>										
</body>
</html>
