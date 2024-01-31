<?php
include_once 'ezy_sc_sub_module.php';

$cache_file = plugin_dir_path(__FILE__) . "/cache/proxy/". str_replace(":", "-", $ip) .".json";

//Proxy Protection
if (get_option('wpg_proxy_protection') > 0) {
    
    $proxyv = 0;
    
    if (get_option('wpg_proxy_protection') == 1) {
        
        if (ezy_sc_getcache($cache_file) == 'WPGUD_NoCache') {
			$key = get_option('wpg_proxy_api1');
        
			$ch    = curl_init();
			$url   = 'http://v2.api.iphub.info/ip/' . $ip . '';
			curl_setopt_array($ch, [
				CURLOPT_URL => $url,
				CURLOPT_CONNECTTIMEOUT => 30,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
			]);
			$block = json_decode(curl_exec($ch))->block;
			curl_close($ch);
		
			// Grabs API Response and Caches
			file_put_contents($cache_file, $choutput);
        } else {
            @$block = json_decode(ezy_sc_getcache($cache_file))->block;
        }
        
        if ($block) {
            $proxyv = 1;
        }
        
    } else if (get_option('wpg_proxy_protection') == 2) {
        
        if (ezy_sc_getcache($cache_file) == 'WPGUD_NoCache') {
			$key = get_option('wpg_proxy_api2');
        
			$ch           = curl_init('http://proxycheck.io/v2/' . $ip . '?key=' . $key . '&vpn=1');
			$curl_options = array(
				CURLOPT_CONNECTTIMEOUT => 30,
				CURLOPT_RETURNTRANSFER => true
			);
			curl_setopt_array($ch, $curl_options);
			$response = curl_exec($ch);
			curl_close($ch);
			$jsonc = json_decode($response);
        
			// Grabs API Response and Caches
			file_put_contents($cache_file, $response);
		} else {
            $jsonc = json_decode(ezy_sc_getcache($cache_file));
        }
		
        if (isset($jsonc->$ip->proxy) && $jsonc->$ip->proxy == "yes") {
            $proxyv = 1;
        }
        
    } else if (get_option('wpg_proxy_protection') == 3) {
        
		if (ezy_sc_getcache($cache_file) == 'WPGUD_NoCache') {
			$key = get_option('wpg_proxy_api3');
		
			$headers = [
				'X-Key: '.$key,
			];
			$ch = curl_init("https://www.iphunter.info:8082/v1/ip/" . $ip);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
			$output      = json_decode(curl_exec($ch), 1);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
        
			if ($http_status == 200) {
				if ($output['data']['block'] == 1) {
					$proxyv = 1;
				
				}
				
				// Grabs API Response and Caches
				file_put_contents($cache_file, $choutput);
			}
        } else {
            $output = json_decode(ezy_sc_getcache($cache_file), 1);
			
            if ($output['data']['block'] == 1) {
                $proxyv = 1;
            }
        }
    }
    
    if ($proxyv == 1) {
        
        $type = "Proxy";
        
        //Logging
        if (get_option('wpg_proxy_logging') == 1) {
            ezy_sc_logging($type);
        }
        
        // //E-Mail Notification
        // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_proxy_mail')) {
        //     ezy_sc_mail($type);
        // }
        
        if ($actual_url != get_option('wpg_proxy_redirect') && $actual_url != (get_option('wpg_proxy_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_proxy_redirect') . '" />';
            exit;
        }
    }
}

//Method 2
if (get_option('wpg_proxy_protection2') == 1) {
    $proxy_headers = array(
        'HTTP_VIA',
        'VIA',
        'Proxy-Connection',
        'HTTP_X_FORWARDED_FOR',  
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'X-PROXY-ID',
        'MT-PROXY-ID',
        'X-TINYPROXY',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT-IP',
        'CLIENT_IP',
        'PROXY-AGENT',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION'
    );
    foreach ($proxy_headers as $x) {
        if (isset($_SERVER[$x])) {
            
            $type = "Proxy";
            
            //Logging
            if (get_option('wpg_proxy_logging') == 1) {
                ezy_sc_logging($type);
            }
            
            // //E-Mail Notification
            // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_proxy_mail')) {
            //     ezy_sc_mail($type);
            // }
            
            if ($actual_url != get_option('wpg_proxy_redirect') && $actual_url != (get_option('wpg_proxy_redirect') . '/')) {
                echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_proxy_redirect') . '" />';
                exit;
            }
        }
    }
}
?>