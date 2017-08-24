<?php if($wp) { ?>
	<?php foreach($wp as $val_wp) { ?>
		<tr>
			<th scope="row"><label for="blogname"><?php echo $val_wp->name;?></label></th>
			<td>
				<input name="syndicate[<?php echo $val_wp->account_id;?>][title]" style="width:50%;" value="%TITLE%">
				<p></p>
				<textarea name="syndicate[<?php echo $val_wp->account_id;?>][message]" rows="10" cols="90">%FIRST50% ... Read more: <a href="%LINK">%LINK%</a></textarea>
				<?php $cred = DTB_Admin_WP::get_instance()->get_credentials($val_wp->account_id);?>
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][account_id]" value="<?php echo $val_wp->account_id;?>">
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][service]" value="<?php echo $val_wp->service;?>">
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][client_id]" value="<?php echo $cred['client_id'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][client_secret]" value="<?php echo $cred['client_secret'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][api_token]" value="<?php echo $cred['api_token'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_wp->account_id;?>][blog_id]" value="<?php echo $cred['blog_id'];?>">
			</td>
		</tr>
	<?php } ?>
<?php } ?>
