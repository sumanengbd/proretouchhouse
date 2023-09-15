<?php get_header('', array('gutter_disable' => false, 'transparent' => true)); ?>

	<section class="breadcrumb-wrapper">
		<div class="container">
			<?php echo proretouchhouse_breadcrumb(); ?>
		</div>
	</section><!-- breadcrumb-wrapper -->

	<div id="primary" class="content-area">
		
		<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
		<section class="default-page">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="content__editor">
							<?php 
								the_content(); 

								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'proretouchhouse' ),
									'after'  => '</div>',
								) );
							?>
						</div>
					</div>
				</div>
			</div>
		</section><!-- /default-page -->
		<?php endwhile; endif; ?>

	</div><!-- /primary -->

<?php get_footer(); ?>