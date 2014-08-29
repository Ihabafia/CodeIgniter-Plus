<div class="row">
	<div class="col-lg-12">
		<?php
			echo form_open(uri_string(), "class='form-horizontal'");
			echo $printTable;

			//echo anchor('/navigation/permission_submit', t('updatePermissions'));

			echo btn(t('updateS', t('permissions')));

		 ?>
	</div>
</div>

<h1 class="strong">Menu Test</h1>
<?php
$groups = Modules::run('group/get_groupsObj');

foreach ($groups as $group):
?>
	<div class="row">
		<div class="col-lg-12" style="padding: 10px 20px">
			<strong><?php echo humanize($group->name); ?></strong>
		</div>
	</div>
	<!-- Navigation -->
	<div class="navbar navbar-inverse">
		<div class="test" >
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#tablets">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><?php echo Modules::run('pref/_site_name'); ?></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="tablets">
				<?php echo Modules::run('navigation/build_test', $group->id); ?>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</div>
<?php
endforeach;
brs(15);
?>
