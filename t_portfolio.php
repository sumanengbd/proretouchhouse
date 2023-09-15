<?php 
/*
Template Name: Portfolio
*/
get_header('', array('gutter' => false, 'transparent' => true)); ?>
	
	<section class="breadcrumb-wrapper">
		<div class="container">
			<?php echo proretouchhouse_breadcrumb(); ?>
		</div>
	</section><!-- breadcrumb-wrapper -->

	<div id="primary" class="content-area">

		<section class="recentworks">
			<div class="container">
				<div class="entry-title text-center">
					<?php
						$pcontent = get_field( 'pcontent' );

						if ( $pcontent['title'] ) 
						{
							printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', $pcontent['title'] );
						}
						else
						{
							printf( '<h2 class="title wow animate__fadeInUp" data-wow-delay="0.0s">%s</h2>', get_the_title() );
						}

						if ( $pcontent['description'] ) 
						{
							printf( '<div class="description wow animate__fadeInUp" data-wow-delay="0.3s">%s</div>', $pcontent['description'] );
						}
					?>
				</div>

				<div class="recentworks__filter wow animate__fadeInUp" data-wow-delay="0.5s">
				    <ul class="filters filter-group list-inline" data-filter-group>
				        <li  data-filter="*"><span>All Works</span></li>
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
					'posts_per_page' => -1,
					'post_status' => 'publish', 
					'post_type' => 'portfolio',
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
			</div>
		</section>

		<?php $call_action = get_field( 'call_action' ); if ( !empty( $call_action ) && array_filter( $call_action ) ): ?>
		<div class="container">
			<hr>
		</div>

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