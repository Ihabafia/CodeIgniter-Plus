<?php echo form_open(uri_string(), "class='form-horizontal'");

?>
<div class="row">
	<div class="col-lg-offset-2 col-lg-8">

		<div class="radio-inline">
			<label>
				<input type="radio" name="roleType" id="roleType-1" value="1" <?php echo set_radio('roleType', '1', ($role->roleType==1? TRUE:FAlSE)); ?> />
				<?php echo t('singleRole'); ?>
			</label>
		</div>
		<div class="radio-inline">
			<label>
				<input type="radio" name="roleType" id="roleType-2" value="2" <?php echo set_radio('roleType', '2', ($role->roleType==2? TRUE:FAlSE)); ?> />
				<?php echo t('groupRole'); ?>
			</label>
		</div>



		<div class="form-group">
			<?php echo form_label(t("roleName"), "roleName", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('roleName', set_value('roleName', $role->roleName), 'class="form-control" placeholder="' . t("roleNamePH").'"' ); ?>
			</div>
		</div>





	<?php
		/*echo form_hidden('id', $id);
		echo form_hidden($csrf);*/
	?>

	<?php echo (empty($role->id)) ? btn(t('createS', t('role'))) : btn(t('editS', t('role'))); ?>

	</div>
</div>




<?php echo form_close();?>
