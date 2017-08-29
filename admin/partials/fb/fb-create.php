<?php
$domain = get_option('siteurl'); //or home
$domain = str_replace('http://', '', $domain);
$domain = str_replace('www', '', $domain); //add the . after the www if you don't want it
$domain = strstr($domain, '/', true); //PHP5 only, this is in case WP is not root
?>
<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New Facebook Account : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<h4>Facebook Configuration Wizard</h4>
			<p>
			Welcome to the Facebook Configuration Wizard. 
			The steps in this wizard were last verified for accuracy on June 9, 2015. 
			If any of these steps appear to have changed, please contact us at the <a href="http://www.deadbeatsuperaffiliate.com/portal/support" target="_blank">support desk</a>
			</p>
			<h4>1. Create a Facebook Developer Account</h4>
			<p>In order to post content to Facebook, you must register your Facebook Developer account at <a href="http://developers.facebook.com" target="_blank">Click Here Developers Facebook</a>. To register or log into your account, go to the developer site and click the "Log In" link. You can sign up if you don't already have an account.</p>
			<img src="<?php echo $root_url . 'admin/help/facebook_1.jpg'; ?>">
			<h4>2. Create a Facebook App</h4>
			<p>Once you have logged in, return to the <a href="http://developers.facebook.com" target="_blank">developer site</a> and click the Apps link (as shown above). Select "Create a New App." You will be presented with the "Create a New App" screen. The display name is usually your website's title, such as "<?php echo get_bloginfo( 'name' ); ?>" Next, select the category that best describes your website. When you're finished, click "Create App."</p>
			<img src="<?php echo $root_url . 'admin/help/facebook_2.jpg'; ?>">
			<h4>3. Copy/Paste your App ID and App Secret</h4>
			<p>Now that your app has been created, it's time to configure the Deadbeat Traffic Blaster plugin. The App Secret is hidden by default, so you must click the "Show" button to make it visible. Enter the ID and secret in their respective fields below the following image. It's best to copy and paste instead of trying to enter the input manually on your keyboard. Any mistakes could result in authentication errors on the next page.</p>
			<img src="<?php echo $root_url . 'admin/help/facebook_3.jpg'; ?>">
			
		</div>
		<div>
			<h4>4. Update Your Email and Website Address</h4>
			<p>Before you can activate your app, you must supply Facebook with your contact email and website address. To do this, first click on the Settings option as shown in the image above. On the settings page, you have to enter your email, your website domain, and your URL.</p>
			<img src="<?php echo $root_url . 'admin/help/facebook_4.jpg'; ?>">
			<p>The Site URL option will only appear after you have added the website platform. To do this, click the "Add Platform" button then select "Website." You can then enter your domain, email, and site URL in their respective fields.</p>
			<p>The Site URL option will only appear after you have added the website platform. To do this, click the "Add Platform" button then select "Website." You can then enter your domain, email, and site URL in their respective fields.</p>
			<p>Based on your Wordpress configuration, your App Domain appears to be <span style="font-weight: bold; background-color: #8ca7e0;"><?php echo $domain; ?></span>, and your Site URL appears to be 
			<span style="font-weight: bold; background-color: #8ca7e0;"><?php echo get_site_url(); ?></span>. Once you've entered the required information, click the "Save Changes" button.</p>
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
