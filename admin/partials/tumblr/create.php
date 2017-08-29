<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New Tumblr Account : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<h3>Tumblr Configuration Wizard</h3>
			<p>Welcome to the Tumblr Configuration Wizard. <?php /*The video above will help you if you have difficulty completing the steps below.*/ ?> 
				If any of these steps appear to have changed, please contact us at the <a href="http://www.deadbeatsuperaffiliate.com/portal/support" target="_blank">support desk</a>.</p>
			<h3>1. Register Your Application</h3>
			<p>In order to post content to Tumblr, you must first register a developer application. After logging into your Tumblr account, head on over to <a href="http://www.tumblr.com/oauth/register" target="_blank">http://www.tumblr.com/oauth/register</a>
			to begin the registration process.</p>
			<img src="<?php echo $root_url . 'admin/help/tumblr_1.jpg'; ?>">
			<p>The five fields highlighted in the image above are required. Please fill them in as described below.</p>
			<p>The application name is usually your website's title, such as <span style="font-weight: bold; background-color: #b2c0cd;">"<?php echo get_bloginfo( 'name' ); ?>." </span>
			The application website is your website's URL. Based on your Wordpress configuration, your website appears to be 
			<?php echo get_site_url(); ?>. The description can be as simple as "Manage Tumblr Content via Wordpress." The email address can be any that Tumblr can use to contact you. 
			Lastly, the callback URL isn't technically necessary for Deadbeat Traffic Blaster Pro, but you still need to fill in this field. Any URL will suffice. A suggested callback would be something like <span style="font-weight: bold; background-color: #b2c0cd;"><?php echo get_site_url(); ?>?callback</span>
			</p>
			<p>Once you've filled in the required fields, click the "Register" button to continue.</p>
			<h3>2. Copy/Paste your OAuth Credentials</h3>
			<p>Now it's time to acquire the OAuth credentials that will be used to access your account. The first two credentials are the OAuth Consumer key and Secret key. Both of these keys can be found at 
			<a href="http://www.tumblr.com/oauth/apps" target="_blank">http://www.tumblr.com/oauth/apps</a>.</p>
			<img src="<?php echo $root_url . 'admin/help/tumblr_2.jpg'; ?>">
			<p>Click the "Show secret key" link to reveal the secret. Then enter both the Consumer key and Secret key in their respective fields in the form below. It's best to copy and paste instead of trying to enter the input manually on your keyboard. Any mistakes could result in authentication errors. </p>
			<p>Next, click the "Explore API" link that is marked in the image above. You will be asked if you would like to allow access to your data. Confirm that you would.</p>
			<img src="<?php echo $root_url . 'admin/help/tumblr_3.jpg'; ?>">
			<p>You should then be presented with an access token and access token secret. They will appear on lines 3 and 4 as noted in the image above. Like you just did for the consumer key and secret, paste the access token and secret into their respective fields in the form below. </p>
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
						<th scope="row"><label for="blogname">Consumer Key:</label></th>
						<td>
							<input type="text" name="consumer_key" style="width:80%;">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="blogname">Consumer Secret:</label></th>
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
						<th scope="row"><label for="blogname">Access Token Secret:</label></th>
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
