<div id="dbtb-wrapper" class="about-wrap wrap">
	<div>
		<h3>Queue : </h3>
	</div>
	<div class="wrap">
		<div class="error hidden">
			<p>Error</p>
		</div>
		<div>
			<h3><a href="admin.php?page=<?php echo $menu_slug;?>&_method=create_queue">Create New</a></h3>
			<div>
				<h3>List</h3>
				<?php if( $list ){//$db_list ?>
						<ul>
							<?php foreach($list as $k => $v){ ?>
									<li>
										<p><?php echo $v->name;?> - <a href="<?php echo $edit_url;?>&id=<?php echo $v->id;?>">Edit</a> 
										| <a href="<?php echo $delete_url;?>&id=<?php echo $v->id;?>">Delete</a></p>
									</li>
							<?php }//foreach $db_list ?>
						</ul>
				<?php }//$db_list ?>
			</div>
		</div>
	</div>
</div>

