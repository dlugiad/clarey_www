<?php
get_header();
?>
<div class="container-fluid">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; else: ?>
			<p><?php _e('Brak postów.'); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
?>