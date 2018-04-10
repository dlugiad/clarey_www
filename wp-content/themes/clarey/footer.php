		<footer>
		  <div class="container">
			<div class="row">
			  <div class="col-sm-3 col-xs-6">
				<?php 
					$menu_name = 'footer_first';
					$locations = get_nav_menu_locations();
					$menu_id = $locations[ $menu_name ] ;
					$nav_menu = wp_get_nav_menu_object($menu_id);
					echo '<h2>'.$nav_menu->name.'</h2>';
					wp_nav_menu( array( 'theme_location' => 'footer_first' ) ); 
				?>  
			  </div>
			  <div class="col-sm-3 col-xs-6">
				<?php 
					$menu_name = 'footer_second';
					$locations = get_nav_menu_locations();
					$menu_id = $locations[ $menu_name ] ;
					$nav_menu = wp_get_nav_menu_object($menu_id);
					echo '<h2>'.$nav_menu->name.'</h2>';
					wp_nav_menu( array( 'theme_location' => 'footer_second' ) ); 
				?>
			  </div>
			  <div class="col-sm-3 col-xs-6">
				<?php 
					$menu_name = 'footer_third';
					$locations = get_nav_menu_locations();
					$menu_id = $locations[ $menu_name ] ;
					$nav_menu = wp_get_nav_menu_object($menu_id);
					echo '<h2>'.$nav_menu->name.'</h2>';
					wp_nav_menu( array( 'theme_location' => 'footer_third' ) ); 
				?>
			  </div>
			  <div class="col-sm-3 col-xs-6">
				<?php 
					$menu_name = 'footer_fourth';
					$locations = get_nav_menu_locations();
					$menu_id = $locations[ $menu_name ] ;
					$nav_menu = wp_get_nav_menu_object($menu_id);
					// then echo the name of the menu
					echo '<h2>'.$nav_menu->name.'</h2>';
					wp_nav_menu( array( 'theme_location' => 'footer_fourth' ) ); 
				?>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-12 clearfix">
				<div class="copyrights">
				  <div class="pull-center">
					<p>Korzystanie z serwisu oznacza akceptację Regulaminu.</br>©2017 Clarey Sp. z o.o. Wszelkie prawa zastrzeżone.</p>
				  </div>
				  <div class="pull-right">
					<div class="go-to-top">
					  <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/go-to-top.png" alt="Do góry"></a>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</footer>

			<!-- Bootstrap core JavaScript
			================================================== -->
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
		<?php wp_footer(); ?>
	</body>
</html>
