<?php
/**
 * Plugin Name: Coffing Control
 * Plugin URI: https://www.coffing.es/
 * Description: Plugin de control de la tienda y productos en general.
 * Version: 1.0
 * Author: Nick Cyrus Lemus Duque
 * Author URI: https://www.coffing.es/
 * Text Domain: CoffingControl
 * Domain Path: /i18n/languages/
 * Requires PHP: 7.0
 *
 * @package CoffingControl
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'COFCO_PLUGIN' ) )  define( 'COFCO_PLUGIN', __DIR__ );
if ( ! defined( 'COFCO_PLUGIN_ADMIN' ) )  define( 'COFCO_PLUGIN_ADMIN', COFCO_PLUGIN.'/admin/' );
if ( ! defined( 'COFCO_PLUGIN_PUBLIC' ) )  define( 'COFCO_PLUGIN_PUBLIC', COFCO_PLUGIN.'/public/' );
if ( ! defined( 'COFCO_PLUGIN_ADMIN_URL' ) )  define( 'COFCO_PLUGIN_ADMIN_URL', WP_CONTENT_URL.'/plugins/'.basename(__DIR__).'/admin/' );
if ( ! defined( 'COFCO_PLUGIN_PUBLIC_URL' ) )  define( 'COFCO_PLUGIN_PUBLIC_URL', WP_CONTENT_URL.'/plugins/'.basename(__DIR__).'/public/' );

include_once COFCO_PLUGIN . '/include/functions.php';
include_once COFCO_PLUGIN . '/include/noticies.php';
include_once COFCO_PLUGIN . '/include/class-coffing.php';

function cofco(){
	return  new coffing();
}

$GLOBALS['cofco'] = cofco();
  