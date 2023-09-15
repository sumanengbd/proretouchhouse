<?php
show_admin_bar(false);
require_once('wp_bootstrap_navwalker.php');
require_once('includes/proretouchhouse-classes.php');

if ( ! function_exists( 'proretouchhouse_setup' ) ) {

	function proretouchhouse_setup() {
		/** Make theme available for translation. */
		load_theme_textdomain( 'proretouchhouse', get_template_directory() . '/languages' );

		/** Enable support for Post Thumbnails on posts and pages. */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'portfolio_thumb', 363, 304, true );
		add_image_size( 'whatwedo_thumb', 555, 322, true );

		/** This theme uses wp_nav_menu() in one location. */
		register_nav_menus( array(
		  	'menu-1' => esc_html__( 'Primary Menu', 'proretouchhouse' ),
		  	'menu-2' => esc_html__( 'Footer Menu 1', 'proretouchhouse' ),
		  	'menu-3' => esc_html__( 'Footer Menu 2', 'proretouchhouse' ),
		  	'menu-4' => esc_html__( 'Privacy Menu', 'proretouchhouse' ),
		) );
	}
}
add_action( 'after_setup_theme', 'proretouchhouse_setup' );

/*** Enqueue scripts and styles. */
function proretouchhouse_scripts() {

	/*** Enqueue styles. */
	wp_enqueue_style('prh-style', get_template_directory_uri() . '/css/prh-style.css', array(), date("ymd-Gis", filemtime( get_template_directory() . '/css/prh-style.css' )), 'all');
	wp_enqueue_style( 'proretouchhouse-style', get_stylesheet_uri(), array(), "0.1.0");

	/*** Enqueue scripts. */
	wp_enqueue_script('jquery');
	wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), date("ymd-Gis", filemtime( get_template_directory() . '/js/scripts.min.js' )), true);
}
add_action( 'wp_enqueue_scripts', 'proretouchhouse_scripts' );

/*** Register and enqueue a custom stylesheet in the WordPress admin. */
function admin_scripts() {
	wp_enqueue_style('icon-fonts', get_template_directory_uri() . '/css/icon-fonts.css', array(), false, 'all');
	wp_enqueue_script('admin-js', get_template_directory_uri() . '/js/admin.js');
}
add_action( 'admin_enqueue_scripts', 'admin_scripts' );

/** Options Page Header Background */
function proretouchhouse_admin_dashboard_css() {
	echo '<style type="text/css">
		#acf-group_5a2badeb476ba .hndle { flex-grow: initial; }
		#acf-group_5a2badeb476ba .hndle img { max-width: 200px; margin-right: 15px; }
		#acf-group_5a2badeb476ba .hndle span { display: inline-flex; align-items: center; }
	</style>';
}
add_action('admin_head', 'proretouchhouse_admin_dashboard_css');

/*** ACF OPTIONS PAGE */
if(function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

/*** ACF Color Palette */
add_action( 'acf/input/admin_footer', function() {
	?><script type="text/javascript">
	(function($) {
	    acf.add_filter('color_picker_args', function( args, $field ){
	        args.palettes = ['#FFFFFF', '#000000', '#9D6939', '#F6E7D7', '#0E333C', '#EF4136']
	        return args;
	    });
	})(jQuery);
	</script><?php
});

/*** Reorder dashboard menu */
function reorder_admin_menu( $__return_true ) {
	return array(
		'index.php',                 		// Dashboard
		'separator1',                		// --Space--
		'acf-options',               		// ACF Theme Settings
		'edit.php',   						// Pages 
		'edit.php?post_type=page',   		// Pages 
		'edit.php?post_type=portfolio',   	// Pages 
		'edit.php?post_type=what-we-do',   	// Pages 
		'gf_edit_forms',             		// Gravity Forms
		'upload.php',                		// Media
		'wpseo_dashboard',           		// Yoasta
		'gadash_settings',           		// Google Analytics
		'themes.php',                		// Appearance
		'edit-comments.php',         		// Comments 
		'users.php',                 		// Users
		'tools.php',                 		// Tools
		'options-general.php',       		// Settings
		'plugins.php',               		// Plugins
	);
}
add_filter( 'custom_menu_order', 'reorder_admin_menu' );
add_filter( 'menu_order', 'reorder_admin_menu' );

/*** Remove dashboard menu */
function remove_admin_menus() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'sharethis-general' );
}
add_action( 'admin_menu', 'remove_admin_menus', 999);

/*** Gravity form user role */
function gforms_editor_access() {
	$role = get_role( 'editor' );
	$role->add_cap( 'gform_full_access' );
}
add_action( 'after_switch_theme', 'gforms_editor_access' );

/*** Gravity form anchor */
add_filter( 'gform_confirmation_anchor', '__return_false' );

function form_submit_button($button, $form) {
	return "<button class='btn btn-orange' id='gform_submit_button_{$form["id"]}'>{$form['button']['text']}</button>";
}
add_filter("gform_submit_button", "form_submit_button", 10, 2);

/*** get permalink by template name */
function get_template_link($temp) {
	$link = null;
	$pages = get_pages(
		array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $temp
		)
	);
	if(isset($pages[0])){
		$link = get_page_link($pages[0]->ID);
	}
	return $link;
}

/*** get permalink by template name */
function get_template_id($temp) {
    $link = null;
    $pages = get_posts(
        array(
        	'post_type' => 'page',
        	'nopaging' => true,
            'meta_key' => '_wp_page_template',
            'meta_value' => $temp
        )
    );

    if(isset($pages[0])){
        $id = $pages[0]->ID;
    }
    return $id;
}

/*** Clean */
function clean($string) {
	$string = str_replace(' ', '-', implode(' ', array_slice(explode( "\n", wordwrap( $string, 3)), 0, 3)));
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	return preg_replace('/-+/', '-', strtolower($string));
}

/*** Return an alternate title, without prefix, for every type used in the get_the_archive_title(). */
add_filter('get_the_archive_title', function ($title) {

    if ( is_category() || is_tag() ) 
    {
        $title = single_tag_title( '', false );
    }
    elseif ( is_author() ) 
    {
        $title = get_the_author();
    }

    return $title;
});

/*** add SVG to allowed file uploads */
function proretouchhouse_custom_mime_types( $mimes ) {
	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['doc'] = 'application/msword';
	 
	// Optional. Remove a mime type.
	unset( $mimes['exe'] );
	 
	return $mimes;
}
add_filter( 'upload_mimes', 'proretouchhouse_custom_mime_types' );

/*** Breadcrumb */
function proretouchhouse_breadcrumb() {
	global $post;
	$delimiter = '<span class="angle-right">/</span>';
	$home = 'Home';
	$before = '<span class="current-page">'; 
	$after = '</span>';
	if ( !is_front_page() ) 
	{
		echo '<nav class="breadcrumb">';
		$homeLink = get_bloginfo('url');
		$blogTitle = get_the_title( get_option( 'page_for_posts' ) );
		$blogLink = get_permalink( get_option( 'page_for_posts' ) );
		echo '<a href="' . home_url() . '">' . $home . '</a> ' . $delimiter . ' ';
		if ( is_home() ) 
		{
			echo '<a href="' . $blogLink . '">'.$blogTitle.'</a>';
		} 
		elseif ( is_category() ) 
		{
		 	global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo '<a href="' . $blogLink . '">'.$blogTitle.'</a> ' . $delimiter . ' ';
			echo $before . single_cat_title('', false) . $after;
		} 
		elseif ( is_day() ) 
		{
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} 
		elseif ( is_month() ) 
		{
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} 
		elseif ( is_year() ) 
		{
		 	echo $before . get_the_time('Y') . $after;
		} 
		elseif ( is_single() && !is_attachment() ) 
		{
			if ( get_post_type() != 'post' ) 
			{
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} 
			else 
			{
				$cat = get_the_category(); $cat = $cat[0];
				echo '<a href="' . $blogLink . '">'.$blogTitle.'</a> ' . $delimiter . ' ';
				echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $before . get_the_title() . $after;
			}
		 
		} 
		elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) 
		{
		 	$post_type = get_post_type_object(get_post_type());
		 	echo $before . $post_type->labels->singular_name . $after;
		} 
		elseif ( is_attachment() ) 
		{
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} 
		elseif ( is_page() && !$post->post_parent ) {
			echo $before . get_the_title() . $after;
		} 
		elseif ( is_page() && $post->post_parent ) 
		{
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) 
			{
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} 
		elseif ( is_search() ) 
		{
			echo $before . 'Search Results for: "' . get_search_query() . '"' . $after;
		} 
		elseif ( is_tag() ) 
		{
			echo '<a href="' . $blogLink . '">'.$blogTitle.'</a> ' . $delimiter . ' ';
		 	echo $before . 'Posts with the tag "' . single_tag_title('', false) . '"' . $after;
		} 
		elseif ( is_tag() ) 
		{
			echo '<a href="' . $blogLink . '">'.$blogTitle.'</a> ' . $delimiter . ' ';
		 	echo $before . 'Posts with the tag "' . single_tag_title('', false) . '"' . $after;
		} 
		elseif ( is_404() ) 
		{
		 	echo $before . 'Error 404' . $after;
		}
		if ( get_query_var('paged') ) 
		{
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo ': ' . __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		} 
		echo '</nav>';
	} 
}