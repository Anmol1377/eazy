<?php
$cache_file = plugin_dir_path(__FILE__) . "/cache/ip-details/". str_replace(":", "-", $ip) .".json";

//Ban System
$table    = $wpdb->prefix . 'wpg_bans';
$bannedip = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip', $ip));
if ($bannedip > 0) {
    if ($actual_url != get_option('wpg_banned_redirect') && $actual_url != (get_option('wpg_banned_redirect') . '/')) {
		echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_banned_redirect') . '" />';
        exit;
    }
}

//IP Ranges
$bannedipr = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $ip_range));
if ($bannedipr > 0) {
    if ($actual_url != get_option('wpg_banned_redirect') && $actual_url != (get_option('wpg_banned_redirect') . '/')) {
        echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_banned_redirect') . '" />';
        exit;
    }
}

//Blocking Country
$bannedcs = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s LIMIT 1", 'country'));
if ($bannedcs > 0) {
	if (ezy_sc_getcache($cache_file) == 'WPGUD_NoCache') {
		$url = 'https://ipapi.co/' . $ip . '/json/';
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
		$ipcontent = curl_exec($ch);
		curl_close($ch);
    
		$ip_data = json_decode($ipcontent);
	
		// Grabs API Response and Caches
		file_put_contents($cache_file, $ipcontent);
		
	} else {
		$ip_data = @json_decode(ezy_sc_getcache($cache_file));
	}
	
    if ($ip_data && !isset($ip_data->{'error'})) {
        $country_check = $ip_data->{'country_name'};
        $isp_check     = $ip_data->{'org'};
		
		if($country_check == '') {
			$country_check = "Unknown";
		}
    } else {
        $country_check = "Unknown";
        $isp_check     = "Unknown";
    }
    
} else {
    $isp_check = "Unknown";
    $country_check = "Unknown";
}

$bannedc = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'country', $country_check));

if (get_option('wpg_countryban_blacklist') == 1) {
    if ($bannedc > 0) {
        if ($actual_url != get_option('wpg_bannedc_redirect') && $actual_url != (get_option('wpg_bannedc_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedc_redirect') . '" />';
            exit;
        }
    }
} else {
    if (strpos(strtolower($useragent), "googlebot") !== false OR strpos(strtolower($useragent), "bingbot") !== false OR strpos(strtolower($useragent), "yahoo! slurp") !== false) {
    } else {
        if ($bannedc <= 0) {
            if ($actual_url != get_option('wpg_bannedc_redirect') && $actual_url != (get_option('wpg_bannedc_redirect') . '/')) {
                echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedc_redirect') . '" />';
                exit;
            }
        }
    }
}

//Blocking Browser
$bannedb = $wpdb->get_results($wpdb->prepare("SELECT type, value FROM $table
                    WHERE type = %s", 'browser'));
foreach ($bannedb as $row) {
    if (strpos(strtolower($browser), strtolower($row->value)) !== false) {
        if ($actual_url != get_option('wpg_bannedb_redirect') && $actual_url != (get_option('wpg_bannedb_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedb_redirect') . '" />';
            exit;
        }
    }
}

//Blocking Operating System
$bannedo = $wpdb->get_results($wpdb->prepare("SELECT type, value FROM $table
                    WHERE type = %s", 'os'));
foreach ($bannedo as $row) {
    if (strpos(strtolower($os), strtolower($row->value)) !== false) {
        if ($actual_url != get_option('wpg_bannedo_redirect') && $actual_url != (get_option('wpg_bannedo_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedo_redirect') . '" />';
            exit;
        }
    }
}

//Blocking Internet Service Provider
$bannedi = $wpdb->get_results($wpdb->prepare("SELECT type, value FROM $table
                    WHERE type = %s", 'isp'));
foreach ($bannedi as $row) {
    if (strpos(strtolower($isp), strtolower($row->value)) !== false) {
        if ($actual_url != get_option('wpg_bannedi_redirect') && $actual_url != (get_option('wpg_bannedi_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedi_redirect') . '" />';
            exit;
        }
    }
}

//Blocking Referrer
$bannedr = $wpdb->get_results($wpdb->prepare("SELECT type, value FROM $table
                    WHERE type = %s", 'referrer'));
foreach ($bannedr as $row) {
    if (strpos(strtolower($referer), strtolower($row->value)) !== false) {
        if ($actual_url != get_option('wpg_bannedr_redirect') && $actual_url != (get_option('wpg_bannedr_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_bannedr_redirect') . '" />';
            exit;
        }
    }
}
?>