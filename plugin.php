<?php
/*
Plugin Name: Titan Theme Generator
Description: Generates a _s theme that includes Titan Framework. Based on Automattic's Underscores.me
Author: Benjamin Intal
Version: 0.1
Author URI: http://gambit.ph
*/

// Reference: https://github.com/Automattic/underscores.me
// Prototype folder contents acquired from the dist version at http://underscores.me


require_once( 'underscoresme-generator.php' );


add_shortcode( 'underscores', '_underscores' );
function _underscores( $atts, $content = null ) {
	wp_enqueue_style( 'titan-generator', plugins_url( 'styles.css', __FILE__ ), null, '0.1' );
	do_action( 'underscoresme_print_form' ); 
}


add_action( 'init', 'underscores_init', 1 );
function underscores_init() {
	if ( ! isset( $_REQUEST['underscoresme_generate'], $_REQUEST['underscoresme_name'] ) )
		return;
	
	$_REQUEST['underscoresme_description'] = 'An _s based theme with Titan Framework integration, generated from http://titanframework.net';
}
	

add_filter( 'underscoresme_generator_file_contents', 'do_titan_replacements', 9, 2 );
function do_titan_replacements( $contents, $filename ) {
	if ( $filename == 'functions.php' ) {
		$contents .= <<< TITAN

/**
 * Load Titan Framework plugin checker
 */
require get_template_directory() . '/titan-framework-checker.php';

/**
 * Load Titan Framework options
 */
require get_template_directory() . '/titan-options.php';
TITAN;

	}
	
	return $contents;
}