<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New WordPress Account : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<h3>Wordpress.com Configuration Wizard</h3>
			<p>Welcome to the Wordpress.com Configuration Wizard. The steps in this wizard were last verified for accuracy on June 9, 2015. 
			If any of these steps appear to have changed, please contact us at the <a href="http://www.deadbeatsuperaffiliate.com/portal/support" target="_blank">support desk</a>.</p>
			<h4>1. Create a Wordpress.com Application</h4>
			<p>In order to post content to your Wordpress.com blog, you must first create a developer application. To do this, first sign into your Wordpress.com Developer account at <a href="http://developer.wordpress.com" target="_blank">https://developer.wordpress.com</a>. 
				You can access the app creation page at: <a href="https://developer.wordpress.com/apps/new/" target="_blank">https://developer.wordpress.com/apps/new/</a>.</p>
			<img src="<?php echo $root_url . 'admin/help/wordpress_1.jpg'; ?>">
			<p>The app name is usually your website's title, such as "<?php echo get_bloginfo( 'name' ); ?>." The description can be as simple as "Posting content from Wordpress." The website is your website's URL.
			The Redirect URL should be </p>
			<p><span style="font-weight: bold; background-color: #74d2f6;"><?php echo admin_url('admin.php?page=dbtb-wp'); ?></span></p>
			<p>You will then be asked to answer a simple addition problem to verify you are human. When you are ready, click the "Create" button at the bottom of the page.</p>
			<h4>2. Gather Your Client ID and Client Secret</h4>
			<p>Now you need to acquire your Client ID and Client Secret. These can be found at: <a href="https://developer.wordpress.com/apps/" target="_blank">https://developer.wordpress.com/apps/</a></p>
			<img src="<?php echo $root_url . 'admin/help/wordpress_2.jpg'; ?>">
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
