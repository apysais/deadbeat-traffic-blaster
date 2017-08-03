<div id="dbtb-wrapper" class="about-wrap wrap">
	<h1><?php echo $heading;?></h1>
	<div>
		<h2 class="nav-tab-wrapper wp-clearfix">
			<a href="#" class="nav-tab nav-tab-active">Social Media Accounts</a>
			<a href="#" class="nav-tab">Activity Logs</a>
			<a href="#" class="nav-tab">Syndicate Now</a>
			<a href="#" class="nav-tab">Queue Syndicate</a>
		</h2>
	</div>
	<div class="feature-section one-col">
		<p class="lead-description">Welcome to Deadbeat Traffic Blaster. You can edit your social media accounts below. Once you have configured at least one account, you can begin syndicating content via individual Posts and Pages, or you can post directly to any of your accounts via Syndicate Now</p>
	
	</div>
	<div class="feature-section two-col">
		<div class="col">
			<h3>Facebook</h3>
			<?php //print_r($fb_api);?>
			<?php if( !empty($fb_api) ){ ?>
				<?php foreach($fb_api as $k => $v) { ?>
						<form>
							<input type="hidden" name="id" value="<?php echo $v->id;?>">
							<?php $settings = unserialize($v->settings);?>
							<p>Name : <input type="text" name="name" value="<?php echo $v->name;?>" style="width:100%;"></p>
							<p>App ID : <input type="text" name="name" value="<?php echo $settings['app_id'];?>" style="width:100%;"></p>
							<p>App Secret : <input type="text" name="name" value="<?php echo $settings['app_secret'];?>" style="width:100%;"></p>
							<p><input type="submit" name="submit" id="submit" class="button button-primary" value="Re Authenticate">  <input type="submit" name="submit" id="submit" class="button button-primary" value="Delete"></p>
						</form>
						<hr>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="col">
			<h3>Title</h3>
		</div>
	</div>
</div>
