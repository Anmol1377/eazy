<?php
// If uninstall.php is not called by WordPress, stop
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

//Delete plugin options
delete_option('wpg_mail_notifications');
delete_option('wpg_countryban_blacklist');
delete_option('wpg_sqli_protection');
delete_option('wpg_sqli_protection2');
delete_option('wpg_sqli_protection3');
delete_option('wpg_sqli_protection4');
delete_option('wpg_sqli_protection5');
delete_option('wpg_sqli_protection6');
delete_option('wpg_sqli_logging');
delete_option('wpg_sqli_autoban');
delete_option('wpg_sqli_mail');
delete_option('wpg_sqli_redirect');
delete_option('wpg_badbot_protection');
delete_option('wpg_badbot_protection2');
delete_option('wpg_badbot_protection3');
delete_option('wpg_badbot_logging');
delete_option('wpg_badbot_autoban');
delete_option('wpg_badbot_mail');
delete_option('wpg_proxy_protection');
delete_option('wpg_proxy_protection2');
delete_option('wpg_proxy_api1');
delete_option('wpg_proxy_api2');
delete_option('wpg_proxy_api3');
delete_option('wpg_proxy_logging');
delete_option('wpg_proxy_mail');
delete_option('wpg_proxy_redirect');
delete_option('wpg_spam_protection');
delete_option('wpg_spam_logging');
delete_option('wpg_spam_mail');
delete_option('wpg_spam_redirect');
delete_option('wpg_live_traffic');
delete_option('wpg_error_reporting');
delete_option('wpg_display_errors');
delete_option('wpg_banned_redirect');
delete_option('wpg_bannedc_redirect');
delete_option('wpg_bannedo_redirect');
delete_option('wpg_bannedb_redirect');
delete_option('wpg_bannedi_redirect');
delete_option('wpg_bannedr_redirect');

// For site options in Multisite
delete_site_option('wpg_mail_notifications');
delete_site_option('wpg_countryban_blacklist');
delete_site_option('wpg_sqli_protection');
delete_site_option('wpg_sqli_protection2');
delete_site_option('wpg_sqli_protection3');
delete_site_option('wpg_sqli_protection4');
delete_site_option('wpg_sqli_protection5');
delete_site_option('wpg_sqli_protection6');
delete_site_option('wpg_sqli_logging');
delete_site_option('wpg_sqli_autoban');
delete_site_option('wpg_sqli_mail');
delete_site_option('wpg_sqli_redirect');
delete_site_option('wpg_badbot_protection');
delete_site_option('wpg_badbot_protection2');
delete_site_option('wpg_badbot_protection3');
delete_site_option('wpg_badbot_logging');
delete_site_option('wpg_badbot_autoban');
delete_site_option('wpg_badbot_mail');
delete_site_option('wpg_proxy_protection');
delete_site_option('wpg_proxy_protection2');
delete_site_option('wpg_proxy_api1');
delete_site_option('wpg_proxy_api2');
delete_site_option('wpg_proxy_api3');
delete_site_option('wpg_proxy_logging');
delete_site_option('wpg_proxy_autoban');
delete_site_option('wpg_proxy_mail');
delete_site_option('wpg_proxy_redirect');
delete_site_option('wpg_spam_protection');
delete_site_option('wpg_spam_logging');
delete_site_option('wpg_spam_autoban');
delete_site_option('wpg_spam_mail');
delete_site_option('wpg_spam_redirect');
delete_site_option('wpg_live_traffic');
delete_site_option('wpg_error_reporting');
delete_site_option('wpg_display_errors');
delete_site_option('wpg_banned_redirect');
delete_site_option('wpg_bannedc_redirect');
delete_site_option('wpg_bannedo_redirect');
delete_site_option('wpg_bannedb_redirect');
delete_site_option('wpg_bannedi_redirect');
delete_site_option('wpg_bannedr_redirect');

// Delete Warning Pages
if (get_page_by_title('Banned') != NULL) {
    $page = get_page_by_title('Banned');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Blocked Request') != NULL) {
    $page = get_page_by_title('Blocked Request');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Proxy Detected') != NULL) {
    $page = get_page_by_title('Proxy Detected');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Spam IP') != NULL) {
    $page = get_page_by_title('Spam IP');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Banned Country') != NULL) {
    $page = get_page_by_title('Banned Country');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Banned Browser') != NULL) {
    $page = get_page_by_title('Banned Browser');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Banned OS') != NULL) {
    $page = get_page_by_title('Banned OS');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Banned ISP') != NULL) {
    $page = get_page_by_title('Banned ISP');
    wp_delete_post($page->ID, true);
}
if (get_page_by_title('Banned Referer') != NULL) {
    $page = get_page_by_title('Banned Referer');
    wp_delete_post($page->ID, true);
}

// Drop custom database tables
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_logs");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_bans");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_ipwhitelist");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_dnsbl");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_livetraffic");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_loginhistory");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wpg_filewhitelist");
?>