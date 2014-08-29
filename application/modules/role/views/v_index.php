<div class="row">
	<div class="col-lg-12">
		<?php
			echo form_open(uri_string(), "class='form-horizontal'");
			echo $printTable;

			if(Modules::run('role/has_role', 'create_role'))
				echo anchor('/role/create', t('addRole'));

			echo btn(t('updateS', t('roles')));

		 ?>
	</div>
</div>
