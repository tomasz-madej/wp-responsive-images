<?php

/**
 * Plugin Name: Responsive Images
 * Plugin URI: https://github.com/tomasz-madej/wp-responsive-images
 * Description: This plugin makes all images responsive.
 * Version: 1.0.0
 * Author: Tomasz Madej
 * Author URI: https://github.com/tomasz-madej
 * Text Domain: responsive-images
 * License: GPL2
 */

//Functions
function available_on($content_types) {
	foreach ($content_types as $single) {

		$is_checked = esc_attr(get_option("content_type")) == $single ? 'checked="checked"' : '';
		
		echo 	'<div class="single-option">
	 				<p>
						<input type="radio" name="content_type" value="' . $single . '" id="' . $single . '" ' . $is_checked . '/>
						<label for="' . $single . '">' . strtoupper($single) . '</label>
					</p>
	 			</div>';
	}
}

function responsive_images_active_on() {
	$types = ["everywhere", "pages", "posts"];
 ?>
 
	<div class="wrap">
    	<h1 style="border-bottom: solid 1px;">
     		Responsive Images Plugin
     		<span style="float: right; font-size: 14px; font-style: italic; color: #a9a9a9;">Make it all responsive!</span>
 		</h1>
 		<div class="content" style="margin: 50px 0 0;">
 			<h4><?php _e( 'Please choose where to use responsive images', 'responsive-images-plugin' ) ?>:</h4>
 			<form action="options.php" method="post">
				<?php
					settings_fields( 'responsive-images-plugin-settings' );
					do_settings_sections( 'responsive-images-plugin-settings' );
				?>
	 			<div class="options" style="margin: 0 0 50px; border-bottom: solid 1px; padding-bottom: 40px;">
	 				<?php available_on($types); ?>
				</div>
	 			<button class="button button-primary" type="submit">Save</button>
 			</form>
 		</div>
	</div>
<?php
}

//JS

function responsive_images_scripts() {
    wp_enqueue_script( 'make-images-responsive-js', plugins_url( '/js/scripts.min.js', __FILE__ ));
	wp_localize_script(
		'make-images-responsive-js', 
		'content_type_var',
		array(
            'name' => esc_attr(get_option("content_type"))
        )
    );
}

//CSS

function responsive_images_styles() {
    wp_enqueue_style( 'make-images-responsive-css', plugins_url( '/css/style.min.css', __FILE__ ));
}

//Actions

add_action('admin_menu', function() {
  add_options_page( 'Responsive Images Settings', 'Responsive Images', 'manage_options', 'responsive-images', 'responsive_images_active_on' );
});

add_action( 'admin_init', function() {
    register_setting( 'responsive-images-plugin-settings', 'content_type' );
});

add_action('wp_enqueue_scripts','responsive_images_scripts');
add_action('wp_enqueue_scripts','responsive_images_styles');