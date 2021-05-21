<!DOCTYPE html>
<div class="tab head-content">
  <button class="tablinks" onclick="openCity(event, 'help')">Aide</button>
  <button class="tablinks" onclick="openCity(event, 'video')">Tutoriels vidéos</button>
</div>
<!-- begin: section -->
<div id="help" class="tabcontent">
	<div class="tab tab-help" id="tab_help">
		<!--begin: Item-->
			<h5 class="font-weight-bold big-h5"><?php echo lang('quest_resp') ?></h5>
				<div class="bloc-content">
					<span class="text-hover-primary">Peut-on travailler à plusieurs sur Bison ?</span>
					<span class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
				</div>
		<!--end: Item-->
		<!--begin: Item-->
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary">Ou mes données sont-elles stockées ?</span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary">Lorem ipsum dolor sit amet ?</span>
			</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary">Lorem ipsum dolor  consectetur adipiscing ?</span>
			</div>
			<div class="separator separator-bar"></div>
				<div class="bloc-content">
					<span class="text-secondary">Lorem ipsum dolor sit amet ?</span>
				</div>
			<div class="separator separator-bar"></div>
			<div class="bloc-content">
				<span class="text-secondary">Puis-je donner un accès l’expert comtable ?</span>
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
				<h5 class="font-weight-bold small-h5">Des vidéos pour vous aider</h5>
			</div>
							<!--begin: Item-->
								<div class="content-bar video-menu">
									<div class="bloc-content">
										<span class="text-hover-primary vd-5">Créer un Contact</span>
										<iframe class="video-iframe" height="176" src="https://www.youtube.com/embed/gMUbZMdDRCo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									</div>
								</div>
			<div class="separator separator-bar"></div>
							<!--end: Item-->
							<!--begin: Item-->
								<div class="content-bar video-menu">
									<div class="bloc-content">
										<span class="text-hover-primary vd-5">Créer un devis</span>
										<iframe class="video-iframe" height="176" src="https://www.youtube.com/embed/gMUbZMdDRCo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									</div>
								</div>
			<div class="separator separator-bar"></div>
							<!--end: Item-->
							<!--begin: Item-->
								<div class="content-bar video-menu">
									<div class="bloc-content">
										<span class="text-hover-primary vd-5">Créer une facture</span>
										<iframe class="video-iframe" height="176" src="https://www.youtube.com/embed/gMUbZMdDRCo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									</div>
								</div>
			<div class="separator separator-bar"></div>
							<!--end: Item-->
	</div>
</div>

<!-- end: section -->
<script>
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
</script>

