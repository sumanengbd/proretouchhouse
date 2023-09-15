<?php
/*** Gravity form field */
class acf_field_gravity_forms extends acf_field {
	/*
	*  __construct
	*  This function will setup the field type data
	*/
	function __construct() {
		// vars
		$this->name = 'gravity_forms_field';
		$this->label = __('Gravity Forms');
		$this->category = __("Relational",'proretouchhouse'); // Basic, Content, Choice, etc
		$this->defaults = array(
		'allow_multiple' => 0,
		'allow_null' => 0
		);
		// do not delete!
		parent::__construct();
	}
  
	/*
	*  render_field_settings()
	*  Create extra settings for your field. These are visible when editing a field
	*/
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*/
		acf_render_field_setting( $field, 
			array(
				'label' => 'Allow Null?',
				'type'  =>  'radio',
				'name'  =>  'allow_null',
				'choices' =>  array(
				1 =>  __("Yes",'proretouchhouse'),
				0 =>  __("No",'proretouchhouse'),
				),
				'layout'  =>  'horizontal'
			)
		);

		acf_render_field_setting( $field, 
			array(
				'label' => 'Allow Multiple?',
				'type'  =>  'radio',
				'name'  =>  'allow_multiple',
				'choices' =>  array(
					1 =>  __("Yes",'proretouchhouse'),
					0 =>  __("No",'proretouchhouse'),
				),
				'layout'  =>  'horizontal'
			)
		);
	}
  
	/*
	*  render_field()
	*  Create the HTML interface for your field
	*  @param $field (array) the $field being rendered
	*/
	  
	function render_field( $field ) {

		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		$field = array_merge($this->defaults, $field);
		$choices = array();

		//Show notice if Gravity Forms is not activated
		if (class_exists('RGFormsModel')) 
		{
			$forms = RGFormsModel::get_forms(1);
		}   
		else 
		{
			echo "<font style='color:red;font-weight:bold;'>Warning: Gravity Forms is not installed or activated. This field does not function without Gravity Forms!</font>";
		}
		
		//Prevent undefined variable notice
		if(isset($forms)){
		  foreach( $forms as $form ){
			$choices[ intval($form->id) ] = ucfirst($form->title);
		  }
		}
		// override field settings and render
		$field['choices'] = $choices;
		$field['type']    = 'select';
			if ( $field['allow_multiple'] ) {
				$multiple = 'multiple="multiple" data-multiple="1"';
				echo "<input type=\"hidden\" name=\"{$field['name']}\">";
			}
			else $multiple = '';
		?>
		<select id="<?php echo str_replace(array('[',']'), array('-',''), $field['name']);?>" name="<?php echo $field['name']; if( $field['allow_multiple'] ) echo "[]"; ?>"<?php echo $multiple; ?>>
			<?php
			if ( $field['allow_null'] ) 
				echo '<option value="">- Select -</option>';
				
			foreach ($field['choices'] as $key => $value){
				$selected = '';
				if ( (is_array($field['value']) && in_array($key, $field['value'])) || $field['value'] == $key )
					$selected = ' selected="selected"';
			?>
				<option value="<?php echo $key; ?>"<?php echo $selected;?>><?php echo $value; ?></option>
			<?php } ?>
		</select>
		<?php
	}

	/*
	*  format_value()
	*  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
	*/
	function format_value( $value, $post_id, $field ) {
			
		//Return false if value is false, null or empty
		if( !$value || empty($value) ){
			return false;
		}
			
		//If there are multiple forms, construct and return an array of form objects
		if( is_array($value) && !empty($value) ) 
		{
			$form_objects = array();
			foreach($value as $k => $v)
			{
				$form = GFAPI::get_form( $v );
				//Add it if it's not an error object
				if( !is_wp_error($form) )
				{
					$form_objects[$k] = $form;
				}
			}

			//Return false if the array is empty
			if( !empty($form_objects) )
			{
				return $form_objects;   
			}
			else
			{
				return false;
			}
		}
		else
		{
			$form = GFAPI::get_form(intval($value));
			//Return the form object if it's not an error object. Otherwise return false. 
			if( !is_wp_error($form) )
			{
				return $form;   
			}
			else
			{
				return false;
			}
		}
	}
}

// create field
new acf_field_gravity_forms();

/*** Gravity form field */
class acf_field_post_type extends acf_field {
	/*
	*  __construct
	*  This function will setup the field type data
	*/
	function __construct() {
		// vars
		$this->name = 'post_type_field';
		$this->label = __('Post Type');
		$this->category = __("Relational", 'proretouchhouse'); // Basic, Content, Choice, etc
		$this->defaults = array(
		'allow_null' => 0
		);
		// do not delete!
		parent::__construct();
	}
  
	/*
	*  render_field_settings()
	*  Create extra settings for your field. These are visible when editing a field
	*/
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*/
		acf_render_field_setting( $field, 
			array(
				'label' => 'Allow Null?',
				'type'  =>  'radio',
				'name'  =>  'allow_null',
				'choices' =>  array(
				1 =>  __("Yes",'proretouchhouse'),
				0 =>  __("No",'proretouchhouse'),
				),
				'layout'  =>  'horizontal'
			)
		);
	}
  
	/*
	*  render_field()
	*  Create the HTML interface for your field
	*  @param $field (array) the $field being rendered
	*/
	  
	function render_field( $field ) {

		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		$field = array_merge($this->defaults, $field);

		//Show notice if Gravity Forms is not activated
		$args=array(
			'public'                => true,
			// 'exclude_from_search'   => true,
			'_builtin'              => false
		); 

		$output = 'objects'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'
		$post_types = get_post_types($args,$output,$operator);

		$posttypes_array = wp_list_pluck( $post_types, 'label', 'name');

		// override field settings and render
		$field['choices'] = $posttypes_array;
		?>
		<select id="<?php echo str_replace(array('[',']'), array('-',''), $field['name']);?>" name="<?php echo $field['name']; ?>">
			<?php
			if ( $field['allow_null'] ) 
				echo '<option value="">- Select Post Type -</option>';
				
			foreach ($field['choices'] as $key => $value){
				$selected = '';
				if ( (is_array($field['value']) && in_array($key, $field['value'])) || $field['value'] == $key )
					$selected = ' selected="selected"';
			?>
				<option value="<?php echo $key; ?>"<?php echo $selected;?>><?php echo $value; ?></option>
			<?php } ?>
		</select>
		<?php
	}
}

// create field
new acf_field_post_type();

/*** acf_field_menu Class */
class acf_field_menu extends acf_field {

	/**
	 * Sets up some default values and delegats work to the parent constructor.
	 * This function shows nav menu field into the acf field type.
	 */
	function __construct() {
		$this->name     = 'nav_menu';
		$this->label    = esc_html__( 'Select Menu', 'proretouchhouse' );
		$this->category = 'choice';
		$this->defaults = array(
			'save_format' => 'menu',
			'allow_null'  => 0,
			'container'   => 'div',
		);
		parent::__construct();
	}

	/**
	 * Renders the ACF Nav Menu Field options seen when editing a Nav Menu Field.
	 *
	 * @param array $field The array representation of the current Nav Menu Field.
	 */
	function render_field_settings( $field ) {
		// Register the Return Value format setting
		acf_render_field_setting( $field, array(
			'label'        => esc_html__( 'Return Value', 'proretouchhouse' ),
			'instructions' => esc_html__( 'Specify the returned value on front end', 'proretouchhouse' ),
			'type'         => 'radio',
			'name'         => 'save_format',
			'layout'       => 'horizontal',
			'choices'      => array(
				'menu'   => esc_html__( 'Nav Menu HTML', 'proretouchhouse' ),
				'object' => esc_html__( 'Nav Menu Object', 'proretouchhouse' ),
				'id'     => esc_html__( 'Nav Menu ID', 'proretouchhouse' ),
			),
		) );

		// Register the Menu Container setting
		acf_render_field_setting( $field, array(
			'label'        => esc_html__( 'Menu Container', 'proretouchhouse' ),
			'instructions' => esc_html__( "What to wrap the Menu's ul with (when returning HTML only)", 'proretouchhouse' ),
			'type'         => 'select',
			'name'         => 'container',
			'choices'      => $this->get_allowed_nav_container_tags(),
		) );

		// Register the Allow Null setting
		acf_render_field_setting( $field, array(
			'label'        => esc_html__( 'Allow Null?', 'proretouchhouse' ),
			'type'         => 'radio',
			'name'         => 'allow_null',
			'layout'       => 'horizontal',
			'choices'      => array(
				1 => esc_html__( 'Yes', 'proretouchhouse' ),
				0 => esc_html__( 'No', 'proretouchhouse' ),
			),
		) );
	}

	/**
	 * Get the allowed wrapper tags for use with wp_nav_menu().
	 *
	 * @return array An array of allowed wrapper tags.
	 */
	function get_allowed_nav_container_tags() {
		$tags           = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		$formatted_tags = array(
			'0' => 'None',
		);
		foreach ( $tags as $tag ) {
			$formatted_tags[$tag] = ucfirst( $tag );
		}
		return $formatted_tags;
	}

	/**
	 * Renders the ACF Nav Menu Field.
	 *
	 * @param array $field The array representation of the current Nav Menu Field.
	 */
	function render_field( $field ) {
		$allow_null = $field['allow_null'];
		$nav_menus  = $this->get_nav_menus( $allow_null );
		if ( empty( $nav_menus ) ) {
			return;
		}
		?>
		<div class="custom-acf-nav-menu">
			<select id="<?php esc_attr( $field['id'] ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>">
			<?php foreach( $nav_menus as $nav_menu_id => $nav_menu_name ) : ?>
				<option value="<?php echo esc_attr( $nav_menu_id ); ?>" <?php selected( $field['value'], $nav_menu_id ); ?>>
					<?php echo esc_html( $nav_menu_name ); ?>
				</option>
			<?php endforeach; ?>
			</select>
		</div>
		<?php
	}
	/**
	 * Gets a list of ACF Nav Menus indexed by their Nav Menu IDs.
	 *
	 * @param bool $allow_null If true, prepends the null option.
	 *
	 * @return array An array of Nav Menus indexed by their Nav Menu IDs.
	 */
	function get_nav_menus( $allow_null = false ) {
		$navs = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$nav_menus = array();
		if ( $allow_null ) {
			$nav_menus[''] = esc_html__( '- Select -','proretouchhouse' );
		}
		foreach ( $navs as $nav ) {
			$nav_menus[ $nav->term_id ] = $nav->name;
		}
		return $nav_menus;
	}

	/**
	 * Renders the ACF Nav Menu Field.
	 *
	 * @param int   $value   The Nav Menu ID selected for this Nav Menu Field.
	 * @param int   $post_id The Post ID this $value is associated with.
	 * @param array $field   The array representation of the current Nav Menu Field.
	 *
	 * @return mixed The Nav Menu ID, or the Nav Menu HTML, or the Nav Menu Object, or false.
	 */
	function format_value( $value, $post_id, $field ) {
		// bail early if no value
		if ( empty( $value ) ) {
			return false;
		}
		// check format
		if ( 'object' == $field['save_format'] ) {
			$wp_menu_object = wp_get_nav_menu_object( $value );

			if( empty( $wp_menu_object ) ) {
				return false;
			}
			$menu_object = new stdClass;
			$menu_object->ID    = $wp_menu_object->term_id;
			$menu_object->name  = $wp_menu_object->name;
			$menu_object->slug  = $wp_menu_object->slug;
			$menu_object->count = $wp_menu_object->count;
			return $menu_object;
		} 
		elseif ( 'menu' == $field['save_format'] ) {
			ob_start();
			wp_nav_menu( array(
				'menu' => $value,
				'container' => 'div',
       			'container_class' => 'acf-nav-menu',
				'container' => $field['container'],
				'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			) );
			return ob_get_clean();
		}

		// Just return the Nav Menu ID
		return $value;
	}

	function load_value( $value, $post_id, $field ) {
		return $value;
	}
}
new acf_field_menu();