<?php

/*
Plugin Name: Instagram Heliverse
Plugin URI: http://heliverse.com
Description: Feeding instagram posts
Version: 1.0.0
Author: Abhinandan
Author URI: airindustry.itch.io
License: GPLv2 or later
Text Domain: instagramheliverse
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );



// getting all the functions required to run db,
require_once 'pluginFunctions.php';


// The code that runs during plugin activation
function activate_instagramh_plugin() {
	echo 'lets see does it working';
    flush_rewrite_rules();
	createTableInstagramH();
}
register_activation_hook( __FILE__, 'activate_instagramh_plugin' );


// The code that runs during plugin deactivation
function deactivate_instagramh_plugin() {
	flush_rewrite_rules();
	whileDeactivatingPlugin();
}
register_deactivation_hook( __FILE__, 'deactivate_instagramh_plugin' );



// adding styles and scripts to plugin
function enqueMyScripts(){
	wp_enqueue_style( 'mypluginStyle', plugin_dir_url(  __FILE__  ).'assets/mystyle.css' );
	wp_enqueue_script( 'mypluginScript', plugin_dir_url( __FILE__ ).'assets/myscript.js' );
}
add_action( 'admin_enqueue_scripts', 'enqueMyScripts' );



// adding pages and subpages to plugin
require_once 'Pages.php';


// adding custom input fields to pages
require_once 'CustomInputs.php';


// plugin shortcode
add_shortcode( 'Instagram_Heliverse',  'shortcodeCallback'); // callback func in 'pluginFunctions.php'



?>