	<footer class="footer">
		<?php $gallery = get_field( 'gallery', 'options' ); $social_media = get_field( 'social_media', 'options' ); if ( $gallery || $social_media ): ?>
		<div class="container">
			<div class="latestpost">
				<div class="row lr-10 mbm-20 popup-gallery">
					<?php
						if ( $gallery ) 
						{
							foreach ( $gallery as $gall ) 
							{
								printf( '<div class="col-lg-3 col-6">
									<a href="%s" class="latestpost__item wow animate__fadeIn popup" data-wow-delay="0.0s" data-effect="mfp-move-from-top">
										<figure class="media">
											<img src="%s" class="img-fluid" alt="%s">
										</figure>
									</a>
								</div>', esc_url( $gall['url'] ), esc_url( $gall['url'] ), $gall['alt'] );
							}
						}

						if ( $social_media ) 
						{
							foreach ( $social_media as $social ) 
							{
								if ( $social['action'] ) 
								{
									printf( '<div class="col-lg-3 col-6">
										<a href="%s" class="latestpost__item has-bg d-flex flex-column align-items-center justify-content-center wow animate__fadeIn" data-wow-delay="0.7s">
											<div class="icon">
												<i class="%s"></i>
											</div>

											<div class="text">
												<h5 class="title">%s</h5>
											</div>
										</a>
									</div>', esc_url( $social['url'] ), $social['icon'], $social['label'] );

									break;
								}
							}
						}
					?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container">
			<div class="footer__top">
				<div class="row lr-10">
					<div class="col-md-4">
						<div class="footer__logo wow animate__fadeInUp" data-wow-delay="0.0s">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
		                            $footer_logo = get_field( 'footer_logo', 'options' );

		                            if ( $footer_logo ) 
		                            {
		                                printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( $footer_logo['url'] ), $footer_logo['alt']);
		                            }
		                            else
		                            {
		                                printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri('images/logo.png') ), get_bloginfo('name'));
		                            }
		                        ?>
							</a>
						</div>

						<div class="text wow animate__fadeInUp" data-wow-delay="0.1s">
							<?php
								$contacts = get_field( 'contacts', 'options' );
								
								if ( !empty( $contacts ) && array_filter( $contacts ) ) 
								{
									echo '<ul class="quick-connect list-unstyled">';

										if ( $contacts['phone'] ) 
										{
											printf( '<li><a href="tel:%s">%s</a></li>', $contacts['phone'], $contacts['phone'] );
										}

										if ( $contacts['email'] ) 
										{
											printf( '<li><a href="mailto:%s">%s</a></li>', $contacts['email'], $contacts['email'] );
										}

										if ( $contacts['address'] ) 
										{
											printf( '<li><a href="%s" target="_blank">%s</a></li>', esc_url( $contacts['google_map_url'] ), $contacts['address'] );
										}

									echo '</ul>';
								}

								$social_media = get_field( 'social_media', 'options' );

								if ( $social_media ) 
								{
									echo '<ul class="social-media list-inline">';

										foreach ( $social_media as $social ) 
										{
											if ( !$social['action'] ) 
											{
												printf( '<li><a href="%s" class="%s" target="_blank"></a></li>', esc_url( $social['url'] ), $social['icon'] );
											}
										}

									echo '</ul>';
								}
							?>
						</div>
					</div>

					<div class="col-md-3 col-sm-4 col-7">
						<div class="footer__widget wow animate__fadeInUp" data-wow-delay="0.2s">
							<?php
								wp_nav_menu( array(
								    'depth'              => 1,
								    'menu_id'            => '',
								    'container'          => false,
								    'theme_location'     => 'menu-2',
								    'menu'               => 'Footer Menu 1',
								    'menu_class'         => 'footer__widget-menu list-unstyled',
								    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
								    'walker'             => new wp_bootstrap_navwalker(),
								));
							?>
						</div>
					</div>

					<div class="col-md-2 col-sm-4 col-5">
						<div class="footer__widget wow animate__fadeInUp" data-wow-delay="0.3s">
							<?php
								wp_nav_menu( array(
								    'depth'              => 1,
								    'menu_id'            => '',
								    'container'          => false,
								    'theme_location'     => 'menu-3',
								    'menu'               => 'Footer Menu 2',
								    'menu_class'         => 'footer__widget-menu list-unstyled',
								    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
								    'walker'             => new wp_bootstrap_navwalker(),
								));
							?>
						</div>
					</div>

					<div class="col-md-3 col-sm-4 col-12">
						<div class="footer__widget wow animate__fadeInUp" data-wow-delay="0.4s">
							<?php
								$newsletter = get_field( 'newsletter', 'options' );

								if ( $newsletter['title'] || $newsletter['description'] ) 
								{
									echo '<ul class="footer__widget-menu list-unstyled">';

										if ( $newsletter['title'] ) 
										{
											printf( '<li class="title"><a>%s</a></li>', $newsletter['title'] );
										}

										if ( $newsletter['description'] ) 
										{
											printf( '<li class="sub-title"><a>%s</a></li>', $newsletter['description'] );
										}

									echo '</ul>';
								}

								if ( $newsletter['form_type'] ) 
								{
									echo '<div class="search-form">';

				                    	if ( $newsletter['form_type'] == 'embed' && $newsletter['embed_code'] ) 
			                    		{
			                    			printf('<div class="embed_code">%s</div>', $newsletter['embed_code']);
			                    		}
			                    		elseif( $newsletter['form_type'] == 'form' && $newsletter['select_form'] )
			                    		{
			                    			echo do_shortcode('[gravityform id="'. $newsletter['select_form']['id'] .'" title="false" description="false" tabindex="10" ajax="true"]');
			                    		} 

									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="footer__bottom">
				<div class="row">
					<div class="col-12">
						<div class="d-flex flex-row-reverse align-items-center justify-content-between">
							<?php
								wp_nav_menu( array(
								    'depth'              => 1,
								    'menu_id'            => '',
								    'container'          => false,
								    'theme_location'     => 'menu-4',
								    'menu'               => 'Privacy Menu',
								    'menu_class'         => 'privacy__menu list-inline wow animate__fadeInUp',
								    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
								    'walker'             => new wp_bootstrap_navwalker(),
								));
							?>

							<div class="copyright wow animate__fadeInUp" data-wow-delay="0.1s">
								<p>&copy; Copyright <?php the_date('Y') ?> All Rights Reserved</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- /footer -->

	<div id="cursor">
		<div class="cursor__circle"></div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>