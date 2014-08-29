<!DOCTYPE html>
<html lang="en">
<?php echo $template['partials']['header']; ?>
<body id="<?php echo $this->router->method; ?>" style="background-color: #fff; direction: <?php echo t('direction'); ?>">
	<!-- Page Navigation -->
	<?php echo $template['partials']['nav'];?>
	<!-- Page Content -->
	<div class="container">
		<div class="row"><!-- /.row -->
			<div class="col-lg-12">
				<div id="page-header" class="strong">
					<h3 class="subHeading"><small><?php echo $template['parentTitle']; ?></small></h3>
					<h3 id="page-title" class="strong"><?php echo $template['title']; ?></h3>
				</div>
				<?php echo $template['partials']['message']; ?>
				<?php echo $template['body']; ?>
			</div>
		</div><!-- /.row -->
	</div>
	<!-- Page Content -->
	<?php echo $template['partials']['javascript']; ?>
	<?php echo $template['partials']['copyright'];?>




</body>
</html>
