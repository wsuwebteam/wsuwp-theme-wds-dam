<?php namespace WSUWP\Theme\WDSDAM;

class Supports {

	public static function init() {

		add_filter( 'big_image_size_threshold', function () { return false; }, 9999999 );

		add_action( 'init', array( __CLASS__, 'add_taxonomy_support' ) );

		add_action( 'after_setup_theme', array( __CLASS__, 'add_image_size' ) );
		

	}

	public static function add_taxonomy_support() {

		register_taxonomy_for_object_type( 'category', 'attachment' );

		register_taxonomy_for_object_type( 'post_tag', 'attachment' );


	}

	public static function add_image_size() {

		add_image_size( 'web', 1900 );

	}


}

Supports::init();
