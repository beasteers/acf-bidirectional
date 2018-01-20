# ACF Bidirectional Relationship Field

Adds bidirectional functionality to a relationship field. 

-----------------------

### Description

Creates a two-way post relationship, identical to the builtin relationship field that links to another post relation field. 

Given the configuration:

Post type A has a bidirectional field:
 - Field Label: Post Type B
 - Field Slug: post_type_b
 - Field Name to Update: post_type_a

Post type B has a bidirectional field:
 - Field Label: Post Type A
 - Field Slug: post_type_a
 - Field Name to Update: post_type_b

These two fields will update each other when either are changed. As long as the "Field Slug" in one field is the same as the "Field Name to Update" in the other (and vice versa), the fields will be updated. The field can also work where one side is a built-in (one-sided) relationship field. In that case, changes will only be bidirectional when updated from the bidirectional side.

### Compatibility

This ACF field type is compatible with:
* ACF 5
* ACF 4

### Installation

1. Install via the plugin page (or copy the `acf-bidirectional` folder into your `wp-content/plugins` folder)
2. Activate the ACF Bidirectional Relationship Field plugin via the plugins admin page
3. Create a new field via ACF and select the Bidirectional Relationship type
4. Set the "Field Name to Update" to the field slug that you want to link to
5. Set "Filter by Post Type" to limit theavailable  post types

