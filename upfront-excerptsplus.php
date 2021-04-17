<?php
/*
Plugin Name:    UpFront Auszüge Plus
Plugin URI:     https://n3rds.work
Description:    ExcerptsPlus ist das Schweizer Taschenmesser für die Anzeige von Inhalten und bietet eine flexible und fortschrittliche Anzeige von Inhalten. Fügt einen Block hinzu, der viele weitere Optionen für die Anzeige von Auszügen und Inhalten bietet. Kann zum Einrichten von Magazin-Layouts, Post-Schiebereglern und sogar einfachen Bildergalerien verwendet werden. In Verbindung mit benutzerdefinierten Post Typen kannst Du fast alles erstellen! Basierend auf Pizazz ExcerptsPlus 3.4.14 von Chris Howard.

Version:        1.0.0
Author:         WMS N@W
Author URI:     https://n3rds.work
License:        GPL2
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:    upfront-excerptsplus
Domain Path:    /languages
Network: false


UpFront ExcerptsPlus plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
UpFront ExcerptsPlus plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with UpFront ExcerptsPlus plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
require 'includes/psource-plugin-update/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=upfront-excerptsplus', 
	__FILE__, 
	'upfront-excerptsplus' 
);

define('EPVERSION', '0.0.1');

define('EP_BLOCK_URL', plugin_dir_url(__FILE__));
define('EP_BLOCK_PATH', plugin_dir_path(__FILE__));

$upload_dir = wp_upload_dir();
define('EP_CACHE_URL', $upload_dir['baseurl'] . '/cache/upfront/eplus');
define('EP_CACHE_PATH', $upload_dir['basedir'] . '/cache/upfront/eplus');

define('EP_CACHE_URL_PREFIX', EP_CACHE_URL . '/eplus-');
define('EP_CACHE_PATH_PREFIX', EP_CACHE_PATH . '/eplus-');

define('CHDEBUG', 'false');
define('CHDEBUGNOIMAGES', 'false'); // To test with no images. Do not delete.


require EP_BLOCK_PATH . '/ep2_functions.php';

if (!class_exists('jo_Resize')) {
	require EP_BLOCK_PATH . '/includes/jo-resizer/jo_image_resizer.php';
}

require EP_BLOCK_PATH . '/ep2_admin.php';


if (is_admin())
{
	add_action('admin_notices', 'ep_check_cache');
}

// Setup cache clearing as required
add_action('post_updated', 'ep_clear_post_image_cache');
add_action('upfront_visual_editor_save', 'ep_clear_image_cache');
add_action('wp_footer', 'ep_quickread_code', 2);

register_deactivation_hook(__FILE__, 'ep_deactivate');


add_action('after_setup_theme', 'ep_register_block');

function ep_register_block() {
	if (!class_exists('UpFrontBlockAPI') )
	{
		return false;
	}
	EPFunctions::php_debug('ExcerptsPlus v' . EPVERSION);

	//require EP_BLOCK_PATH . '/ep2_display.php';
	require EP_BLOCK_PATH . '/ep2_options.php';

	add_theme_support('post-formats', array('aside', 'gallery'));

	
	$class = 'UpFrontExcerptsPBlock';
	$block_type_url = substr(WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), '', plugin_basename(__FILE__)), 0, -1);		
	$class_file = __DIR__ . '/ep2_display.php';
	$icons = array(
			'path' => __DIR__,
			'url' => $block_type_url
		);

	upfront_register_block(
		$class,
		$block_type_url,
		$class_file,
		$icons
	);
	

	/**
	 *
	 * Check if there is the UpFront Loader
	 *
	 */		
	if ( version_compare(UPFRONT_VERSION, '1.1.70', '<=') ){			
		include_once $class_file;
	}

}

register_activation_hook(__FILE__, 'ep_activate');

function ep_activate() {
	if (!class_exists('UpFrontBlockAPI'))
	{
		exit("UpFront Theme nicht aktiv. Der Auszüge Plus-Block kann nicht aktiviert werden.");
	}

	return;

	//Kept this incase need something like it
	$blocks = UpFrontBlocksData::get_all_blocks();

	if (is_array($blocks))
	{

		foreach ($blocks as $block_id => $block)
		{

			if ($block['type'] == 'excerpts-plus')
			{
				echo $block['id'], ' : ', $block['type'], ' ';
				$field = UpFrontBlockAPI::get_setting($block, 'ep-content-in-post');
				if (is_array($field))
				{
					foreach ($field as $key => $value)
					{
						echo $value;
					}
				}
				else
				{
					if (!isset($field))
					{
						echo 'Die Standardeinstellung war true. Machen wir dies also wahr';						
					}
					elseif ($field === false)
					{
						echo 'False';
					}
					elseif ($field == false)
					{
						echo 'False-ish';
					}
					elseif ($field == true)
					{
						echo 'True';
					}
				}
				echo '<br/>';
			}
		}
		exit;
	}
}

function ep_deactivate() {
	// empty ep cache
	ep_clear_image_cache();
}

function ep_check_cache() {

	$pzep_err_level = error_reporting();

	// Check exists
	if (!is_dir(EP_CACHE_PATH))
	{
		$upload_dir = wp_upload_dir();
		// Trying to use WPsversion instead.
		wp_mkdir_p($upload_dir['basedir'] . '/cache/upfront/eplus' );
	}

	if (!is_dir(EP_CACHE_PATH))
	{
		echo '<div id="message" class="error"><p>ExcerptsPlus Image Cache-Ordner können nicht erstellt werden. Du musst die folgenden Ordner manuell erstellen:</p>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache/pizazzwp<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache/upfront/eplus<br/>
			<p>Verwende FTP und setze ihre Berechtigungen auf 775<br/><br/></p>
		</div>';
	}

	// Check can write
	if (!is_writable(EP_CACHE_PATH))
	{
		echo '<div id="message" class="error"><p>ExcerptsPlus Image Cache-Ordner sind nicht beschreibbar.</p>';
		echo 'Überprüfe die Berechtigungen von: <strong>', EP_CACHE_PATH, '</strong>';
		echo ' verwende FTP und setze die Berechtigungen auf 755 oder 775';
		echo '<br/><br/></div>';
	}
}

/**
 * Add meta links in Plugins table
 */

add_filter( 'plugin_row_meta', 'ep_plugin_meta_links', 10, 2 );
function ep_plugin_meta_links( $links, $file ) {

  $plugin = plugin_basename(__FILE__);

  // create link
  if ( $file == $plugin ) {
    return array_merge(
      $links,
      array(
      	'<a href="http://guides.pizazzwp.com/excerptsplus/about-excerpts/" target="_blank">Online-Anleitung</a>',
      	'<a href="mailto:webmaster@n3rds.work" target=_blank>Benutzer-Support</a>' )
    );
  }
  return $links;
}