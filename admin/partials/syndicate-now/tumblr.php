<?php if($tumblr) { ?>
	<?php foreach($tumblr as $val_tumblr) { ?>
		<tr>
			<th scope="row"><label for="blogname"><?php echo $val_tumblr->name;?></label></th>
			<td>
				<input name="syndicate[<?php echo $val_tumblr->account_id;?>][title]" style="width:50%;">
				<p></p>
				<textarea name="syndicate[<?php echo $val_tumblr->account_id;?>][message]" rows="10" cols="90"></textarea>
				<?php $cred = DTB_Admin_Tumblr::get_instance()->get_credentials($val_tumblr->account_id); ?>
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][account_id]" value="<?php echo $val_tumblr->account_id;?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][service]" value="<?php echo $val_tumblr->service;?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][blog_id]" value="<?php echo $cred['blog_id'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][consumer_key]" value="<?php echo $cred['consumer_key'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][consumer_secret]" value="<?php echo $cred['consumer_secret'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][access_token]" value="<?php echo $cred['access_token'];?>">
				<input type="hidden" name="syndicate[<?php echo $val_tumblr->account_id;?>][access_token_secret]" value="<?php echo $cred['access_token_secret'];?>">
			</td>
		</tr>
	<?php } ?>
<?php } ?>
