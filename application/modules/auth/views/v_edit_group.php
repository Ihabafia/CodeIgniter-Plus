<p><?php echo lang('edit_group_subheading');?></p>

<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

	<?php echo btn(t('edit_group_submit_btn'), 'success', 'left'); ?>

<?php echo form_close();?>