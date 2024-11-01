<?php
/*
 * Plugin Name: Simple Analytics and Tag Manager Integration for Google
 * Plugin URI: http://blapps.eu/
 * Description: Simply copy and paste your Google Analytcs ID and your Google Tag Manager ID into your Wordpress Admin. No file editing and no configuration needed. Open the <a href="options-general.php?page=google-analytics-tagmanager-integration">Settings</a> page to activate Google Analytics and Google Tag Manager.
 * Author: blapps
 * Version: 1.7
 * Tested up to: 5.4
 * Author URI: https://blapps.eu
 * Text Domain: google-integration
 * Domain Path: /languages
 * Licence GPL2
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

function gi_load_plugin_textdomain()
{
	load_plugin_textdomain('google-integration', FALSE, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'gi_load_plugin_textdomain');


//============ create settings link at plugins page =================//
function satmig_plugin_action_links($links, $file)
{
	if ($file == plugin_basename(dirname(__FILE__) . '/simple-analytics-and-tag-manager-integration-for-google.php')) {
		$links[] = '<a href="' . admin_url('options-general.php?page=google-analytics-tagmanager-integration') . '">' . __('Settings', 'google-integration') . '</a>';
	}
	return $links;
}
add_filter('plugin_action_links', 'satmig_plugin_action_links', 10, 2);

if (!defined('ABSPATH')) die('-1');

function satmig_install()
{
	add_option('satmig_ganalytics_tid', '');
	add_option('satmig_tagmg_tid', '');
	add_option('satmig_ganalytics_apply_to_menu', '0');
	add_option('satmig_tagmg_apply_to_menu', '0');
	add_option('satmig_privacy_apply_to_menu', '1'); // Datenschutz
}
register_activation_hook(__FILE__, 'satmig_install');

function satmig_uninstall()
{
	delete_option('satmig_ganalytics_apply_to_menu');
	delete_option('satmig_tagmg_apply_to_menu');
	delete_option('satmig_privacy_apply_to_menu'); // Datenschutz

}
register_deactivation_hook(__FILE__, 'satmig_uninstall');

function satmig_admin_sidebar()
{
	$screens = array(
		array(
			'url' => 'https://analytics.google.com',
			'img' => 'find-google-analytics-tid.png',
			'alt' => 'How to find Google Analytics Tracking ID',
		),
		array(
			'url' => 'https://tagmanager.google.com/',
			'img' => 'find-google-tag-manager-tid.png',
			'alt' => 'How to dind Google Tag Manager Tracking ID',
		),
	);

	$i = 0;
	echo '<div class="cn_admin_banner">';
	foreach ($screens as $banner) {
		echo '<td><a target="_blank" href="' . esc_url($banner['url']) . '"><img width="700" src="' . plugins_url('images/' . $banner['img'], __FILE__) . '" alt="' . esc_attr($banner['alt']) . '"/></a></td>';
		$i++;
	}
	echo '</div>';
}

function satmig_admin_style()
{
	global $pluginsURI;
	wp_register_style('satmig_admin_css', plugins_url('simple-analytics-and-tag-manager-integration-for-google/css/admin-style.css'), false, '1.0');
	wp_enqueue_style('satmig_admin_css');
}
add_action('admin_enqueue_scripts', 'satmig_admin_style');

function register_satmig_settings()
{
	register_setting('cn-gi-settings-group', 'satmig_ganalytics_tid');
	register_setting('cn-gi-settings-group', 'satmig_tagmg_tid');
	register_setting('cn-gi-settings-group', 'satmig_ganalytics_apply_to_menu');
	register_setting('cn-gi-settings-group', 'satmig_tagmg_apply_to_menu');
	register_setting('cn-gi-settings-group', 'satmig_privacy_apply_to_menu'); // Datenschutz
}
add_action('admin_init', 'register_satmig_settings');

function satmig_plugin_menu()
{
	add_options_page('Google Integration', 'Google Analytics / Google Tag Manager', 'manage_options', 'google-analytics-tagmanager-integration', 'satmig_option_page_fn');
}
add_action('admin_menu', 'satmig_plugin_menu');

function satmig_option_page_fn()
{
	$satmig_ganalytics_tid = get_option('satmig_ganalytics_tid');
	$satmig_tagmg_tid = get_option('satmig_tagmg_tid');
	$satmig_ganalytics_apply_to_menu = get_option('satmig_ganalytics_apply_to_menu');
	$satmig_tagmg_apply_to_menu = get_option('satmig_tagmg_apply_to_menu');
	$satmig_privacy_apply_to_menu = get_option('satmig_privacy_apply_to_menu'); // Datenschutz
	include_once('google-integration-settings.php');
}

function satmig_get_tagmg_tid()
{

	if (get_option('satmig_tagmg_tid') != '') {
		$tracking_id = get_option('satmig_tagmg_tid');
	}

	return $tracking_id;
}

function satmig_get_ganalytics_tid()
{

	if (get_option('satmig_ganalytics_tid') != '') {
		$tracking_id = get_option('satmig_ganalytics_tid');
	}

	return $tracking_id;
}

function satmig_add_gi_tagmg_tracking_code_header()
{
	if (get_option('satmig_tagmg_apply_to_menu') == '1') {
		?>
		<!-- Google Tag Manager -->

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo satmig_get_tagmg_tid(); ?>');</script>
<!-- End Google Tag Manager -->
	<?php
		}
	}

	add_action('wp_head', 'satmig_add_gi_tagmg_tracking_code_header', 11);

	function satmig_add_gi_tagmg_tracking_code_body()
	{
		if (get_option('satmig_tagmg_apply_to_menu') == '1') {

			?>
		<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo satmig_get_tagmg_tid(); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
			}
		}
		add_action('wp_body_open', 'satmig_add_gi_tagmg_tracking_code_body');

		function satmig_add_gi_ganalytics_tracking_code_header()
		{
			if (get_option('satmig_ganalytics_apply_to_menu') == '1') {
				if (get_option('satmig_privacy_apply_to_menu') == '1') {
					?>
			<!-- Google Analytics -->
			<script>
				// Verhindert tracking wenn das Opt-Out-Cookie gesetzt wurde 
				var gaProperty = '<?php echo satmig_get_ganalytics_tid(); ?>';
				var disableStr = 'ga-disable-' + gaProperty;
				if (document.cookie.indexOf(disableStr + '=true') > -1) {
					window[disableStr] = true;
				}

				function gaOptout() {
					document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
					window[disableStr] = true;
				}
				(function(i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function() {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
						m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
				ga('create', '<?php echo satmig_get_ganalytics_tid(); ?>', 'auto');
				ga('set', 'anonymizeIp', true); // die letzten 8 Bit der IP-Adressen werden gelöscht und somit anonymisiert
				ga('send', 'pageview');
			</script>
			<!-- End Google Analytics -->
		<?php
				} else {
					?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140916573-1"></script>
			<script>
				window.dataLayer = window.dataLayer || [];

				function gtag() {
					dataLayer.push(arguments);
				}
				gtag('js', new Date());

				gtag('config', '<?php echo satmig_get_ganalytics_tid(); ?>');
			</script>
<?php
		}
	}
}

add_action('wp_head', 'satmig_add_gi_ganalytics_tracking_code_header', 10);
