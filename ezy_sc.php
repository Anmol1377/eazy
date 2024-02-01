<?php
/**
 * Plugin Name: EaZy security
 * Plugin URI:  https://security.bikswee.com
 * Description: WordPress Security, Firewall & Anti-Spam 
 * Version:     3.3
 * Author:      EaZy security
 * Text Domain: ezy_sc-text
 */

if (!defined('ABSPATH')) {
    die('Error 404');
}

//define('ezy_sc_PLUGIN_PATH', plugin_dir_path(__FILE__));

//Check if is in the Admin Panel
if (is_admin()) {
    //EaZy Security Admin Menus
    add_action('admin_menu', 'ezy_sc_adminmenu');
    
    function ezy_sc_adminmenu()
    {
        $page_title = 'EaZy Security';
        $menu_title = 'EaZy Security';
        $capability = 'manage_options';
        $menu_slug  = 'ezy_sc';
        $function   = 'ezy_sc_dashboard';
        $icon_url   = 'dashicons-shield-alt';
        
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
        add_submenu_page(NULL, 'Dashboard', 'Dashboard', 'manage_options', 'ezy_sc', 'ezy_sc_dashboard');
        // add_submenu_page('ezy_sc', 'Login', 'Login', 'manage_options', 'ezy_sc-login', 'ezy_sc_login');
        add_submenu_page(NULL, 'Settings', 'Settings', 'manage_options', 'ezy_sc-settings', 'ezy_sc_settings');
        add_submenu_page(NULL, 'Protection Modules', 'Protection Modules', 'manage_options', 'ezy_sc-modules', 'ezy_sc_modules');
        add_submenu_page(NULL, 'Logs', 'Logs', 'manage_options', 'ezy_sc-logs', 'ezy_sc_logs');
        add_submenu_page(NULL, 'Bans Details', 'Bans Details', 'manage_options', 'ezy_sc-bans', 'ezy_sc_bans');
        // add_submenu_page('ezy_sc', 'External Scanner', 'External Scanner', 'manage_options', 'ezy_sc_wm_scanner', 'ezy_sc_wm_scanner');
        add_submenu_page(NULL, 'Scan Site', 'Scan Site', 'manage_options', 'ezy_sc-scanner', 'ezy_sc_scanner');
        
        add_submenu_page( NULL,'Whitelist', 'Whitelist', 'manage_options', 'ezy_sc-whitelist', 'ezy_sc_whitelist');
        add_submenu_page(NULL, 'PHP Security Check', 'PHP Security Check', 'manage_options', 'ezy_sc-seccheck', 'ezy_sc_seccheck');
        add_submenu_page( NULL,'System Information', 'System Information', 'manage_options', 'ezy_sc-systeminfo', 'ezy_sc_systeminfo');
        add_submenu_page( NULL,'Analytics', 'Analytics', 'manage_options', 'ezy_sc-analytics', 'ezy_sc_analytics');
        add_submenu_page( NULL,'Error Monitoring', 'Error Monitoring', 'manage_options', 'ezy_sc-errormonitoring', 'ezy_sc_errormonitoring');
        add_submenu_page(NULL, '.htaccess Editor', '.htaccess Editor', 'manage_options', 'ezy_sc-hteditor', 'ezy_sc_hteditor');
        add_submenu_page(NULL, 'Port Scanner', 'Port Scanner', 'manage_options', 'ezy_sc-portscanner', 'ezy_sc_portscanner');
        add_submenu_page( NULL,'IP Blacklist Checker', 'IP Blacklist Checker', 'manage_options', 'ezy_sc-ipblacklistcheck', 'ezy_sc_ipblacklistcheck');
        add_submenu_page( NULL,'Hashing', 'Hashing', 'manage_options', 'ezy_sc-hashing', 'ezy_sc_hashing');
        add_submenu_page( NULL,'Log Details', 'Log Details', 'manage_options', 'ezy_sc-logdetails', 'ezy_sc_logdetails');
        add_submenu_page( NULL,'Visitor Details', 'Visitor Details', 'manage_options', 'ezy_sc-visitordetails', 'ezy_sc_visitordetails');
		add_submenu_page( NULL,'Login History', 'Login History', 'manage_options', 'ezy_sc-loginhistory', 'ezy_sc_loginhistory');
		add_submenu_page( NULL,'Contact Us!', 'Contact Us!', 'manage_options', 'ezy_sc-contactUs', 'ezy_sc_contactUs');
        	// add_submenu_page( 'ezy_sc','Notification', 'NOtification', 'manage_options', 'ezy_sc-notification', 'ezy_sc_notification');
    }
    
    //EaZy Security Action Links
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ezy_sc_actionlinks');
    
    function ezy_sc_actionlinks($links)
    {
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=ezy_sc-settings')) . '">Settings</a>';
        $links[] = '<a href="https://security.bikswee.com" target="_blank">Support</a>';
        return $links;
    }
    
    //EaZy Security Database Options
    // add_option('wpg_mail_notifications', '1', '', 'yes');
    add_option('wpg_countryban_blacklist', '1', '', 'yes');
    add_option('wpg_sqli_protection', '1', '', 'yes');
    add_option('wpg_sqli_protection2', '1', '', 'yes');
    add_option('wpg_sqli_protection3', '0', '', 'yes');
    add_option('wpg_sqli_protection4', '1', '', 'yes');
    add_option('wpg_sqli_protection5', '1', '', 'yes');
    add_option('wpg_sqli_protection6', '1', '', 'yes');
    add_option('wpg_sqli_logging', '1', '', 'yes');
    add_option('wpg_sqli_autoban', '0', '', 'yes');
    add_option('wpg_sqli_mail', '1', '', 'yes');
    add_option('wpg_sqli_redirect', get_site_url() . '/blocked-request', '', 'yes');
    add_option('wpg_badbot_protection', '1', '', 'yes');
    add_option('wpg_badbot_protection2', '1', '', 'yes');
    add_option('wpg_badbot_protection3', '1', '', 'yes');
    add_option('wpg_badbot_logging', '1', '', 'yes');
    add_option('wpg_badbot_autoban', '0', '', 'yes');
    add_option('wpg_badbot_mail', '1', '', 'yes');
    add_option('wpg_proxy_protection', '0', '', 'yes');
    add_option('wpg_proxy_protection2', '0', '', 'yes');
	add_option('wpg_proxy_api1', '', '', 'yes');
	add_option('wpg_proxy_api2', '', '', 'yes');
	add_option('wpg_proxy_api3', '', '', 'yes');
    add_option('wpg_proxy_logging', '1', '', 'yes');
    add_option('wpg_proxy_mail', '1', '', 'yes');
    add_option('wpg_proxy_redirect', get_site_url() . '/proxy-detected', '', 'yes');
    add_option('wpg_spam_protection', '0', '', 'yes');
    add_option('wpg_spam_logging', '1', '', 'yes');
    add_option('wpg_spam_mail', '1', '', 'yes');
    add_option('wpg_spam_redirect', get_site_url() . '/spam-ip', '', 'yes');
    add_option('wpg_live_traffic', '0', '', 'yes');
    add_option('wpg_error_reporting', '5', '', 'yes');
    add_option('wpg_display_errors', '0', '', 'yes');
    add_option('wpg_banned_redirect', get_site_url() . '/banned', '', 'yes');
    add_option('wpg_bannedc_redirect', get_site_url() . '/banned-country', '', 'yes');
    add_option('wpg_bannedo_redirect', get_site_url() . '/banned-os', '', 'yes');
    add_option('wpg_bannedb_redirect', get_site_url() . '/banned-browser', '', 'yes');
    add_option('wpg_bannedi_redirect', get_site_url() . '/banned-isp', '', 'yes');
    add_option('wpg_bannedr_redirect', get_site_url() . '/banned-referer', '', 'yes');
    
    //Warning Pages
    function ezy_sc_addwpage()
    {
        $wppage1_content = '<p>You are banned and you cannot continue to the website</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
		$wpage1  = array(
            'post_title' => 'Banned',
            'post_content' => $wppage1_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage2_content = '<p>Malicious request was detected</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage2  = array(
            'post_title' => 'Blocked Request',
            'post_content' => $wppage2_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage3_content = '<p>Access to the website via Proxy is not allowed (Disable Browser Data Compression if you have it enabled)</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage3  = array(
            'post_title' => 'Proxy Detected',
            'post_content' => $wppage3_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage4_content = '<p>You are in the Blacklist of Spammers and you cannot continue to the website</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage4  = array(
            'post_title' => 'Spam IP',
            'post_content' => $wppage4_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage5_content = '<p>Sorry, but your country is banned and you cannot continue to the website</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage5  = array(
            'post_title' => 'Banned Country',
            'post_content' => $wppage5_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage6_content = '<p>Access to the website through your Browser is not allowed, please use another Internet Browser</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage6  = array(
            'post_title' => 'Banned Browser',
            'post_content' => $wppage6_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage7_content = '<p>Access to the website through your Operating System is not allowed</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage7  = array(
            'post_title' => 'Banned OS',
            'post_content' => $wppage7_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage8_content = '<p>Your Internet Service Provider is blacklisted and you cannot continue to the website</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage8  = array(
            'post_title' => 'Banned ISP',
            'post_content' => $wppage8_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
		
		$wppage9_content = '<p>Your referrer url is blocked and you cannot continue to the website</p>
		<p><br /><br /></p>
		<p>Protected by <strong><a href="http://security.bikswee.com/" target="_blank">EaZy Security</a></strong></p>
		';
        $wpage9  = array(
            'post_title' => 'Banned Referer',
            'post_content' => $wppage9_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        );
        
        if (get_page_by_title('Banned') == NULL) {
            wp_insert_post($wpage1);
        }
        if (get_page_by_title('Blocked Request') == NULL) {
            wp_insert_post($wpage2);
        }
        if (get_page_by_title('Proxy Detected') == NULL) {
            wp_insert_post($wpage3);
        }
        if (get_page_by_title('Spam IP') == NULL) {
            wp_insert_post($wpage4);
        }
        if (get_page_by_title('Banned Country') == NULL) {
            wp_insert_post($wpage5);
        }
        if (get_page_by_title('Banned Browser') == NULL) {
            wp_insert_post($wpage6);
        }
        if (get_page_by_title('Banned OS') == NULL) {
            wp_insert_post($wpage7);
        }
        if (get_page_by_title('Banned ISP') == NULL) {
            wp_insert_post($wpage8);
        }
        if (get_page_by_title('Banned Referer') == NULL) {
            wp_insert_post($wpage9);
        }
    }
    register_activation_hook(__FILE__, 'ezy_sc_addwpage');
    
    //EaZy Security Database Tables
    register_activation_hook(__FILE__, 'ezy_sc_install');
    function ezy_sc_install()
    {
        global $wpdb;
        
        $table_name      = $wpdb->prefix . "wpg_logs";
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip char(45) NOT NULL,
  date varchar(50) NOT NULL,
  time char(10) NOT NULL,
  page varchar(255) NOT NULL,
  query text NOT NULL,
  type varchar(50) NOT NULL,
  browser varchar(255) DEFAULT 'Unknown' NOT NULL,
  browser_code varchar(50) NOT NULL,
  os varchar(255) DEFAULT 'Unknown' NOT NULL,
  os_code varchar(40) NOT NULL,
  country varchar(120) DEFAULT 'Unknown' NULL,
  country_code char(2) DEFAULT 'XX' NULL,
  region varchar(120) DEFAULT 'Unknown' NULL,
  city varchar(120) DEFAULT 'Unknown' NULL,
  latitude varchar(30) DEFAULT '0' NULL,
  longitude varchar(30) DEFAULT '0' NULL,
  isp varchar(255) DEFAULT 'Unknown' NULL,
  useragent text NOT NULL,
  referer_url varchar(255) NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name2 = $wpdb->prefix . "wpg_bans";
        $sql2        = "CREATE TABLE IF NOT EXISTS $table_name2 (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(50) NOT NULL,
  value varchar(255) NOT NULL,
  date varchar(50) NULL,
  time char(10) NULL,
  reason varchar(255) NULL,
  autoban tinyint(1) DEFAULT '0' NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name3 = $wpdb->prefix . "wpg_ipwhitelist";
        $sql3        = "CREATE TABLE IF NOT EXISTS $table_name3 (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip varchar(45) NOT NULL,
  notes varchar(255) NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name4 = $wpdb->prefix . "wpg_dnsbl";
        $sql4        = "CREATE TABLE IF NOT EXISTS $table_name4 (
  id int(11) NOT NULL AUTO_INCREMENT,
  dnsbl_database varchar(30) NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name5 = $wpdb->prefix . "wpg_livetraffic";
        $sql5        = "CREATE TABLE IF NOT EXISTS $table_name5 (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip char(45) NOT NULL,
  useragent varchar(255) NULL,
  browser varchar(255) DEFAULT 'Unknown' NOT NULL,
  browser_code varchar(50) NOT NULL,
  os varchar(255) DEFAULT 'Unknown' NOT NULL,
  os_code varchar(40) NOT NULL,
  device_type varchar(12) NOT NULL,
  country varchar(120) DEFAULT 'Unknown' NULL,
  country_code char(2) DEFAULT 'XX' NULL,
  request_uri varchar(255) NOT NULL,
  referer varchar(255) NULL,
  bot tinyint(1) DEFAULT '0' NOT NULL,
  date varchar(50) NOT NULL,
  time char(10) NOT NULL,
  uniquev tinyint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";

        $table_name6 = $wpdb->prefix . "wpg_loginhistory";
        $sql6        = "CREATE TABLE IF NOT EXISTS $table_name6 (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  ip char(45) NULL,
  date varchar(30) NULL,
  time char(5) NULL,
  successful int(1) NULL,
  PRIMARY KEY (id)
) $charset_collate;";

		$table_name7 = $wpdb->prefix . "wpg_filewhitelist";
        $sql7        = "CREATE TABLE IF NOT EXISTS $table_name7 (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` char(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
   PRIMARY KEY (id)
) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        dbDelta($sql2);
        dbDelta($sql3);
        dbDelta($sql4);
        dbDelta($sql5);
        dbDelta($sql6);
		dbDelta($sql7);
        
        $dnsblc1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name4
                    WHERE dnsbl_database = %s LIMIT 1", 'sbl.spamhaus.org'));
        if ($dnsblc1 <= 0) {
            $wpdb->insert($table_name4, array(
                'dnsbl_database' => 'sbl.spamhaus.org'
            ), array(
                '%s'
            ));
        }
        
        $dnsblc1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name4
                    WHERE dnsbl_database = %s LIMIT 1", 'xbl.spamhaus.org'));
        if ($dnsblc1 <= 0) {
            $wpdb->insert($table_name4, array(
                'dnsbl_database' => 'xbl.spamhaus.org'
            ), array(
                '%s'
            ));
        }
    }
	
    // CSS Styles
    function ezy_sc_styles()
    {
        if (isset($_GET['page']) && strpos($_GET['page'], 'ezy_sc') === 0) {
            wp_enqueue_style('bootstrap460c', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');
            wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.15.3/css/all.css');
            wp_enqueue_style('admincss', 'https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css');
            if (sanitize_text_field($_GET['page']) == 'ezy_sc-bans') {
                wp_enqueue_style('select2c', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
            }
            wp_enqueue_style('swticheryc', 'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css');
            wp_enqueue_style('datatablesc', 'https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.css');
            wp_enqueue_style('flags', esc_url(plugins_url('assets/plugins/flags/flags.css',__FILE__)));
            $wpgcustom_css = "
            body {
				background: #f1f1f1;
			}
            i.fas.fa-align-justify.fa-2x {
                margin-top: -24px;
            }
            i.fas.fa-ban.fa-2x {
                margin-top: -24px;
            }            
			h1.protmodg {
				color:#47A447;
			}
			h1.protmodr {
				color:#d2322d;
			}
			h1.protmodb {
				color:#007bff;
			}
			h4.dashboardlb {
				background-color:#f7f7f7; 
				font-size: 16px; 
				text-align: center; 
				padding: 7px 10px; 
				margin-top: 0;
			}
			.wpanelbg {
				background-color:#23282d;
			}";
            wp_register_style('ezy_sc-css', false);
            wp_enqueue_style('ezy_sc-css');
            wp_add_inline_style('ezy_sc-css', $wpgcustom_css);
        }
    }
    add_action('admin_enqueue_scripts', 'ezy_sc_styles');
    
    // JS Scripts
    function ezy_sc_scripts()
    {
        if (isset($_GET['page']) && strpos($_GET['page'], 'ezy_sc') === 0) {
            wp_enqueue_script('swtichery', 'https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js');
            wp_enqueue_script('jquery361', 'https://code.jquery.com/jquery-3.6.0.min.js');
            if (sanitize_text_field($_GET['page']) == 'ezy_sc' || sanitize_text_field($_GET['page']) == 'ezy_sc-analytics') {
                wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js');
            }
            if (sanitize_text_field($_GET['page']) == 'ezy_sc-logdetails') {
                wp_enqueue_script('openlayers', 'https://openlayers.org/api/OpenLayers.js');
            }
			if (sanitize_text_field($_GET['page']) == 'ezy_sc-modules') {
                wp_enqueue_script('popperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js');
            }
            wp_enqueue_script('bootstrap460', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js');
            wp_enqueue_script('adminjs', 'https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js');
            if (sanitize_text_field($_GET['page']) == 'ezy_sc-bans') {
                wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
            }
            wp_enqueue_script('datatables', 'https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.js');
            
            $wpgcustom_js = '
        $(document).ready(function() {

	$(\'#dt-basic\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basic2\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basiclt\').dataTable( {
		"responsive": true,
        "order": [[ 2, "asc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basiclt1\').dataTable( {
		"responsive": true,
        "order": [[ 5, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basicdb\').dataTable( {
		"responsive": true,
        "order": [[ 1, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
} );

var elems = Array.prototype.slice.call(document.querySelectorAll(\'.psec-switch\'));

elems.forEach(function(html) {
  var switchery = new Switchery(html, {secondaryColor: \'red\'});
});
';
			
            wp_register_script('ezy_sc-js', '', [], '', true);
            wp_enqueue_script('ezy_sc-js');
            wp_add_inline_script('ezy_sc-js', $wpgcustom_js);
			
			if (sanitize_text_field($_GET['page']) == 'ezy_sc-bans') {
				$wpgcustom_js2 = '
$(document).ready(function() {
	$(\'#dt-basic3\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basic4\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basic5\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basic6\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
	$(\'#dt-basic7\').dataTable( {
		"responsive": true,
        "order": [[ 0, "desc" ]],
		"language": {
			"paginate": {
			  "previous": \'<i class="fas fa-angle-left"></i>\',
			  "next": \'<i class="fas fa-angle-right"></i>\'
			}
		}
	} );
} );

$(".select2").select2({
    width: \'100%\'
});
				';
				wp_register_script('ezy_sc-js2', '', [], '', true);
				wp_enqueue_script('ezy_sc-js2');
				wp_add_inline_script('ezy_sc-js2', $wpgcustom_js2);
			}
			
			if (sanitize_text_field($_GET['page']) == 'ezy_sc-seccheck') {
				$wpgcustom_js2 = '
					$("table").addClass("table table-bordered table-hover");
				';
				wp_register_script('ezy_sc-js2', '', [], '', true);
				wp_enqueue_script('ezy_sc-js2');
				wp_add_inline_script('ezy_sc-js2', $wpgcustom_js2);
			}
        }
    }
    add_action('admin_enqueue_scripts', 'ezy_sc_scripts');
	
    //EaZy Security Admin Pages
    function ezy_sc_header()
    {
?>
<div class="wrap">
    <?php
    }
    
    function ezy_sc_dashboard()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Dashboard";
        include_once "header.php";
        include_once "dashboard.php";
        // include_once "login.php";

        echo '</div>';
    }
    
    function ezy_sc_settings()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Settings";
        include_once "header.php";
        include_once "settings.php";
        echo '</div>';
    }
    
    function ezy_sc_modules()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Protection Modules";
        include_once "header.php";
        include_once "protection-modules.php";
        echo '</div>';
    }
    
    function ezy_sc_logs()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Logs";
        include_once "header.php";
        include_once "logs.php";
        echo '</div>';
    }
    
        function ezy_sc_logdetails()
        {
            global $wpdb;
            ezy_sc_header();
            
            $pagetitle = "Log Details";
            include_once "header.php";
            include_once "log-details.php";
            echo '</div>';
        }
    
    function ezy_sc_bans()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Bans Details";
        include_once "header.php";
        include_once "bans.php";
        echo '</div>';
    }
    // function ezy_sc_ext_scanner()
    // {
    //     global $wpdb;
    //     ezy_sc_header();
        
    //     $pagetitle = "External Scanner";
    //     include_once "header.php";
    //     include_once "external_scan_page.php";
    //     include_once "external_scan_page.php";
    //     echo '</div>';
    // }
    function ezy_sc_scanner()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Scan";
        include_once "header.php";
        include_once "heur_internal_scan_page.php";
        include_once "JS/heur_iscan_frontend.php";
        // require "CSS/bootstrap.css";
        echo '</div>';
    }
    
    function ezy_sc_whitelist()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Whitelist";
        include_once "header.php";
        include_once "whitelist.php";
        echo '</div>';
        
    }
    
    function ezy_sc_analytics()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Visit Analytics";
        include_once "header.php";
        include_once "analytics.php";
        echo '</div>';
    }
    
    function ezy_sc_visitordetails()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Visitor Details";
        include_once "header.php";
        include_once "visitor-details.php";
        echo '</div>';
    }
    
    function ezy_sc_seccheck()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "PHP Security Check";
        include_once "header.php";
        include_once "security-check.php";
        echo '</div>';
    }
    
    function ezy_sc_systeminfo()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "System Information";
        include_once "header.php";
        include_once "system-information.php";
        echo '</div>';
    }
    
    function ezy_sc_errormonitoring()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Error Monitoring";
        include_once "header.php";
        include_once "error-monitoring.php";
        echo '</div>';
    }
    
    function ezy_sc_hteditor()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = ".htaccess Editor";
        include_once "header.php";
        include_once "htaccess-editor.php";
        echo '</div>';
    }
    
    function ezy_sc_portscanner()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Port Scanner";
        include_once "header.php";
        include_once "port-scanner.php";
        echo '</div>';
    }
    
    function ezy_sc_ipblacklistcheck()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "IP Blacklist Checker";
        include_once "header.php";
        include_once "blacklist-checker.php";
        echo '</div>';
    }
    
    function ezy_sc_hashing()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Hashing";
        include_once "header.php";
        include_once "hashing.php";
        echo '</div>';
    }
	
	function ezy_sc_loginhistory()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Login History";
        include_once "header.php";
        include_once "login-history.php";
        echo '</div>';
    }
	function ezy_sc_contactUs()
    {
        global $wpdb;
        ezy_sc_header();
        
        $pagetitle = "Contact Us!";
        include_once "header.php";
        include_once "contact-us.php";
        echo '</div>';
    }

	// function ezy_sc_login()
    // {
    //     global $wpdb;
    //     ezy_sc_header();
        
    //     $pagetitle = "Login";
    //     // include_once "header.php";
    //     include_once "login.php";
    //     echo '</div>';
    // }

	// function ezy_sc_notification()
    // {
    //     global $wpdb;
    //     ezy_sc_header();
        
    //     $pagetitle = "Notification";
    //     include_once "header.php";
    //     include_once "notice.php";
    //     echo '</div>';
    // }
    
    //Uninstall
    register_uninstall_hook(__FILE__, 'ezy_sc_uninstall');
    
    function ezy_sc_uninstall()
    {
        global $wpdb;
        
        include_once "uninstall.php";
    }
    
} else {
    //EaZy Security Initialization
    add_action('init', 'ezy_sc_include');
    function ezy_sc_include()
    {
        global $wpdb;
        
        include(plugin_dir_path(__FILE__) . 'modules/core.php');
        
        //IP Whitelist
        $table           = $wpdb->prefix . 'wpg_ipwhitelist';
        $whitelist_check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE ip = %s LIMIT 1", $ip));
		$tablef           = $wpdb->prefix . 'wpg_filewhitelist';
        $fwhitelist_check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $tablef
                    WHERE path = %s LIMIT 1", $script_name));
        
        if ($whitelist_check <= 0 && $fwhitelist_check <= 0) {
            
            if (get_option('wpg_error_reporting') == 1) {
                error_reporting(0);
            }
            if (get_option('wpg_error_reporting') == 2) {
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
            }
            if (get_option('wpg_error_reporting') == 3) {
                error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
            }
            if (get_option('wpg_error_reporting') == 4) {
                error_reporting(E_ALL & ~E_NOTICE);
            }
            if (get_option('wpg_error_reporting') == 5) {
                error_reporting(E_ALL);
            }
            
            //Displaying Errors
            if (get_option('wpg_display_errors') == 1) {
                ini_set('display_errors', '1');
            } else {
                ini_set('display_errors', '0');
            }
            
			include(plugin_dir_path(__FILE__) . 'modules/live-traffic.php');
            include(plugin_dir_path(__FILE__) . 'modules/ban-system.php');
			include(plugin_dir_path(__FILE__) . 'modules/sqli-protection.php');
			if ($actual_url != get_option('wpg_banned_redirect') && $actual_url != (get_option('wpg_banned_redirect') . '/')) {
				include(plugin_dir_path(__FILE__) . 'modules/badbots-protection.php');
				include(plugin_dir_path(__FILE__) . 'modules/headers-check.php');
				include(plugin_dir_path(__FILE__) . 'modules/fakebots-protection.php');
				if ($searchengine_bot == 0) {
					include(plugin_dir_path(__FILE__) . 'modules/proxy-protection.php');
					include(plugin_dir_path(__FILE__) . 'modules/spam-protection.php');
				}
			}
        }
    }
}

//Login History
add_action('wp_login', 'ezy_sc_saveslogin', 10, 1);
add_action('wp_login_failed', 'ezy_sc_saveflogin', 10, 1);

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip == "::1") {
	$ip = "127.0.0.1";
}
$date   = date_i18n(get_option('date_format'));
$time   = date_i18n(get_option('time_format'));

function ezy_sc_saveslogin($user_login) {
	
    global $wpdb;
    global $ip, $date, $time;
	
	$table  = $wpdb->prefix . 'wpg_loginhistory';
	$data   = array(
            'username' => $user_login,
            'ip' => $ip,
            'date' => $date,
            'time' => $time,
            'successful' => '1'
        );
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        );
        $wpdb->insert($table, $data, $format);
}

function ezy_sc_saveflogin($user_login) {
	
    global $wpdb;
    global $ip, $date, $time;
	
	$table  = $wpdb->prefix . 'wpg_loginhistory';
	$data   = array(
            'username' => $user_login,
            'ip' => $ip,
            'date' => $date,
            'time' => $time,
            'successful' => '0'
        );
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        );
        $wpdb->insert($table, $data, $format);
}





require_once('ezyUtils.php');
require_once('ezyConfig.php');
require_once('ezyLogger.php');
require_once('ezyAjaxHandler.php');

if(!function_exists('add_action'))
{
    exit(0);
}

/* ezy_wm_scanner */
@ini_set('max_execution_time', 30000 );
@ini_set('max_input_time', 30000 );
@ini_set('memory_limit', '2024M');
@set_time_limit(30000);


define('ezy_sc_WM_SCANNER','ezy_sc_scanner');
define('ezy_sc_WM_SCANNER_VERSION','3.4.0.62');
define('ezy_sc_URL',plugin_dir_url( __FILE__ ));


add_action( 'admin_enqueue_scripts', 'ezy_sc_style', 1 );

add_action( 'admin_menu', 'ezy_setup_scanner_menu' );

/*
 * setup action @scanner-run_scan mapped to callback ezy_wm_scanner_ajax_run_scan
 * wp_ajax_ prefix used only for logged in users
 */ 
add_action( 'wp_ajax_scanner-run_scan', 'CezyAjaxHandler::RunExternalScan' );

/*
 * setup action @scanner-run_internal_scan mapped to callback ezy_wm_scanner_ajax_run_internal_scan
 * wp_ajax_ prefix used only for logged in users
 */ 
// add_action( 'wp_ajax_scanner-run_internal_scan', 'CezyAjaxHandler::RunInternalScan' );

add_action( 'wp_ajax_scanner-run_heur_internal_scan', 'CezyAjaxHandler::RunHeurInternalScan' );

add_action( 'wp_ajax_scanner-is_internal_scan_running', 'CezyAjaxHandler::IsInternalScanNowRunning' );

add_action( 'wp_ajax_scanner-get_log_lines', 'CezyAjaxHandler::GetLogLines' );

add_action( 'wp_ajax_scanner-clean_log', 'CezyAjaxHandler::CleanLogLines' );

add_action( 'wp_ajax_scanner-get_stats', 'CezyAjaxHandler::GetStats' );

add_action( 'wp_ajax_scanner-stop_internal_scan', 'CezyAjaxHandler::StopInternalScan' );

add_action( 'wp_ajax_scanner-get_detected_threats', 'CezyAjaxHandler::GetDetectedThreatsReport' );

add_action( 'wp_ajax_scanner-get_ignored_threats', 'CezyAjaxHandler::GetIgnoredThreatsReport' );

add_action( 'wp_ajax_scanner-ignore_threat', 'CezyAjaxHandler::IgnoreThreat' );

add_action( 'wp_ajax_scanner-get_file_report', 'CezyAjaxHandler::ScannerReport' );

add_action( 'wp_ajax_scanner-show_file', 'CezyAjaxHandler::ShowFile' );

/* 
 * return threat back to report
 */
add_action( 'wp_ajax_scanner-unignore_threat', 'CezyAjaxHandler::RemoveFromIgnoreList' );

add_action( 'wp_ajax_scanner-clean_ignore_list', 'CezyAjaxHandler::CleanIgnoreList');

add_action( 'wp_ajax_scanner-whitelist_threat','CezyAjaxHandler::WhiteListThreat' );

add_action( 'wp_ajax_scanner-clean_threats_whitelist', 'CezyAjaxHandler::CleanThreatsWhiteList');

add_action( 'wp_ajax_scanner-whitelist_file', 'CezyAjaxHandler::WhiteListFile');

add_action( 'wp_ajax_scanner-clean_files_whitelist', 'CezyAjaxHandler::CleanFilesWhiteList');


function ezy_sc_style() 
{
    if(isset($_GET['page']) && is_string($_GET['page']) && preg_match('/ezy_sc_scanner/',$_GET['page']) ) 
    {
        echo '<link rel="stylesheet" href="'. ezy_sc_URL . DIRECTORY_SEPARATOR . "CSS" . DIRECTORY_SEPARATOR . 'ezy_sc_css.css" type="text/css" media="all" />' . "\n";
        echo '<link rel="stylesheet" href="'. ezy_sc_URL . DIRECTORY_SEPARATOR . "CSS" . DIRECTORY_SEPARATOR . 'bootstrap.css" type="text/css" media="all"/>' . "\n";
    }
}


/**
 * Set up the menu item and register with hooks to print JS and help.
 */
function ezy_setup_scanner_menu() {
    /* 
     * FIXME - this image should be moved to wp.ezy_sc.com 
     */
    $image_path = "http://wp.ezy_sc.com/images/ezy_sc_16x16.png";

    // /***********************************************************
    //  *          External scanner menu and pages
    //  **********************************************************/
    // add_submenu_page(   'ezy_sc_wm_scanner',
    //                     "ezy_sc Web Malware Scanner", 
    //                     "External Scanner", 
    //                     "activate_plugins", 
    //                     "ezy_sc_wm_scanner", 
    //                     "ezy_external_scan_page" );  


    // $page_hook  = add_menu_page(    'ezy_sc Web Malware Scanner', 
    //                                 'ezy_sc',
    //                                 'activate_plugins',
    //                                 'ezy_sc_wm_scanner', 
    //                                 'ezy_external_scan_page',
    //                                 $image_path
    //                         ); 

    // if ( $page_hook ) 
    // {
    //     add_action( "admin_print_styles-$page_hook", 'add_thickbox' );
    //     add_action( "admin_footer-$page_hook", 'ezy_load_escan_frontend' );
    // }


    // /***********************************************************
    //  *          Internal scanner menu and pages
    //  **********************************************************/
    // $page_hook = add_submenu_page(  'ezy_sc_wm_scanner',
    //                                 "ezy_sc Web Malware Scanner", 
    //                                 '<span style = "">Internal Scanner</span>',
    //                                 "activate_plugins", 
    //                                 "ezy_sc_wm_scanner_int", 
    //                                 "ezy_internal_scan_page" );  
    // if ( $page_hook ) 
    // {
    //     add_action( "admin_print_styles-$page_hook", 'add_thickbox' );
    //     add_action( "admin_footer-$page_hook", 'ezy_load_iscan_frontend' );
    // }


    /***********************************************************
     *          Heuristic Internal scanner menu and pages
     **********************************************************/
    $page_hook = add_submenu_page(  'ezy_sc_scanner',
                                    "ezy_sc Web Malware Scanner", 
                                    '<span style = "">Scan</span>',
                                    "activate_plugins", 
                                    "ezy_sc_wm_scanner_heur_int", 
                                    "ezy_heur_internal_scan_page" );  
    if ( $page_hook ) 
    {
        add_action( "admin_print_styles-$page_hook", 'add_thickbox' );
        add_action( "admin_footer-$page_hook", 'ezy_load_heur_iscan_frontend' );
    }

    // add_submenu_page(   'ezy_sc_wm_scanner',
    //                     "ezy_sc Web Malware Scanner", 
    //                     "FAQ", 
    //                     "activate_plugins", 
    //                     "ezy_sc_wm_scanner_faq", 
    //                     "ezy_faq_page" );
}



/**
 * Print scripts that power paged scanning and diff modal.
 */
// function ezy_load_escan_frontend() { 
//     require "JS" . DIRECTORY_SEPARATOR . "escan_frontend.php";
// }


// function ezy_load_iscan_frontend(){
//     require "JS" . DIRECTORY_SEPARATOR . "iscan_frontend.php";
// }


function ezy_load_heur_iscan_frontend(){
    require "JS" . DIRECTORY_SEPARATOR . "heur_iscan_frontend.php";
}


function ezy_wm_scanner_ajax_run_scan()
{
    if(!current_user_can('manage_options'))
    {
        wp_die(__('You do not have sufficient permissions to access this page.') );
    }
	
    //check_ajax_referer( 'ezy_wm_scanner-scan' );
    $this_url = trim($_POST['_this']);        /* domain name of this server */
    $ezy_url  = trim($_POST['_ezy_url']);     /* ezy_sc investigation server name */
     
    if( empty($this_url) )
    {
        $this_url = CezyUtils::GetDomainName();
    }
    else if( empty($ezy_url) )
    {
        $ezy_url = "https://security.bikswee.com";
    }

    if( strpos($this_url, "://" ) != false )
    {
        $parse      = parse_url($this_url);
        $this_url   = $parse['host'];
    }
    /* 
     * validate input of host name 
     */
    if(filter_var(gethostbyname($this_url), FILTER_VALIDATE_IP) === FALSE )
    {
        /* send error to frontend */
	    echo json_encode( array( 'content' => array( "state" => "Failed to access local server",
                                                     "age" => time(),
                                                     "url" => "localhost" )));
        exit;

    }
    
    /* validate ezy_sc server address */
    if( filter_var($ezy_url, FILTER_VALIDATE_URL) === FALSE )
    {
        /* send error to fronend */
    	echo json_encode( array( 'content' => array( "state" => "Failed to access remote server",
                                                     "age" => time(),
                                                     "url" => $this_url )));
        exit;
    }

    $investigation_url =  $ezy_url . "/wp_scan/" . $this_url;

    if( filter_var($investigation_url, FILTER_VALIDATE_URL) === FALSE )
    {
	    echo json_encode( array( 'content' => array( "state" => "Remote server address is invalid",
                                                     "age" => time(),
                                                     "url" => "<undefined>" )));
        exit;
    }

    usleep(1000000); //sleep for a second

    //$output = file_get_contents($investigation_url);
    $output = ezy_scanner_query($investigation_url);
    
    if( empty($output) )
    {
        //$output = file_get_contents($investigation_url);
        $output = ezy_scanner_query($investigation_url);
    
        if( $output == false )
        {
            echo json_encode( array( 'content' => array( "state" => "Failed to access investigation server [ " . $ezy_url . " ]",
                                                         "age" => time(),
                                                         "url" => $this_url,
                                                         "img" => plugins_url( 'loader.gif', __FILE__ )) 
                                    ) 
                            );
            exit;
        }
    }
    
    $output = json_decode($output);
    
    //if state is not finished sleep for a second
    echo json_encode( array( 'content' => $output ) );
    exit;
}


/**
 *
 */
// function ezy_external_scan_page()
// {
//     if(!current_user_can('activate_plugins'))
//     {
//         wp_die(__('You do not have sufficient permissions to access this page.') );
//     }

//     require ("external_scan_page.php");
// }


/**
 *
 */
// function ezy_internal_scan_page()
// {
//     if(!current_user_can('activate_plugins'))
//     {
//         wp_die(__('You do not have sufficient permissions to access this page.') );
//     }

//     require("internal_scan_page.php");
// }

/**
 *
 */
function ezy_heur_internal_scan_page()
{
    if(!current_user_can('activate_plugins'))
    {
        wp_die(__('You do not have sufficient permissions to access this page.') );
    }

    require("heur_internal_scan_page.php");
}



// function ezy_faq_page()
// {
//     if(!current_user_can('activate_plugins'))
//     {
//         wp_die(__('You do not have sufficient permissions to access this page.') );
//     }

//     require "faq_page.php";
// }



/**
 * Activation callback.
 *
 * Add database version info. Set up non-autoloaded options as there is no need
 * to load results or clean core files on any page other than the exploit scanner page.
 */
function on_ezy_scanner_activation() {
    register_uninstall_hook( __FILE__, 'on_ezy_scanner_uninstall' );
}

register_activation_hook( __FILE__, 'on_ezy_scanner_activation' );

/**
 * Deactivation callback. Remove transients.
 */
function on_ezy_scanner_deactivate() {
    /* remove cached (runtime) parameters */
    
    /*
     * removes hook registration if exists
     */
    wp_clear_scheduled_hook('ezy_internal_scan_cron_hook');
}

register_deactivation_hook( __FILE__, 'on_ezy_scanner_deactivate' );


/**
 * Uninstall callback. Remove all data stored by the plugin.
 */
function on_ezy_scanner_uninstall()
{
    /* removes all added options */
}

/**
 * Update routine to perform database cleanup and to ensure that newly
 * introduced settings and defaults are enforced.
 */
function on_ezy_scanner_admin_init() 
{
    on_ezy_scanner_activation();
}

/* 
 * admin_init is triggered before any other hook when a user access the admin area 
 */
add_action( 'admin_init', 'on_ezy_scanner_admin_init' );

/* ?????? */
function ezy_wm_scanner_plugin_actions( $links, $file ) 
{
    if( $file == 'ezy_sc.php' && function_exists( "admin_url" ) ) 
    {
        $settings_link = '<a href="' . admin_url( 'admin.php?page=ezy_sc_scanner' ) . '">' . __('Scanner Settings') . '</a>';
        array_unshift( $links, $settings_link ); // before other links
    }
    return $links;
}


add_filter( 'plugin_action_links', 'ezy_wm_scanner_plugin_actions', 10, 2 );


/**
 * @brief       sends request to remote scanner 
 * @param[in]   remote_url - URL query 
 * @return      on success returns retireved Json, on failure empty string
 */
function ezy_scanner_query($remote_url)
{
    if( function_exists('curl_init') )
    {
       /* curl library loaded */ 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $remote_url );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }else{
        return file_get_contents( $remote_url );
    }
}

// /* end of file */
?>