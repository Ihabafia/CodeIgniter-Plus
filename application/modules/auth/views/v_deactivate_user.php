<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" checked="checked" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

	<?php /*echo btn(t('submit'), 'left', 'danger');*/ ?>
		<div class="form-group text-left margin-bottom-10 margin-top-10">
			<?php echo form_submit(['name'=>'submit', 'value'=>t('submit'), 'class'=>'btn btn-danger', 'style'=>'bold']); ?>
		</div>
<?php echo form_close();?>