<?php 
/*
Template Name: Contact
*/
get_header('', array('gutter' => false, 'transparent' => true)); ?>
	
	<section class="breadcrumb-wrapper">
		<div class="container">
			<?php echo proretouchhouse_breadcrumb(); ?>
		</div>
	</section><!-- breadcrumb-wrapper -->

	<div id="primary" class="content-area">

		<?php $contact_content = get_field( 'contact_content' ); $contacts = get_field( 'contacts', 'options' ); if ( !empty( $contact_content ) && array_filter( $contact_content ) ): ?>
		<section class="contact">
    		<div class="container">
    			<div class="row">
    				<div class="<?php echo $contact_content['form_type'] ? 'col-lg-6' : 'col-lg-12 fluid'; ?>">
    					<div class="content">
    						<?php
    							if ( $contact_content['title'] ) 
    							{
    								printf( '<h1 class="title h2 wow animate__fadeInUp" data-wow-delay="0.0s">%s</h1>', $contact_content['title'] );
    							}
    							else
    							{
    								printf( '<h1 class="title h2 wow animate__fadeInUp" data-wow-delay="0.0s">%s</h1>', get_the_title() );
    							}

    							if ( $contact_content['content'] ) 
    							{
    								printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $contact_content['content'] );
    							}

    							if ( !empty( $contacts ) && array_filter( $contacts ) ) 
    							{
    								echo '<div class="contact-info">';
    									printf( '<span class="title font-weight-bold d-block wow animate__fadeInUp" data-wow-delay="0.5s">%s</span>', __('Contact Information', 'proretouchhouse') );

    									echo '<ul class="contact-info__list list-unstyled">';

    										if ( $contacts['address'] ) 
    										{
    											printf( '<li class="wow animate__fadeInUp" data-wow-delay="0.7s">
													<a href="%s" target="_blank">
														<div class="icon">
															<i class="icon-location"></i>
														</div>

														<span class="location">%s</span>
													</a>
												</li>', esc_url( $contacts['google_map_url'] ), $contacts['address'] );
    										}

    										if ( $contacts['email'] ) 
    										{
    											printf( '<li class="wow animate__fadeInUp" data-wow-delay="0.9s">
													<a href="mailto:%s">
														<div class="icon">
															<i class="icon-mail-alt"></i>
														</div>

														<span>%s</span>
													</a>
												</li>', $contacts['email'], $contacts['email'] );
    										}

    										if ( $contacts['phone'] ) 
    										{
    											printf( '<li class="wow animate__fadeInUp" data-wow-delay="1.5s">
													<a href="tel:%s">
														<div class="icon">
															<i class="icon-phone"></i>
														</div>

														<span>%s</span>
													</a>
												</li>', $contacts['phone'], $contacts['phone'] );
    										}

    									echo '</ul>';
    								echo '</div>';
    							}
    						?>
						</div>
    				</div>

    				<?php if ( $contact_content['form_type'] ): ?>
    				<div class="col-lg-6">
    					<div class="contact__form wow animate__fadeIn" data-wow-delay="0.3s">
							<?php
								printf( '<div class="entry-title">
	    							<h4 class="title">%s</h4>
	    						</div>', __('Send us a Message', 'proretouchhouse') );

		                    	if ( $contact_content['form_type'] == 'embed' && $contact_content['embed_code'] ) 
	                    		{
	                    			printf('<div class="embed_code">%s</div>', $contact_content['embed_code']);
	                    		}
	                    		elseif( $contact_content['form_type'] == 'form' && $contact_content['select_form'] )
	                    		{
	                    			echo do_shortcode('[gravityform id="'. $contact_content['select_form']['id'] .'" title="false" description="false" tabindex="20" ajax="true"]');
	                    		} 
							?>
    					</div>
    				</div>
    				<?php endif; ?>
    			</div>
    		</div>
    	</section>

    	<?php if ( $contact_content['google_map'] ): ?>
    	<section class="googlemap">
    		<iframe src="<?php echo esc_url( $contact_content['google_map'] ); ?>" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    	</section>
    	<?php endif; endif; ?>

	</div><!-- /content-area -->
	
<?php get_footer(); ?>