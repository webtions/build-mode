<?php
/**
 * Registers block patterns.
 *
 * @package BuildMode
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles block patterns.
 *
 * @since 1.0.0
 */
class Themeist_Build_Mode_Patterns {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_patterns' ) );
	}

	/**
	 * Register block patterns.
	 */
	public function register_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		register_block_pattern(
			'build-mode/maintenance-minimal',
			array(
				'title'       => __( 'Maintenance (Minimal)', 'build-mode' ),
				'description' => _x( 'A simple full-screen maintenance message.', 'Block pattern description', 'build-mode' ),
				'content'     => '<!-- wp:cover {"url":"","id":0,"overlayColor":"white","isUserOverlayColor":true,"minHeight":100,"minHeightUnit":"vh","metadata":{"categories":["featured"],"patternName":"build-mode/maintenance-minimal","name":"Maintenance (Minimal)"},"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="min-height:100vh"><span aria-hidden="true" class="wp-block-cover__background has-white-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"4rem"}},"textColor":"black"} -->
<h2 class="wp-block-heading has-text-align-center has-black-color has-text-color" style="font-size:4rem">Site Under Construction</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.5rem"}},"textColor":"black"} -->
<p class="has-text-align-center has-black-color has-text-color" style="font-size:1.5rem">We are working on something amazing. Please check back soon!</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"0px","style":{"layout":{"flexSize":"60px","selfStretch":"fixed"}}} -->
<div style="height:0px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:social-links {"iconColor":"base","iconColorValue":"#FFFFFF","iconBackgroundColor":"contrast","iconBackgroundColorValue":"#111111","layout":{"type":"flex","justifyContent":"center"}} -->
<ul class="wp-block-social-links has-icon-color has-icon-background-color"><!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->',
				'categories'  => array( 'featured' ),
				'keywords'    => array( 'maintenance', 'coming soon', 'under construction', 'build mode' ),
			)
		);
	}
}
