<!DOCTYPE html>
<html lang="en">
<?php echo $template['partials']['header']; ?>
<body id="<?php echo $this->router->method; ?>" style="background-color: #888; direction: <?php echo t('direction'); ?>">
	<section class="container" style="background: none;">
		<div class="content row">
			<?php
				echo $template['body'];
			?>
		</div>
	</section>
	<?php echo $template['partials']['javascript']; ?>
</body>
</html>

