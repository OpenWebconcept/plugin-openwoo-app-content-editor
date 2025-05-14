<?php
/**
 * Helper class for Icons
 *
 * @package    OpenWoo_App_Content_Editor
 * @subpackage OpenWoo_App_Content_Editor/Admin
 * @author     Richard Korthuis <richardkorthuis@acato.nl>
 */

namespace OpenWoo_App_Content_Editor\Admin;

/**
 * Helper class for Icons
 */
class Icons {

	/**
	 * Get a list of all available OpenGemeenten Icons.
	 *
	 * @return array<String, String>
	 */
	public static function get_icons() {
		$icons = [];
		foreach ( glob( plugin_dir_path( dirname( __DIR__ ) ) . '/opengemeenten-iconenset/Svg/Line/*.svg' ) as $icon ) {
			$icon           = basename( $icon );
			$icon           = str_replace( '.svg', '', $icon );
			$icons[ $icon ] = $icon;
		}
		return $icons;
	}

	/**
	 * Get the url for a OpenGemeenten Icon.
	 *
	 * @param string $icon The icon for which the url is requested.
	 *
	 * @return string|null
	 */
	public static function get_icon_url( $icon ) {
		if ( ! $icon ) {
			return null;
		}

		return plugin_dir_url( dirname( __DIR__ ) ) . 'opengemeenten-iconenset/Svg/Line/' . $icon . '.svg';
	}
}
