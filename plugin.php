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
	//do_action( 'underscoresme_print_form' ); 
	
	return '
		<div id="generator-form" class="generator-form-skinny">
			<form method="POST">
				<input type="hidden" name="underscoresme_generate" value="1" />

				<section class="generator-form-inputs">
					<section class="generator-form-primary">
						<label for="underscoresme-name">Theme Name</label>
						<input type="text" id="underscoresme-name" name="underscoresme_name" placeholder="Theme Name" />
					</section><!-- .generator-form-primary -->

					<section class="generator-form-secondary">
						<label for="underscoresme-slug">Theme Slug</label>
						<input type="text" id="underscoresme-slug" name="underscoresme_slug" placeholder="Theme Slug" />

						<label for="underscoresme-author">Author</label>
						<input type="text" id="underscoresme-author" name="underscoresme_author" placeholder="Author" />

						<label for="underscoresme-author-uri">Author URI</label>
						<input type="text" id="underscoresme-author-uri" name="underscoresme_author_uri" placeholder="Author URI" />

						<label for="underscoresme-description">Description</label>
						<input type="text" id="underscoresme-description" name="underscoresme_description" placeholder="Description" />

						<input type="checkbox" id="underscoresme-sass" name="underscoresme_sass" value="1">
						<label for="underscoresme-sass">_sassify!</label>
					</section><!-- .generator-form-secondary -->
				</section><!-- .generator-form-inputs -->

				<div class="generator-form-submit">
					<input type="submit" name="underscoresme_generate_submit" value="Generate" />
					<span class="generator-form-version">Based on <a href="http://github.com/automattic/_s">_s from github</a></span>
				</div><!-- .generator-form-submit -->
			</form>
		</div><!-- .generator-form -->';
}


add_action( 'init', 'underscores_init', 1 );
function underscores_init() {
	if ( ! isset( $_REQUEST['underscoresme_generate'], $_REQUEST['underscoresme_name'] ) )
		return;
	
	$_REQUEST['underscoresme_description'] = 'An Underscores based theme with Titan Framework integration, generated from http://titanframework.net';
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