<!DOCTYPE html>
<?php 
?>
<div class="tab head-content">
  <button class="tablinks" onclick="openCity(event, 'help')" id="defaultOpen">FAQ</button>
  <button class="tablinks tab-video" onclick="openCity(event, 'video')"><?php echo lang('video_tutorials'); ?></button>
</div>
<!-- begin: section -->
<div id="help" class="tabcontent">
	<div class="tab tab-help" id="tab_help">
		<!--begin: Item-->
			<h5 class="font-weight-bold big-h5"><?php echo lang('quest_resp'); ?></h5>
				
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/88/Comment-inserer-son-cachet-et-sa-signature-sur-ses-documents-comptables-.html" target="_blank" ><?php echo lang('insert_cachet'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
				
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/40/Comment-creer-un-devis-en-ligne-sur-BISON-.html" target="_blank" ><?php echo lang('devis_creation'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/89/Comment-personnaliser-lentete-des-documents-.html" target="_blank" ><?php echo lang('entete_document'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
				<div class="bloc-content">
					<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/24/Comment-donner-un-acces-a-BISON-a-mes-collaborateurs-.html" target="_blank" ><?php echo lang('acces_collaborateurs'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
				</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/23/Comment-inserer-les-informations-de-ma-societe-dans-BISON-.html" target="_blank" ><?php echo lang('insert_information'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/51/Comment-ajouter-des-fichiers-lies-a-mes-documents-.html" target="_blank" ><?php echo lang('add_files'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/67/Comment-creer-des-ordres-de-fabrication-.html" target="_blank" ><?php echo lang('ordre_fabrication'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/26/Puis-je-ouvrir-un-acces-gratuit-a-mon-expert-comptable-.html" target="_blank" ><?php echo lang('acces_gratuit'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary"><a href="https://client.bison.tn/knowledgebase/85/Comment-creer--un-bon-de-commande-en-ligne-sur-BISON-.html" target="_blank" ><?php echo lang('bon_de_commande'); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
			</div>
			<div class="separator separator-bar"></div>
		<!--end: Item-->
	</div>
</div>
<!-- end: section -->

<!-- begin: section -->
<div id="video" class="tabcontent">
	<div class="tab tab-video" id="tab_video">
			<div class="bloc-content">
				<h5 class="font-weight-bold small-h5"><?php echo lang('videos_help_you'); ?></h5>
			</div>
							<!--begin: Item onclick="loadDoc()"-->
								<div class="content-bar video-menu">
									<div class="bloc-content">	
									
									<a href="#" class="text-hover-primary" data-toggle="modal" data-target="#myModal"  id="youtube1">
										<div class="bloc-txt" ><?php echo lang('video1'); ?></div>					
											<img  src="<?php echo base_url(); ?>assets/admin/layout/img/bbb.png"data-atf="true" />
									
									</a>
			
									</div>
								</div>
					<div class="separator separator-bar"></div>
							<!--end: Item-->
							<!--begin: Item-->
								<div class="content-bar video-menu">
									<div class="bloc-content">
    <!-- Button HTML (to Trigger Modal) -->
										<a href="#" class="text-hover-primary" data-toggle="modal" data-target="#myModal1" id="youtube">
										<div class="bloc-txt"><?php echo lang('video2'); ?></div>
										<img  src="<?php echo base_url(); ?>assets/admin/layout/img/bbis.png"data-atf="true"/></a>
										
									</div>
									</div>
	<div class="separator separator-bar"></div>
</div>
<script>
 $('#youtube').click(function() 
 {   
        $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_video1'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: "client"
            });
  
    });
	 $('#youtube1').click(function() 
 {   
        $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_video2'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: "client"
            });
  
    });
$('body').click(function() {
 //$('#myModal1').hide();  
//$("#myModal").hide();  
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
