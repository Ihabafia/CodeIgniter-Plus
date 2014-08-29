<div class="row">
	<div class="col-md-offset-2 col-md-8">
		<div class="dd" id="nestable3">
			<ol class="dd-list">
				<?php echo $list; ?>
			</ol>
		</div>
		<?php echo form_open(); ?>
		<div class="form-group margin-bottom-10 margin-top-10">
			<div class="col-md-12 center margin-top-10">
				<input type="submit" name="submit" value="<?php echo t('update'); ?>" id="submit" class="btn btn-primary" style="font-weight: bold">
			</div>
		</div>

		<?php echo form_hidden('id'); ?>
		<?php echo form_close(); ?>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="delNavMod" tabindex="-1" role="dialog" aria-labelledby="delNavModLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo t('delNav'); ?></h4>
			</div>
			<div class="modal-body">
				<strong><?php echo t('rusure', 'user'); ?></strong>
			</div>
			<div class="modal-footer">

				<?php echo form_open('');
				$data_form = array('name' => 'delNav', 'class' => 'btn btn-danger', 'id' => 'delNavBtn', 'value' => t('delete')); ?>
				<?php echo form_hidden('id'); ?>
				<?php echo form_submit($data_form); ?>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo t('cancel'); ?></button>
				<?php echo form_close(); ?>

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

	$(document).ready(function()
	{

		var updateOutput = function(e)
		{
			var list   = e.length ? e : $(e.target);

			nav = list.nestable('serialize');
		};

		$('#nestable3').nestable({
			group: 1
		}).on('change', updateOutput);

		updateOutput($('#nestable3').data('output', $('#nestable-output')));

		$('#nestable').nestable();


		$('#submit').click(function (event)
		{
			event.preventDefault();

			var formData = {};
			formData.dataI = nav;

			$().checkSession();

			$.ajax({
				type    : 'POST',
				url     : '/navigation/sort',
				data    : formData,
				dataType: 'json',
				cache   : false,
				timeout : 15000,
				success : function (data)
				{
					window.location.href = "/navigation";
					/*setTimeout(function() {
						window.location.href = "/navigation";
					}, 4000);*/
				}
			});
		});
	});
</script>
