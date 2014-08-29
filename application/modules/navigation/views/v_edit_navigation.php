<?php echo form_open(current_url(), "class='form-horizontal'"); ?>

<div class="row">
	<div class="col-lg-offset-2 col-lg-8">

		<div class="form-group">
			<?php echo form_label(t("navTitle"), "title_en", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('title_en', set_value('title_en', $title_en), 'class="form-control" placeholder="' . t("navTitlePH").'"' ); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo form_label(t("navURL"), "url", array("class" => "col-md-2 control-label")); ?>
			<div class= "col-md-10">
			<?php echo form_input('url', set_value('url', $url), 'class="form-control" placeholder="' . t("navURLPH", base_url()).'"' ); ?>
			</div>
		</div>

		<div class="form-group text-left margin-bottom-10 margin-top-10">
			<div class="primary col-lg-offset-2 col-lg-10">
				<input type="submit" name="submit" value="<?php echo $formBtn; ?>" id="submit" class="btn btn-primary" style="font-weight: bold">
			</div>
		</div>

	</div>
</div>

<?php echo form_close(); ?>


