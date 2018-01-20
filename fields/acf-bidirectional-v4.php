<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acf_field_bidirectional') ) :


include_once('acf-bidirectional.php');

class acf_field_bidirectional extends abstract_acf_field_bidirectional {
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like below) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// defaults?
		/*
		$field = array_merge($this->defaults, $field);
		*/
		
		// key is needed in the field names to correctly save the data
		$key = $field['name'];
		
		
		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Field Name to Update",'acf'); ?></label>
		<p class="description"><?php _e("The name of the field to link to.",'acf'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('acf/create_field', array(
			'type'		=>	'text',
			'name'		=>	'fields['.$key.'][relation_field_name]',
			'value'		=>	$field['relation_field_name']
		));
		
		?>
	</td>
</tr>
		<?php

		return parent::create_options($field);
	}
}


// initialize
new acf_field_bidirectional( $this->settings );


// class_exists check
endif;

?>