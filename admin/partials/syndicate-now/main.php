<style>
.errors p{
background: red;
    color: white;
}
.success p{
background: blue;
    color: white;
}

</style>
<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Syndicate Now : </h3>
	</div>
	<div class="wrap">
		<div class="errors">
			<?php $error = DTB_Notice::get_instance()->getError();?>
			<?php if( $error ){ ?>
				<?php foreach($error as $k => $v){ ?>
					<p><?php echo $v;?></p>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="success">
			<?php $success = DTB_Notice::get_instance()->getSuccess();?>
			<?php if( $success ){ ?>
				<?php foreach($success as $k => $v){ ?>
					<p><?php echo $v;?></p>
				<?php } ?>
			<?php } ?>
		</div>
		<?php DTB_Notice::get_instance()->clear(); ?>
		<div>
			<p>You can use the following macros in any of the content fields below. These macros will be replaced with their corresponding values when the content is published. </p>

			<h3>Content Macros</h3>
			<p>MACRO	Description</p>
			<p><span style="font-weight:bold;">%TITLE%</span>	The title of the post</p>
			<p><span style="font-weight:bold;">%LINK%</span>	The current permalink to the post</p>
			<p><span style="font-weight:bold;">%CONTENT%</span>	The whole content in the post body</p>
			<p><span style="font-weight:bold;">%FIRST50%</span>	The first fifty words in the post body, counted by spaces</p>
		</div>
		<form name="settings" method="post" action="<?php echo $action;?>">
			<input type="hidden" name="_method" value="<?php echo $method;?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="blogname">Post : </label></th>
						<td>
							<?php if( $posts_array ){ ?>
									<select name="posts[]" style="width:50%;" multiple>
										<?php foreach($posts_array as $post){ ?>
												<option value="<?php echo $post->ID;?>">
													<?php echo $post->post_name;?>
												</option>
										<?php } ?>
									</select>
							<?php } ?>
						</td>
					</tr>
					<?php DTB_Controllers_Facebook::get_instance()->syndicate_html(); ?>
					<?php DTB_Controllers_Twitter::get_instance()->syndicate_html(); ?>
					<?php DTB_Controllers_Tumblr::get_instance()->syndicate_html(); ?>
					<?php DTB_Controllers_WP::get_instance()->syndicate_html(); ?>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Syndicate Now"></p>
		</form>
	</div>
</div>

