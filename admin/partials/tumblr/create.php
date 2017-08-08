<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New Tumblr Account : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<form name="settings" method="post" action="<?php echo $action;?>">
			<input type="hidden" name="_method" value="<?php echo $method;?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="blogname">Name : </label></th>
						<td>
							<input type="text" name="name" style="width:80%;" value="Tumblr">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Blog ID:</label></th>
						<td>
							<input type="text" name="blog_id" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">OAuth Consumer Key:</label></th>
						<td>
							<input type="text" name="oauth_consumer_key" style="width:80%;">
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
</div>
