<?php
/**
 * A stub file for PHPStan in combination with CMB2.
 *
 * @package    OpenWoo_App_Content_Editor
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

if ( ! function_exists( 'new_cmb2_box' ) ) {
	/**
	 * Stub for the CMB2 function.
	 *
	 * @param array<string, mixed> $config
	 * @return CMB2
	 */
	function new_cmb2_box( array $config ) {} // No implementation needed, just declare it
}

if ( ! class_exists( 'CMB2' ) ) {
	class CMB2 {
		/**
		 * Stub method for add_field().
		 *
		 * @param array<string, mixed> $field_args
		 * @return string|false    Field id or false.
		 */
		public function add_field( array $field_args ) {}

		/**
		 * Stub method for add_group_field().
		 *
		 * @param string               $group_field_id
		 * @param array<string, mixed> $field_args
		 * @return void
		 */
		public function add_group_field( string $group_field_id, array $field_args ) {}
	}
}
