<?php if($twitter) { ?>
	<?php foreach($twitter as $val_twitter) { ?>
		<tr>
			<th scope="row"><label for="blogname"><?php echo $val_twitter->name;?> </label></th>
			<td>
				<input type="checkbox" name="exclude_this[]" value="<?php echo $val_twitter->service;?>"> Exclude This?
				<p></p>
				<textarea name="syndicate[<?php echo $val_twitter->account_id;?>][message]" rows="10" cols="90">%TITLE% %LINK%</textarea>
				<?php $cred = DTB_Admin_Twitter::get_instance()->get_credentials($val_twitter->account_id);	?>
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][account_id]" value="<?php echo $val_twitter->account_id;?>">
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][service]" value="<?php echo $val_twitter->service;?>">
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][consumer_key]" value="<?php echo $cred['consumer_key'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][consumer_secret]" value="<?php echo $cred['consumer_secret'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][access_token]" value="<?php echo $cred['access_token'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_twitter->account_id;?>][access_token_secret]" value="<?php echo $cred['access_token_secret'];?>">
			</td>
		</tr>
	<?php } ?>
<?php } ?>
