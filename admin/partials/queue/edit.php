<style>
.code {
    font-family: Lucida Console,DejaVu Sans Mono,Andale Mono,Monaco,courier new,courier,monospace;
    background-color: #D3D3D3;
    border: 2px solid #999999;
    padding-left: 2px;
    padding-right: 2px;
    padding-top: 2px;
    padding-bottom: 2px;
    word-wrap: break-word;
}
.confluence-information-macro-warning {
    background: #fff8f7;
    border-color: #d04437;
}
.confluence-information-macro-note {
    background: #fffdf6;
    border-color: #ffeaae;
}
.confluence-information-macro {
    border: 1px solid #ccc;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    color: #333;
    margin: 10px 0 1em 0;
    min-height: 20px;
    padding: 10px 10px 10px 36px;
    position: relative;
}
.pdl .codeContent .syntaxhighlighter>table td:first-child {
    padding-left: 15px;
}
.pdl .syntaxhighlighter a, .pdl .syntaxhighlighter div, .pdl .syntaxhighlighter code, .pdl .syntaxhighlighter table, .pdl .syntaxhighlighter table td, .pdl .syntaxhighlighter table tr, .pdl .syntaxhighlighter table tbody, .pdl .syntaxhighlighter table thead, .pdl .syntaxhighlighter table caption, .pdl .syntaxhighlighter textarea {
    line-height: 20px;
    font-size: 14px;
}
.syntaxhighlighter table td.code {
    width: 100%;
}
.syntaxhighlighter a, .syntaxhighlighter div, .syntaxhighlighter code, .syntaxhighlighter table, .syntaxhighlighter table td, .syntaxhighlighter table tr, .syntaxhighlighter table tbody, .syntaxhighlighter table thead, .syntaxhighlighter table caption, .syntaxhighlighter textarea {
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    background: 0;
    border: 0;
    bottom: auto;
    float: none;
    height: auto;
    left: auto;
    line-height: 1.2em;
    margin: 0;
    outline: 0;
    overflow: visible;
    padding: 0;
    position: static;
    right: auto;
    text-align: left;
    top: auto;
    vertical-align: baseline;
    width: auto;
    box-sizing: content-box;
    font-family: "Consolas","Bitstream Vera Sans Mono","Courier New",Courier,monospace;
    font-weight: normal;
    font-style: normal;
    font-size: 1em;
    min-height: inherit;
}
</style>
<div>
	<form name="settings" method="post" action="<?php echo $action;?>">
		<input type="hidden" name="_method" value="<?php echo $method;?>">
		<input type="hidden" name="id" value="<?php echo $edit_db->id;?>">
		
		<h3>Add a cron job in cpanel</h3>
		<p>To create a cron job, perform the following steps:</p>
		<ol><li>Select the interval at which you wish to run the cron job from the appropriate menus, or enter the values in the text boxes.<br><ul><li><p><em>Common Settings</em>&nbsp;— This menu allows you to select a commonly-used interval. The system will configure the appropriate settings in the&nbsp;<em>Minute</em>,&nbsp;<em>Hour</em>,&nbsp;<em>Day</em>,&nbsp;<em>Month</em>, and&nbsp;<em>Weekday</em>&nbsp;text boxes for you.</p><div class="confluence-information-macro confluence-information-macro-note conf-macro output-block" data-hasbody="true" data-macro-name="note"><p class="title">Note:</p><span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"> </span><div class="confluence-information-macro-body"><p>If the wildcard characters (<code>*</code>) and intervals confuse you, this menu is an excellent way to learn how to configure the other fields.</p></div></div></li><li><em>Minute</em>&nbsp;— Use this menu to select the number of minutes between each time the cron job runs, or the minute of each hour on which you wish to run the cron job.</li><li><em>Hour</em>&nbsp;— Use this menu to select the number of hours between each time the cron job runs, or the hour of each day on which you wish to run the cron job.</li><li><em>Day</em>&nbsp;— Use this menu to select the number of days between each time the cron job runs, or the day of the month on which you wish to run the cron job.</li><li><em>Month</em>&nbsp;— Use this menu to select the number of months between each time the cron job runs, or the month of the year in which you wish to run the cron job.</li><li><p><em>Weekday</em>&nbsp;— Use this menu to select the days of the week on which you wish to run the cron job.</p></li></ul></li><li><p>In the&nbsp;<em>Command</em>&nbsp;text box, enter the command that you wish the system to run.</p><div class="confluence-information-macro confluence-information-macro-note conf-macro output-block" data-hasbody="true" data-macro-name="note"><p class="title">Notes:</p><span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"> </span><div class="confluence-information-macro-body"><ul><li><p>Specify the absolute path to the command that you wish to run. For example, to run this, enter the following command (Copy and paste the url below in your command textbox / input):</p><div class="code panel pdl conf-macro output-block" data-hasbody="true" data-macro-name="code" style="border-width: 1px;"><div class="codeContent panelContent pdl">
		<div><div id="highlighter_86189" class="syntaxhighlighter sh-confluence nogutter  java"><div class="toolbarx"><span></span></div><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="code"><div class="container" title="Hint: double-click to select code"><div class="line number1 index0 alt2">
			<code class="code"><?php echo $url_cron;?></code>
			<p>Example in your cron jobs command line (with time):</p>
			<code class="code">* * * * * <?php echo $url_cron;?></code>
		</div></div>
		</td></tr></tbody></table></div></div>
		</div></div></li><li><p>To disable notifications for a specific cron job, add the following line to the command:</p><div class="code panel pdl conf-macro output-block" data-hasbody="true" data-macro-name="code" style="border-width: 1px;"><div class="codeContent panelContent pdl">
		<div><div id="highlighter_879325" class="syntaxhighlighter sh-confluence nogutter  bash"><div class="toolbarx"><span></span></div><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="code"><div class="container" title="Hint: double-click to select code"><div class="line number1 index0 alt2"><code class="bash plain">&gt;</code><code class="bash plain">/dev/null</code> <code class="bash plain">2&gt;&amp;1</code></div></div></td></tr></tbody></table></div></div>
		</div></div></li></ul></div></div><div class="confluence-information-macro confluence-information-macro-warning conf-macro output-block" data-hasbody="true" data-macro-name="warning"><p class="title">Important:</p><span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"> </span><div class="confluence-information-macro-body"><ul><li>You <strong>must</strong> specify settings for the <em>Minute</em>, <em>Hour</em>, <em>Day</em>, <em>Month</em>, <em>Weekday</em>, and <em>Command</em> text boxes.</li><li>Exercise <strong>extreme</strong> caution when you use the&nbsp;<code>rm</code> command in a cron job. If you do not declare the correct options, you may delete your home directory's data.</li></ul></div></div></li><li>Click&nbsp;<em>Add New Cron Job</em>.</li></ol>
		<hr>
		<p>Name : </p>
		<p><input type="text" name="queue_name" value="<?php echo $edit_db->name;?>" style="width:50%;"></p>
		<div class="list-posts">
			<p>Choose Post</p>
			<select name="post_id[]" multiple style="width:50%;">
			<?php
				foreach($choose_posts as $k => $v){
					if( in_array($v->ID, $get_post_id_array) ){
						echo '<option value="'.$v->ID.'" selected>';
					}else{
						echo '<option value="'.$v->ID.'" >';
					}
							echo $v->post_title;
					echo '</option>';
				}
			?>
			</select>
		</div>
		<div>
			<p>For FB Page, Choose which page to post</p>
			<?php if( count($choose_fb_page) > 0 ){ //count($choose_fb_page)?>
					<select name="choose_fb_page[]" id="choose_fb_page" multiple style="width:50%;">
						<?php foreach($choose_fb_page as $k => $v){
							if( in_array($v['id'], $current_fb_pages) ){
								echo '<option value="'.$v['id'].'" selected>';
							}else{
								echo '<option value="'.$v['id'].'">';
							}
								echo $v['name'];
							echo '</option>';
						} ?>
					</select>
			<?php }//count($choose_fb_page) ?>
		</div>
		<p><input type="submit" value="Update" name="Update"></p>
		<p><input type="button" onclick="location.href='admin.php?page=dbtb-queue';" value="Go Back" /></p>
	</form>
</div>
