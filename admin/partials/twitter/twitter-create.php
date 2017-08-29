<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Create New Twitter Account : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<h3>Twitter Configuration Wizard</h3>
			<p>	Welcome to the Twitter Configuration Wizard. <?php /*The video above will help you if you have difficulty completing the steps below.*/ ?> The steps in this wizard were last verified for accuracy on June 9, 2015. </p>
			<p>If any of these steps appear to have changed, please contact us at the <a href="http://www.deadbeatsuperaffiliate.com/portal/support" target="_blank">support desk</a></p>
			<h4>1. Create a Twitter Application</h4>
			<p>In order to post content to Twitter, you must first create a developer application. To do this, first sign into your Twitter Developer account at <a href="https://apps.twitter.com/app/new" target="_blank">http://dev.twitter.com</a>. </p>
			<p>Upon logging in, you will be presented with the "Create an application" page. You can also access that page directly at this address: <a href="https://apps.twitter.com/app/new" target="_blank">https://apps.twitter.com/app/new</a>.</p>
			<p><strong>*NOTE: Prior to creating an app, you must have activated a mobile phone in your Twitter Profile Settings.</strong></p>
			<img src="<?php echo $root_url . 'admin/help/twitter_1.jpg'; ?>">
			<p>The app name is usually your website's title, such as "<?php echo get_bloginfo( 'name' ); ?>." The description can be as simple as "Posting content from Wordpress." The website is your website's URL. Based on your Wordpress configuration, your website appears to be <span style="font-weight: bold; background-color: #74d2f6;"><?php echo get_site_url(); ?></span></p>
			<p>After you have filled out the three fields, you must agree to the Developer Rules of the Road by checking the box below the rules, and then clicking "Create your Twitter application."</p>
			<h4>2. Modify App Permissions</h4>
			<p>By default, you are not allowed to publish content to Twitter feeds. To enable this functionality, you must change your app permissions. After your app has been created, you should be automatically 
			redirected to the app details page. You can alternatively access the app details page by going to <a href="https://apps.twitter.com" target="_blank">https://apps.twitter.com</a> and selecting the name of the app that you just created.
			Once on the details page, click the Permissions tab, as shown below. Once on the Permissions page, select the option to "Read and Write" and then click the "Update settings" button.</p>
			<img src="<?php echo $root_url . 'admin/help/twitter_2.jpg'; ?>">
			<h4>3. Gather Your Access Keys And Tokens</h4>
			<p>After a minute or two, your permissions should have updated. It's now time to generate your access token and then configure the Deadbeat Traffic Blaster plugin.</p>
			<p>The tokens can be found on the API Keys tab.</p>
			<img src="<?php echo $root_url . 'admin/help/twitter_3.jpg'; ?>">
			<p>To create your access token, simply click the "Create my access token" button. It may take a minute or two for your token to be generated. Refresh the page to view the tokens. Once the tokens have been generated, verify that the access level is listed as "Read and write." If it's listed as "read only," then you will have to repeat step #2. </p>
			<p>In the area marked credentials, you will find the API key and secret. Enter both the API key and secret as well as the Access token and token secret in their respective fields below. It's best to copy and paste instead of trying to enter the input manually on your keyboard. Any mistakes could result in authentication errors.</p>
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
			<p>Congratulations! After you click the "Save Changes" button below, you can begin posting to Twitter.</p>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
</div>
