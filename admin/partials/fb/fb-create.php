<div id="dbtb-wrapper" class="about-wrap wrap">
	<h1>Add Facebook</h1>
	<div>
		<h3>Create New Facebook Account : </h3>
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
							<input type="text" name="name" style="width:80%;" value="Facebook">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">APP ID:</label></th>
						<td>
							<input type="text" name="app_id" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">APP Secret:</label></th>
						<td>
							<input type="text" name="app_secret" style="width:80%;">
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
</div>
