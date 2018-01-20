<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acf_field_bidirectional') ) :


include_once('acf-bidirectional.php');

class acf_field_bidirectional extends abstract_acf_field_bidirectional {
	
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Field Name to Update','acf-bidirectional'),
			'instructions'	=> __('The name of the field to link to. Defaults to current post\'s post type slug.','acf-bidirectional'),
			'type'			=> 'text',
			'name'			=> 'relation_field_name',
		));

		// Call the correct 
		parent::render_field_settings($field);
	}
	
}


acf_register_field_type( 'acf_field_bidirectional' );


// class_exists check
endif;

?>