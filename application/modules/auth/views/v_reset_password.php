<div id="loginPage">
	<?php echo $template['partials']['message']; ?>
	<h2><?php echo lang('reset_password_heading');?></h2>

	<?php echo form_open('reset_password/' . $code);

		echo form_label(t('reset_password_new_password_label', $min_password_length), 'new_password');
	?>
	<div class="input-group">
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-lock"></span>
		</span>
	<?php
		echo form_input($new_password);
	?>
	</div>

<?php
		echo form_label(t('reset_password_new_password_confirm_label'), 'new_password_confirm');
	?>
	<div class="input-group">
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-lock"></span>
		</span>
	<?php
		echo form_input($new_password_confirm);
	?>
	</div>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<div class="text-right margin-top-10">
		<button type="submit" class="btn btn-success btn-sm" style="font-weight: bold"><?php echo t('submit') ?></button>
	</div>


	<?php echo form_close();?>
</div>




