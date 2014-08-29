		<!-- Footer -->
		<div class="navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text"><small><?php echo t('copyright', Modules::run('pref/_copyright', $this->session->userdata('lang'))); ?></small></p>
				<a href="/logout" class="navbar-btn btn-danger btn btn-sm pull-right"><?php echo t('logout'); ?></a>
			</div>
		</div>
