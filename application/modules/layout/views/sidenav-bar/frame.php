<!DOCTYPE html>
<?php 
?>

<!-- begin: section -->

<!-- end: section -->

<!-- begin: section -->
<div id="video" class="tabcontent">
	<div class="tab tab-video" id="tab_video">
			<div class="bloc-content">
				<h5 class="font-weight-bold small-h5"><?php echo lang('videos_help_you'); ?></h5>
			</div>
							<!--begin: Item-->
						
				
							<!--end: Item-->
							<!--begin: Item-->
								<div class="content-bar video-menu">
									<div class="bloc-content">
    <!-- Button HTML (to Trigger Modal) -->
										<a href="#" class="text-hover-primary" data-toggle="modal" data-target="#myModal1">
										<div class="bloc-txt"><?php echo lang('video2'); ?></div>
										<img  src="<?php echo base_url(); ?>assets/admin/layout/img/bbis.png"data-atf="true"></a>
										<!-- Modal HTML -->
											<div id="myModal1" class="modal fade ">
											<div class="modal-dialog">
												<div class="modal-content">
													
													<div class="modal-body">
													     <div class="embed-responsive embed-responsive-16by9">
													   <iframe width="100%" height="150" src="https://www.youtube.com/embed/_fH_GObWiJ0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
													  </div>
													</div>
												</div>
											</div>
										</div>  
								</div>
								</div>
	
</div>
</div>
<!-- end: section -->
<script>

$('body').click(function() {
 $('#myModal1').hide();  
$("#myModal").hide();  
});
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
