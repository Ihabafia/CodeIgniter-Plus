<div id="loginPage">
	<?php echo $template['partials']['message']; ?>
	<h2><?php echo lang('forgot_password');?></h2>
	<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

	<?php echo form_open("forgot_password");

		echo form_label(t($identity_label), $identity_label);
	?>
	<div class="input-group">
		<span class="input-group-addon">
			<?php echo $icon ?>
		</span>
	<?php
		echo form_input('email', set_value('email'), 'class="form-control" placeholder= "' . t(strtolower($identity_label).'PH') . '"');
	?>
	</div>


	<div class="text-right margin-top-10">
		<a href="/login"><?php echo t('login'); ?></a>
		<button type="submit" class="btn btn-success btn-sm" style="font-weight: bold"><?php echo t('send') ?></button>
	</div>


	<?php echo form_close();?>
</div>
