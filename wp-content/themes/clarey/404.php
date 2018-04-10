<?php
	get_header();
?>
<div class="container-fluid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">404 Strona nie została znaleziona.</h1>
				</header><!-- .page-header -->
				
				<div class="page-content">
					<p> Wygląda na to, że szukana strona nie istnieje. Prosimy zweryfikować wprowadzony adres.</br>
					Możesz skorzystać z wyszukiwarki bądz zacząć od strony głównej 
					<?php
					printf('<strong><a href="'. esc_url( home_url() ) . '"> '. esc_html( get_bloginfo( 'name' ) ) .'</a></strong>');
					?>
					</p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div>
<?php
get_footer();
?>	
