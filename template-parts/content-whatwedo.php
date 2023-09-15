<div class="whatwedo__item">
	<div class="whatwedo__media">
		<figure class="media__1">
			<?php
				$before_image = get_field( 'before_image' );

				if ( $before_image ) 
				{
					printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( $before_image['sizes']['whatwedo_thumb'] ), $before_image['alt'] );
				}
				else
				{
					printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri( 'images/placeholder-wedo-thumb.jpg' ) ), get_the_title() );
				}
			?>
		</figure>

		<figure class="media__2">
			<?php
				if ( has_post_thumbnail() ) 
				{
					the_post_thumbnail( 'whatwedo_thumb', array( 'class' => 'img-fluid' ) );
				}
				else
				{
					printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri( 'images/placeholder-wedo-thumb.jpg' ) ), get_the_title() );
				}
			?>
		</figure>
	</div>

	<div class="text">
		<?php  
			the_title('<h5 class="title">', '</h5>');

			if( '' !== get_post()->post_content )
	        {
	        	echo '<div class="description">';

	        		the_content();

	        	echo '</div>';
	        }
		?>
	</div>
</div>