<?php
 /* @param string $meta Meta name.	 
 * @param array $details Contains the details for the field.	 
 * @param string $value Contains input value;
 * @param string $context Context where the function is used. Depending on it some actions are preformed.;
 * @return string $element input element html string. */

 
/* define id's for input and info div */
$upload_input_id = str_replace( '-', '_', Wordpress_Creation_Kit::wck_generate_slug( $meta . $details['title'] ) );
$upload_info_div_id = str_replace( '-', '_', Wordpress_Creation_Kit::wck_generate_slug( $meta .'_info_container_'. $details['title'] ) ); 
 
/* hidden input that will hold the attachment id */
$element.= '<input id="'. esc_attr( $upload_input_id ) .'" type="hidden" size="36" name="'. esc_attr( Wordpress_Creation_Kit::wck_generate_slug( $details['title'] ) ) .'" value="'. $value .'" class="mb-text-input mb-field"/>';

/* container for the image preview (or file ico) and name and file type */
if( !empty ( $value ) ){
	/* it can hold multiple attachments separated by comma */
	$values = explode( ',', $value );
	foreach( $values as $value ){
		$file_src = wp_get_attachment_url($value);
		$thumbnail = wp_get_attachment_image( $value, array( 80, 80 ), true );
		$file_name = get_the_title( $value );			
		$file_type = get_post_mime_type( $value );		
		
		$element.= '<div id="'.esc_attr( $upload_info_div_id ).'_info_container" class="upload-field-details" data-attachment_id="'. $value .'">';			
		$element.= '<div class="file-thumb">';		
			$element.= $thumbnail;		
		$element.= '</div>';			
		
		$element.= '<p><span class="file-name">';			
			$element.= $file_name;
		$element.= '</span><span class="file-type">';			
			$element.= $file_type;
		$element.= '</span>';
		if( !empty ( $value ) )
			$element.= '<span class="wck-remove-upload">'.__( 'Remove', 'core' ).'</span>';
		$element.= '</p></div>';
	}
}

$element.= '<a href="#" class="button wck_upload_button" id="upload_'. esc_attr(Wordpress_Creation_Kit::wck_generate_slug( $details['title'] ) ) .'_button" data-uploader_title="'. $details['title'] .'" data-uploader_button_text="Select Files" data-upload_input="'.esc_attr( $upload_input_id ).'" ';
if( is_user_logged_in() )
	$element.= 'data-uploader_logged_in="true"';

if( $details['multiple_upload'] == 'true' )
	$element.= ' data-multiple_upload="true"';
else	
	$element.= ' data-multiple_upload="false"';
	
if( $context != 'fep' )
	$element.= ' data-upload_in_backend="true"';
else	
	$element.= ' data-upload_in_backend="false"';

if( !empty( $details['allowed_types'] ) )
	$element.= ' data-allowed_types="'. $details['allowed_types'] .'"';
	
$element.= '>'. __( 'Upload ', 'wck' ) . $details['title'] .'</a>';
?>