<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title(''); ?></title>
    <?php $favicon = get_field( 'favicon', 'options' ); if ($favicon && isset($favicon)): ?>
    <link rel="icon" type="image/png" href="<?php echo $favicon['url']; ?>" sizes="32x32">
    <?php else: ?>
    <link rel="icon" type="image/png" href="<?php echo get_theme_file_uri('images/favicon.png'); ?>" sizes="32x32">
    <?php endif;
    wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="sidr">
	    <div class="mobile-header d-none">
	        <div class="navbar-header d-flex align-items-center justify-content-between">
	        	<div class="logo">
	        	 	<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	        	 		<?php
	        	 		    $logo = get_field( 'logo', 'options' );

	        	 		    if ( $logo ) 
	        	 		    {
	        	 		        printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( $logo['url'] ), $logo['alt'] );
	        	 		    }
	        	 		    else
	        	 		    {
	        	 		        printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri('images/logo.png') ), get_bloginfo('name'));
	        	 		    }
	        	 		?>
	        	 	</a>
	        	</div>

	         	<button class="navbar-toggle in">
	        		<span class="icon-bar"></span>
	        	  	<span class="icon-bar"></span>
	        	  	<span class="icon-bar"></span>
	          	</button>
	        </div>

	        <div class="navigation">
	        	<div class="prh-mobile-nav">
	        		<?php
	        			wp_nav_menu( array(
	        			    'depth'              => 1,
	        			    'menu_id'            => '',
	        			    'container'          => false,
	        			    'theme_location'     => 'menu-1',
	        			    'menu'               => 'Primary Menu Mobile',
	        			    'menu_class'         => 'nav navbar-nav navbar-mobile',
	        			    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
	        			    'walker'             => new wp_bootstrap_navwalker(),
	        			));
	        		?>
		        </div>
	        </div>
	    </div>
	</div><!-- /mobile-header -->

	<header class="header<?php if ( isset( $args['transparent'] ) && $args['transparent'] ) echo ' transparent'; if ( get_field( 'sticky', 'options' ) || ( isset( $args['sticky'] ) && $args['sticky'] ) ) echo ' sticky'; ?>">
		<div class="navbar navbar-expand">
		  	<div class="container d-flex align-items-center justify-content-between">
				<div class="navbar-header">
					<div class="logo">
					 	<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					 		<?php
					 		    if ( $logo ) 
					 		    {
					 		        printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( $logo['url'] ), $logo['alt'] );
					 		    }
					 		    else
					 		    {
					 		        printf('<img src="%s" class="img-fluid" alt="%s">', esc_url( get_theme_file_uri('images/logo.png') ), get_bloginfo('name'));
					 		    }
					 		?>
					 	</a>
					</div>
				</div>
		
				<div class="collapse navbar-collapse">
				  	<?php
				  		wp_nav_menu( array(
				  		    'depth'              => 1,
				  		    'menu_id'            => '',
				  		    'container'          => false,
				  		    'theme_location'     => 'menu-1',
				  		    'menu'               => 'Primary Menu',
				  		    'menu_class'         => 'nav navbar-nav',
				  		    'fallback_cb'        => 'wp_bootstrap_navwalker::fallback',
				  		    'walker'             => new wp_bootstrap_navwalker(),
				  		));
				  	?>

				  	<ul class="nav navbar-nav navbar-nav-right">
                        <li class="mobile-navbar-toggler d-lg-none">
							<button class="navbar-toggle" type="button">
								<span class="icon-bar"><span class="inner"></span></span>
							  	<span class="icon-bar"><span class="inner"></span></span>
							  	<span class="icon-bar"><span class="inner"></span></span>
						  	</button>
						</li>
				  	</ul>
				</div>
		  	</div>
		</div>
	</header><!--/header -->
	<?php
	    if ( isset($args['gutter_disable']) &&  !$args['gutter_disable'] ) 
	    {
	        echo '<div class="header-gutter"></div>';
	    }
	?>
    