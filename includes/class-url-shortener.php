<?php

// The core plugin class.
class Url_Shortener {

	protected $plugin_name;

	protected $version;

	public function __construct() {

		$this->version = URL_SHORTENER_VERSION;

		$this->plugin_name = 'url-shortener';
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}

}
