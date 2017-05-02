<?php

/*
 * Plugin Name: Flow Plugin
 * Plugin URI: 
 * Description: This plugin displays school assignments.
 * Version: 1.0.0
 * Author: Florin
 * Author URI: http://www.flow.com
 * License: GPL v2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: flow-plugin
 * Domain Path: 
 */

// Exit if accessed directly.
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Portfolio post type.
 *  
 * 
 */
function fp_register_post_type() {

    $labels = array(
        'name'                  => _x( 'Flow', 'Post type general name', 'flow-plugin' ),
        'singular_name'         => _x( 'Flow Item', 'Post type singular name', 'flow-plugin' ),
        'menu_name'             => _x( 'Flow Items', 'Admin Menu text', 'flow-plugin' ),
        'name_admin_bar'        => _x( 'Flow Items', 'Add New on Toolbar', 'flow-plugin' ),
	);

    $args = array(
	    'labels'             => $labels,
	    'public'             => true,
	    'publicly_queryable' => true,
	    'show_ui'            => true,
	    'show_in_menu'       => true,
	    'query_var'          => true,
	    'rewrite'            => array( 'slug' => 'flow' ),
	    'capability_type'    => 'post',
	    'has_archive'        => true,
	    'hierarchical'       => false,
	    'menu_position'      => null,
	    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	    'menu_icon'			 => 'dashicons-screenoptions',
    );

	register_post_type( 'fp_plugin', $args );

}
add_action( 'init', 'fp_register_post_type' );

/**
 * Register Item Type taxonomy.
 * 
 */
function fp_create_taxonomy() {

    $labels = array(
        'name'              => _x( 'Item Types', 'taxonomy general name', 'flow-plugin' ),
        'singular_name'     => _x( 'Item Type', 'taxonomy singular name', 'flow-plugin' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'item-type' ),
    );

	register_taxonomy( 'fp_item_type', 'fp_plugin', $args );

}
add_action( 'init', 'fp_create_taxonomy' );




function getResults(){
global $wpdb;
if(!isset($_POST['name']))return false;
$name=$_POST['name'];
    $email=$_POST['email'];
    $message=$_POST['message'];

$wpdb->insert( 
  'wp_guestbook', 
  array( 
    'user_id' => get_current_user_id(), 
    'title' => $name ,
    'body' => $email ,
    'c_at' => date('Y-m-d H:i:s'),
   // 'u_at' => 123 ,
  ), 
  array( 
    '%d' ,
    '%s' ,
    '%s' ,
    '%s' ,

  ) 
);

$results = $wpdb->get_row('Select * From  wp_guestbook');


    var_export($results);
}

getResults();
