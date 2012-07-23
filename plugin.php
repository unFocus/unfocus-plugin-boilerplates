<?php
/*
Plugin Name: Plugin Boilerplate
Plugin URI: https://github.com/unFocus/unfocus-plugin-boilerplates
Description: A Collection of Boilerplates and Libraries to take care of the annoying and mundaine tasks of WordPress Plugin development.
Author: unFocus Projects
Author URI: http://www.unfocus.com/
Version: 2012.07.23-17.37
License: GPLv2 or later
Text Domain: plugin-boilerplate
Network: false
*/

/*  This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Plugin_Boilerplate {
	
	static $version;
	static $file = __FILE__;
	const OPTION = 'Plugin_Boilerplate';
	
	function __construct() {
		self::upgrade_check();
		register_activation_hook(   __FILE__, array( __CLASS__, 'activate'   ) );
		register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivate' ) );
		register_uninstall_hook(    __FILE__, array( __CLASS__, 'uninstall'  ) );
		
		add_action( 'init', array( __CLASS__, 'init' ) );
	}
	function init() {
		//Debug_Bar_Extender::instance()->trace_var( get_option( self::OPTION ) );
	}
	
	
	function upgrade_check() {
		$data = get_file_data( __FILE__, array ( 'version' ) );
		self::$version = $data[ 0 ];
		$options = get_option( self::OPTION );
		
		if ( ! isset( $options[ 'version' ] ) || version_compare( self::$version, $options[ 'version' ], '>' ) ) 
			self::upgrade();
	}
	function upgrade() {
		$options = get_option( self::OPTION );
		if ( ! $options ) $options = array();
		$options[ 'version' ] = self::$version;
		update_option( self::OPTION, $options );
	}
	function activate() {
		//self::loaded(); // call any methods that register CPTs
		flush_rewrite_rules();
	}
	function deactivate() {
		flush_rewrite_rules();
	}
	function uninstall() {
		delete_option( self::OPTION );
		self::deactivate();
	}

}
new Plugin_Boilerplate();