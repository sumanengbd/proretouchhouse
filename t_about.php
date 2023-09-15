<?php 
/*
Template Name: About
*/
get_header('', array('gutter' => false, 'transparent' => true )); ?>

	<section class="breadcrumb-wrapper">
		<div class="container">
			<?php echo proretouchhouse_breadcrumb(); ?>
		</div>
	</section><!-- breadcrumb-wrapper -->

	<div id="primary" class="content-area">

		<?php $acontent = get_field( 'acontent' ); if ( !empty( $acontent ) && array_filter( $acontent ) ): ?>
		<section class="pagebanner">
			<div class="container">
				<div class="row lr-10 align-items-center">
					<?php if ( $acontent['sub_title'] || $acontent['title'] || $acontent['position'] || $acontent['content'] || $acontent['button'] ): ?>
					<div class="<?php echo $acontent['image'] ? 'col-md-6' : 'col-md-12'; ?>">
						<div class="pagebanner__content">
							<?php
								if ( $acontent['sub_title'] ) 
								{
									printf( '<h6 class="sub-title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h6>', $acontent['sub_title'] );
								}

								if ( $acontent['title'] ) 
								{
									printf( '<h1 class="name h2 wow animate__fadeInUp" data-wow-delay="0.3s">%s</h1>', $acontent['title'] );
								}

								if ( $acontent['position'] ) 
								{
									printf( '<span class="position wow animate__fadeInUp" data-wow-delay="0.5s">%s</span>', $acontent['position'] );
								}

								if ( $acontent['content'] ) 
								{
									printf( '<div class="content__editor wow animate__fadeInUp" data-wow-delay="0.7s">%s</div>', $acontent['content'] );
								}

								if ( $acontent['button'] ) 
								{
									printf( '<a href="%s" class="btn wow animate__fadeInUp" target="%s" data-wow-delay="0.9s">%s <span class="icon-arrow-right"></span></a>', esc_url( $acontent['button']['url'] ), $acontent['button']['target'], $acontent['button']['title'] );
								}
							?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $acontent['image'] ): ?>
					<div class="col-md-6">
						<figure class="media wow animate__fadeIn" data-wow-delay="0.3s">
							<?php printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $acontent['image']['url'] ), $acontent['image']['alt'] ); ?>
						</figure>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<div class="container">
			<hr>
		</div>
		<?php endif;

		$what_we_do = get_field( 'what_we_do' ); if ( !empty( $what_we_do ) && array_filter( $what_we_do ) ): ?>
		<section class="whatwedo">
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

		$our_team = get_field( 'our_team' ); if ( !empty( $our_team ) && array_filter( $our_team ) ): ?>
		<section class="teammember">
			<div class="container">
		    	<?php if ( $our_team['title'] || $our_team['description'] ): ?>
                <div class="entry-title text-center mx-auto">
                	<?php
                		if ( $our_team['title'] ) 
                		{
                			printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $our_team['title'] );
                		}

                		if ( $our_team['description'] ) 
                		{
                			printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $our_team['description'] );
                		}
                	?>
                </div>
		    	<?php endif;

		    	if ( $our_team['team_member'] ): ?>
				<div class="row lr-10 mbm-20">
					<?php foreach ($our_team['team_member'] as $member): ?>
					<div class="col-sm-6 col-md-4 col-lg-3">
						<div class="teammember__item d-flex flex-column align-items-start justify-content-between wow animate__fadeInUp" data-wow-delay="0.0s">
							<?php
								if ( $member['image'] ) 
								{
									printf( '<figure class="media mx-auto">
										<img src="%s" class="img-fluid" alt="%s">
									</figure>', esc_url( $member['image']['url'] ), $member['image']['alt'] );
								}

								if ( $member['name'] || $member['position'] || $member['social_media'] ) 
								{
									echo '<div class="text text-center mx-auto">';

										if ( $member['name'] ) 
										{
											printf( '<h6 class="name">%s</h6>', $member['name'] );
										}

										if ( $member['position'] ) 
										{
											printf( '<span class="position">%s</span>', $member['position'] );
										}

										if ( $member['socail_media'] ) 
										{
											echo '<ul class="social-media list-inline">';

												foreach ( $member['socail_media'] as $social ) 
												{
													printf( '<li><a href="%s" class="%s" target="_blank"></a></li>', esc_url( $social['url'] ), $social['icon'] );
												}

											echo '</ul>';
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
		</section>

		<div class="container">
			<hr>
		</div>
		<?php endif;

		$call_action = get_field( 'call_action' ); if ( !empty( $call_action ) && array_filter( $call_action ) ): ?>
		<section class="call-action-about about">
			<div class="container">
		        <div class="row">
		            <div class="col-12">
		                <div class="call-action">
		                	<?php if ( $call_action['title'] || $call_action['description'] || $call_action['button'] ): ?>
		                    <div class="text">
		                    	<?php
		                    		if ( $call_action['title'] ) 
		                    		{
		                    			printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $call_action['title'] );
		                    		}

		                    		if ( $call_action['description'] ) 
		                    		{
		                    			printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $call_action['description'] );
		                    		}

		                    		if ( $call_action['button'] ) 
		                    		{
		                    			printf( '<a href="%s" class="btn btn-primary wow animate__fadeInUp" data-wow-delay="0.5s" target="%s">%s</a>', esc_url( $call_action['button']['url'] ), $call_action['button']['target'], $call_action['button']['title'] );
		                    		}
		                    	?>
		                    </div>
		                    <?php endif;

		                    if ( $call_action['image'] ): ?>
		                    <div class="media">
		                    	<?php printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $call_action['image']['url'] ), $call_action['image']['alt'] ); ?>
		                    </div>
		                    <?php endif; ?>
		                </div>
		            </div>
		        </div>
	        </div>
		</section>
		<?php endif; ?>

	</div><!-- /content-area -->
	
<?php get_footer(); ?>