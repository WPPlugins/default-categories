<?php
/*
Plugin Name: Default Categories
Plugin URI: http://wordpress.org/extend/plugins/default-categories/
Description: Allows authors to set their default categories for authoring new posts.
Author: Simon Wheatley
Version: 0.11b
Author URI: http://simonwheatley.co.uk/wordpress/
*/

/*  Copyright 2008 Simon Wheatley

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

require_once ( dirname (__FILE__) . '/plugin.php' );

/**
 * A Class to allow authors to set default categories for their new posts.
 *
 * Extends John Godley's WordPress Plugin Class, which adds all sorts of functionality
 * like templating which can be overriden by the theme, etc.
 * 
 * @package default
 * @author Simon Wheatley
 **/
class DefaultCategories extends DefaultCategories_Plugin
{

	/**
	 * Constructor for this class. 
	 *
	 * @return void
	 * @author Simon Wheatley
	 **/
	function __construct() 
	{
		$this->register_plugin ( 'default-categories', __FILE__ );

		// Hooks involved with saving the default cats from the profile
		$this->add_action( 'show_user_profile', 'user_profile' );
		$this->add_action( 'edit_user_profile', 'user_profile' );
		$this->add_action( 'profile_update' );
		// Hooks involved with setting the categories on a new post
		$this->add_action( 'load-post-new.php', 'load_post_new' );
		$this->add_action( 'admin_print_scripts-post-new.php', 'admin_header_scripts_post_new' );
	}
	
	/* HOOKS */

	public function user_profile()
	{
		global $profileuser;
		// No point continuing if the user can't write posts
		if ( ! $profileuser->has_cap( 'edit_posts' ) ) return;

		$vars = array();
		$vars[ 'default_categories' ] = (array) $profileuser->default_categories;
		$this->render_admin( 'user-profile', $vars );
	}

	public function profile_update()
	{
		// SECURE-A-TEA: If the nonce isn't present, or incorrect, then we don't have anything to do
		if ( ! wp_verify_nonce( $_REQUEST[ '_dc_nonce' ], 'default-categories') ) return;

		$user_id = (int) @ $_REQUEST['user_id'];
		$default_categories = (array) @ $_POST[ 'post_category' ];
		update_usermeta( $user_id, 'default_categories', $default_categories );
	}
	
	public function load_post_new()
	{
		wp_enqueue_script( 'jquery' ); // Just to be sure
		$set_categories = $this->url() . '/js/set-categories.js';
		wp_enqueue_script( 'dc_set_categories', $set_categories );
	}
	
	public function admin_header_scripts_post_new()
	{
		$vars = array();
		$current_user = wp_get_current_user();
		$vars[ 'default_categories' ] = (array) $current_user->default_categories;
		$this->render_admin( 'js-default-categories', $vars );
	}

}

/**
 * Instantiate the plugin
 *
 * @global
 **/

$DefaultCategories = new DefaultCategories();


?>