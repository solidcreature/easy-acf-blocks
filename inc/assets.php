<?php 

function SBL_register_scripts() {
	wp_enqueue_script( 'jquery');
}

add_action( 'wp_enqueue_scripts', 'SBL_register_scripts' );	


function SBL_enqueue_assets_slickjs() {
	wp_enqueue_style( 'slick-css', SBL_ASSETS_URL . 'slickjs/slick.css' );
	wp_enqueue_style( 'slick-theme', SBL_ASSETS_URL . 'slickjs/slick-theme.css' );
	wp_enqueue_script( 'slick-js', SBL_ASSETS_URL . 'slickjs/slick.min.js' );
}

function SBL_enqueue_assets_morrisjs() {
	wp_enqueue_style( 'morris-css', SBL_ASSETS_URL . 'morrisjs/morris.css' );
	wp_enqueue_script( 'morris-js', SBL_ASSETS_URL . 'morrisjs/morris.min.js' );
	wp_enqueue_script( 'raphael-js', SBL_ASSETS_URL . 'morrisjs/raphael.min.js' );
}

function SBL_enqueue_assets_scrollyeah() {
	wp_enqueue_style( 'scrollyeah-css', SBL_ASSETS_URL . 'scrollyeah/scrollyeah.min.css' );
	wp_enqueue_script( 'scrollyeah-js', SBL_ASSETS_URL . 'scrollyeah/scrollyeah.min.js' );
}




 