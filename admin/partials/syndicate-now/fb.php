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
		<tr>
			<th scope="row"><label for="blogname"><?php echo $val_fb->name;?></label></th>
			<td>
				<?php if( isset($page['accounts']['data']) ){ ?>
					<select name="syndicate[<?php echo $val_fb->account_id;?>][pages]">
						<?php foreach($page['accounts']['data'] as $val_pages){ ?>
								<option value="<?php echo $val_pages['access_token']; ?>::<?php echo $val_pages['id']; ?>">
									<?php echo $val_pages['name']; ?>
								</option>
						<?php } ?>
					</select>
					
					<input type="hidden" name="syndicate[<?php echo $val_fb->account_id;?>][account_id]" value="<?php echo $val_fb->account_id;?>">
					<input type="hidden" name="syndicate[<?php echo $val_fb->account_id;?>][service]" value="<?php echo $val_fb->service;?>">
					<input type="hidden" name="syndicate[<?php echo $val_fb->account_id;?>][app_id]" value="<?php echo $cred['app_id']; ?>">
					<input type="hidden" name="syndicate[<?php echo $val_fb->account_id;?>][app_secret]" value="<?php echo $cred['app_secret']; ?>">
					<input type="hidden" name="syndicate[<?php echo $val_fb->account_id;?>][fb_access_token]" value="<?php echo $cred['fb_access_token']; ?>">
				<?php } ?>
				<p></p>
				<textarea name="syndicate[<?php echo $val_fb->account_id;?>][message]" rows="10" cols="90">%TITLE% - %LINK%</textarea>
			</td>
		</tr>
	<?php } ?>
<?php } ?>

