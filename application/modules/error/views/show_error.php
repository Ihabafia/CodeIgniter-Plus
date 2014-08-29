
<!DOCTYPE html>
<html lang="en">
<?php echo $header; ?>
<body id="error_404" style="background-color: #fff; direction: <?php echo t('direction'); ?>">
	<!-- Page Navigation -->
	<?php if(!isset($active)) $active =''; ?>
	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div id="navi" class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#tablets">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><?php echo $site_name ?></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="tablets">
				<?php echo $nav; ?>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>
	<!-- Page Content -->
	<div class="container">
		<div class="row"><!-- /.row -->
			<div class="col-lg-12">
				<div id="page-header" class="strong">
					<h3 class="subHeading"><small></small></h3>
					<h3 id="page-title" class="strong"><?php echo $title; ?></h3>
				</div>
				<?php echo $body; ?>
			</div>
			<?php echo $copyright;?>
		</div><!-- /.row -->
	</div>
	<!-- Page Content -->
</body>
</html>
