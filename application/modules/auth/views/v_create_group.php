<p><?php echo lang('create_group_subheading');?></p>

<?php echo form_open("auth/create_group");?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('create_group_desc_label', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

	<?php echo btn(t('create_group_submit_btn'),'left', 'success', ''); ?>
      <p><?php /*echo form_submit('submit', lang('create_group_submit_btn'));*/?></p>

<?php echo form_close();?>