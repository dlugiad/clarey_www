<?php $i=1; ?>
<div class="container articles page">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $i=$i+1; ?>
			<?php if ($i%2==0) {
				echo "<div class='row'>";
			} ?>
		<article class="col-sm-6">
			<?php if ( has_post_thumbnail()) : ?>
			<a class="img-art" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail('', array('class' => 'img-responsive')); ?>
			</a>
			<?php endif; ?>

			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p><span class="glyphicon glyphicon-calendar"></span>&nbsp; <?php the_time('j F Y');?></p>
			<?php echo(get_the_excerpt()); ?>
		</article>
		<?php if ($i%2!=0) {
				echo "</div>";//row
			} ?>
		<?php endwhile; else: ?>
		<p><?php _e('Brak wyników wyszukiwania.'); ?></p>
		<?php endif; ?>
		<?php if ($i%2==0) {
				echo "</div>";//row
			} ?>
		<div class="pagination">	
<?php
global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
        'before_page_number' => '<span class="screen-reader-text"> </span>'
) );
?>
		</div>
	</div>
