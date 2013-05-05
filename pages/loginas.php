<div class="wrap">
	<h2><?php _e($GLOBALS['title'], 'emloginas'); ?></h2>

	<form action="<?php echo esc_html(admin_url('admin-post.php')); ?>" method="post">
		<label for="username"><?php _e('Log in as:', 'emloginas'); ?></label>
		<select name="userid">
		<?php foreach ($GLOBALS['params']['users'] as $x) : ?>
			<option value="<?php echo $x->ID; ?>"><?php echo esc_html($x->user_login); ?> (<?php echo $x->ID; ?>)</option>
		<?php endforeach; ?>
		</select>
		<br/>

		<p class="submit">
			<?php wp_nonce_field('login-as'); ?>
			<input type="hidden" name="action" value="login_as"/>
			<input type="submit" value="<?php _e('Log In', 'emloginas'); ?>" class="button button-primary"/>
		</p>
	</form>
</div>