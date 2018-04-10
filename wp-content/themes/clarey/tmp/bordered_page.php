<?php
/*
Template Name:Strona wysrodkowana
*/
?>
<?php
get_header();
?>
<div class="container page-content">
	<div class="row">
		<div class="col-xs-12">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; else: ?>
			<p><?php _e('Brak postów.'); ?></p>
	<?php endif; ?>
		</div>
	</div>
</div>
<?php
get_footer();
?>