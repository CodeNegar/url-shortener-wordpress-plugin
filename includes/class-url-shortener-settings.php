<?php

class Url_shortener_settings_page {

	public function __construct() {
		
	}

	public function url_shortener_create_settings() {
		$callback = array($this, 'url_shortener_settings_content');
		add_options_page('URL Shortener', 'URL Shortener', 'manage_options', 'url_shortener', $callback);
	}

	public function url_shortener_settings_content() {
		?>
			<div class="wrap url_shortener_settings_content">
				<h1>URL Shortener</h1>
				<form method="POST" action="options.php">
					<?php
						settings_fields( 'url_shortener' );
						do_settings_sections( 'url_shortener' );
						submit_button();
					?>
				</form>
			</div>
		<?php
	}

	public function url_shortener_setup_sections() {
		add_settings_section( 'url_shortener_section', '', array(), 'url_shortener' );
	}

	public function url_shortener_setup_fields() {
		$fields = array(
			array(
				'label' => 'URL Shortener installation URL',
				'id' => 'url_shortener_api_url',
				'type' => 'text',
				'placeholder' => 'http://www.exaple.com/links',
				'desc' => 'Enter URL with http:// or https://',
				'section' => 'url_shortener_section',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'url_shortener_field_callback' ), 'url_shortener', $field['section'], $field );
			register_setting( 'url_shortener', $field['id'] );
		}
	}

	public function url_shortener_field_callback( $field ) {
		$value = get_option( $field['id'] );
		printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" class="%5$s" />',
			$field['id'],
			$field['type'],
			$field['placeholder'],
			$value,
			'regular-text ltr'
		);
		if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}
	}
}

new Url_shortener_settings_page();