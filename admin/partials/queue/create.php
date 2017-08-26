<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Queue : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<form name="settings" method="post" action="<?php echo $action;?>">
				<input type="hidden" name="_method" value="<?php echo $method;?>">
				<p>Name : </p>
				<p><input type="text" name="queue_name" style="width:50%;"></p>
				<div class="list-posts">
					<p>Choose Post</p>
					<select name="post_id[]" multiple style="width:50%;">
					<?php
						foreach($choose_posts as $k => $v){
							echo '<option value="'.$v->ID.'">';
									echo $v->post_title;
							echo '</option>';
						}
					?>
					</select>
				</div>
				<div>
					<p>For FB Page, Choose which page to post</p>
					<?php if($fb){ ?>
						<?php foreach($fb as $val_fb) { ?>
							<?php
								$cred = DTB_Admin_Facebook::get_instance()->get_credentials($val_fb->account_id);
								$me = DTB_API_Facebook::get_instance()->me_account(
									$cred['app_id'], 
									$cred['app_secret'], 
									$cred['fb_access_token']
								);
								$page = $me->getDecodedBody();
							?>
							<?php if( isset($page['accounts']['data']) ){ ?>
								<select name="choose_fb_page[]" id="choose_fb_page" multiple style="width:50%;">
									<?php foreach($page['accounts']['data'] as $val_pages){ ?>
											<option value="<?php echo $val_pages['id']; ?>">
												<?php echo $val_pages['name']; ?>
											</option>
									<?php } ?>
								</select>
								<input type="hidden" name="queue_fb_page[app_id]" value="<?php echo $cred['app_id']; ?>">
								<input type="hidden" name="queue_fb_page[app_secret]" value="<?php echo $cred['app_secret']; ?>">
								<input type="hidden" name="queue_fb_page[fb_access_token]" value="<?php echo $cred['fb_access_token']; ?>">
							<?php } ?>
						<?php }//foreach($fb) ?>
					<?php }//if($fb) ?>
				</div>
				<p><input type="submit" value="Add" name="Add"></p>
				<p><input type="button" onclick="location.href='admin.php?page=tbsettings&pg=queue_syndicate';" value="Go Back" /></p>
			</form>
		</div>

	</div>
</div>

