<?php $gallery = get_field( 'portfolio_gallery' ); ?>
<a <?php echo $gallery ? 'href="#gallery-'.get_the_ID().'" class="recentworks-box gallery-popup" data-effect="mfp-move-from-top"' : 'class="recentworks-box"'; ?> >
	<figure class="media">
		<?php
			if ( has_post_thumbnail() ) 
			{
				the_post_thumbnail( 'portfolio_thumb', array( 'class' => 'img-fluid' ) );
			}
			else
			{
				printf( '<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri( 'images/placeholder-portfolio-thumb.jpg' ) ), get_the_title() );
			}
		?>
	</figure>

	<div class="text">
		<?php  
			the_title('<h4 class="title">', '</h4>');

			if( '' !== get_post()->post_content )
	        {
	        	echo '<div class="description">';

	        		the_content();

	        	echo '</div>';
	        }
		?>
	</div>
</a>

<?php if ( $gallery ): ?>
<div id="gallery-<?php the_ID(); ?>" class="mfp-hide">
	<?php
		foreach ( $gallery as $gall ) 
		{
			printf( '<a href="%s" title="%s"></a>', $gall['url'], $gall['title'] );
		}
	?>
</div>
<?php endif; ?>