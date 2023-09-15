<?php 
/*
Template Name: Home
*/
get_header( '', array('gutter' => false, 'transparent' => true) ); 

	$banner = get_field( 'banner' ); ?>

	<div id="primary" class="content-area">

		<section class="banner">
			<div class="container position-relative">
				<div class="overlay"></div>

				<div class="banner__content">	
					<div class="row lr-10 align-items-center">
						<div class="col-lg-6">
							<div class="banner__text">
								<?php
									if ( $banner['title'] ) 
									{
										printf( '<h1 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h1>', $banner['title'] );
									}
									else
									{
										printf( '<h1 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h1>', get_bloginfo('title') );
									}

									if ( $banner['description'] ) 
									{
										printf( '<div class="description desc-big wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $banner['description'] );
									}
									else
									{
										printf( '<div class="description desc-big wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', get_bloginfo('description') );
									}

									if ( $banner['button'] || $banner['video'] ) 
									{
										echo '<div class="d-flex align-items-center mt">';

											if ( $banner['button'] ) 
											{
												printf( '<a href="%s" class="btn wow animate__fadeInUp" target="%s" data-wow-delay="0.5s">%s <span class="icon-arrow-right"></span></a>', esc_url( $banner['button']['url'] ), $banner['button']['target'], $banner['button']['title'] );
											}

											if ( $banner['video'] ) 
											{
												printf( '<a href="%s" class="banner__video popup-video wow animate__fadeInUp" data-effect="mfp-move-from-top" data-wow-delay="0.7s"><span class="icon-play"></span>%s</a>', esc_url( $banner['video'] ), __('Play Video', 'proretouchhouse') );
											}

										echo '</div>';
									}
								?>
							</div>
						</div>

						<?php if ( $banner['image'] || $banner['simage'] ): ?>
						<div class="col-lg-6">
							<div class="media align-items-center">
								<?php
									if ( $banner['image'] ) 
									{
										printf( '<div class="media__one wow animate__fadeInUp" data-wow-delay="0.2s">
											<img src="%s" class="img-fluid" alt="%s">
										</div>', esc_url( $banner['image']['url'] ), $banner['image']['alt'] );
									}

									if ( $banner['simage'] ) 
									{
										printf( '<div class="media__two wow animate__fadeInUp" data-wow-delay="0.5s">
											<img src="%s" class="img-fluid" alt="%s">
										</div>', esc_url( $banner['simage']['url'] ), $banner['simage']['alt'] );
									}
								?>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<?php $happy_client = get_field( 'happy_client' ); if ( !empty( $happy_client ) && array_filter( $happy_client ) ): ?>
		<section class="happyclient">
			<div class="container position-relative">
				<div class="overlay"></div>

				<div class="row">
					<div class="col-12">
						<div class="content d-flex align-items-center">
							<?php if ( $happy_client['image'] ): ?>
							<div class="media wow animate__fadeIn" data-wow-delay="0.0s">
								<?php printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $happy_client['image']['url'] ), $happy_client['image']['alt'] ); ?>
							</div>
							<?php endif;

							if ( $happy_client['client'] ): ?>
							<div class="item d-flex align-items-center">
								<?php foreach ( $happy_client['client'] as $key => $cli ): ?>
								<div class="items wow animate__fadeIn" data-wow-delay="0.1s">
									<div class="text">
										<?php
											if ( $cli['title'] ) 
											{
												printf( '<h3 class="title">%s</h3>', $cli['title'] );
											}

											if ( $cli['description'] ) 
											{
												printf( '<div class="description">%s</div>', $cli['description'] );
											}
										?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<button class="scrollDown round-text wow animate__zoomIn" data-space="0" data-round="<?php echo __('Explore All • Explore All • Explore All • ', 'proretouchhouse') ?>" data-radius="76" data-wow-delay="0.4s">
				    <i class="icon-arrow-drown"></i>
				</button>
			</div>
		</section>
		<?php endif;

		$what_we_do = get_field( 'what_we_do' ); if ( !empty( $what_we_do ) && array_filter( $what_we_do ) ): ?>
		<section id="what-we-do" class="whatwedo">
		    <div class="container">
		    	<?php if ( $what_we_do['title'] || $what_we_do['description'] ): ?>
                <div class="entry-title text-center">
                	<?php
                		if ( $what_we_do['title'] ) 
                		{
                			printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $what_we_do['title'] );
                		}

                		if ( $what_we_do['description'] ) 
                		{
                			printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $what_we_do['description'] );
                		}
                	?>
                </div>
		    	<?php endif;

		    	$counter = 1;
		    	$args = array(
		    		'posts_per_page' => -1,
		    		'post_status' => 'publish', 
		    		'post_type' => $what_we_do['post_type'],
		    	);

		    	$wedo_query = new WP_Query( $args );

		    	if ( $what_we_do['post_type'] && $wedo_query->have_posts() ): ?>
		        <div class="row lr-10 mbm-30">
					<?php
						while ( $wedo_query->have_posts() ): $wedo_query->the_post();
							if ( $counter == 4 ) 
							{
								$counter = 1;
							}

							echo '<div class="col-6 wow animate__fadeInUp" data-wow-delay="0.'.$counter.'s">';

								get_template_part('template-parts/content', 'whatwedo');

							echo '</div>';

							$counter++;
						endwhile;
					?>
		        </div>
		    	<?php endif; wp_reset_query(); ?>
		    </div>
		</section>

		<div class="container">
			<hr>
		</div>
		<?php endif;

		$portfolio = get_field( 'portfolio' ); if ( !empty( $portfolio ) && array_filter( $portfolio ) ): ?>
		<section class="recentworks">
			<div class="container">
				<?php if ( $portfolio['title'] || $portfolio['description'] ): ?>
				<div class="entry-title text-center">
					<?php
						if ( $portfolio['title'] ) 
						{
							printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $portfolio['title'] );
						}
						else
						{
							printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', get_the_title() );
						}

						if ( $portfolio['description'] ) 
						{
							printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $portfolio['description'] );
						}
					?>
				</div>
				<?php endif; ?>

				<div class="recentworks__filter wow animate__fadeInUp" data-wow-delay="0.5s">
				    <ul class="filters filter-group list-inline" data-filter-group>
				        <?php
				        	$terms = get_terms([
				        	    'hide_empty' => true,
				        	    'taxonomy' => 'portfolio_category',
				        	]);

				        	if ( $terms ) 
				        	{
				        		foreach ( $terms as $term ) 
				        		{
				        			printf( '<li  data-filter=".%s"><span>%s</span></li>', $term->slug, $term->name );
				        		}
				        	}
				        ?>
				    </ul>
				</div>

				<?php 
				$counter = 1;
				$args = array(
					'posts_per_page' => 12,
					'post_status' => 'publish', 
					'post_type' => $portfolio['post_type'],
				);

				$portfolio_query = new WP_Query( $args );

				if ( $portfolio_query->have_posts() ): ?>
				<div class="recentworks__item">
					<div class="row lr-10 mbm-20 resentworks-grid">
						<?php
							while ( $portfolio_query->have_posts() ): $portfolio_query->the_post();
					        	$terms = get_the_terms($post->ID, 'portfolio_category');
    							if ($terms && !is_wp_error($terms)) {
    								$links = array();
    								foreach ($terms as $term) {
    									$links[] = $term->slug;
    								}
    								$links = join(' ', $links);
    							} else {
    								$links = '';
    							}

    							if ( $counter == 4 ) 
    							{
    								$counter = 1;
    							}

								echo '<div class="col-lg-4 col-sm-6 wowp animate__fadeInUp mix '.$links.'" data-wow-delay="0.'.$counter.'s">';

									get_template_part('template-parts/content', 'portfolio');

								echo '</div>';

								$counter++;
							endwhile;
						?>
					</div>
				</div>
				<?php endif; wp_reset_query(); ?>

				<?php
					if ( $portfolio['button'] ) 
					{
						printf( '<div class="text-center">
							<a href="%s" class="btn" target="%s">%s <span class="icon-arrow-right"></span></a>
						</div>', esc_url( $portfolio['button']['url'] ), $portfolio['button']['target'], $portfolio['button']['title'] );
					}
				?>
			</div>
		</section>

		<div class="container">
			<hr>
		</div>
		<?php endif;

		$new_arrival = get_field( 'new_arrival' ); if ( !empty( $new_arrival ) && array_filter( $new_arrival ) ): ?>
		<section class="newarrival">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php if ( $new_arrival['title'] || $new_arrival['description'] ): ?>
						<div class="newarrival__top d-flex align-items-end justify-content-between">	
							<div class="entry-title">
								<?php
									if ( $new_arrival['title'] ) 
									{
										printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $new_arrival['title'] );
									}

									if ( $new_arrival['description'] ) 
									{
										printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.1s">%s</div>', $new_arrival['description'] );
									}
								?>
							</div>

							<?php if ( $new_arrival['works'] ): ?>
				            <div class="slick__controls d-flex align-items-center">
								<div class="arrows d-flex align-items-center">
									<button class="slick__control prev"><i class="icon-arrow-left"></i></button>
									<button class="slick__control next"><i class="icon-arrow-right"></i></button>
								</div>
							</div>
							<?php endif; ?>
						</div>
						<?php endif;

						if ( $new_arrival['works'] ): ?>
						<div class="newarrival__slider" cursor-class="drag">
							<?php foreach ($new_arrival['works'] as $work): ?>
				            <div class="slick-slide">
				            	<div class="slider-item">
				            		<?php
				            			if ( $work['image'] ) 
				            			{
				            				printf( '<figure class="media">
												<img src="%s" class="img-fluid" alt="%s">
											</figure>', esc_url( $work['image']['url'] ), $work['image']['alt'] );
				            			}

				            			if ( $work['title'] || $work['price'] ) 
				            			{
				            				echo '<div class="text">';

				            					if ( $work['title'] ) 
				            					{
				            						printf( '<div class="top d-flex align-items-center justify-content-between">
														<h6 class="title">%s</h6>

														<div class="icon">
															<i class="icon-envelope-open-o"></i>
														</div>
													</div>', $work['title'] );
				            					}

				            					if ( $work['price'] ) 
				            					{
				            						printf( '<span class="prize">%s</span>', $work['price'] );
				            					}
				            				echo '</div>';
				            			}
				            		?>
				            	</div>
				            </div>
				            <?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section><!-- newarrival -->
		<?php endif;

		$about_us = get_field( 'about_us' ); if ( !empty( $about_us ) && array_filter( $about_us ) ): ?>
		<section class="tradition">
			<div class="container">
				<div class="row align-items-center">
					<?php if ( $about_us['image'] || $about_us['simage'] ): ?>
					<div class="col-md-5">
						<div class="tradition__media wow animate__fadeInUp" data-wow-delay="0.0s">
							<?php
								if ( $about_us['image'] ) 
								{
									printf( '<div class="media-1">
										<img src="%s" class="img-fluid" alt="%s">
									</div>', esc_url( $about_us['image']['url'] ), $about_us['image']['alt'] );
								}

								if ( $about_us['simage'] ) 
								{
									printf( '<div class="media-2">
										<img src="%s" class="img-fluid" alt="%s">
									</div>', esc_url( $about_us['simage']['url'] ), $about_us['simage']['alt'] );
								}
							?>
						</div>
					</div>
					<?php endif; 

					if ( $about_us['title'] || $about_us['description'] || $about_us['button'] ): ?>
					<div class="col-md-7">
						<div class="tradition__text">
							<?php
								if ( $about_us['title'] ) 
								{
									printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.1s">%s</h2>', $about_us['title'] );
								}

								if ( $about_us['description'] ) 
								{
									printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.2s">%s</div>', $about_us['description'] );
								}

								if ( $about_us['button'] ) 
								{
									printf( '<a href="%s" class="btn wow animate__fadeInUp" data-wow-delay="0.3s" target="%s">%s <span class="icon-arrow-right"></span></a>', esc_url( $about_us['button']['url'] ), $about_us['button']['target'], $about_us['button']['title'] );
								}
							?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<div class="container">
			<hr>
		</div>
		<?php endif;

		$testimonial = get_field( 'testimonial' ); if ( !empty( $testimonial ) && array_filter( $testimonial ) ): ?>
		<section class="testimonial">
			<div class="container">
				<?php if ( $testimonial['title'] || $testimonial['description'] ): ?>
				<div class="entry-title text-center">
					<?php
						if ( $testimonial['title'] ) 
						{
							printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $testimonial['title'] );
						}

						if ( $testimonial['description'] ) 
						{
							printf( '<div class="drsctiption wow animate__fadeInUp" data-wow-delay="0.1s">%s</div>', $testimonial['description'] );
						}
					?>
				</div>
				<?php endif; 

				if ( $testimonial['testimonials'] ): ?>
				<div class="row align-items-center">
					<div class="col-7">
						<div class="testimonial-slider-text">
							<?php foreach ( $testimonial['testimonials'] as $testi ): ?>
							<div class="testimonial-slider-text__item">
								<div class="text">
			                		<div class="icon wow animate__fadeInUp" data-wow-delay="0.0s">
			                			<span class="icon-quote"></span>
			                		</div>

			                		<?php
			                			if ( $testi['quote'] ) 
			                			{
			                				printf( '<div class="description desc-big wow animate__fadeInUp" data-wow-delay="0.3s">
				                				<p>%s</p>
				                			</div>', $testi['quote'] );
			                			}

			                			if ( $testi['name'] || $testi['position'] ) 
			                			{
			                				echo '<div class="info">';

			                					if ( $testi['name'] ) 
			                					{
			                						printf( '<h5 class="name wow animate__fadeInUp" data-wow-delay="0.5s">%s</h5>', $testi['name'] );
			                					}

			                					if ( $testi['position'] ) 
			                					{
			                						printf( '<span class="position wow animate__fadeInUp" data-wow-delay="0.2s">%s</span>', $testi['position'] );
			                					}
			                				echo '</div>';
			                			}
			                		?>
		                		</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="col-5">
						<div class="testimonial-slider-media">
							<?php foreach ( $testimonial['testimonials'] as $testi ): ?>
							<div class="testimonial-slider-media__item">
								<div class="testimonial__media">
									<?php
										if ( $testi['image'] ) 
										{
											printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $testi['image']['url'] ), $testi['image']['alt'] );
										}
									?>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

	</div><!-- /content-area -->
	
<?php get_footer(); ?>