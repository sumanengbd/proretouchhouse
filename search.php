<?php 
header("HTTP/1.1 301 Moved Permanently");

header( "Location: ". get_bloginfo( 'url' ) );

exit();

get_header('', array('transparent' => true)); ?>

	<section class="breadcrumb-wrapper">
		<div class="container">
			<?php echo proretouchhouse_breadcrumb(); ?>
		</div>
	</section><!-- breadcrumb-wrapper -->

	<div id="primary" class="content-area">

		<section class="default-page">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="error-404 not-found text-center">
							<?php
								$error_404 = get_field( 'error_404', 'options' );
							
								echo '<header class="error-header">';

									if ( $error_404['404'] ) 
									{
										printf('<h1 class="hero">%s</h1>', $error_404['404']);
									} 
									else 
									{
										printf('<h1 class="hero">%s</h1>', '404');
									}

									if ( $error_404['title'] ) 
									{
										printf('<h3 class="page-title">%s</h3>', $error_404['title']);
									} 
									else 
									{
										printf('<h3 class="page-title">%s</h3>', 'Oops! That page can&rsquo;t be found.');
									}

								echo '</header>';

								echo '<div class="error-content">';

									if ( $error_404['description'] ) 
									{
										printf('%s', $error_404['description']);
									} 
									else 
									{
										printf('<p>%s</p>', 'It looks like nothing was found at this location. Maybe try one of the links below or a search?');
									}

									if ( $error_404['button']['text'] ) 
									{
										acfButton($error_404);
									} 
									else 
									{
										printf('<a href="%s" class="btn">%s</a>', esc_url( home_url( '/' ) ), 'Go Back To Home');
									}

								echo '</div>';
							?>
						</div><!-- .error-404 -->
					</div>
				</div>
			</div>
		</section>

	</div><!-- /primary -->

<?php get_footer();