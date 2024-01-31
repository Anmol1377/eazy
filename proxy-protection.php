<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_GET['api'])) {
    
    $apid = (int) $_GET['api'];
    
    if ($apid == 0 || $apid == 1 || $apid == 2 || $apid == 3) {

		update_option('wpg_proxy_protection', $apid);
		
		$files = glob(plugin_dir_path(__FILE__) . 'modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
    }
}

if (isset($_POST['psave2'])) {
    
    if (isset($_POST['protection2'])) {
        $protection2 = 1;
    } else {
        $protection2 = 0;
    }
    
    update_option('wpg_proxy_protection2', $protection2);
	
	if (get_option('wpg_proxy_protection') > 0) {
		$apiks   = 'wpg_proxy_api' . get_option('wpg_proxy_protection');

		$api_key = sanitize_text_field($_POST['apikey']);
		update_option($apiks, $api_key);
		
		$files = glob(plugin_dir_path(__FILE__) . 'modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
	}
}

if (isset($_POST['psave'])) {
    
    if (isset($_POST['logging'])) {
        $logging = 1;
    } else {
        $logging = 0;
    }

    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    $redirect = sanitize_text_field($_POST['redirect']);
    
    update_option('wpg_proxy_logging', $logging);
    update_option('wpg_proxy_mail', $mail);
    update_option('wpg_proxy_redirect', $redirect);
}
?>
<div class="row">
    <div class="col-md-8">

        <?php
if (get_option('wpg_proxy_protection') > 1 OR get_option('wpg_proxy_protection2') == 1) {
    echo '
              <div class="card col-md-12 card-solid card-success">
';
} else {
    echo '
              <div class="card col-md-12 card-solid card-danger">
';
}
?>
        <div class="card-header">
            <h3 class="card-title"><?php
echo esc_html__("Proxy", "ezy_sc-text");
?> - <?php
echo esc_html__("Protection Module", "ezy_sc-text");
?></h3>
        </div>
        <div class="card-body jumbotron">
            <?php
if (get_option('wpg_proxy_protection') > 0 OR get_option('wpg_proxy_protection2') == 1) {
    echo '
        <h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is protected from", "ezy_sc-text") . ' <strong>' . esc_html__("Proxies", "ezy_sc-text") . '</strong></p>
';
} else {
    echo '
        <h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is not protected from", "ezy_sc-text") . ' <strong>' . esc_html__("Proxies", "ezy_sc-text") . '</strong></p>
';
}
?>
        </div>
    </div>

    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title"><?php
echo esc_html__("Proxy Detection Methods", "ezy_sc-text");
?></h3>
        </div>
        <div class="card-body">
            <form class="form-horizontal form-bordered" action="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body bg-light col-md-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <h5><?php
echo esc_html__("Detection Method #1", "ezy_sc-text");
?></h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <button class="btn btn-<?php
if (get_option('wpg_proxy_protection') == 0) {
    echo 'danger';
} else {
    echo 'success';
}
?> dropdown-toggle float-right" style="width: 100%;" type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?php
if (get_option('wpg_proxy_protection') == 1) {
    echo 'IPHub';
} else if (get_option('wpg_proxy_protection') == 2) {
    echo 'ProxyCheck';
} else if (get_option('wpg_proxy_protection') == 3) {
    echo 'IPHunter';
} else {
    echo 'Proxy Detection API';
}
?>
                                        </button>
                                        <div class="dropdown-menu" style="width: 100%;">
                                            <a class="dropdown-item <?php
if (get_option('wpg_proxy_protection') == 0) {
    echo 'active';
}
?>" href="?page=ezy_sc-modules&api=0"><?php
echo esc_html__("Disabled", "ezy_sc-text");
?></a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item <?php
if (get_option('wpg_proxy_protection') == 1) {
    echo 'active';
}
?>" href="?page=ezy_sc-modules&api=1"><?php
echo esc_html__("IPHub", "ezy_sc-text");
?></a>
                                            <a class="dropdown-item <?php
if (get_option('wpg_proxy_protection') == 2) {
    echo 'active';
}
?>" href="?page=ezy_sc-modules&api=2"><?php
echo esc_html__("ProxyCheck", "ezy_sc-text");
?></a>
                                            <a class="dropdown-item <?php
if (get_option('wpg_proxy_protection') == 3) {
    echo 'active';
}
?>" href="?page=ezy_sc-modules&api=3"><?php
echo esc_html__("IPHunter", "ezy_sc-text");
?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <?php
echo esc_html__("Connects to Proxy Detection API and verifies whether the visitor is using a Proxy, VPN or TOR", "ezy_sc-text");
?>
                            <br /><br />
                            <?php
if (get_option('wpg_proxy_protection') > 0 && get_option('wpg_proxy_protection') < 4) {
    
    $apik = 'wpg_proxy_api' . get_option('wpg_proxy_protection');
    $key  = get_option($apik);
    
    $proxy_check = 0;
    
    if (get_option('wpg_proxy_protection') == 1) {
        //Invalid API Key ==> Offline
        $ch  = curl_init();
        $url = "http://v2.api.iphub.info/ip/8.8.8.8";
        curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            $proxy_check = 1;
        } else if ($httpCode == 429) {
            $proxy_check = 429;
        }
		
    } else if (get_option('wpg_proxy_protection') == 2) {
            
        $ch           = curl_init('http://proxycheck.io/v2/8.8.8.8?key=' . $key . '');
        $curl_options = array(
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $curl_options);
        $response = curl_exec($ch);
        curl_close($ch);

        $jsonc = json_decode($response);
		
		if (isset($jsonc->status) && $jsonc->status == "ok") {
			$proxy_check = 1;
		}
        
    } else if (get_option('wpg_proxy_protection') == 3) {
        //Invalid API Key ==> Offline
        $headers = [
			'X-Key: '.$key.'',
        ];
        $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            $proxy_check = 1;
        } else if ($httpCode == 429) {
            $proxy_check = 429;
        }
        
    }
    
	if ($proxy_check == 0) {
        echo '<div class="callout callout-warning" role="callout">' . esc_html__("Invalid / missing API Key or API is Offline", "ezy_sc-text") . '</div>';
    } else if ($proxy_check == 429) {
        echo '<div class="callout callout-warning" role="callout">' . esc_html__("Requests Limit exceeded", "ezy_sc-text") . '</div>';
    }
    
    if (get_option($apik) == NULL OR $proxy_check == 0) {
        if (get_option('wpg_proxy_protection') == 1) {
            $apik_url = 'https://iphub.info/pricing';
        } else if (get_option('wpg_proxy_protection') == 2) {
            $apik_url = 'https://proxycheck.io/pricing';
        } else if (get_option('wpg_proxy_protection') == 3) {
            $apik_url = 'https://www.iphunter.info/prices';
        }
?>
                            <a href="<?php
        echo $apik_url;
?>" class="btn btn-info btn-block text-white" target="_blank"><i class="fas fa-key"></i> <?php
echo esc_html__("Get API Key", "ezy_sc-text");
?></a><br />
                            <?php
    }
}
?>

                            <p><?php
echo esc_html__("API Key", "ezy_sc-text");
?></p>
                            <input name="apikey" class="form-control" type="text" <?php
if (get_option('wpg_proxy_protection') > 0) {
	echo 'value="' . get_option($apik) . '"';
} else {
	echo 'disabled';
}
?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body bg-light col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5><?php
echo esc_html__("Detection Method #2", "ezy_sc-text");
?>
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" name="protection2" class="psec-switch" <?php
if (get_option('wpg_proxy_protection2') == 1) {
    echo 'checked="checked"';
}
?> />
                                </div>
                            </div>
                            <hr />
                            <?php
echo esc_html__("Checks the visitor's HTTP Headers for Proxy Elements", "ezy_sc-text");
?>

                        </div>
                    </div>
                </div>
                <button class="btn btn-flat btn-md btn-block btn-primary mar-top" name="psave2" type="submit"><i
                        class="fas fa-floppy"></i> <?php
echo esc_html__("Save", "ezy_sc-text");
?></button>
        </div>
    </div>
    </form>

</div>

<div class="col-md-4">
    <div class="card col-md-12 card-dark">
        <div class="card-header" style="background-color:#8c52ff; color:white;">
            <h3 class="card-title"><?php
echo esc_html__("What is", "ezy_sc-text");
?> <?php
echo esc_html__("Proxy", "ezy_sc-text");
?></h3>
        </div>
        <div class="card-body">
            <?php
echo balanceTags("<strong>Proxy</strong> or <strong>Proxy Server</strong>", "ezy_sc-text");
?> <?php
echo esc_html__("is basically another computer which serves as a hub through which internet requests are processed. By connecting through one of these servers, your computer sends your requests to the proxy server which then processes your request and returns what you were wanting.", "ezy_sc-text");
?>
        </div>
    </div>
    <div class="card card-dark col-md-12">
        <div class="card-header" style="background-color:#8c52ff; color:white;">
            <h3 class="card-title"><?php
echo esc_html__("Module Settings", "ezy_sc-text");
?></h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <form class="form-horizontal form-bordered" action="" method="post">
                    <li class="list-group-item">
                        <p><?php
echo esc_html__("Logging", "ezy_sc-text");
?></p>
                        <input type="checkbox" name="logging" class="psec-switch" <?php
if (get_option('wpg_proxy_logging') == 1) {
    echo 'checked="checked"';
}
?> /><br />
                        <span class="text-muted"><?php
echo esc_html__("Logging every threat of this type", "ezy_sc-text");
?></span>
                    </li>

                    </li>
                    <li class="list-group-item">
                        <p><?php
echo esc_html__("Redirect URL", "ezy_sc-text");
?></p>
                        <input name="redirect" class="form-control" type="text" value="<?php
echo get_option('wpg_proxy_redirect');
?>" required>
                    </li>
            </ul>
        </div>
        <div class="card-footer">
            <button class="btn btn-flat btn-block btn-primary mar-top" name="psave" type="submit"><i
                    class="fas fa-floppy"></i> <?php
echo esc_html__("Save", "ezy_sc-text");
?></button>
        </div>
        </form>
    </div>
</div>

</div>