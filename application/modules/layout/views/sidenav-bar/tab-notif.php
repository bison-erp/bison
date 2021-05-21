
 <div class="content-notif" id="content_sidenav_notif">
	<!-- begin::Item : title notif -->
			<div class="bloc-content">
				<h5 class="font-weight-normal small-h5 notif-title"><?php echo lang('actus'); ?><small class="text-muted font-size-sm"></small></h5>
					<!--span class="link-display-inline"><a href="javascript:;">view all</a></span-->
			</div>
		<!-- end: Item -->
    <div class="scroller" style="" data-always-visible="1" data-rail-visible1="0" data-handle-color="#B5B5C3">
		<ul class="feeds">
			<?php
			$path = base_url() 
				  . 'uploads/' 
				  . strtolower(
					  $this->session->userdata('licence')
					) 
				  . '/photos_users/';

			$users_log = $this->db->get('ip_users')->result();

			foreach ($users_log as $user_log) 
			{
				$image_user[
					$user_log->user_id
				] = '<span align="center" '
				  . 'class="fa fa-user img-circle" '
				  . 'style="width: 25px; height:25px;line-height:25px;background:#596572;padding: 0px;color: #DDD; ">'
				  . '</span>';

				if ($user_log->user_avatar != "") 
				{
					$statut = getHTTPStatus(
						$path 
						. $user_log->user_avatar
					);

					if ($statut['http_code'] == 200) 
					{
						$image_user[
							$user_log->user_id
						] = '<img class="img-circle fa fa-user" src="' 
						  . $path 
						  . $user_log->user_avatar 
						  . '" style="width: 25px; height:25px;line-height:25px;  padding: 0px;  background-color: #fff; color:#999;  border: 1px solid #ddd;">';
					}
				}
			}
		 
			$this->load->helper('logs');
			$logs = getLogs();
			if (!empty($logs)) {
				foreach ($logs as $log) {
					?>

					<li style=" padding:5px; cursor:pointer;max-width: 400px;" class="log_infos" data-title="<?php echo $log['infos']->user_name; ?>" data-description="<?php echo $log['message2']; ?>" data-class="<?php echo $log['class']; ?>" id="log_<?php echo $log['infos']->log_id; ?>">
						<div class="notif-item <?php echo $log['class']; ?>">
								<div class="notif-link rounded">
								<?php if ($log['class'] == 'log_success') {?>
									<div class="symbol-label <?php echo $log['class']; ?>">
										<i class="fas fa-check-circle"></i>
									</div>
								<?php } else { ?>
									<div class="symbol-label <?php echo $log['class']; ?>">
										<i class="fas fa-exclamation-circle"></i>
									</div>
								<?php }?>
									<div class="notif-text">
										<span class="details font-weight-bold font-size-lg"><?php echo $log['message']; ?></span>
										<span class="time text-muted">
												<?php
											$dt = $log['infos']->log_date;
											$dte = explode(' ', $dt);
											$dted = explode('-', $dte[0]);
											// print_r($dted);
											echo $dted[2] . '/' . $dted[1] . '/' . $dted[0] . ' ' . $dte[1];
											?>
										</span>
									</div>
								</div>
						</div>
						<div class="clearfix"></div>
					</li>
					<?php
				}
			}
			?>
		</ul>
    </div>
	
		<!-- other style notifications : activate the item to show it in the bottom of the notif side bar -->
		<!-- begin: Item : notif -->
			<!--div class="bloc-content">
				<a href="javascript:;" class="notif-item">
					<div class="notif-link rounded">
						<div class="symbol-label">
							<i class="fas fa-user-check"></i>
						</div>
						<div class="notif-text">
							<span class="details font-weight-bold font-size-lg">New user registered.</span>
							<span class="time text-muted">just now</span>
						</div>
					</div>
				</a>
			</div-->
		<!-- end: Item -->
		<!-- begin: Item : notif -->
			<!--div class="bloc-content">
				<a href="javascript:;" class="notif-item">
					<div class="notif-link rounded">
						<div class="symbol-label">
							<i class="fas fa-paper-plane"></i>
						</div>
						<div class="notif-text">
							<span class="details  font-weight-bold font-size-lg">Server #12 overloaded.</span>
							<span class="time text-muted">3 mins</span>
						</div>
					</div>
                </a>
			</div-->
		<!-- end: Item -->
		<!-- begin: Item : notif -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="notif-item">
					<div class="notif-link rounded">
						<div class="symbol-label">
							<i class="fas fa-exclamation-circle"></i>
						</div>
						<div class="notif-text">
							<span class="details font-weight-bold font-size-lg">Application error. </span>
							<span class="time text-muted">14 hrs</span>
						</div>
					</div>
                </a>
			</div-->
		<!-- end: Item -->
		<!-- begin: Item : notif -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="notif-item">
					<div class="notif-link rounded">
						<div class="symbol-label">
							<i class="fas fa-paper-plane"></i>
						</div>
						<div class="notif-text">
							<span class="details font-weight-bold font-size-lg">A user IP blocked. </span>
							<span class="time text-muted">3 days</span>
						</div>
					</div>
                </a>
			</div-->
		<!-- end: Item -->

		<!-- begin: Item : notif -->
			<!--div class="bloc-content">
                <a href="javascript:;" class="notif-item">
					<div class="notif-link rounded">
						<div class="symbol-label">
							<i class="fas fa-exclamation-circle"></i>
						</div>
						<div class="notif-text">
							<span class="details font-weight-bold font-size-lg">System Error. </span>
							<span class="time text-muted">5 days</span>
						</div>
					</div>
                </a>
			</div-->
		<!-- end: Item -->

		
</div>
