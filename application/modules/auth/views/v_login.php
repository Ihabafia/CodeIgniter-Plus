<div id="loginPage">
	<?php
		echo $template['partials']['message'];
		//echo(!empty($message) ? "<div class='alert alert-danger center'>$message</div>" : '');
		echo form_open('login', 'id="login-form"');
		echo form_label(t('username'), 'username');
	?>
	<div class="input-group">
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-user"></span>
		</span>
	<?php
		echo form_input('identity', set_value('identity'), 'class="form-control" placeholder= "' . t('usernamePH') . '"');
	?>
	</div>

	<?php
		echo form_label(t('password'), 'password');
	?>
	<div class="input-group">
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-lock"></span>
		</span>
	<?php
		echo form_password('password', set_value('password'), 'class="form-control" placeholder= "' . t('passwordPH') . '"');
	?>
	</div>

	<div class="text-right margin-top-10">
		<a href="/forgot_password"><?php echo t('lostpass'); ?></a>
		<button type="submit" class="btn btn-success btn-sm" style="font-weight: bold"><?php echo t('login') ?></button>
	</div>
	<?php
		echo form_close();
	?>
</div>



