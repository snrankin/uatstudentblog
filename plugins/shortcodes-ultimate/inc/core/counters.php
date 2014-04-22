<?php

class Su_Counter_Examples {

	static $option = 'su_counter_examples';

	function __construct() {

	}
}

// new Su_Counter_Examples;

class Su_Counter_Extra_Addon {

	static $option = 'su_counter_extra_addon';

	function __construct() {
		add_filter( 'su/menu/shortcodes',  array( __CLASS__, 'display' ) );
		add_filter( 'su/menu/addons',      array( __CLASS__, 'display' ) );
		add_action( 'sunrise/page/before', array( __CLASS__, 'disable' ) );
	}

	public static function display( $title ) {
		if ( get_option( self::$option ) ) return $title;
		return sprintf(
			'%s <span class="update-plugins count-1" title="%s"><span class="update-count">%s</span></span>',
			$title,
			__( '1 new add-on for Shortcodes Ultimate', 'su' ),
			'1'
		);
	}

	public static function disable() {
		if ( $_GET['page'] === 'shortcodes-ultimate-addons' ) update_option( self::$option, true );
	}
}

new Su_Counter_Extra_Addon;
