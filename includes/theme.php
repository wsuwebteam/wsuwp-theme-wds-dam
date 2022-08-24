<?php namespace WSUWP\Theme\WDSDAM;


class Theme {


	protected static $version = '0.0.1';


	public static function get( $property ) {

		switch ( $property ) {
			case 'version':
				return self::$version;
			default:
				return '';
		}

	}


	public static function init() {

		require_once __DIR__ . '/supports.php';
        require_once __DIR__ . '/shortcode.php';

	}

}

Theme::init();
