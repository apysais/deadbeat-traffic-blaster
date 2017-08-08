<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New WordPress Account : </h3>
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
							<input type="text" name="name" style="width:80%;" value="WordPress">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Client ID:</label></th>
						<td>
							<input type="text" name="client_id" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Client Secret:</label></th>
						<td>
							<input type="text" name="client_secret" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Redirect URL:</label></th>
						<td>
							<input type="text" name="redirect_url" style="width:80%;" value="<?php echo $redirect_url;?>" readonly>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
</div>
