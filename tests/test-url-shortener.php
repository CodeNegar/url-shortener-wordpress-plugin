<?php
/**
 * Class Url_shortener_test
 *
 * @package Url_Shortener
 */

// Url shortener tests.
class Url_ShortenerTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
        $this->class_instance = new Url_Shortener();

         wp_set_current_user( self::factory()->user->create( [
             'role' => 'administrator',
         ] ) );
    }


    // Test that the plugin is activated
	function test_activated() {
        $this->assertTrue( class_exists( 'Url_Shortener' ), 'Url_Shortener class not defined' );
        $this->assertNotEmpty( $this->class_instance->get_version() );
	}
}
