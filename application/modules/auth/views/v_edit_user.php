<?php echo form_open(uri_string(), "class='form-horizontal'");
$d = ($this->my_auth->is_admin()? '':'disabled=disabled');
?>
<div class="row">
	<div class="col-lg-offset-2 col-lg-8">

		<div class="form-group">
			<?php echo form_label(t("userCodeId"), "user_code_id", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('user_code_id', set_value('user_code_id', $user->user_code_id), 'class="form-control" placeholder="' . t("userCodeIdPH").'"'. $d ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("username"), "username", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('username', set_value('username', $user->username), 'class="form-control" placeholder="' . t("usernamePH").'"'. $d ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("password"), "password", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_password('password', set_value('password'), 'class="form-control" placeholder="' . t("passwordPH").'"' ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("password"), "passwordConf", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_password('password_confirm', set_value('password_confirm'), 'class="form-control" placeholder="' . t("password_confirmPH").'"' ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("first_name"), "first_name", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('first_name', set_value('first_name', $user->first_name), 'class="form-control" placeholder="' . t("first_namePH").'"'. $d ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("last_name"), "last_name", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('last_name', set_value('last_name', $user->last_name), 'class="form-control" placeholder="' . t("last_namePH").'"'. $d ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("mobile"), "mobile", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('mobile', set_value('mobile', $user->mobile), 'class="form-control" placeholder="' . t("mobilePH").'"' ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("email"), "email", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input_email('email', set_value('email', $user->email), 'class="form-control" placeholder="' . t("emailPH").'"' ); ?>
			</div>
		</div>
		<?php if ($this->my_auth->is_admin()): ?>
		<div class="form-group">
			<?php echo form_label(t("group"), "group", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php
				if(!empty($id) and (Modules::run('role/has_role', 'cannot_edit_his_own_group') and $user->id == $this->session->userdata['user_id'])){
					echo '<div class="form-control-static">'.humanize($this->session->userdata['group_name']).'</div>';
					//echo '<div class="controls readonly">John Smith</div>';
					echo form_hidden('group_id', $user->group_id);
				} else {
					echo form_dropdown('group_id', $groups_options, set_value('group_id', $user->group_id), 'class="form-control"');
				} ?>
			</div>
		</div>
		<?php endif; ?>
		<?php echo form_hidden('id', $id);?>
		<?php echo form_hidden($csrf); ?>

		<?php echo (empty($id)) ? btn(t('create')) : btn(t('edit')); ?>

	</div>
</div>



<?php echo form_close();?>
