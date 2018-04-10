<?php
/*
Template Name:Home
*/
?>
<?php
get_header();
?>
			<div id="carousel-home" class="carousel slide" data-interval="7000" data-pause="false">
				<!-- Wrapper for slides -->
			  <div class="carousel-inner waypoint" role="listbox">
			  	
<?php 
	$loop = new WP_Query(array('post_type' => 'project', 'posts_per_page' => -1));
	$count =1;
?>
<?php if ( $loop ) : 
		 
		while ( $loop->have_posts() ) : $loop->the_post(); ?>
			    <div class="item <?php if ($count==1) {echo "active";}?>">
			    	<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
			      <div class="fill" style="background-image:url('<?php echo $url; ?>');"></div>
			      <div class="carousel-caption">
			        <h2 data-animation="animated zoomIn"><?php the_title(); ?></h2>
			        <div class="content" data-animation="animated fadeIn"><?php the_content(''); ?></div>
			      </div>
			    </div>
			    <?php $count = $count+1; ?>
<?php endwhile; else: ?>
		 
		<div class="error-not-found">Sorry, no portfolio entries for while.</div>
			
	<?php endif; ?>

			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div><!-- /.carousel -->



		<div class="container">
			<div class="row link-calc">
				<a href="#home-calc" class="button-calc">Skorzystaj z kalkulatora</a>
			</div>
			<div id="home-calc">
				<div class="row">
					<div class="col-sm-4">
						<div class="item-c">
							<h2>Ubezpieczenie Ochronne</h2>
							<hr>
							<form>
								<div class="form-group">
									<label for="">Suma ubezpieczenia</label>
									<select class="form-control">
										<option>50 tyś.</option>
										<option>100 tyś.</option>
										<option>150 tyś.</option>
										<option>200 tyś.</option>
										<option>250 tyś.</option>
										<option>300 tyś.</option>
										<option>350 tyś.</option>
										<option>400 tyś.</option>
										<option>450 tyś.</option>
										<option>500 tyś.</option>
										<option>550 tyś.</option>
										<option>600 tyś.</option>
										<option>650 tyś.</option>
										<option>700 tyś.</option>
										<option>750 tyś.</option>
										<option>800 tyś.</option>
										<option>850 tyś.</option>
										<option>900 tyś.</option>
										<option>950 tyś.</option>
										<option>1 mln.</option>
										<option>powyżej 1 mln.</option>
									</select>
								</div>
								<div class="form-group">
									<label for="czas_trwania">Czas trwania</label>
									<select id="czas_trwania" class="form-control">
										<option>Terminowe</option>
										<option>Bezterminowe</option>
									</select>
								</div>
								<div class="checkbox">
								    <input id="check1" type="checkbox" name="check" value="check1">
								    <label for="check1">Ochrona na wypadek inwalidztwa i ciężkiej choroby</label>
								    <br />
								    <input id="check2" type="checkbox" name="check" value="check2">
								    <label for="check2">Bezpieczeństwo finansowe bliskich w przypadku mojej śmierci</label>
								    <br />
								    <input id="check3" type="checkbox" name="check" value="check3">
								    <label for="check3">Ochrona na wypadek niezdolności do pracy</label>
								</div>
								<a href="https://www.ubezpieczeniaonline.pl/zamow-ubezpieczenie/?ref=ubezpieczenienazyciekalkulator" class="button">Dalej<span class="glyphicon glyphicon-play" aria-hidden="true"></span></a>
							</form>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="item-c">
							<h2>Ubezpieczenie Inwestycyjne</h2>
							<hr>
							<form>
								<div class="form-group">
									<label for="">Suma ubezpieczenia</label>
									<select class="form-control">
										<option>50 tyś.</option>
										<option>100 tyś.</option>
										<option>150 tyś.</option>
										<option>200 tyś.</option>
										<option>250 tyś.</option>
										<option>300 tyś.</option>
										<option>350 tyś.</option>
										<option>400 tyś.</option>
										<option>450 tyś.</option>
										<option>500 tyś.</option>
										<option>550 tyś.</option>
										<option>600 tyś.</option>
										<option>650 tyś.</option>
										<option>700 tyś.</option>
										<option>750 tyś.</option>
										<option>800 tyś.</option>
										<option>850 tyś.</option>
										<option>900 tyś.</option>
										<option>950 tyś.</option>
										<option>1 mln.</option>
										<option>powyżej 1 mln.</option>
									</select>
								</div>
								<div class="form-group">
									<label for="czas_trwania">Czas trwania</label>
									<select id="czas_trwania" class="form-control">
										<option>Terminowe</option>
										<option>Bezterminowe</option>
									</select>
								</div>
								<div class="checkbox">
								    <input id="check4" type="checkbox" name="check" value="check4">
								    <label for="check4">Zgromadzenie kapitału dla dziecka</label>
								    <br />
								    <input id="check5" type="checkbox" name="check" value="check5">
								    <label for="check5">Dodatkowy kapitał na emeryturę</label>
								    <br />
								    <input id="check6" type="checkbox" name="check" value="check6">
								    <label for="check6">Bezpieczeństwo finansowe bliskich w przypadku mojej śmierci</label>
								</div>
								<a href="https://www.ubezpieczeniaonline.pl/zamow-ubezpieczenie/?ref=ubezpieczenienazyciekalkulator" class="button">Dalej<span class="glyphicon glyphicon-play" aria-hidden="true"></span></a>
							</form>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="item-c">
							<h2>Ubezpieczenie na życie</h2>
							<hr>
							<form>
								<div class="form-group">
									<label for="">Suma ubezpieczenia</label>
									<select class="form-control">
										<option>50 tyś.</option>
										<option>100 tyś.</option>
										<option>150 tyś.</option>
										<option>200 tyś.</option>
										<option>250 tyś.</option>
										<option>300 tyś.</option>
										<option>350 tyś.</option>
										<option>400 tyś.</option>
										<option>450 tyś.</option>
										<option>500 tyś.</option>
										<option>550 tyś.</option>
										<option>600 tyś.</option>
										<option>650 tyś.</option>
										<option>700 tyś.</option>
										<option>750 tyś.</option>
										<option>800 tyś.</option>
										<option>850 tyś.</option>
										<option>900 tyś.</option>
										<option>950 tyś.</option>
										<option>1 mln.</option>
										<option>powyżej 1 mln.</option>
									</select>
								</div>
								<div class="form-group">
									<label for="czas_trwania">Czas trwania</label>
									<select id="czas_trwania" class="form-control">
										<option>Terminowe</option>
										<option>Bezterminowe</option>
									</select>
								</div>
								<div class="checkbox">
								    <input id="check7" type="checkbox" name="check" value="check7">
								    <label for="check7">Bezpieczeństwo finansowe bliskich w przypadku mojej śmierci</label>
								    <br />
								    <input id="check8" type="checkbox" name="check" value="check8">
								    <label for="check8">Ochrona na wypadek niezdolności do pracy</label>
								    <br />
								    <input id="check9" type="checkbox" name="check" value="check9">
								    <label for="check9">Ochrona na wypadek inwalidztwa i ciężkiej choroby</label>
								</div>
								<a href="https://www.ubezpieczeniaonline.pl/zamow-ubezpieczenie/?ref=ubezpieczenienazyciekalkulator" class="button">Dalej<span class="glyphicon glyphicon-play" aria-hidden="true"></span></a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container steps">
			<div class="row">
				<h2 class="heading">Schemat działania kalkulatora</h2>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="content-steps">
						<div class="line">
							<div class="icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/step1.png" alt="">
							</div>
						</div>
						<h3>Krok 1</h3>
						<p><strong>wypełniasz</strong> prosty formularz</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="content-steps">
						<div class="line">
							<div class="icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/step2.png" alt="">
							</div>
						</div>
						<h3>Krok 2</h3>
						<p><strong>otrzymujesz</strong> gotowe oferty</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="content-steps">
						<div class="line">
							<div class="icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/step3.png" alt="">
							</div>
						</div>
						<h3>Krok 3</h3>
						<p><strong>porównujesz</strong> oferty ubezpieczenia</p>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="content-steps">
							<div class="icon">
								<img src="<?php echo get_template_directory_uri(); ?>/img/step4.png" alt="">
							</div>
						<h3>Krok 4</h3>
						<p><strong>zawierasz</strong> najlepszą polisę</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container articles">
			<div class="row">
				<h2 class="heading">Najnowsze Artykuły</h2>
			</div>
			<div class="row">
	<?php
		$args = array( 'numberposts' => 2 );
		$lastposts = get_posts( $args );
		foreach($lastposts as $post) : setup_postdata($post); ?>

				<article class="col-sm-6">
					<?php if ( has_post_thumbnail()) : ?>
						   <a class="img-art" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						   <?php the_post_thumbnail('', array('class' => 'img-responsive')); ?>
						   </a>
						 <?php endif; ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="home-content"><?php echo(get_the_excerpt()); ?></div><!-- 
					<a href="#" class="button-calc">Czytaj więcej</a> -->
				</article>
			<?php endforeach; ?>
			</div>
			<div class="row see-all">
				<a href="<?php bloginfo('home');?>/blog" class="button">Zobacz wszystkie artykuły</a>
			</div>
		</div>
		<div class="container-fluid info clearfix">
			<div class="col-sm-3 item">
				<h2>dlaczego my?</h2>
				<ul>
					<li>Oszczędzasz czas, bo nie musisz „w ciemno” szukać ofert agentów ubezpieczeniowych.</li>
					<li>Oszczędzasz pieniądze, bo masz pewność, że otrzymasz atrakcyjne propozycje.</li>
					<li>Sam wybierasz, jaki zakres i przedmiot ubezpieczenia Cię interesuje.</li>
				</ul>
			</div>
			<div class="col-sm-3 item">
				<h2>Jak to działa?</h2>
				<p>Taka aplikacja pozwala nam szybko zweryfikować oferty różnych towarzystw ubezpieczeniowych. W Internecie możemy spotkać się z wieloma kalkulatorami, dlatego ich wizualna konstrukcja może być inna, jednak schemat działania jest podobny. </p>
			</div>
			<div class="col-sm-3 item">
				<h2>co mam zrobić?</h2>
				<p>Zainteresowany musi odpowiedzieć na kilka pytań, po czym otrzyma maksymalnie pięć ofert od agentów ubezpieczeniowych ze swojej lokalizacji – tych agentów, którzy są pewni, że mogą zaproponować najlepszą ofertę. Składki za ubezpieczenie na życie są kalkulowane na podstawie taryfikatorów towarzystw ubezpieczeniowych.</p>
			</div>
			<div class="col-sm-3 item">
				<h2>wysokość składki</h2>
				<p>W ubezpieczeniach na życie wysokość składki zależna jest od wielu czynników. Najważniejsze z nich to wiek ubezpieczonego, płci, wykonywanego zawodu, stanu zdrowia, czasu na jaki zawierana jest umowa ubezpieczenia, sumy ubezpieczenia na życie, a także zakresu ochrony. Pytania zawarte w kalkulatorze dotyczą właśnie tych kwestii.</p>
			</div>
		</div>
		<div class="container-fluid logos clearfix">
			<h2 class="heading">Najlepsi ubezpieczyciele</h2>
			<!-- <div class="col-sm-3 text-center">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-allianz.png" class="img-responsive" alt=""></a>
			</div>
			<div class="col-sm-3 text-center">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-warta.png" class="img-responsive" alt=""></a>
			</div>
			<div class="col-sm-3 text-center">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-allianz.png" class="img-responsive" alt=""></a>
			</div>
			<div class="col-sm-3 text-center">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-warta.png" class="img-responsive" alt=""></a>
			</div> -->
			<?php echo do_shortcode( '[WLS id="119"]' ) ?>
		</div>
		<?php
get_footer();
?>