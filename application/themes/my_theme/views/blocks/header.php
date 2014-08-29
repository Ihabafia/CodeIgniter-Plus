<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo Modules::run('pref/_site_name').' | '.$template['title'] ?></title>
	<meta name="title" content="" />
	<meta name="description" content="" />
	<meta name="author" content="Ihab Abu Afia - +966564177717" />
	<!-- Google will often use this as its description of your page/site. Make it good. -->

	<meta name="google-site-verification" content="" />
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->

	<meta name="author" content="Ihab Abu Afia" />
	<meta name="Copyright" content="" />


	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Iconifier might be helpful for generating favicons and touch icons: http://iconifier.net -->
	<link rel="shortcut icon" href="<?php echo img_url(); ?>favicon.ico" type="image/vnd.microsoft.icon" />
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK -->

	<link rel="apple-touch-icon" href="<?php echo img_url(); ?>apple-touch-icon.png" />
	<!-- The is the icon for iOS's Web Clip and other things.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->

	<!-- Bootstrap Core CSS -->
	<?php echo css('bootstrap'); ?>

	<!-- myBootstrap custom CSS -->
	<?php echo css('myBootstrap'); ?>

	<!-- Custom Module CSS -->
	<?php echo module_css(); ?>




	<!-- Standard JS files -->
	<!-- jQuery Version 1.11.1 -->
	<?php echo js('jquery-1.11.1.min'); ?>
	<!-- Bootstrap Core JavaScript -->
	<?php echo js('bootstrap.min'); ?>
	<!-- Common JavaScript -->
	<?php echo js('common'); ?>
	<?php echo js('ie-emulation-modes-warning'); ?>
	<?php echo js('ie10-viewport-bug-workaround'); ?>

	<!-- Custom Module JS files -->
	<?php echo module_js(); ?>

	<?php echo (isset($template['metadata']) ? $template['metadata']:''); ?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
