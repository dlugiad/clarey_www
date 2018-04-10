<div class="container articles page">
	<div class="row">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article class="col-sm-12">
			<?php if ( has_post_thumbnail()) : ?>
			<a class="img-art" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail('', array('class' => 'img-responsive')); ?>
			</a>
			<?php endif; ?>

			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p><span class="glyphicon glyphicon-calendar"></span>&nbsp; <?php the_time('j F Y');?></p>
			<?php the_content(); ?></p>
		</article>
		<?php endwhile; else: ?>
				<p><?php _e('Brak postów.'); ?></p>
				<?php endif; ?>
	</div>
</div>