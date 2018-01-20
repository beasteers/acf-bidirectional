<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('abstract_acf_field_bidirectional') ) :

abstract class abstract_acf_field_bidirectional extends acf_field_relationship {
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function initialize() {

		$this->name = 'bidirectional';
		$this->label = __('Bidirectional Relationship', 'acf-bidirectional');
		$this->category = 'relational';
		$this->defaults = array(
			'relation_field_name' => '',
			'post_type'			=> array(),
			'taxonomy'			=> array(),
			'min' 				=> 0,
			'max' 				=> 0,
			'filters'			=> array('search', 'post_type', 'taxonomy'),
			'elements' 			=> array(),
			'return_format'		=> 'object'
		);

    	$this->toggle_filter(true);
		add_action('wp_ajax_acf/fields/relationship/query',			array($this, 'ajax_query'));
		add_action('wp_ajax_nopriv_acf/fields/relationship/query',	array($this, 'ajax_query'));
	}

	function input_admin_enqueue_scripts() {
		
		// vars
		$url = acf_plugin_bidirectional::$settings['url'];

		// register & include JS
		wp_register_script( 'acf-field-bidirectional', "{$url}assets/js/acf-field-bidirectional.js" );
		wp_enqueue_script('acf-field-bidirectional');


		// register & include CSS
		wp_register_style( 'acf-field-bidirectional', "{$url}assets/css/acf-field-bidirectional.css" );
		wp_enqueue_style('acf-field-bidirectional');

		// enqueue font awesome
		wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	}

	function toggle_filter($on=true){
		if($on)
			add_filter('acf/update_value/type='.$this->name, array($this, 'update_relationship'), 10, 3);
		else
			remove_filter('acf/update_value/type='.$this->name, array($this, 'update_relationship'), 10, 3);
	}


	function update_relationship($value, $post_id, $field){
		/*
		Args: 
			$value (array): the updated list of post_ids
			$post_id (int): the current post's post ID
			$field (array): the field metadata

		*/
		// vars
		$field_name = $field['name']; // the local field name - should be the remote post_type
		$rel_name = $field['relation_field_name'] ?: get_post_type($post_id); // the remote field name - should be the local post_type
		$value = (array)$value;
		$old_value = (array)get_field($field_name, $post_id, false);
		
		// Turn off filter to avoid infinite loop
		$this->toggle_filter(false);
		
		/* Loop over all updated relations. Get the complimentary relations for each $post_id2 in $value and add $post_id if missing. */
		foreach( array_diff($value, $old_value) as $post_id2 ) {
			
			// load existing related posts, default to blank array
			$value2 = (array)get_field($rel_name, $post_id2, false);
			
			// append the current $post_id, keep going if it's already there
			if( in_array($post_id, $value2) ) continue;
			$value2[] = $post_id;
			
			// update the selected post's value (use field's key for performance)
			update_field($rel_name, $value2, $post_id2);
		}
		
		/* Loop over all removed relations. Get the complimentary relations for each $post_id2 in $value and remove $post_id if exists. */
		foreach( array_diff($old_value, $value) as $post_id2 ) {
			
			// load existing related posts
			$value2 = (array)get_field($rel_name, $post_id2, false);

			// remove post_id if it exists, otherwise keep going
			$pos = array_search($post_id, $value2);
			if( $pos === false ) continue;
			unset( $value2[$pos] );
			
			// update the un-selected post's value (use field's key for performance)
			update_field($rel_name, $value2, $post_id2);
		}
		
		// turn filter back on
		$this->toggle_filter(true);

	    return $value;
	}
}



// class_exists check
endif;

?>