<?php 
    $options = get_option('clarey_theme_options');
?>
<!DOCTYPE html>
<html lang="pl">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="wp-content/uploads/2017/11/favicon15.png"/>
		<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" />
	    <!-- Custom styles for this template -->
	    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
	    <style><?php echo $options['css_style']; ?></style>
	    <script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-84937911-1', 'auto');
			ga('send', 'pageview');
		</script>
	    <?php wp_head(); ?>		 
	</head>

	<body>
		<header class="container top-header">
			<div class="row">
				<h1><a href="<?php bloginfo('home');?>">Clarey.pl</a></h1>
				<section class="social-links">
					<?php if ($options['facebook']){ ?>
						<a href="<?php echo $options['facebook']; ?>" class="facebook"></a>
					<?php } ?>
					<?php if ($options['twitter']){ ?>
						<a href="<?php echo $options['twitter']; ?>" class="twitter"></a>
					<?php } ?>
					<?php if ($options['instagram']){ ?>
						<a href="<?php echo $options['instagram']; ?>" class="instagram"></a>
					<?php } ?>
					<?php if ($options['linkedin']){ ?>
						<a href="<?php echo $options['linkedin']; ?>" class="linkedin"></a>
					<?php } ?>
					<?php if ($options['gplus']){ ?>
						<a href="<?php echo $options['gplus']; ?>" class="googleplus"></a>
					<?php } ?>
					<?php if ($options['youtube']){ ?>
						<a href="<?php echo $options['youtube']; ?>" class="youtube"></a>
					<?php } ?>
					<?php if ($options['pinterest']){ ?>
						<a href="<?php echo $options['pinterest']; ?>" class="pinterest"></a>
					<?php } ?>
				</section>
			</div>
		</header>

		<nav class="navbar js-navbar navbar-green" role="navigation">
			<div class="container">
				<div class="row">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				</div>
				
				<div class="collapse navbar-collapse">
					<?php theboot_menu_user();?>
					<div class="navbar-right">
						<ul>
							<li><a href="<?php echo $options['register']; ?>">REJESTRACJA</a></li>
							<li><a href="<?php echo $options['login']; ?>">LOGOWANIE</a></li>
						</ul>
					</div>
				</div><!--/.nav-collapse -->
			</div>
			</div>
		</nav><!-- nav -->
