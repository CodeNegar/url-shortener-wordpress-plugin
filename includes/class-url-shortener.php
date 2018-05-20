<?php

// The core plugin class.
class Url_Shortener {

	protected $plugin_name;

	protected $version;

	public function __construct() {

		$this->version = URL_SHORTENER_VERSION;
		$this->plugin_name = 'url-shortener';

		$this->define_admin_hooks();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}

	// Register hooks to integrate to WordPress admin dashboard
	private function define_admin_hooks() {
		// Register admin settings page
		$settings = new Url_shortener_settings_page();
		add_action( 'admin_menu', array( $settings, 'url_shortener_create_settings' ) );
		add_action( 'admin_init', array( $settings, 'url_shortener_setup_sections' ) );
		add_action( 'admin_init', array( $settings, 'url_shortener_setup_fields' ) );

		// Register widget
		add_action( 'widgets_init', function () {
			register_widget( 'Url_shortener_widget' );
		} );
	}

}
