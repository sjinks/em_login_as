<?php
/*
Plugin Name: EM Log In As
Version: 1.0
Description: This plugin allows you to log in as a different user
Plugin URI: http://www.extrememember.com/
Author: Extreme Member
Author URI: http://blog.sjinks.pro/
*/

defined('ABSPATH') or die();

class EM_LogInAs
{
	public static function instance()
	{
		static $self = null;
		if (!$self) {
			$self = new self();
		}

		return $self;
	}

	public function __construct()
	{
		if (is_admin()) {
			load_plugin_textdomain('emloginas', false, 'em_log_in_as/lang');

			add_action('admin_init', array($this, 'admin_init'));
			add_action('admin_menu', array($this, 'admin_menu'));
		}
	}

	public function admin_init()
	{
		if (current_user_can('manage_options')) {
			add_action('load-em_log_in_as/pages/loginas.php', array($this, 'load_loginas_page'));
			add_action('admin_post_login_as',                 array($this, 'admin_post_login_as'));
			add_action('user_row_actions',                    array($this, 'user_row_actions'), 10, 2);
		}
	}

	public function admin_menu()
	{
		add_management_page(__('Log In As a Different User', 'emloginas'), __('Log In As…', 'emloginas'), 'manage_options', 'em_log_in_as/pages/loginas.php');
	}

	public function load_loginas_page()
	{
		global $params;

		if (!is_array($params)) {
			$params = array();
		}

		$params['users'] = get_users(
			array(
				'count_total' => false,
				'fields'      => array('ID', 'user_login'),
			)
		);
	}

	public function admin_post_login_as()
	{
		check_admin_referer('login-as');

		$id = isset($_POST['userid']) ? intval($_POST['userid']) : intval($_GET['userid']);
		wp_logout();
		wp_set_auth_cookie($id, false, (is_ssl() ? true : false));

		wp_redirect(admin_url());
		die();
	}

	public function user_row_actions(array $actions, WP_User $user)
	{
		$link = wp_nonce_url(admin_url("admin-post.php?action=login_as&userid={$user->ID}"), 'login-as');
		$actions['loginas'] = "<a href='{$link}'>" . sprintf(__('Log In As <strong>%s</strong>', 'emloginas'), $user->user_login) . '</a>';
		return $actions;
	}
}

if (is_admin()) {
	EM_LogInAs::instance();
}
