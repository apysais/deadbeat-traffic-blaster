<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New Twitter Account : </h3>
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
							<input type="text" name="name" style="width:80%;" value="Twitter">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Consumer Key (API Key):</label></th>
						<td>
							<input type="text" name="consumer_key" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Consumer Secret (API Secret):</label></th>
						<td>
							<input type="text" name="consumer_secret" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Access Token:</label></th>
						<td>
							<input type="text" name="access_token" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Access token secret:</label></th>
						<td>
							<input type="text" name="access_token_secret" style="width:80%;">
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
</div>
